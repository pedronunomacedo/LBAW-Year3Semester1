<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ShopCart;
use App\Models\Product;
use App\Models\ProductImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShopCartController extends Controller {
    public function showShopCart(Request $request) {
        $this->authorize('show', Auth::user());

        if (Auth::check()) {
            $user = Auth::user();
            $products = ShopCart::where('idusers', $user->id)
                    ->join('product', function ($join) {
                        $join->on('shopcart.idproduct', '=', 'product.id');
                    })
                    ->join('productimages', 'shopcart.idproduct', 'productimages.idproduct')
                    ->distinct('productimages.idproduct')
                    ->get();

            $user_shopcart = $user->shopcart()->get();

            $shop_cart_totalPrice = $user_shopcart->sum(function($product) {
                return $product->pivot->quantity * $product->price;
            });
        }

        return view('pages.shopcart', ['products' => $products, 'shop_cart_totalPrice' => $shop_cart_totalPrice]);
    }

    public function addShopCartProduct(Request $request) {   
        $this->authorize('edit', Auth::user());

        $product = Product::findOrFail($request->id);
        if ($product != NULL) {

            if (Auth::check()) {
                $user = Auth::user();
                if($user->shopcart()->where('idproduct', $request->id)->count() > 0){
                    return response(json_encode("You already have this product in your Shopcart"), 401);
                }
                Auth::user()->shopcart()->attach($product, array('quantity' => 1));
                return response(json_encode("Product added to Shopcart"), 200);

            } else {
                return response(json_encode("You need to Login first"), 401);
            }
        }
    }

    public function removeShopCartProduct(Request $request) {
        $this->authorize('edit', Auth::user());

        if (Auth::check()) {
            $user = Auth::user();
            $product = $user->shopcart()->where('idproduct', $request->id)->first();
        }
        if($product != null){
            $user->shopcart()->detach([$product->id]);
            return response(200);
        }
        return response(401);
    }

    public function showCheckout(Request $request) {
        $this->authorize('show', Auth::user());

        if (Auth::check()) {
            $user = Auth::user();
            $products = $user->shopcart()->get();

            $user_shopcart = $user->shopcart()->get();

            $shop_cart_totalPrice = $user_shopcart->sum(function($product) {
                return $product->pivot->quantity * $product->price;
            });

            $shop_cart_totalProducts = $user_shopcart->sum(function($product) {
                return $product->pivot->quantity;
            });
        }

        return view('pages.checkout', ['products' => $products, 'shop_cart_totalPrice' => $shop_cart_totalPrice, 'shop_cart_totalProducts' => $shop_cart_totalProducts]);
    }

    public function updateProductShopCart(Request $request) {
        $this->authorize('edit', Auth::user());

        try {
            $user = Auth::user();

            $product = $user->shopcart()->where('idproduct', $request->id)->first();
        } catch (\Exception $e) {
            return response(json_encode(array("Message" => "Error updating product from cart", "Price" => null)), 400);
        }

        if ($product != null) {
            try {
                if ($request->typeModification == "decrement") {
                    $product->pivot->quantity = intval($request->quantity) - 1;
                } else {
                    $product->pivot->quantity = intval($request->quantity);
                }
                $product->pivot->update();
                $products = $user->shopcart()->get();
                $total = $products->sum(function ($t) {
                    return $t->price * $t->pivot->quantity;
                });
                $total_products = $products->sum(function ($t) {
                    return $t->pivot->quantity;
                });
                return response(json_encode(array("Message" => "Your product quantity was updated", "Price" => $total, "productID" => $request->id, "totalProducts" => $total_products, "productQuantity" => $product->pivot->quantity)), 200);
            } catch (\Exception $e) {
                return response(json_encode(array('Message' => "There is not enough available products", "Price" => null)), 500);
            }

        }
    }
}
