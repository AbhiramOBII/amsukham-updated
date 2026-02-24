<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoSetting;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    public function index()
    {
        $seoSettings = SeoSetting::all();
        return view('admin.seo.index', compact('seoSettings'));
    }

    public function edit(string $pageIdentifier)
    {
        $seo = SeoSetting::firstOrCreate(
            ['page_identifier' => $pageIdentifier],
            ['meta_title' => ucwords(str_replace('-', ' ', $pageIdentifier))]
        );

        return view('admin.seo.edit', compact('seo'));
    }

    public function update(Request $request, string $pageIdentifier)
    {
        $validated = $request->validate([
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:255',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string',
            'og_image' => 'nullable|string|max:255',
        ]);

        SeoSetting::updateOrCreate(
            ['page_identifier' => $pageIdentifier],
            $validated
        );

        return redirect()->route('admin.seo.index')
            ->with('success', 'SEO settings updated successfully.');
    }
}
