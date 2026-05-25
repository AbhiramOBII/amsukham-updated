@extends('admin.layouts.app')

@section('title', 'Media Library')

@section('content')
<div class="bg-white rounded-lg shadow">
    <div class="p-6 border-b border-gray-200 flex items-center justify-between">
        <h2 class="text-lg font-semibold text-gray-800">Media Library</h2>
        <button onclick="document.getElementById('uploadModal').classList.remove('hidden')" class="bg-amber-600 text-white px-4 py-2 rounded-lg hover:bg-amber-700">
            Upload Files
        </button>
    </div>
    
    <div class="p-6">
        @if($media->isEmpty())
            <div class="text-center py-12 text-gray-500">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <p>No media files uploaded yet</p>
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($media as $item)
                    <div class="relative group">
                        <div class="bg-gray-100 rounded-lg overflow-hidden">
                            <img src="{{ $item->url }}" alt="{{ $item->alt_text ?? $item->name }}" class="w-full h-auto">
                        </div>
                        <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center gap-2">
                            <button onclick="copyUrl('{{ $item->url }}')" class="p-2 bg-white rounded-full hover:bg-gray-100" title="Copy URL">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                            </button>
                            <form action="{{ route('admin.media.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Delete this file?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 bg-white rounded-full hover:bg-red-100" title="Delete">
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                        <p class="mt-2 text-sm text-gray-600 truncate">{{ $item->name }}</p>
                    </div>
                @endforeach
            </div>
            <div class="mt-6">
                {{ $media->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Upload Modal -->
<div id="uploadModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl max-w-lg w-full mx-4">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-lg font-semibold">Upload Files</h3>
            <button onclick="document.getElementById('uploadModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
                <input type="file" name="files[]" id="files" multiple accept="image/*" class="hidden" onchange="updateFileList(this)">
                <label for="files" class="cursor-pointer">
                    <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                    <p class="text-gray-600">Click to upload or drag and drop</p>
                    <p class="text-sm text-gray-400 mt-1">PNG, JPG, GIF, WEBP up to 5MB</p>
                </label>
            </div>
            <div id="fileList" class="mt-4 space-y-2"></div>
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('uploadModal').classList.add('hidden')" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700">Upload</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function copyUrl(url) {
    navigator.clipboard.writeText(url);
    alert('URL copied to clipboard!');
}

function updateFileList(input) {
    const fileList = document.getElementById('fileList');
    fileList.innerHTML = '';
    for (const file of input.files) {
        const div = document.createElement('div');
        div.className = 'flex items-center gap-2 text-sm text-gray-600';
        div.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg> ${file.name}`;
        fileList.appendChild(div);
    }
}
</script>
@endpush
@endsection
