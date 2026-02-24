<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Media</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-4">
    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold">Select Images <span id="selectedCount" class="text-sm text-gray-500 font-normal"></span></h2>
                <div class="flex items-center gap-3">
                    <button type="button" id="insertSelected" class="hidden bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 text-sm font-medium">
                        Insert Selected (<span id="insertCount">0</span>)
                    </button>
                    <label class="cursor-pointer bg-amber-600 text-white px-4 py-2 rounded-lg hover:bg-amber-700">
                        Upload New
                        <input type="file" class="hidden" id="quickUpload" accept="image/*" multiple>
                    </label>
                </div>
            </div>
            <p class="text-xs text-gray-500 mb-3">Click to select multiple images, then click "Insert Selected". Or click once to select a single image.</p>
            
            <div class="grid grid-cols-4 md:grid-cols-6 gap-3" id="mediaGrid">
                @foreach($media as $item)
                    <div class="media-item cursor-pointer relative group" data-id="{{ $item->id }}" data-url="{{ $item->url }}">
                        <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden border-2 border-transparent hover:border-amber-500 transition-colors">
                            <img src="{{ $item->url }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                        </div>
                        <div class="select-check hidden absolute top-1 right-1 bg-amber-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold shadow">&#10003;</div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-4">
                {{ $media->links() }}
            </div>
        </div>
    </div>

    <script>
    const selected = new Map();
    let clickTimeout = null;
    const mode = '{{ $mode }}';
    const maxImages = {{ $max }};
    const isMultiSelect = mode === 'multi';

    function updateUI() {
        const count = selected.size;
        const insertBtn = document.getElementById('insertSelected');
        const insertCount = document.getElementById('insertCount');
        const selectedCount = document.getElementById('selectedCount');
        
        if (count > 0) {
            insertBtn.classList.remove('hidden');
            insertCount.textContent = count;
            if (maxImages > 0) {
                selectedCount.textContent = '(' + count + '/' + maxImages + ' selected)';
            } else {
                selectedCount.textContent = '(' + count + ' selected)';
            }
        } else {
            insertBtn.classList.add('hidden');
            selectedCount.textContent = '';
        }

        document.querySelectorAll('.media-item').forEach(item => {
            const id = item.dataset.id;
            const border = item.querySelector('div');
            const check = item.querySelector('.select-check');
            if (selected.has(id)) {
                border.classList.remove('border-transparent');
                border.classList.add('border-amber-500');
                check.classList.remove('hidden');
            } else {
                border.classList.add('border-transparent');
                border.classList.remove('border-amber-500');
                check.classList.add('hidden');
            }
        });
    }

    document.querySelectorAll('.media-item').forEach(item => {
        item.addEventListener('click', function(e) {
            const id = this.dataset.id;
            const url = this.dataset.url;

            // Multi-select mode (for color variants)
            if (isMultiSelect) {
                if (selected.has(id)) {
                    selected.delete(id);
                } else {
                    if (maxImages > 0 && selected.size >= maxImages) {
                        alert('Maximum ' + maxImages + ' images allowed.');
                        return;
                    }
                    selected.set(id, url);
                }
                updateUI();
                return;
            }

            // Single select mode with auto-close
            if (selected.size === 0) {
                if (clickTimeout) {
                    clearTimeout(clickTimeout);
                    clickTimeout = null;
                    selected.set(id, url);
                    updateUI();
                    return;
                }
                clickTimeout = setTimeout(() => {
                    clickTimeout = null;
                    if (window.opener && window.opener.selectMedia) {
                        window.opener.selectMedia(parseInt(id), url);
                        window.close();
                    }
                }, 250);
                return;
            }

            // Toggle selection in single mode after first selection
            if (selected.has(id)) {
                selected.delete(id);
            } else {
                selected.set(id, url);
            }
            updateUI();
        });
    });

    document.getElementById('insertSelected').addEventListener('click', function() {
        if (window.opener && window.opener.selectMedia) {
            selected.forEach((url, id) => {
                window.opener.selectMedia(parseInt(id), url);
            });
            if (window.opener.closeMediaBrowser) {
                window.opener.closeMediaBrowser();
            }
            window.close();
        }
    });

    document.getElementById('quickUpload').addEventListener('change', async function() {
        const formData = new FormData();
        for (const file of this.files) {
            formData.append('files[]', file);
        }
        formData.append('_token', '{{ csrf_token() }}');

        const response = await fetch('{{ route("admin.media.store") }}', {
            method: 'POST',
            body: formData
        });

        if (response.ok) {
            location.reload();
        }
    });
    </script>
</body>
</html>
