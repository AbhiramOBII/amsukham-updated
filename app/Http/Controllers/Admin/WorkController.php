<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WorkController extends Controller
{
    public function index()
    {
        $works = Work::latest()->paginate(15);
        return view('admin.works.index', compact('works'));
    }

    public function create()
    {
        return view('admin.works.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:works',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['is_active'] = $request->has('is_active');

        Work::create($validated);

        return redirect()->route('admin.works.index')
            ->with('success', 'Work type created successfully.');
    }

    public function edit(Work $work)
    {
        return view('admin.works.edit', compact('work'));
    }

    public function update(Request $request, Work $work)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:works,slug,' . $work->id,
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['is_active'] = $request->has('is_active');

        $work->update($validated);

        return redirect()->route('admin.works.index')
            ->with('success', 'Work type updated successfully.');
    }

    public function destroy(Work $work)
    {
        if ($work->products()->count() > 0) {
            return back()->with('error', 'Cannot delete work type with associated products.');
        }

        $work->delete();

        return redirect()->route('admin.works.index')
            ->with('success', 'Work type deleted successfully.');
    }
}
