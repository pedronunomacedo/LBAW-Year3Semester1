<div class="product_wishlist_card row mb-3">
    <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
        <a href="{{ route('product', ['product_id'=> $product->id]) }}"><img class="card-img-top w-100" src="{{$product->imgpath}}" alt="Card image cap"></a>
    </div>
    <div class="col-lg-7 col-md-6 my-4" id="product_info" style="position:relative">
        <div><h5 class="product_card_name"><a href="{{ route('product', ['product_id'=> $product->id]) }}">{{$product->prodname}}</a></h5></div>
        <div class="product_card_btn" id="card_buttons" style="position:absolute; bottom: 0;">
            <button class="btn p-0" onclick="addToShopCart({{ $product->id }})"><i class="fas fa-shopping-cart"></i> Cart</button>
            <button class="btn p-0 mx-4" data-bs-toggle="modal" data-bs-target="#removeWishlistProduct{{$product->id}}"><i class="fas fa-times"></i> Remove</button>
        </div>
    </div>
    <div class="col-lg-2 col-md-6 mb-4 my-4" id="product_price">
        <p class="text-center" style="color: red">
            <strong>{{$product->price}} €</strong>
        </p>
    </div>
    <div class="modal fade" id="removeWishlistProduct{{$product->id}}" tabindex="-1" aria-labelledby="removeWishlistProductLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="removeWishlistProduct{{$product->id}}Header">Remove Product from Wishlist</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    After this action <strong>{{$product->prodname}}</strong> will no longer be on your wishlist.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" onclick="removeFromWishlist({{$product->id}})">Remove</button>
                </div>
            </div>
        </div>
    </div>
</div>


