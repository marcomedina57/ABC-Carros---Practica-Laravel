@extends('layouts.app')

@section('content')
    <h1>Your cart</h1>
    
    <div class="row">
        @if( !isset($cart) || $cart->products->isEmpty())
            <div class="alert alert-danger">
                Your cart is empty
            </div>

        @else 

        <h4 class = "text-center">
            <strong>Cart total: </strong> {{$cart->total}}
        </h4>
        <a class = "btn btn-success mb-3"
        href="{{route('orders.create')}}">
            Start Order
        </a>
        @endif
    </div>
        <div class="row">
            
            @foreach($cart->products as $product)
                <div class="col-3">
                    @include('components.product-card')               
                </div>        
            @endforeach
        </div>

@endsection