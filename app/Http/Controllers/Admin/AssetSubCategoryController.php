<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssetSubCategory;
use App\Models\AssetCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class AssetSubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assetSubCategories = AssetSubCategory::with('category')->orderBy('id', 'desc')->paginate(10);
        return view('admin.asset-sub-categories.index', compact('assetSubCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = AssetCategory::where('status', 'on')->get();
        return view('admin.asset-sub-categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:asset_categories,id',
            'subcategory_name' => 'required|string|max:255',
            'status' => 'required|in:on,off',
        ]);

        AssetSubCategory::create($request->all());

        return redirect()->route('admin.asset-sub-categories.index')->with('success', 'Asset Sub Category added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AssetSubCategory $assetSubCategory)
    {
        $categories = AssetCategory::where('status', 'on')->get();
        return view('admin.asset-sub-categories.edit', compact('assetSubCategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AssetSubCategory $assetSubCategory)
    {
        $request->validate([
            'category_id' => 'required|exists:asset_categories,id',
            'subcategory_name' => 'required|string|max:255',
            'status' => 'required|in:on,off',
        ]);

        $assetSubCategory->update($request->all());

        return redirect()->route('admin.asset-sub-categories.index')->with('success', 'Asset Sub Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AssetSubCategory $assetSubCategory)
    {
        $assetSubCategory->delete();
        return redirect()->route('admin.asset-sub-categories.index')->with('success', 'Asset Sub Category deleted successfully.');
    }
}