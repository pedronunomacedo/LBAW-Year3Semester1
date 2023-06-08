@extends('layouts.app')

@section('title', 'Tech4You')

@section('content')

<main>
    <div class="mt-5 container">
        <nav class="path" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" style="color: black;">My orders</li>
            </ol>
        </nav>
        <div class="row" style="border-left: 0.5rem solid red; margin-bottom: 2rem;"><h2>My Orders</h2></div>
        @if(count($userOrders) == 0)
            <h3>Sorry, we could not find any orders</i></h3>
        @else
            @each('partials.order_card', $userOrders, 'order')
        @endif
    </div>
<main>


@endsection