@extends('layouts.app')

@section('content')
    <h3>{{ __('New Product') }}</h3>
    <div class="row">
        <div class="col-4">
            <form method="POST" action="{{route('admin.products.update', $product->id)}}">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{$product->id}}">
                @include('admin.products.fields')  
                <div class="form-group mt-5">
                    <button class="btn btn-primary" type="submit">Save</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection