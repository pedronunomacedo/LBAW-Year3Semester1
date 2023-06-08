<div class="product_card mx-1" id="productCard {{ $product->id }} {{ $product->launchdate }} {{ $product->price }} {{ $product->score }} {{ $product->categoryname }}" style="width: 18rem;">
    <div class="product_card_img"><a style="display: block" href="{{ route('product', ['product_id'=> $product->id]) }}"><img src="{{$product->imgpath}}" alt="Card image cap"></a></div>
    <h5 class="product_card_name"><a href="{{ route('product', ['product_id'=> $product->id]) }}">{{$product->prodname}}</a></h5>
    <div class="product_card_desc text-muted small my-1">{{ $product->proddescription }}</div>
    <div class="product_card_ratings">
        <?php
        for ($x = 0; $x < $product->score; $x++) {?> 
            <i class="fa fa-star rating-color"></i>
        <?php } ?>
        <?php
        for ($x = 0; $x <= 4 - $product->score; $x++) {?> 
            <i class="fa fa-star"></i>
        <?php } ?>
    </div>
    <p class="product_card_price mb-1"><strong>{{ $product->price }} €</strong></p>
    @if(Auth::check() && !Auth::user()->isAdmin())
        <div class="product_card_btn my-2">
            <button class="btn p-0" onclick="addToWishlist({{ $product->id }})"><i class="fas fa-heart"></i> Wishlist</button>
            <button class="btn p-0 mx-4" onclick="addToShopCart({{ $product->id }})"><i class="fas fa-shopping-cart"></i> Cart</button>
        </div>
    @endif
</div>

