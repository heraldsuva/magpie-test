@extends('layouts.app')

@section('content')
    <h3>{{ __('Cart') }}</h3>
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">   
            <div id="cartTable">
                <div class="table-responsive">
                    <table class="table border-top border-200">
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Name</th>
                                <th class="text-end">Unit Price</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-end">Total</th>
                                <th>&nbsp;</th>
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
                                <td class="text-end">{{ number_format($item->price, 2) }}</td>
                                <td>                      
                                    <input type="number" min="1" class="form-control cartItemQuantity" value="{{ $item->quantity }}" style="width: 70px;" data-item-id={{ $item->id }} data-item-price="{{ $item->price }}">                                 
                                </td>
                                <td class="total text-end"><span class="cartItemTotal">{{ number_format(floatval($item->price) * (int) $item->quantity, 2) }}</span> </td>
                                <td class="text-end">
                                    <form action="{{ route('cart.remove') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" value="{{ $item->id }}" name="id">
                                        <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Remove</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="{{ route('cart.clear') }}" class="btn btn-danger">Remove All</a>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-between-center mb-3">
                        <h3 class="card-title mb-0">Summary</h3>
                    </div>
                    <div>
                        <div class="d-flex justify-content-between">
                            <p class="text-900 fw-semi-bold">Items subtotal :</p>
                            <p class="text-1100 fw-semi-bold cartTotal">{{ number_format($total, 2) }} </p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="text-900 fw-semi-bold">Discount :</p>
                            <p class="text-danger fw-semi-bold">0</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="text-900 fw-semi-bold">Tax :</p>
                            <p class="text-1100 fw-semi-bold">0</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="text-900 fw-semi-bold">Subtotal :</p>
                            <p class="text-1100 fw-semi-bold cartTotal">{{ $total }} </p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="text-900 fw-semi-bold">Shipping Cost :</p>
                            <p class="text-1100 fw-semi-bold">0</p>
                        </div>
                    </div>
            
                    <div class="d-flex justify-content-between border-y border-dashed py-3 mb-4">
                        <h4 class="mb-0">Total :</h4>
                        <h4 class="mb- cartTotal">{{ $total }} </h4>
                    </div>
                    <form action="{{route('checkout')}}" method="POST">
                        @csrf
                        <button
                            type="submit"
                            @class([
                                'btn',
                                'btn-primary',
                                'w-100',
                                'disabled' => $total == 0 ? true : false
                            ])
                        >Checkout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
 
@endsection

@push('page_scripts')
    <script type="module">
        $(document).ready(function(e){
            $('.cartItemQuantity').on('change', function(e) {
                let el_Quantity = $(this),
                    itemId = el_Quantity.data('item-id'),
                    itemPrice = parseInt(el_Quantity.data('item-price')) / 100,
                    quantity = parseInt(el_Quantity.val()),
                    itemTotal = itemPrice * quantity;
        
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: '/cart/update',
                    dataType: 'json',
                    data: {
                        id: itemId,
                        quantity: quantity
                    },
                    success: function(response) {
                        el_Quantity.parents('tr').find('.cartItemTotal').text(itemTotal.toFixed(2));
                        $('.cartTotal').text(response.total);
                    }, 
                    error: function() {
                        console.log('error')
                    }
                });
            });
        });
    </script>
@endpush
