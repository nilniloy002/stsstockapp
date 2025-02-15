@extends('layouts.masternew')

@section('content')
    <div class="card">
        <div class="card-header">
            Add Asset Sub Category
        </div>
        <div class="card-body">
            <form action="{{ route('admin.asset-sub-categories.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select name="category_id" class="form-control" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="subcategory_name" class="form-label">Subcategory Name</label>
                    <input type="text" name="subcategory_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="on">On</option>
                        <option value="off">Off</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('admin.asset-sub-categories.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection