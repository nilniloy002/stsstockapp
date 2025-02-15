<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\AssetSubCategory;
use Illuminate\Support\Facades\Storage;

class AssetController extends Controller
{
    /**
     * Display a listing of the assets.
     */
    public function index(Request $request)
    {
        $query = Asset::with(['category', 'subCategory'])->orderBy('id', 'desc');
    
        if ($request->has('category_id') && !empty($request->category_id)) {
            $query->where('asset_category_id', $request->category_id);
        }
    
        if ($request->has('subcategory_id') && !empty($request->subcategory_id)) {
            $query->where('asset_sub_category_id', $request->subcategory_id);
        }
    
        $assets = $query->paginate(10);
        $categories = AssetCategory::where('status', 'on')->get();
    
        return view('admin.assets.index', compact('assets', 'categories'));
    }
    
    public function show($id)
    {
        $asset = Asset::with(['category', 'subCategory'])->findOrFail($id);
        return view('admin.assets.show', compact('asset'));
    }

    /**
     * Show the form for creating a new asset.
     */
    public function create()
    {
        $categories = AssetCategory::where('status', 'on')->get();
        $subCategories = AssetSubCategory::where('status', 'on')->get();
        return view('admin.assets.create', compact('categories', 'subCategories'));
    }

    /**
     * Store a newly created asset in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'asset_name' => 'required|string|max:255',
            'asset_category_id' => 'required|exists:asset_categories,id',
            'asset_sub_category_id' => 'required|exists:asset_sub_categories,id',
            'asset_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'quantity' => 'required|integer|min:0',
            'in_use' => 'nullable|integer|min:0',
            'in_stock' => 'nullable|integer|min:0',
            'is_disabled' => 'nullable|integer',
            'is_lost' => 'nullable|integer',
            'lost_approved' => 'nullable|in:Anup Saha,Devjit Saha',
            'warranty_from' => 'nullable|date',
            'warranty_to' => 'nullable|date',
            'note' => 'nullable|string',
            'pricing' => 'nullable|numeric|min:0',
            'status' => 'required|in:on,off',
        ]);

        // Handle File Upload
        $imagePath = null;
        if ($request->hasFile('asset_image')) {
            $imagePath = $request->file('asset_image')->store('assets', 'public');
        }

        // Store Asset
        Asset::create([
            'asset_name' => $request->asset_name,
            'asset_category_id' => $request->asset_category_id,
            'asset_sub_category_id' => $request->asset_sub_category_id,
            'asset_image' => $imagePath,
            'quantity' => $request->quantity,
            'in_use' => $request->in_use ?? 0,
            'in_stock' => $request->in_stock ?? 0,
            'is_disabled' => $request->is_disabled ?? 0,
            'is_lost' => $request->is_lost ?? 0,
            'lost_approved' => $request->lost_approved,
            'warranty_from' => $request->warranty_from,
            'warranty_to' => $request->warranty_to,
            'note' => $request->note,
            'pricing' => $request->pricing,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.assets.index')->with('success', 'Asset added successfully!');
    }

    /**
     * Show the form for editing the specified asset.
     */
    public function edit(Asset $asset)
    {
        $categories = AssetCategory::where('status', 'on')->get();
        $subCategories = AssetSubCategory::where('status', 'on')->get();
        return view('admin.assets.edit', compact('asset', 'categories', 'subCategories'));
    }

    /**
     * Update the specified asset in storage.
     */
    public function update(Request $request, Asset $asset)
    {
        $request->validate([
            'asset_name' => 'required|string|max:255',
            'asset_category_id' => 'required|exists:asset_categories,id',
            'asset_sub_category_id' => 'required|exists:asset_sub_categories,id',
            'asset_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'quantity' => 'required|integer|min:0',
            'in_use' => 'nullable|integer|min:0',
            'in_stock' => 'nullable|integer|min:0',
            'is_disabled' => 'nullable|integer',
            'is_lost' => 'nullable|integer',
            'lost_approved' => 'nullable|in:Anup Saha,Devjit Saha',
            'warranty_from' => 'nullable|date',
            'warranty_to' => 'nullable|date',
            'note' => 'nullable|string',
            'pricing' => 'nullable|numeric|min:0',
            'status' => 'required|in:on,off',
        ]);

        // Handle File Upload
        if ($request->hasFile('asset_image')) {
            // Delete old image if exists
            if ($asset->asset_image) {
                Storage::disk('public')->delete($asset->asset_image);
            }
            // Store new image
            $imagePath = $request->file('asset_image')->store('assets', 'public');
            $asset->update(['asset_image' => $imagePath]);
        }

        // Update Asset
        $asset->update([
            'asset_name' => $request->asset_name,
            'asset_category_id' => $request->asset_category_id,
            'asset_sub_category_id' => $request->asset_sub_category_id,
            'quantity' => $request->quantity,
            'in_use' => $request->in_use ?? 0,
            'in_stock' => $request->in_stock ?? 0,
            'is_disabled' => $request->is_disabled ?? 0,
            'is_lost' => $request->is_lost ?? 0,
            'lost_approved' => $request->lost_approved,
            'warranty_from' => $request->warranty_from,
            'warranty_to' => $request->warranty_to,
            'note' => $request->note,
            'pricing' => $request->pricing,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.assets.index')->with('success', 'Asset updated successfully!');
    }

    /**
     * Remove the specified asset from storage.
     */
    public function destroy(Asset $asset)
    {
        // Delete asset image if exists
        if ($asset->asset_image) {
            Storage::disk('public')->delete($asset->asset_image);
        }

        $asset->delete();
        return redirect()->route('admin.assets.index')->with('success', 'Asset deleted successfully!');
    }

    public function getSubcategories($category_id)
    {
        try {
            $subcategories = AssetSubCategory::where('category_id', $category_id)
                ->where('status', 'on') 
                ->get();

            return response()->json($subcategories);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    
}
