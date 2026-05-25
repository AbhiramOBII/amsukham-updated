<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\Fabric;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductImage;
use App\Models\Media;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BulkProductController extends Controller
{
    public function index()
    {
        $categories = Category::active()->get();
        $fabrics = Fabric::active()->get();
        $works = Work::active()->get();
        $colors = Color::active()->get();

        return view('admin.products.bulk-upload', compact('categories', 'fabrics', 'works', 'colors'));
    }

    public function downloadTemplate()
    {
        $headers = [
            'name',
            'category',
            'fabric',
            'work',
            'price',
            'discount',
            'stock',
            'length',
            'blouse_length',
            'with_blouse',
            'short_description',
            'description',
            'is_featured',
            'is_active',
            'colors',
        ];

        $exampleRow = [
            'Kanchipuram Silk Saree',
            'Silk Sarees',
            'Pure Silk',
            'Zari Work',
            '12500',
            '10',
            '5',
            '6.3 meters',
            '0.8 meters',
            'yes',
            'A beautiful handwoven silk saree',
            'Detailed description of the product...',
            'yes',
            'yes',
            'Red:5:0|Blue:3:200',
        ];

        $csv = implode(',', $headers) . "\n";
        $csv .= implode(',', array_map(function ($val) {
            return '"' . str_replace('"', '""', $val) . '"';
        }, $exampleRow)) . "\n";

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="products_bulk_template.csv"',
        ]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:5120',
            'default_category_id' => 'nullable|exists:categories,id',
            'skip_duplicates' => 'nullable|boolean',
        ]);

        $file = $request->file('csv_file');
        $skipDuplicates = $request->boolean('skip_duplicates', true);

        // Read file content and ensure UTF-8 encoding
        $content = file_get_contents($file->getRealPath());
        $encoding = mb_detect_encoding($content, ['UTF-8', 'Windows-1252', 'ISO-8859-1', 'ASCII'], true);
        if ($encoding && $encoding !== 'UTF-8') {
            $content = mb_convert_encoding($content, 'UTF-8', $encoding);
        }
        // Remove BOM if present
        $content = preg_replace('/^\xEF\xBB\xBF/', '', $content);
        // Replace any remaining non-UTF-8 characters
        $content = mb_convert_encoding($content, 'UTF-8', 'UTF-8');

        $tempFile = tempnam(sys_get_temp_dir(), 'csv_');
        file_put_contents($tempFile, $content);

        $handle = fopen($tempFile, 'r');
        if (!$handle) {
            @unlink($tempFile);
            return back()->with('error', 'Could not read the CSV file.');
        }

        $headers = fgetcsv($handle);
        if (!$headers) {
            fclose($handle);
            @unlink($tempFile);
            return back()->with('error', 'CSV file is empty or has no headers.');
        }

        $headers = array_map(fn($h) => strtolower(trim($h)), $headers);

        $requiredHeaders = ['name', 'price'];
        foreach ($requiredHeaders as $req) {
            if (!in_array($req, $headers)) {
                fclose($handle);
                @unlink($tempFile);
                return back()->with('error', "Missing required column: {$req}");
            }
        }

        $categories = Category::all()->keyBy(fn($c) => strtolower($c->name));
        $fabrics = Fabric::all()->keyBy(fn($f) => strtolower($f->name));
        $works = Work::all()->keyBy(fn($w) => strtolower($w->name));
        $colors = Color::all()->keyBy(fn($c) => strtolower($c->name));

        $created = 0;
        $skipped = 0;
        $errors = [];
        $rowNum = 1;

        DB::beginTransaction();

        try {
            while (($row = fgetcsv($handle)) !== false) {
                $rowNum++;

                if (count($row) < count($headers)) {
                    $row = array_pad($row, count($headers), '');
                }

                $data = array_combine($headers, array_map('trim', $row));

                if (empty($data['name'])) {
                    $errors[] = "Row {$rowNum}: Name is required.";
                    continue;
                }

                if (empty($data['price']) || !is_numeric($data['price'])) {
                    $errors[] = "Row {$rowNum}: Valid price is required for '{$data['name']}'.";
                    continue;
                }

                $slug = Str::slug($data['name']);
                if ($skipDuplicates && Product::where('slug', $slug)->exists()) {
                    $skipped++;
                    continue;
                }

                // Make slug unique
                $originalSlug = $slug;
                $counter = 1;
                while (Product::where('slug', $slug)->exists()) {
                    $slug = $originalSlug . '-' . $counter++;
                }

                $categoryId = $request->default_category_id;
                if (!empty($data['category'])) {
                    $cat = $categories->get(strtolower($data['category']));
                    if ($cat) $categoryId = $cat->id;
                }

                if (!$categoryId) {
                    $errors[] = "Row {$rowNum}: No category found for '{$data['name']}'.";
                    continue;
                }

                $fabricId = null;
                if (!empty($data['fabric'])) {
                    $fab = $fabrics->get(strtolower($data['fabric']));
                    if ($fab) $fabricId = $fab->id;
                }

                $workId = null;
                if (!empty($data['work'])) {
                    $wrk = $works->get(strtolower($data['work']));
                    if ($wrk) $workId = $wrk->id;
                }

                $product = Product::create([
                    'name' => $this->sanitizeString($data['name']),
                    'slug' => $slug,
                    'category_id' => $categoryId,
                    'fabric_id' => $fabricId,
                    'work_id' => $workId,
                    'price' => (float) $data['price'],
                    'discount' => isset($data['discount']) && is_numeric($data['discount']) ? (float) $data['discount'] : 0,
                    'stock' => isset($data['stock']) && is_numeric($data['stock']) ? (int) $data['stock'] : 0,
                    'length' => $this->sanitizeString($data['length'] ?? null),
                    'blouse_length' => $this->sanitizeString($data['blouse_length'] ?? null),
                    'with_blouse' => $this->parseBool($data['with_blouse'] ?? 'yes'),
                    'short_description' => $this->sanitizeString($data['short_description'] ?? null),
                    'description' => $this->sanitizeString($data['description'] ?? null),
                    'is_featured' => $this->parseBool($data['is_featured'] ?? 'no'),
                    'is_active' => $this->parseBool($data['is_active'] ?? 'yes'),
                ]);

                // Handle colors: format "Red:5:0|Blue:3:200" (name:stock:price_adjustment)
                if (!empty($data['colors'])) {
                    $colorEntries = explode('|', $data['colors']);
                    foreach ($colorEntries as $entry) {
                        $parts = explode(':', $entry);
                        $colorName = trim($parts[0] ?? '');
                        $colorStock = (int) ($parts[1] ?? 0);
                        $priceAdj = (float) ($parts[2] ?? 0);

                        $color = $colors->get(strtolower($colorName));
                        if ($color) {
                            $sku = strtoupper(substr($data['name'], 0, 3)) . '-' . strtoupper(substr($colorName, 0, 3)) . '-' . str_pad($product->id, 4, '0', STR_PAD_LEFT);
                            ProductColor::create([
                                'product_id' => $product->id,
                                'color_id' => $color->id,
                                'sku' => $sku,
                                'stock' => $colorStock,
                                'price_adjustment' => $priceAdj,
                            ]);
                        }
                    }
                }

                $created++;
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            fclose($handle);
            @unlink($tempFile);
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }

        fclose($handle);
        @unlink($tempFile);

        $message = "{$created} product(s) imported successfully.";
        if ($skipped > 0) {
            $message .= " {$skipped} duplicate(s) skipped.";
        }
        if (!empty($errors)) {
            $message .= " " . count($errors) . " row(s) had errors.";
        }

        return back()->with('success', $message)->with('import_errors', $errors);
    }

    private function parseBool($value): bool
    {
        return in_array(strtolower(trim($value)), ['yes', '1', 'true', 'on']);
    }

    private function sanitizeString(?string $value): ?string
    {
        if ($value === null || $value === '') {
            return $value;
        }
        // Remove characters that aren't valid in utf8mb4
        return preg_replace('/[^\x{0000}-\x{FFFF}]/u', '', $value);
    }
}
