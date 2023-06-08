@extends('layouts.app')

@section('title', 'ShopCart')

@section('content')

<main>
    <div class="container py-5">
        <div class="row" style="border-left: 0.5rem solid red; margin-bottom: 2rem;"><h2>Shopcart</h2></div>
        <div class="row d-flex justify-content-center my-4">
            <div class="col-md-9">
                <div class="mb-4">
                    <!-- Single item -->
                    @each('partials.product_shopcart_card', $products, 'product')
                    <!-- Single item -->
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-4 wishlist_summary">
                    <h4 class="mb-3"><strong>Summary</strong></h4>
                    <ul class="list-group list-group-flush">
                        <li
                        class="list-group-item d-flex justify-content-between align-items-center border-0 p-0 mb-2">
                        Products
                        <span id="total_products">{{sizeof($products)}}</span>
                        </li>
                        <li
                        class="list-group-item d-flex justify-content-between align-items-center border-0 p-0 mb-3">
                        <strong>TOTAL</strong>
                        <span><strong id="shop_cart_total_price">{{ $shop_cart_totalPrice }} €</strong></span>
                        </li>
                    </ul>
                    <hr class="my-4" />
                    <div class="text-center">
                        <a class="btn btn-info btn-lg" href="/checkout">
                            Checkout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


@endsection