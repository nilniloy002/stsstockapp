@extends('layouts.masternew')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="float-start">Asset Details</h5>
            <a href="{{ route('admin.assets.index') }}" class="btn btn-secondary btn-sm float-end">Back to List</a>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th>Asset Name</th>
                            <td>{{ $asset->asset_name }}</td>
                        </tr>
                        <tr>
                            <th>Asssets Category</th>
                            <td>{{ $asset->category->category_name }}</td>
                        </tr>
                        <tr>
                            <th>Asssets Subcategory</th>
                            <td>{{ $asset->subCategory->subcategory_name }}</td>
                        </tr>
                        <tr>
                            <th>Quantity</th>
                            <td>{{ $asset->quantity }}</td>
                        </tr>

                        <tr>
                            <th>Assets Pricing</th>
                            <td>{{ $asset->pricing }}</td>
                        </tr>

                        <tr>
                            <th>In Use</th>
                            <td>{{ $asset->in_use }}</td>
                        </tr>
                        <tr>
                            <th>In Stock</th>
                            <td>{{ $asset->in_stock }}</td>
                        </tr>
                        <tr>
                            <th>Disabled</th>
                            <td>
                                @if($asset->is_disabled)
                                    <span class="badge bg-danger">{{ $asset->is_disabled }}</span>
                                @else
                                    <span class="badge bg-success">
                                        {{$asset->is_disabled }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Lost</th>
                            <td>
                                @if($asset->is_lost)
                                    <span class="badge bg-danger">{{$asset->is_lost}}</span>
                                @else
                                    <span class="badge bg-success">{{$asset->is_lost}}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Lost Approved By</th>
                            <td>
                            @if(isset($asset->lost_approved)==NULL)
                                    <span>-</span>
                                @else
                                    <span class="badge bg-danger">{{$asset->lost_approved}}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td>{{ $asset->created_at->format('d M Y, h:i A') }}</td>
                        </tr>
                        <tr>
                            <th>Updated At</th>
                            <td>{{ $asset->updated_at->format('d M Y, h:i A') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    @if($asset->image)
                        <div class="mb-3">
                            <label><strong>Asset Image:</strong></label>
                            <br>
                            <img src="{{ asset('uploads/assets/' . $asset->image) }}" class="img-fluid rounded" width="300">
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="card-footer text-end">
            <a href="{{ route('admin.assets.edit', $asset->id) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('admin.assets.destroy', $asset->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
        </div>
    </div>
@endsection
