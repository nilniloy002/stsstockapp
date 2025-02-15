@extends('layouts.masternew')

@section('content')
    <div class="card">
        <div class="card-header">
            Add Asset Category
        </div>
        <div class="card-body">
            <form action="{{ route('admin.asset-categories.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="category_name" class="form-label">Category Name</label>
                    <input type="text" name="category_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="on">On</option>
                        <option value="off">Off</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('admin.asset-categories.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection