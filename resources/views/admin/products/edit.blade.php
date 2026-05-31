@extends('admin.layouts.app')

@section('title', 'Edit Product')

@section('content')
<form action="{{ route('admin.products.update', $product) }}" method="POST" class="space-y-6">
    @csrf @method('PUT')
    
    <div class="grid grid-cols-3 gap-6">
        <div class="col-span-2 space-y-6">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-800 mb-4">Basic Information</h3>
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">SKU</label>
                            <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
                            <input type="text" name="slug" value="{{ old('slug', $product->slug) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                            <select name="category_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Fabric</label>
                            <select name="fabric_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                <option value="">Select Fabric</option>
                                @foreach($fabrics as $fabric)
                                    <option value="{{ $fabric->id }}" {{ old('fabric_id', $product->fabric_id) == $fabric->id ? 'selected' : '' }}>{{ $fabric->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Work Type</label>
                            <select name="work_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                <option value="">Select Work Type</option>
                                @foreach($works as $work)
                                    <option value="{{ $work->id }}" {{ old('work_id', $product->work_id) == $work->id ? 'selected' : '' }}>{{ $work->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Short Description</label>
                        <textarea name="short_description" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ old('short_description', $product->short_description) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea name="description" id="description" rows="6" class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ old('description', $product->description) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-800 mb-4">Product Details</h3>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Length</label>
                    <input type="text" name="length" value="{{ old('length', $product->length) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div class="mt-4">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="with_blouse" id="with_blouse" value="1" {{ old('with_blouse', $product->with_blouse) ? 'checked' : '' }} class="rounded border-gray-300 text-amber-600" onchange="toggleBlouseLength()">
                        <span class="text-sm text-gray-700">Includes Blouse Piece</span>
                    </label>
                </div>
                <div id="blouse_length_field" class="mt-4" style="{{ old('with_blouse', $product->with_blouse) ? '' : 'display:none' }}">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Blouse Length</label>
                    <input type="text" name="blouse_length" value="{{ old('blouse_length', $product->blouse_length) }}" placeholder="e.g., 0.8 meters" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-800">Color Variants</h3>
                </div>
                <p class="text-sm text-gray-500 mb-4">Add color variants with their own images. SKU will be auto-generated.</p>
                <div id="colorVariantsContainer" class="space-y-4"></div>
                 <div class="flex justify-end">
                <button type="button" onclick="addColorVariant()" class="text-sm text-amber-600 hover:text-amber-700">+ Add Color</button>
            </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-800 mb-4">Product Thumbnail</h3>
                <p class="text-sm text-gray-500 mb-3">This image will be shown as the product card thumbnail in listings.</p>
                <div id="thumbnailPreview" class="mb-4"></div>
                <input type="hidden" name="thumbnail_id" id="thumbnail_id" value="{{ $product->thumbnail_id }}">
                <button type="button" onclick="openThumbnailBrowser()" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">Select Thumbnail from Media</button>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-800 mb-4">Product Gallery</h3>
                <p class="text-sm text-gray-500 mb-3">Additional images shown on the product detail page.</p>
                <div id="selectedImages" class="flex flex-wrap gap-4 mb-4"></div>
                <button type="button" onclick="openImageBrowser()" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">Select Images from Media</button>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-800">FAQs</h3>
                </div>
                <div id="faqContainer" class="space-y-4"></div>
                <div class="flex justify-end">
                <button type="button" onclick="addFaq()" class="text-sm text-amber-600 hover:text-amber-700">+ Add FAQ</button>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-800 mb-4">SEO Settings</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Meta Title</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title', $product->meta_title) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Meta Description</label>
                        <textarea name="meta_description" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ old('meta_description', $product->meta_description) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Meta Keywords</label>
                        <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $product->meta_keywords) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-800 mb-4">Pricing & Stock</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Price (₹) *</label>
                        <input type="number" name="price" value="{{ old('price', $product->price) }}" required min="0" step="0.01" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Discount (%)</label>
                        <input type="number" name="discount" value="{{ old('discount', $product->discount) }}" min="0" max="100" step="0.01" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Stock</label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-800 mb-4">Status</h3>
                <div class="space-y-3">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }} class="rounded border-gray-300 text-amber-600">
                        <span class="text-sm text-gray-700">Active</span>
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="is_featured" value="1" {{ $product->is_featured ? 'checked' : '' }} class="rounded border-gray-300 text-amber-600">
                        <span class="text-sm text-gray-700">Featured</span>
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="is_bestseller" value="1" {{ $product->is_bestseller ? 'checked' : '' }} class="rounded border-gray-300 text-amber-600">
                        <span class="text-sm text-gray-700">Bestseller</span>
                    </label>
                </div>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('admin.products.index') }}" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-center">Cancel</a>
                <button type="submit" class="flex-1 px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700">Update</button>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
    ClassicEditor.create(document.querySelector('#description')).catch(console.error);

    let productImages = @json($productImagesData ?? []);
    let thumbnailData = @json($product->thumbnail ? ['id' => $product->thumbnail_id, 'url' => $product->thumbnail->url] : null);
    let selectingThumbnail = false;
    let faqCount = 0;
    let colorCount = 0;
    let currentColorIndex = null;
    let colorImages = {};
    const availableColors = @json($colors);
    const existingProductColors = @json($productColors);
    const MAX_COLOR_IMAGES = 5;
    const MAX_PRODUCT_IMAGES = 5;

    renderThumbnail();
    renderProductImages();
    @foreach($product->faqs as $faq)
        addFaq('{{ addslashes($faq->question) }}', '{{ addslashes($faq->answer) }}');
    @endforeach

    existingProductColors.forEach(pc => {
        addColorVariant(pc.color_id, pc.stock, pc.price_adjustment, pc.images);
    });

    function toggleBlouseLength() {
        const checkbox = document.getElementById('with_blouse');
        const field = document.getElementById('blouse_length_field');
        field.style.display = checkbox.checked ? 'block' : 'none';
    }

    function openThumbnailBrowser() {
        selectingThumbnail = true;
        currentColorIndex = null;
        window.open('{{ route("admin.media.browse") }}?mode=single', 'mediaBrowser', 'width=900,height=600');
    }

    function openImageBrowser() {
        selectingThumbnail = false;
        currentColorIndex = null;
        window.open('{{ route("admin.media.browse") }}?mode=multi&max=5', 'mediaBrowser', 'width=900,height=600');
    }

    function openColorImageBrowser(colorIndex) {
        if (!colorImages[colorIndex]) colorImages[colorIndex] = [];
        if (colorImages[colorIndex].length >= MAX_COLOR_IMAGES) {
            alert('Maximum ' + MAX_COLOR_IMAGES + ' images per color.');
            return;
        }
        currentColorIndex = colorIndex;
        window.open('{{ route("admin.media.browse") }}?mode=multi&max=5', 'mediaBrowser', 'width=900,height=600');
    }

    function selectMedia(id, url) {
        if (selectingThumbnail) {
            thumbnailData = { id, url };
            document.getElementById('thumbnail_id').value = id;
            renderThumbnail();
            selectingThumbnail = false;
            return;
        }
        if (currentColorIndex !== null) {
            if (!colorImages[currentColorIndex]) colorImages[currentColorIndex] = [];
            if (colorImages[currentColorIndex].length >= MAX_COLOR_IMAGES) {
                alert('Maximum ' + MAX_COLOR_IMAGES + ' images per color.');
                return;
            }
            if (!colorImages[currentColorIndex].find(img => img.id === id)) {
                colorImages[currentColorIndex].push({ id, url });
                renderColorImages(currentColorIndex);
            }
        } else {
            if (productImages.length >= MAX_PRODUCT_IMAGES) {
                alert('Maximum ' + MAX_PRODUCT_IMAGES + ' images allowed.');
                return;
            }
            if (!productImages.find(img => img.id === id)) {
                productImages.push({ id, url });
                renderProductImages();
            }
        }
    }
    
    function closeMediaBrowser() {
        selectingThumbnail = false;
        currentColorIndex = null;
    }

    function renderThumbnail() {
        const container = document.getElementById('thumbnailPreview');
        if (!thumbnailData) {
            container.innerHTML = '';
            return;
        }
        container.innerHTML = `
            <div class="relative w-40">
                <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden border-2 border-amber-500">
                    <img src="${thumbnailData.url}" class="w-full h-full object-cover">
                </div>
                <button type="button" onclick="removeThumbnail()" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 text-xs flex items-center justify-center">×</button>
            </div>
        `;
    }

    function removeThumbnail() {
        thumbnailData = null;
        document.getElementById('thumbnail_id').value = '';
        renderThumbnail();
    }

    function renderProductImages() {
        const container = document.getElementById('selectedImages');
        container.innerHTML = productImages.map((img, index) => `
            <div class="relative w-32">
                <input type="hidden" name="product_images[]" value="${img.id}">
                <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden border border-gray-300">
                    <img src="${img.url}" class="w-full h-full object-cover">
                </div>
                <button type="button" onclick="removeProductImage(${index})" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 text-xs flex items-center justify-center">×</button>
            </div>
        `).join('');
    }

    function removeProductImage(index) {
        productImages.splice(index, 1);
        renderProductImages();
    }

    function addFaq(question = '', answer = '') {
        const container = document.getElementById('faqContainer');
        const div = document.createElement('div');
        div.className = 'p-4 bg-gray-50 rounded-lg';
        div.innerHTML = `
            <div class="flex justify-between items-start mb-2">
                <span class="text-sm font-medium text-gray-700">FAQ #${++faqCount}</span>
                <button type="button" onclick="this.closest('.p-4').remove()" class="text-red-500 text-sm">Remove</button>
            </div>
            <div class="space-y-3">
                <input type="text" name="faqs[${faqCount}][question]" value="${question}" placeholder="Question" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                <textarea name="faqs[${faqCount}][answer]" placeholder="Answer" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">${answer}</textarea>
            </div>
        `;
        container.appendChild(div);
    }

    function addColorVariant(colorId = '', stock = 0, priceAdj = 0, images = []) {
        const container = document.getElementById('colorVariantsContainer');
        const index = colorCount++;
        colorImages[index] = images || [];
        
        const colorOptions = availableColors.map(c => 
            `<option value="${c.id}" ${c.id == colorId ? 'selected' : ''}>${c.name}</option>`
        ).join('');
        
        const div = document.createElement('div');
        div.className = 'p-4 bg-gray-50 rounded-lg';
        div.id = `color-variant-${index}`;
        div.innerHTML = `
            <div class="flex justify-between items-start mb-3">
                <span class="text-sm font-medium text-gray-700">Color Variant</span>
                <button type="button" onclick="removeColorVariant(${index})" class="text-red-500 text-sm">Remove</button>
            </div>
            <div class="grid grid-cols-3 gap-3 mb-3">
                <div>
                    <label class="block text-xs text-gray-600 mb-1">Color *</label>
                    <select name="product_colors[${index}][color_id]" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                        <option value="">Select Color</option>
                        ${colorOptions}
                    </select>
                </div>
                <div>
                    <label class="block text-xs text-gray-600 mb-1">Stock</label>
                    <input type="number" name="product_colors[${index}][stock]" value="${stock}" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                </div>
                <div>
                    <label class="block text-xs text-gray-600 mb-1">Price Adjustment (₹)</label>
                    <input type="number" name="product_colors[${index}][price_adjustment]" value="${priceAdj}" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                </div>
            </div>
            <div>
                <label class="block text-xs text-gray-600 mb-1">Images for this color (max ${MAX_COLOR_IMAGES})</label>
                <div id="colorImages-${index}" class="grid grid-cols-6 gap-2 mb-2"></div>
                <button type="button" onclick="openColorImageBrowser(${index})" class="text-sm px-3 py-1 border border-gray-300 rounded hover:bg-gray-100">Select Images</button>
            </div>
        `;
        container.appendChild(div);
        renderColorImages(index);
    }

    function removeColorVariant(index) {
        const el = document.getElementById(`color-variant-${index}`);
        if (el) el.remove();
        delete colorImages[index];
    }

    function renderColorImages(index) {
        const container = document.getElementById(`colorImages-${index}`);
        if (!container) return;
        
        container.innerHTML = (colorImages[index] || []).map((img, i) => `
            <div class="relative">
                <input type="hidden" name="product_colors[${index}][images][]" value="${img.id}">
                <div class="aspect-square bg-gray-100 rounded overflow-hidden">
                    <img src="${img.url}" class="w-full h-full object-cover">
                </div>
                <button type="button" onclick="removeColorImage(${index}, ${i})" class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-4 h-4 text-xs">×</button>
            </div>
        `).join('');
    }

    function removeColorImage(colorIndex, imageIndex) {
        colorImages[colorIndex].splice(imageIndex, 1);
        renderColorImages(colorIndex);
    }
</script>
@endpush
@endsection
