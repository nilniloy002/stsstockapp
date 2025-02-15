@extends('layouts.masternew')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="float-start">
                <h5>Asset List</h5>
            </div>
            <div class="float-end">
                <a class="btn btn-success btn-sm text-white" href="{{ route('admin.assets.create') }}">
                    Add Asset
                </a>
            </div>
        </div>

        <div class="card-body">
            {{-- Filter Options --}}
            <form method="GET" id="filterForm">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="category_id">Category:</label>
                        <select class="form-control" name="category_id" id="category_id">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="subcategory_id">Subcategory:</label>
                        <select class="form-control" name="subcategory_id" id="subcategory_id">
                            <option value="">Select Subcategory</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ route('admin.assets.index') }}" class="btn btn-secondary ms-2">Reset</a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Asset Name</th>
                            <th>Category</th>
                            <th>Subcategory</th>
                            <th>Quantity</th>
                            <th>In Use</th>
                            <th>In Stock</th>
                            <th>Disabled</th>
                            <th>Lost</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assets as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->asset_name }}</td>
                                <td>{{ $item->category->category_name }}</td>
                                <td>{{ $item->subCategory->subcategory_name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->in_use }}</td>
                                <td>{{ $item->in_stock }}</td>
                                <td>{{ $item->is_disabled }}</td>
                                <td>{{ $item->is_lost }}</td>
                                <td>
                                <a href="{{ route('admin.assets.show', $item->id) }}" class="btn btn-info btn-sm">View</a>
                                    <a href="{{ route('admin.assets.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('admin.assets.destroy', $item->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer clearfix">
            {{ $assets->links() }}
        </div>
    </div>

    {{-- jQuery for Ajax --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var selectedSubcategory = "{{ request('subcategory_id') }}";

            $('#category_id').change(function() {
                var category_id = $(this).val();
                $('#subcategory_id').html('<option value="">Select Subcategory</option>');

                if (category_id) {
                    $.ajax({
                        url: '{{ url("admin/get-subcategories") }}/' + category_id,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            $.each(response, function(key, value) {
                                var isSelected = value.id == selectedSubcategory ? "selected" : "";
                                $('#subcategory_id').append('<option value="' + value.id + '" ' + isSelected + '>' + value.subcategory_name + '</option>');
                            });
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });

            // Trigger change event on page load if category is already selected
            if ($('#category_id').val()) {
                $('#category_id').trigger('change');
            }
        });
    </script>
@endsection
