<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\Product;
use App\Models\ProductImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WishlistController extends Controller
{
    public function showWishlist(Request $request) {
        $this->authorize('show', Auth::user());

        if (Auth::check()) {

            $user = Auth::user();
            //$this->authorize('edit', $user);
            $products = Wishlist::where('idusers', $user->id)
                    ->join('product', function ($join) {
                        $join->on('wishlist.idproduct', '=', 'product.id');
                    })
                    ->join('productimages', 'wishlist.idproduct', 'productimages.idproduct')
                    ->distinct('productimages.idproduct')
                    ->get();
        }

        return view('pages.wishlist', ['products' => $products]);
    }

    public function addWishlistProduct(Request $request) {
        $this->authorize('edit', Auth::user());

        $product = Product::findOrFail($request->id);
        if ($product != NULL) {

            if (Auth::check()) {
                $user = Auth::user();
                if($user->wishlist()->where('idproduct', $request->id)->count() > 0){
                    return response(json_encode("You already have this product in your wishlist"), 401);
                }
                Auth::user()->wishlist()->attach($product);
                return response(json_encode("Product added to Wishlist"), 200);
            } else {
                return response(json_encode("You need to Login first"), 401);
            }
        }
    }

    public function removeWishlistProduct(Request $request) {
        $this->authorize('edit', Auth::user());

        if (Auth::check()) {
            $user = Auth::user();
            $product = $user->wishlist()->where('idproduct', $request->id)->first();
        }
        if($product != null){
            $user->wishlist()->detach([$product->id]);
            return response(200);
        }
        return response(401);
    }
}
