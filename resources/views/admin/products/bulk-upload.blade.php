@extends('admin.layouts.app')

@section('title', 'Bulk Upload Products')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">Bulk Upload Products</h2>
                <p class="text-sm text-gray-500 mt-1">Import multiple products at once using a CSV file</p>
            </div>
            <a href="{{ route('admin.products.index') }}" class="text-gray-600 hover:text-gray-800 border border-gray-300 px-4 py-2 rounded-lg">
                Back to Products
            </a>
        </div>

        <div class="p-6">
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('import_errors'))
                <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 text-yellow-800 rounded-lg">
                    <p class="font-medium mb-2">Import Warnings:</p>
                    <ul class="list-disc list-inside text-sm space-y-1 max-h-40 overflow-y-auto">
                        @foreach(session('import_errors') as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Step 1: Download Template -->
            <div class="mb-8">
                <h3 class="text-md font-semibold text-gray-700 mb-3 flex items-center gap-2">
                    <span class="w-7 h-7 bg-amber-600 text-white rounded-full flex items-center justify-center text-sm">1</span>
                    Download CSV Template
                </h3>
                <p class="text-sm text-gray-600 mb-3 ml-9">Download the template file, fill in your product data, then upload it below.</p>
                <div class="ml-9">
                    <a href="{{ route('admin.products.bulk.template') }}" class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Download Template CSV
                    </a>
                </div>
            </div>

            <!-- Step 2: Upload CSV -->
            <div class="mb-6">
                <h3 class="text-md font-semibold text-gray-700 mb-3 flex items-center gap-2">
                    <span class="w-7 h-7 bg-amber-600 text-white rounded-full flex items-center justify-center text-sm">2</span>
                    Upload Your CSV
                </h3>

                <form action="{{ route('admin.products.bulk.upload') }}" method="POST" enctype="multipart/form-data" class="ml-9">
                    @csrf

                    <div class="grid md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">CSV File *</label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-amber-400 transition cursor-pointer" onclick="document.getElementById('csv_file').click()">
                                <input type="file" name="csv_file" id="csv_file" accept=".csv,.txt" class="hidden" onchange="updateFileName(this)">
                                <svg class="w-10 h-10 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                <p class="text-sm text-gray-600" id="file-name-display">Click to select CSV file</p>
                                <p class="text-xs text-gray-400 mt-1">Max 5MB</p>
                            </div>
                            @error('csv_file')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Default Category (if not in CSV)</label>
                                <select name="default_category_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-amber-500 focus:border-amber-500">
                                    <option value="">-- None --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="skip_duplicates" value="1" checked class="rounded border-gray-300 text-amber-600 focus:ring-amber-500">
                                    <span class="text-sm text-gray-700">Skip duplicate products (matching by name/slug)</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="bg-amber-600 text-white px-6 py-2.5 rounded-lg hover:bg-amber-700 transition font-medium inline-flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        Import Products
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- CSV Format Reference -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-md font-semibold text-gray-800">CSV Column Reference</h3>
        </div>
        <div class="p-6 overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left font-medium text-gray-600">Column</th>
                        <th class="px-4 py-2 text-left font-medium text-gray-600">Required</th>
                        <th class="px-4 py-2 text-left font-medium text-gray-600">Description</th>
                        <th class="px-4 py-2 text-left font-medium text-gray-600">Example</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr>
                        <td class="px-4 py-2 font-mono text-xs bg-gray-50">name</td>
                        <td class="px-4 py-2"><span class="text-red-600 font-medium">Yes</span></td>
                        <td class="px-4 py-2 text-gray-600">Product name</td>
                        <td class="px-4 py-2 text-gray-500">Kanchipuram Silk Saree</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-mono text-xs bg-gray-50">category</td>
                        <td class="px-4 py-2"><span class="text-amber-600">Recommended</span></td>
                        <td class="px-4 py-2 text-gray-600">Category name (must match existing)</td>
                        <td class="px-4 py-2 text-gray-500">Silk Sarees</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-mono text-xs bg-gray-50">fabric</td>
                        <td class="px-4 py-2"><span class="text-gray-500">No</span></td>
                        <td class="px-4 py-2 text-gray-600">Fabric name (must match existing)</td>
                        <td class="px-4 py-2 text-gray-500">Pure Silk</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-mono text-xs bg-gray-50">work</td>
                        <td class="px-4 py-2"><span class="text-gray-500">No</span></td>
                        <td class="px-4 py-2 text-gray-600">Work type (must match existing)</td>
                        <td class="px-4 py-2 text-gray-500">Zari Work</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-mono text-xs bg-gray-50">price</td>
                        <td class="px-4 py-2"><span class="text-red-600 font-medium">Yes</span></td>
                        <td class="px-4 py-2 text-gray-600">Price in INR (number only)</td>
                        <td class="px-4 py-2 text-gray-500">12500</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-mono text-xs bg-gray-50">discount</td>
                        <td class="px-4 py-2"><span class="text-gray-500">No</span></td>
                        <td class="px-4 py-2 text-gray-600">Discount percentage (0-100)</td>
                        <td class="px-4 py-2 text-gray-500">10</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-mono text-xs bg-gray-50">stock</td>
                        <td class="px-4 py-2"><span class="text-gray-500">No</span></td>
                        <td class="px-4 py-2 text-gray-600">Stock quantity</td>
                        <td class="px-4 py-2 text-gray-500">5</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-mono text-xs bg-gray-50">length</td>
                        <td class="px-4 py-2"><span class="text-gray-500">No</span></td>
                        <td class="px-4 py-2 text-gray-600">Saree length</td>
                        <td class="px-4 py-2 text-gray-500">6.3 meters</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-mono text-xs bg-gray-50">blouse_length</td>
                        <td class="px-4 py-2"><span class="text-gray-500">No</span></td>
                        <td class="px-4 py-2 text-gray-600">Blouse piece length</td>
                        <td class="px-4 py-2 text-gray-500">0.8 meters</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-mono text-xs bg-gray-50">with_blouse</td>
                        <td class="px-4 py-2"><span class="text-gray-500">No</span></td>
                        <td class="px-4 py-2 text-gray-600">Includes blouse piece? (yes/no)</td>
                        <td class="px-4 py-2 text-gray-500">yes</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-mono text-xs bg-gray-50">short_description</td>
                        <td class="px-4 py-2"><span class="text-gray-500">No</span></td>
                        <td class="px-4 py-2 text-gray-600">Brief product description</td>
                        <td class="px-4 py-2 text-gray-500">A beautiful silk saree</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-mono text-xs bg-gray-50">description</td>
                        <td class="px-4 py-2"><span class="text-gray-500">No</span></td>
                        <td class="px-4 py-2 text-gray-600">Full product description</td>
                        <td class="px-4 py-2 text-gray-500">Detailed description...</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-mono text-xs bg-gray-50">is_featured</td>
                        <td class="px-4 py-2"><span class="text-gray-500">No</span></td>
                        <td class="px-4 py-2 text-gray-600">Feature on homepage? (yes/no)</td>
                        <td class="px-4 py-2 text-gray-500">no</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-mono text-xs bg-gray-50">is_active</td>
                        <td class="px-4 py-2"><span class="text-gray-500">No</span></td>
                        <td class="px-4 py-2 text-gray-600">Active/published? (yes/no)</td>
                        <td class="px-4 py-2 text-gray-500">yes</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-mono text-xs bg-gray-50">colors</td>
                        <td class="px-4 py-2"><span class="text-gray-500">No</span></td>
                        <td class="px-4 py-2 text-gray-600">Colors with stock. Format: Name:Stock:PriceAdj separated by |</td>
                        <td class="px-4 py-2 text-gray-500">Red:5:0|Blue:3:200</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Existing Reference Data -->
    <div class="grid md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h4 class="font-semibold text-gray-700 mb-3">Available Categories</h4>
            <div class="space-y-1 max-h-48 overflow-y-auto">
                @forelse($categories as $category)
                    <p class="text-sm text-gray-600">{{ $category->name }}</p>
                @empty
                    <p class="text-sm text-gray-400">No categories yet</p>
                @endforelse
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h4 class="font-semibold text-gray-700 mb-3">Available Fabrics</h4>
            <div class="space-y-1 max-h-48 overflow-y-auto">
                @forelse($fabrics as $fabric)
                    <p class="text-sm text-gray-600">{{ $fabric->name }}</p>
                @empty
                    <p class="text-sm text-gray-400">No fabrics yet</p>
                @endforelse
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h4 class="font-semibold text-gray-700 mb-3">Available Colors</h4>
            <div class="space-y-1 max-h-48 overflow-y-auto">
                @forelse($colors as $color)
                    <p class="text-sm text-gray-600 flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full inline-block border border-gray-200" style="background-color: {{ $color->hex_code ?? '#ccc' }}"></span>
                        {{ $color->name }}
                    </p>
                @empty
                    <p class="text-sm text-gray-400">No colors yet</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function updateFileName(input) {
    const display = document.getElementById('file-name-display');
    if (input.files.length > 0) {
        display.textContent = input.files[0].name;
        display.classList.add('text-amber-700', 'font-medium');
    }
}
</script>
@endpush
@endsection
