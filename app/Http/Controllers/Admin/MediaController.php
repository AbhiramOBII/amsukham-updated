<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function index()
    {
        $media = Media::latest()->paginate(24);
        return view('admin.media.index', compact('media'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'files.*' => 'required|file|mimes:jpeg,jpg,png,gif,webp,svg|max:5120',
        ]);

        $uploaded = [];

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('media', $fileName, 'public');

                $media = Media::create([
                    'name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                    'file_name' => $fileName,
                    'mime_type' => $file->getMimeType(),
                    'path' => $path,
                    'disk' => 'public',
                    'size' => $file->getSize(),
                ]);

                $uploaded[] = $media;
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'media' => $uploaded,
            ]);
        }

        return back()->with('success', count($uploaded) . ' file(s) uploaded successfully.');
    }

    public function update(Request $request, Media $media)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'alt_text' => 'nullable|string|max:255',
        ]);

        $media->update($request->only(['name', 'alt_text']));

        if ($request->ajax()) {
            return response()->json(['success' => true, 'media' => $media]);
        }

        return back()->with('success', 'Media updated successfully.');
    }

    public function destroy(Media $media)
    {
        Storage::disk($media->disk)->delete($media->path);
        $media->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Media deleted successfully.');
    }

    public function browse(Request $request)
    {
        $media = Media::latest()->paginate(24);
        $mode = $request->get('mode', 'single'); // 'single' or 'multi'
        $max = (int) $request->get('max', 0); // 0 = no limit
        return view('admin.media.browse', compact('media', 'mode', 'max'));
    }
}
