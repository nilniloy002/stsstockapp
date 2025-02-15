@extends('layouts.masternew')

@section('content')
    <div class="card">
        <div class="card-header">
            Add Asset
        </div>
        <div class="card-body">
            <form action="{{ route('admin.assets.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="asset_name" class="form-label">Asset Name</label>
                    <input type="text" name="asset_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="asset_category_id" class="form-label">Category</label>
                    <select name="asset_category_id" id="category" class="form-control" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="asset_sub_category_id" class="form-label">Subcategory</label>
                    <select name="asset_sub_category_id" id="subcategory" class="form-control" required>
                        <option value="">Select Subcategory</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="asset_image" class="form-label">Asset Image</label>
                    <input type="file" name="asset_image" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" name="quantity" class="form-control" required min="0">
                </div>
                <div class="mb-3">
                    <label for="in_use" class="form-label">In Use</label>
                    <input type="number" name="in_use" class="form-control" value="0" min="0">
                </div>
                <div class="mb-3">
                    <label for="in_stock" class="form-label">In Stock</label>
                    <input type="number" name="in_stock" class="form-control" value="0" min="0">
                </div>
                <div class="mb-3">
                    <label for="is_disabled" class="form-label">Is Disabled</label>
                    <input type="number" name="is_disabled" class="form-control" value="0" min="0">
                </div>
                <div class="mb-3">
                    <label for="is_lost" class="form-label">Is Lost</label>
                    <input type="number" name="is_lost" class="form-control" value="0" min="0">
                </div>
                <div class="mb-3">
                    <label for="pricing" class="form-label">Pricing</label>
                    <input type="number" name="pricing" class="form-control" value="0" step="0.01" min="0">
                </div>
                <div class="mb-3">
                    <label for="lost_approved" class="form-label">Lost Approved By</label>
                    <select name="lost_approved" class="form-control">
                        <option value="">Select</option>
                        <option value="Anup Saha">Anup Saha</option>
                        <option value="Devjit Saha">Devjit Saha</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="warranty_from" class="form-label">Warranty From</label>
                    <input type="date" name="warranty_from" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="warranty_to" class="form-label">Warranty To</label>
                    <input type="date" name="warranty_to" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="note" class="form-label">Note</label>
                    <textarea name="note" class="form-control"></textarea>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="on">On</option>
                        <option value="off">Off</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('admin.assets.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#category').on('change', function () {
            var categoryId = $(this).val();
            if (categoryId) {
                $.ajax({
                    url: "{{ url('/admin/get-subcategories') }}/" + categoryId,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $('#subcategory').html('<option value="">Select Subcategory</option>');
                        $.each(data, function (key, value) {
                            $('#subcategory').append('<option value="' + value.id + '">' + value.subcategory_name + '</option>');
                        });
                    }
                });
            } else {
                $('#subcategory').html('<option value="">Select Subcategory</option>');
            }
        });
    });
</script>
@endsection
