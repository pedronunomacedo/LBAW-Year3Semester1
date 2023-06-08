<div class="product_wishlist_card row mb-3">
    <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
        <a href="{{ route('product', ['product_id'=> $product->id]) }}"><img class=" w-100" src="{{$product->imgpath}}" alt="Card image cap"></a>
    </div>
    <div class="col-lg-7 col-md-6 my-4" style="position:relative">
        <h5 class="product_card_name"><a href="{{ route('product', ['product_id'=> $product->id]) }}">{{$product->prodname}}</a></h5>
        <div class="d-flex my-auto" style="max-width: 200px">
            <button class="btn btn-primary px-3 me-2"
            onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                <i class="fas fa-minus" onclick="decrement(this, {{ $product->stock }}, {{ $product }})"></i>
            </button>
            <div class="form-outline">
                <input id="form{{ $product->id }}" min="0" name="quantity" value="{{ Auth::user()->shopcart()->where('idproduct', $product->id)->get()->first()->pivot->quantity }}" type="number" class="form-control" />
            </div>
            <button class="btn btn-primary px-3 ms-2"
            onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                <i class="fas fa-plus" onclick="increment(this, {{ $product->stock }}, {{ $product }})"></i>
            </button>
        </div>
        <div class="col-lg-2 col-md-6 my-4" style="position:relative; right: -250px; bottom: 25px; width: 120px;">
            <p class="m-0" style="position:absolute; bottom: 0; color: red; font-size: 1.3rem">
                <strong>{{ $product->price }} €</strong> x <span id="product_shopcart_quantity{{ $product->id }}">{{ $product->quantity }}</span>
            </p>
        </div>
        <div class="product_card_btn" style="position:absolute;">
            <button class="btn p-0" data-bs-toggle="modal" data-bs-target="#removeShopCartProduct{{$product->id}}"><i class="fas fa-times"></i> Remove</button>
        </div>
    </div>
    <div class="modal fade" id="removeShopCartProduct{{$product->id}}" tabindex="-1" aria-labelledby="removeShopCartProductLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="removeShopCartProduct{{$product->id}}Header">Remove Product from ShopCart</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    After this action <strong>{{$product->prodname}}</strong> will no longer be on your shopcart.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" onclick="removeFromShopCart({{$product->id}})">Remove</button>
                </div>
            </div>
        </div>
    </div>
</div>