@extends('layouts.app')

@section('content')
    <h3>{{ __('Checkout') }}</h3>
    @if ($success == true)
        <div class="alert alert-success">Checkout success. See summary below.</div>
        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table border-top border-200">
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Name</th>
                                <th class="text-end">Unit Price</th>
                                <th class="text-end">Quantity</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                            <tr>
                                <td><img src="{{ $item->attributes->image }}" alt="{{ $item->name }}" width="50px"></td>
                                <td>
                                    {{ $item->name }} <br>
                                    {{ $item->attributes->description }}
                                </td>
                                <td class="text-end">{{ $item->price }}</td>
                                <td class="text-end">{{$item->quantity}} </td>
                                <td class="total text-end"><span class="cartItemTotal">{{ floatval($item->price) * (int) $item->quantity }}</span> </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="4" class="text-end">
                                    <span>Subtotal : </span><br>
                                    <span>Shipping Fee : </span><br>
                                    <strong>Total : </strong> 
                                </td>
                                <td class="text-end">
                                    <span>{{$total}}</span><br>
                                    <span>0</span><br>
                                    <strong>{{$total}}</strong>           
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-danger">Your checkout is not successful.</div>
    @endif
@endsection