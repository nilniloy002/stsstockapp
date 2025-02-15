@extends('layouts.masternew')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="float-start">
                Asset Sub Category List
            </div>
            <div class="float-end">
                <a class="btn btn-success btn-sm text-white" href="{{ route('admin.asset-sub-categories.create') }}">
                    Add Asset Sub Category
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Category</th>
                            <th>Subcategory Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assetSubCategories as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->category->category_name }}</td>
                                <td>{{ $item->subcategory_name }}</td>
                                <td>
                                    @if($item->status == 'on')
                                        <span class="badge bg-success">On</span>
                                    @else
                                        <span class="badge bg-danger">Off</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.asset-sub-categories.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('admin.asset-sub-categories.destroy', $item->id) }}" method="POST" style="display:inline;">
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
            {{ $assetSubCategories->links() }}
        </div>
    </div>
@endsection