<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fabric;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FabricController extends Controller
{
    public function index()
    {
        $fabrics = Fabric::latest()->paginate(15);
        return view('admin.fabrics.index', compact('fabrics'));
    }

    public function create()
    {
        return view('admin.fabrics.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:fabrics',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['is_active'] = $request->has('is_active');

        Fabric::create($validated);

        return redirect()->route('admin.fabrics.index')
            ->with('success', 'Fabric created successfully.');
    }

    public function edit(Fabric $fabric)
    {
        return view('admin.fabrics.edit', compact('fabric'));
    }

    public function update(Request $request, Fabric $fabric)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:fabrics,slug,' . $fabric->id,
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['is_active'] = $request->has('is_active');

        $fabric->update($validated);

        return redirect()->route('admin.fabrics.index')
            ->with('success', 'Fabric updated successfully.');
    }

    public function destroy(Fabric $fabric)
    {
        if ($fabric->products()->count() > 0) {
            return back()->with('error', 'Cannot delete fabric with associated products.');
        }

        $fabric->delete();

        return redirect()->route('admin.fabrics.index')
            ->with('success', 'Fabric deleted successfully.');
    }
}
