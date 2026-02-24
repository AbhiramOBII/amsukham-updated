<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::latest()->paginate(20);
        return view('admin.colors.index', compact('colors'));
    }

    public function create()
    {
        return view('admin.colors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:colors',
            'hex_code' => 'nullable|string|max:7',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        Color::create($validated);

        return redirect()->route('admin.colors.index')->with('success', 'Color created successfully.');
    }

    public function edit(Color $color)
    {
        return view('admin.colors.edit', compact('color'));
    }

    public function update(Request $request, Color $color)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:colors,slug,' . $color->id,
            'hex_code' => 'nullable|string|max:7',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        $color->update($validated);

        return redirect()->route('admin.colors.index')->with('success', 'Color updated successfully.');
    }

    public function destroy(Color $color)
    {
        if ($color->products()->count() > 0) {
            return back()->with('error', 'Cannot delete color with associated products.');
        }

        $color->delete();

        return redirect()->route('admin.colors.index')->with('success', 'Color deleted successfully.');
    }
}
