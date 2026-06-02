<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductColor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderStatusUpdate;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['items', 'user']);

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
