@extends('layouts.masternew')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="float-start">
                Asset Category List
            </div>
            <div class="float-end">
                <a class="btn btn-success btn-sm text-white" href="{{ route('admin.asset-categories.create') }}">
                    Add Asset Category
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Category Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assetCategories as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->category_name }}</td>
                                <td>
                                    @if($item->status == 'on')
                                        <span class="badge bg-success">On</span>
                                    @else
                                        <span class="badge bg-danger">Off</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.asset-categories.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('admin.asset-categories.destroy', $item->id) }}" method="POST" style="display:inline;">
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
            {{ $assetCategories->links() }}
        </div>
    </div>
@endsection