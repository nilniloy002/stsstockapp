@extends('layouts.masternew')

@section('content')
    <div class="card">
        <div class="card-header">
            Edit Asset Category
        </div>
        <div class="card-body">
            <form action="{{ route('admin.asset-categories.update', $assetCategory->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="category_name" class="form-label">Category Name</label>
                    <input type="text" name="category_name" class="form-control" value="{{ $assetCategory->category_name }}" required>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="on" {{ $assetCategory->status == 'on' ? 'selected' : '' }}>On</option>
                        <option value="off" {{ $assetCategory->status == 'off' ? 'selected' : '' }}>Off</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.asset-categories.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection