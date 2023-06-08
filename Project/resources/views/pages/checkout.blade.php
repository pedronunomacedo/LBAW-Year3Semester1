@extends('layouts.app')

@section('title', 'Checkout')

@section('content')

<main>
    <div class="container py-5">
        <nav class="path" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="shopcart">ShopCart</a></li>
                <li class="breadcrumb-item active" style="color: black;">Checkout</li>
            </ol>
        </nav>
        <div class="row" style="border-left: 0.5rem solid red; margin-bottom: 2rem;"><h2>Checkout</h2></div>
        <div class="row d-flex justify-content-center my-4">
            <div class="col-md-9" style="margin-bottom: 20px">
                <div class="checkout_state_bar mb-3 d-flex align-items-center justify-content-center py-2">
                    <ul class="nav nav-pills nav-justified stepper-wrapper" id="pills-tab" role="tablist">
                        <li class="nav-item stepper-item active" id="billingAddress" role="presentation">
                            <div class="step-counter"></div>
                            <div class="step-name nav-link active" onclick="tabAddress()" id="pills-address-tab" data-bs-toggle="pill" data-bs-target="#pills-address" type="button" role="tab" aria-controls="pills-address" aria-selected="true">Billing Address</div>
                        </li>
                        <li class="nav-item stepper-item" id="paymentMethod" role="presentation">
                            <div class="step-counter"></div>
                            <div class="step-name nav-link" onclick="tabPayment()" id="pills-pay-tab" data-bs-toggle="pill" data-bs-target="#pills-pay" type="button" role="tab" aria-controls="pills-pay" aria-selected="false">Payment Method</div>
                        </li>
                        <li class="nav-item stepper-item" id="confirmCheckout" role="presentation">
                            <div class="step-counter"></div>
                            <div class="step-name nav-link" onclick="tabConfirm()" id="pills-confirm-tab" data-bs-toggle="pill" data-bs-target="#pills-confirm" type="button" role="tab" aria-controls="pills-confirm" aria-selected="false">Confirm Checkout</div>
                        </li>
                    </ul>
                </div>
                <div class="tab-content" id="pills-tabContentCheckout">
                    <div class="tab-pane fade show active p-2 checkout_tab" id="pills-address" role="tabpanel" aria-labelledby="pills-address-tab">
                        <p class="mb-5">Choose a billing address from the following:</p>
                        <div style="display: flex; gap: 2rem;">
                            @each('partials.address_card', Auth::user()->address()->get(), 'address')
                        </div>
                        <div><button id="continue_button" class="btn btn-success" onclick="document.getElementById('pills-pay-tab').click()">Continue -></button></div>
                    </div>
                    <div class="tab-pane fade p-2 checkout_tab" id="pills-pay" role="tabpanel" aria-labelledby="pills-pay-tab">
                        <p class="mb-5">This are the available payment methods:</p>
                        <div class="row">
                            <div class="col-md-4 py-1 px-5" id="payment_option1">
                                <h5 class="mb-4 text-center">Transfer</h5>
                                <p><strong>IBAN: </strong>1234567890987654321</p>
                                <p><strong>Value: </strong>{{array_sum(array_column($products->toArray(), 'price'))}} €</p>
                            </div>
                            <div class="col-md-4 py-1 px-5" id="payment_option2">
                                <h5 class="mb-4 text-center">MultiBanco</h5>
                                <p><strong>Entidade: </strong>12345</p>
                                <p><strong>Referência: </strong>123 456 789</p>
                                <p><strong>Montante: </strong>{{array_sum(array_column($products->toArray(), 'price'))}} €</p>
                            </div>
                            <div class="col-md-4 py-1 px-5" id="payment_option3">
                                <h5 class="mb-4 text-center">MBway</h5>
                                <p><strong>Tel Number: </strong>912345678</p>
                                <p><strong>Amount: </strong>{{array_sum(array_column($products->toArray(), 'price'))}} €</p>
                            </div>
                        </div>
                        <button style="position: absolute; bottom: 1rem; right: 1rem;" class="btn btn-success" onclick="document.getElementById('pills-confirm-tab').click()">Continue -></button>
                    </div>
                    <div class="tab-pane fade p-2 checkout_tab" id="pills-confirm" role="tabpanel" aria-labelledby="pills-confirm-tab">
                        <h5 class="mb-5">Checkout Information</h5>
                        <p>- Before finishing checkout confirm that all information is correct.</p>
                        <p>- When checkout is confirmed an order will be created. Until the payment is completed the order is kept at "In Proccess" state.</p>
                        <p>- You can keep track of the order states at 'My Orders' page.</p>
                        <p>- For further questions or information Contact Us.</p>
                        <button style="position: absolute; bottom: 1rem; right: 1rem;" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#checkoutModal" onclick="tabAll()">Finish Checkout</button>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-4 wishlist_summary">
                    <h4 class="mb-3"><strong>Checkout Details</strong></h4>
                    <ul class="list-group list-group-flush">
                        <li
                        class="list-group-item d-flex justify-content-between align-items-center border-0 p-0 mb-2">
                        Products
                        <span>{{$shop_cart_totalProducts}}</span>
                        </li>
                        <li
                        class="list-group-item d-flex justify-content-between align-items-center border-0 p-0 mb-3">
                        <strong>TOTAL</strong>
                        <span><strong>{{ $shop_cart_totalPrice }} €</strong></span>
                        </li>
                    </ul>
                    <hr class="my-4" />
                    @foreach($products as $product)
                        <p><strong>{{$product->prodname}}</strong> | {{$product->pivot->quantity}} | {{$product->price}}<p>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="checkoutModalHeader">Finish your Purchase</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        After this action your order will be created.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" onclick="addToOrders()">Buy</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection