@extends('layouts.app')

@section('content')
    <h3>{{ __('View Product') }}</h3>
    <div class="row">
        <div class="d-flex justify-content-end">
            <a href="{{route('admin.products.index')}}" class="btn btn-primary">Back</a>
            <a href="{{route('admin.products.edit', $product->id)}}" class="btn btn-warning mx-2">Edit</a>
        </div>
        <div class="col-4">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label> : <strong>{{$product->name}} </strong>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Description</label> : <strong>{{$product->description}} </strong>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Price</label> : <strong>{{$product->price}} </strong>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Stocks</label> : <strong>{{$product->stocks}} </strong>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Photo</label> : <img src="{{$product->image}}" alt="{{$product->name}}" width="200px">
            </div>
        </div>
    </div>
@endsection