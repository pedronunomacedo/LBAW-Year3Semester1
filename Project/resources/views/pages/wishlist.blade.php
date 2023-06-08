@extends('layouts.app')

@section('title', 'Wishlist')

@section('content')

<main>
    <div class="container py-5">
        <div class="row" style="border-left: 0.5rem solid red; margin-bottom: 2rem;"><h2>Wishlist</h2></div>
        <div class="row d-flex justify-content-center my-4">
            <div class="col-md-9">
                <div class="mb-4">
                    <!-- Single item -->
                    @each('partials.product_wishlist_card', $products, 'product')
                    <!-- Single item -->
                </div>
            </div>
            <div class="col-lg-3">
                <div class="mb-4 wishlist_summary">
                    <h4 class="mb-3"><strong>Summary</strong></h4>
                    <ul class="list-group list-group-flush">
                        <li
                        class="list-group-item d-flex justify-content-between align-items-center border-0 p-0 mb-2">
                        Products
                        <span>{{sizeof($products)}}</span>
                        </li>
                        <li
                        class="list-group-item d-flex justify-content-between align-items-center border-0 p-0 mb-3">
                        <strong>TOTAL</strong>
                        <span id="total_price"><strong>{{array_sum(array_column($products->toArray(), 'price'))}} €</strong></span>
                        </li>
                    </ul>
                    <hr class="my-4" />
                    <div class="text-center">
                        <button type="button" class="btn btn-info btn-lg" onclick="addAllToShopCart({{$products}})">
                            Add All To ShopCart
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


@endsection