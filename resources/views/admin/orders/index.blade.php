@extends('layouts.app')

@section('content')
    <h3>{{ __('Orders') }}</h3>
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-end">
                <a href="{{route('admin.products.create')}}" class="btn btn-primary">New Product</a>
            </div>
            <div class="table-responsive mt-3">
                <table class="table border-top border-200">
                    <thead>
                        <tr>
                            <th>Invoice #</th>
                            <th>User</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $item)
                            <tr>
                                <td>{{ $item->invoice_id}}</td>
                                <td>{{ $item->user->name}}</td>
                                <td>
                                    {{$item->product->name}}
                                    {{-- <img src="{{$item->product->image}}" alt="{{$item->product->name}}" width="60px"> --}}
                                </td>
                                <td>{{ $item->price }} </td>
                                <td>{{ $item->quantity}} </td>
                                <td>&nbsp;</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection