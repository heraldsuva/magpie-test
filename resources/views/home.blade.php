@extends('layouts.app')

@section('content')
    <h3>{{ __('Shop') }}</h3>
    <div class="row">
        @foreach ($products as $product)
            <div class="col-12 col-sm-6 col-md-3 mt-4">
                <div class="card h-100">
                    <img class="card-img-top" src="{{ $product->image }}" alt="{{ $product->name }}">
                    <div class="card-body p-4">
                        <div class="text-center">
                            <h5 class="fw-bolder">{{ $product->name }}</h5>
                            <h6> {{ $product->description }} </h6>
                            {{ $product->getPriceFormat() }}
                        </div>
                    </div>
                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                        <form action="{{ route('cart.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{ $product->id }}" name="id">
                            <input type="hidden" value="{{ $product->name }}" name="name">
                            <input type="hidden" value="{{ $product->price }}" name="price">
                            <input type="hidden" value="{{ $product->image }}" name="image">
                            <input type="hidden" value="{{ $product->description }}" name="description">
                            <button class="btn btn-primary w-100" type="submit">Add To Cart</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection