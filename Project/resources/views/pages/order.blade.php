@extends('layouts.app')

@section('title', 'Tech4You')

@section('content')

<main>
    <div class="mt-5 container">
        <nav class="path" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                @if(Auth::user()->isAdmin())
                <li class="breadcrumb-item"><a href="/adminManageOrders">Manage Orders</a></li>
                @else
                <li class="breadcrumb-item"><a href="/orders">My Orders</a></li>
                @endif
                <li class="breadcrumb-item active" style="color: black;">Order #{{$order->id}}</li>
            </ol>
        </nav>
        <div class="row d-flex justify-content-center my-4" style="background-color: white; padding: 1rem; border-radius:10px;">
			<h4 class="mb-4" style="text-decoration: underline 4px red">Order Info</h4>
			<div class="col-md-6" style="font-size: 1.1em">
                <div class="mb-4"><span><strong>Order: </strong>#{{ $order->id }}</span></div>
				<div class="mb-4"><span><strong>Date: </strong>{{ $order->orderdate }}</span></div>
			</div>
			<div class="col-md-6" style="font-size: 1.1em">
                <div class="mb-4"><span><strong>State: </strong>{{ $order->orderstate }}</span></div>
                <div class="mb-4"><span><strong>Total Price: </strong>{{ $order->products()->get()->sum('pivot.totalprice') }} €</span></div>
			</div>
        </div>
        <div class="row d-flex justify-content-center my-4" style="background-color: white; padding: 1rem; border-radius:10px;">
			<h4 class="mb-4" style="text-decoration: underline 4px red">Products</h4>
            <div class="d-flex justify-content-between align-items-center mb-2" style="border-bottom: 1px dashed black; padding: 1rem">
                <div class="col-md-8">
                    <h5 class="m-0">Name</h5>
                </div>
                <div class="col-md-2 text-center">
                    <h5 class="m-0">Quantity</h5>
                </div>
                <div class="col-md-2 text-center">
                    <h5 class="m-0">Price</h5>
                </div>
            </div>
            @foreach($order->products()->get() as $product)
                <div class="d-flex justify-content-between align-items-center mb-1" id="product_order">
                    <div class="col-md-8 product_name">
                        <span class="product_order_card_name"><a href="{{ route('product', ['product_id'=> $product->id]) }}">{{$product->prodname}}</a></span>
                    </div>
                    <div class="col-md-2 text-center product_quantity" >
                        <span>{{$product->pivot->quantity}}</span>
                    </div>
                    <div class="col-md-2 text-center product_price">
                        <span>{{$product->pivot->totalprice}} €<span>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row d-flex justify-content-center my-4" style="background-color: white; padding: 1rem; border-radius:10px;">
			<h4 class="mb-4" style="text-decoration: underline 4px red">Billing Address</h4>
            <div class="address_card" style="width: 22em;">
                <p><strong>Street: </strong>{{$address->street}}<p>
                <p><strong>City: </strong>{{$address->city}}, {{$address->country}}</p>
                <p><strong>Postal Code: </strong>{{$address->postalcode}}</p>
            </div>
        </div>
    </div>
<main>


@endsection