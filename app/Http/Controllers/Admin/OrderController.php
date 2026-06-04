<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderStatusUpdate;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['items.product.thumbnail', 'user']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('billing_name', 'like', "%{$search}%")
                    ->orWhere('billing_email', 'like', "%{$search}%")
                    ->orWhere('billing_phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->latest()->paginate(15)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['items.product', 'user', 'address']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled,refunded',
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        // Statuses that mean stock was released back
        $stockReleasedStatuses = ['cancelled', 'refunded'];
        $needsStockRestore = in_array($newStatus, $stockReleasedStatuses) && !in_array($oldStatus, $stockReleasedStatuses);
        $needsStockDeduct = !in_array($newStatus, $stockReleasedStatuses) && in_array($oldStatus, $stockReleasedStatuses);

        DB::beginTransaction();

        try {
            $order->load('items');

            if ($needsStockRestore) {
                foreach ($order->items as $item) {
                    Product::where('id', $item->product_id)->increment('stock', $item->quantity);
                    if ($item->product_color_id) {
                        ProductColor::where('id', $item->product_color_id)->increment('stock', $item->quantity);
                    }
                }
            }

            if ($needsStockDeduct) {
                foreach ($order->items as $item) {
                    $product = Product::lockForUpdate()->find($item->product_id);
                    $productColor = $item->product_color_id
                        ? ProductColor::lockForUpdate()->find($item->product_color_id)
                        : null;

                    $availableStock = $productColor ? $productColor->stock : $product->stock;
                    if ($availableStock < $item->quantity) {
                        DB::rollBack();
                        return back()->with('error', "Cannot reactivate order: {$item->product_name} only has {$availableStock} in stock.");
                    }

                    $product->decrement('stock', $item->quantity);
                    if ($productColor) {
                        $productColor->decrement('stock', $item->quantity);
                    }
                }
            }

            $order->update(['status' => $newStatus]);

            DB::commit();

            // Send status update email
            Mail::to($order->billing_email)->send(new OrderStatusUpdate($order, $oldStatus));

            return back()->with('success', 'Order status updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update order status: ' . $e->getMessage());
        }
    }

    public function updatePaymentStatus(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,failed,refunded',
        ]);

        $order->update(['payment_status' => $request->payment_status]);

        return back()->with('success', 'Payment status updated successfully.');
    }

    public function updateAddress(Request $request, Order $order)
    {
        $validated = $request->validate([
            'billing_name' => 'required|string|max:255',
            'billing_phone' => 'required|string|max:20',
            'billing_email' => 'required|email|max:255',
            'billing_address' => 'required|string|max:500',
            'billing_city' => 'required|string|max:100',
            'billing_state' => 'required|string|max:100',
            'billing_pincode' => 'required|string|max:10',
        ]);

        $order->update($validated);

        return back()->with('success', 'Shipping address updated successfully.');
    }

    public function create()
    {
        return view('admin.orders.create');
    }

    public function searchProducts(Request $request)
    {
        $query = $request->get('q', '');

        $products = Product::where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('sku', 'like', "%{$query}%");
            })
            ->with(['thumbnail', 'productColors.color'])
            ->where('stock', '>', 0)
            ->limit(10)
            ->get()
            ->map(function ($product) {
                $colors = $product->productColors->map(function ($pc) {
                    return [
                        'id' => $pc->id,
                        'name' => $pc->color->name ?? 'Unknown',
                        'stock' => $pc->stock,
                    ];
                });

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'sku' => $product->sku,
                    'price' => $product->price,
                    'discount' => $product->discount,
                    'display_price' => $product->display_price,
                    'stock' => $product->stock,
                    'thumbnail' => $product->thumbnail?->url ?? null,
                    'colors' => $colors,
                ];
            });

        return response()->json($products);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'billing_name' => 'required|string|max:255',
            'billing_email' => 'required|email|max:255',
            'billing_phone' => 'required|string|max:20',
            'billing_address' => 'required|string|max:500',
            'billing_city' => 'required|string|max:100',
            'billing_state' => 'required|string|max:100',
            'billing_pincode' => 'required|string|max:10',
            'payment_status' => 'required|in:pending,paid',
            'payment_method' => 'required|string|max:50',
            'notes' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.product_color_id' => 'nullable|exists:product_colors,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $freeShippingThreshold = (float) SiteSetting::get('free_shipping_threshold', 5000);
        $shippingCharge = (float) SiteSetting::get('shipping_charge', 99);

        DB::beginTransaction();

        try {
            $subtotal = 0;
            $itemsData = [];

            foreach ($validated['items'] as $itemInput) {
                $product = Product::lockForUpdate()->findOrFail($itemInput['product_id']);
                $productColor = !empty($itemInput['product_color_id'])
                    ? ProductColor::lockForUpdate()->find($itemInput['product_color_id'])
                    : null;

                $availableStock = $productColor ? $productColor->stock : $product->stock;
                if ($availableStock < $itemInput['quantity']) {
                    DB::rollBack();
                    $colorLabel = $productColor && $productColor->color ? " ({$productColor->color->name})" : '';
                    return back()->withInput()->with('error', "{$product->name}{$colorLabel} only has {$availableStock} in stock.");
                }

                $unitPrice = $product->display_price;
                $colorName = $productColor && $productColor->color ? $productColor->color->name : null;
                $lineTotal = $unitPrice * $itemInput['quantity'];
                $subtotal += $lineTotal;

                $itemsData[] = [
                    'product' => $product,
                    'productColor' => $productColor,
                    'colorName' => $colorName,
                    'unitPrice' => $unitPrice,
                    'quantity' => $itemInput['quantity'],
                    'lineTotal' => $lineTotal,
                ];
            }

            $shipping = $subtotal >= $freeShippingThreshold ? 0 : $shippingCharge;
            $total = round($subtotal + $shipping);

            $order = Order::create([
                'billing_name' => $validated['billing_name'],
                'billing_email' => $validated['billing_email'],
                'billing_phone' => $validated['billing_phone'],
                'billing_address' => $validated['billing_address'],
                'billing_city' => $validated['billing_city'],
                'billing_state' => $validated['billing_state'],
                'billing_pincode' => $validated['billing_pincode'],
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'total' => $total,
                'status' => $validated['payment_status'] === 'paid' ? 'processing' : 'pending',
                'payment_status' => $validated['payment_status'],
                'payment_method' => $validated['payment_method'],
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($itemsData as $data) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $data['product']->id,
                    'product_color_id' => $data['productColor']?->id,
                    'product_name' => $data['product']->name . ($data['colorName'] ? ' - ' . $data['colorName'] : ''),
                    'product_sku' => $data['product']->sku,
                    'price' => $data['product']->price,
                    'discount' => $data['product']->discount,
                    'discounted_price' => $data['unitPrice'],
                    'quantity' => $data['quantity'],
                    'total' => $data['lineTotal'],
                ]);

                $data['product']->decrement('stock', $data['quantity']);
                if ($data['productColor']) {
                    $data['productColor']->decrement('stock', $data['quantity']);
                }
            }

            DB::commit();

            return redirect()->route('admin.orders.show', $order)
                ->with('success', "Order {$order->order_number} created successfully.");
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Admin order creation failed: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create order: ' . $e->getMessage());
        }
    }

    public function exportCsv(Request $request)
    {
        $query = Order::with(['items.product']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('billing_name', 'like', "%{$search}%")
                    ->orWhere('billing_email', 'like', "%{$search}%")
                    ->orWhere('billing_phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->latest()->get();

        $filename = 'orders-' . now()->format('Y-m-d-His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($orders) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Order #',
                'Date',
                'Customer Name',
                'Email',
                'Phone',
                'Address',
                'City',
                'State',
                'Pincode',
                'Items',
                'Item Details',
                'Subtotal',
                'Shipping',
                'Total',
                'Status',
                'Payment Status',
                'Payment Method',
                'Razorpay Payment ID',
                'Notes',
            ]);

            foreach ($orders as $order) {
                $itemDetails = $order->items->map(function ($item) {
                    return $item->product_name . ' x' . $item->quantity . ' @ Rs.' . number_format($item->discounted_price, 2);
                })->implode(' | ');

                fputcsv($file, [
                    $order->order_number,
                    $order->created_at->format('d-m-Y H:i:s'),
                    $order->billing_name,
                    $order->billing_email,
                    $order->billing_phone,
                    $order->billing_address,
                    $order->billing_city,
                    $order->billing_state,
                    $order->billing_pincode,
                    $order->items->sum('quantity'),
                    $itemDetails,
                    $order->subtotal,
                    $order->shipping,
                    $order->total,
                    ucfirst($order->status),
                    ucfirst($order->payment_status),
                    $order->payment_method ?? '',
                    $order->razorpay_payment_id ?? '',
                    $order->notes ?? '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
