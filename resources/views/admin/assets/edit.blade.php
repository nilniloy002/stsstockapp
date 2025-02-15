@extends('layouts.masternew')

@section('content')
    <div class="card">
        <div class="card-header">
            Edit Asset
        </div>
        <div class="card-body">
            <form action="{{ route('admin.assets.update', $asset->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="asset_name" class="form-label">Asset Name</label>
                    <input type="text" name="asset_name" class="form-control" value="{{ $asset->asset_name }}" required>
                </div>
                <div class="mb-3">
                    <label for="asset_category_id" class="form-label">Category</label>
                    <select name="asset_category_id" id="asset_category_id" class="form-control" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ isset($asset) && $asset->asset_category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="asset_sub_category_id" class="form-label">Subcategory</label>
                    <select name="asset_sub_category_id" id="asset_sub_category_id" class="form-control" required>
                        <option value="">Select Subcategory</option>
                        @if(isset($subCategories))
                            @foreach($subCategories as $subCategory)
                                <option value="{{ $subCategory->id }}" {{ isset($asset) && $asset->asset_sub_category_id == $subCategory->id ? 'selected' : '' }}>
                                    {{ $subCategory->subcategory_name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="mb-3">
                    <label for="asset_image" class="form-label">Asset Image</label>
                    <input type="file" name="asset_image" class="form-control">
                    @if($asset->asset_image)
                        <img src="{{ asset('storage/' . $asset->asset_image) }}" alt="Asset Image" width="100" class="mt-2">
                    @endif
                </div>
                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" name="quantity" class="form-control" value="{{ $asset->quantity }}" required min="0">
                </div>
                <div class="mb-3">
                    <label for="in_use" class="form-label">In Use</label>
                    <input type="number" name="in_use" class="form-control" value="{{ $asset->in_use }}" min="0">
                </div>
                <div class="mb-3">
                    <label for="in_stock" class="form-label">In Stock</label>
                    <input type="number" name="in_stock" class="form-control" value="{{ $asset->in_stock }}" min="0">
                </div>
                <div class="mb-3">
                    <label for="is_disabled" class="form-label">Is Disabled</label>
                    <input type="number" name="is_disabled" class="form-control" value="{{ $asset->is_disabled }}" min="0">
                </div>
                <div class="mb-3">
                    <label for="is_lost" class="form-label">Is Lost</label>
                    <input type="number" name="is_lost" class="form-control" value="{{ $asset->is_lost }}" min="0">
                </div>
                <div class="mb-3">
                    <label for="pricing" class="form-label">Pricing</label>
                    <input type="number" name="pricing" class="form-control" value="{{ $asset->pricing }}" step="0.01" min="0">
                </div>
                <div class="mb-3">
                    <label for="lost_approved" class="form-label">Lost Approved By</label>
                    <select name="lost_approved" class="form-control">
                        <option value="">Select</option>
                        <option value="Anup Saha" {{ $asset->lost_approved == 'Anup Saha' ? 'selected' : '' }}>Anup Saha</option>
                        <option value="Devjit Saha" {{ $asset->lost_approved == 'Devjit Saha' ? 'selected' : '' }}>Devjit Saha</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="warranty_from" class="form-label">Warranty From</label>
                    <input type="date" name="warranty_from" class="form-control" value="{{ $asset->warranty_from }}">
                </div>
                <div class="mb-3">
                    <label for="warranty_to" class="form-label">Warranty To</label>
                    <input type="date" name="warranty_to" class="form-control" value="{{ $asset->warranty_to }}">
                </div>
                <div class="mb-3">
                    <label for="note" class="form-label">Note</label>
                    <textarea name="note" class="form-control">{{ $asset->note }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="on" {{ $asset->status == 'on' ? 'selected' : '' }}>On</option>
                        <option value="off" {{ $asset->status == 'off' ? 'selected' : '' }}>Off</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.assets.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#asset_category_id').change(function () {
                let categoryId = $(this).val();
                let subCategorySelect = $('#asset_sub_category_id');
                subCategorySelect.empty().append('<option value="">Select Subcategory</option>');

                if (categoryId) {
                    $.ajax({
                        url: "{{ url('/admin/get-subcategories') }}/" + categoryId,
                        type: "GET",
                        success: function (response) {
                            if (response.length > 0) {
                                $.each(response, function (index, subCategory) {
                                    subCategorySelect.append(
                                        `<option value="${subCategory.id}">${subCategory.subcategory_name}</option>`
                                    );
                                });
                            }
                        },
                        error: function (xhr) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });

            // Auto-load subcategories when editing an existing asset
            let selectedCategoryId = $('#asset_category_id').val();
            let selectedSubCategoryId = "{{ isset($asset) ? $asset->asset_sub_category_id : '' }}";

            if (selectedCategoryId) {
                $.ajax({
                    url: "{{ url('/admin/get-subcategories') }}/" + selectedCategoryId,
                    type: "GET",
                    success: function (response) {
                        let subCategorySelect = $('#asset_sub_category_id');
                        subCategorySelect.empty().append('<option value="">Select Subcategory</option>');

                        $.each(response, function (index, subCategory) {
                            let isSelected = subCategory.id == selectedSubCategoryId ? 'selected' : '';
                            subCategorySelect.append(
                                `<option value="${subCategory.id}" ${isSelected}>${subCategory.subcategory_name}</option>`
                            );
                        });
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    </script>

@endsection