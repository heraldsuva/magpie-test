@extends('layouts.app')

@section('content')
    <h3>{{ __('Invoices') }}</h3>
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
                            <th>Amount</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoices as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->user->name}}</td>
                                <td>{{ $item->amount }}</td>
                                <td>&nbsp;</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection