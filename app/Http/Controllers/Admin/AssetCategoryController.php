<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssetCategory;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class AssetCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assetCategories = AssetCategory::orderBy('id', 'desc')->paginate(10);
        return view('admin.asset-categories.index', compact('assetCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.asset-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'status' => 'required|in:on,off',
        ]);

        AssetCategory::create($request->all());

        return redirect()->route('admin.asset-categories.index')->with('success', 'Asset Category added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AssetCategory $assetCategory)
    {
        return view('admin.asset-categories.edit', compact('assetCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AssetCategory $assetCategory)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'status' => 'required|in:on,off',
        ]);

        $assetCategory->update($request->all());

        return redirect()->route('admin.asset-categories.index')->with('success', 'Asset Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AssetCategory $assetCategory)
    {
        $assetCategory->delete();
        return redirect()->route('admin.asset-categories.index')->with('success', 'Asset Category deleted successfully.');
    }
}