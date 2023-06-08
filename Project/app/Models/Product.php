<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Review;

class Product extends Model {
  // Don't add create and update timestamps in database.
  public $timestamps  = false;
  protected $fillable = [
    'prodname', 
    'price', 
    'proddescription',
    'launchdate', 
    'stock', 
    'categoryname'
  ];
  protected $table = 'product';

  public function getAllProducts() {
    $allProducts = Product::all();

    return $allProducts;
  }

  public static function productBought($userID, $productID) {
    $orders = Order::where('idusers', $userID)
                    ->get();

    foreach ($orders as $order) {
      $orderProducts = $order->products()->get();

      foreach ($orderProducts as $product) {
          if ($product->id == $productID) {
              return true;
          }
      }
    }

    return false;
  }

  public static function userReviewedProduct($userID, $productID) {
    $userReviews = Review::where('idusers', $userID)
                          ->where('idproduct', $productID)
                          ->get();

    if ($userReviews->count() > 0) {
      return true;
    }

    return false;
  }
}