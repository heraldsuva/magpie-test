@extends('layouts.app')

@section('content')
    <h3>{{ __('Products') }}</h3>
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-end">
                <a href="{{route('admin.products.create')}}" class="btn btn-primary">New Product</a>
            </div>
            <div class="table-responsive mt-3">
                <table class="table border-top border-200">
                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Unit Price</th>
                            <th>Stocks</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $item)
                            <tr>
                                <td><img src="{{$item->image}}" alt="{{$item->name}}" width="60px"></td>
                                <td>{{ $item->name}}</td>
                                <td>{{ $item->description}} </td>
                                <td>{{ $item->getPriceFormat() }} </td>
                                <td>{{ $item->stock}}</td>
                                <td>
                                    <a href="{{route('admin.products.show', $item->id)}}" class="btn btn-sm btn-info">View</a>
                                    <a href="{{route('admin.products.edit', [$item->id])}}" class="btn btn-sm btn-warning mx-2">Edit</a>
                                    <form method="POST" action="{{route('admin.products.destroy', $item->id)}}" class="mt-2">
                                        @csrf
                                        @method('DELETE') 
                                        <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection