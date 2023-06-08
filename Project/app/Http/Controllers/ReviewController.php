<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use App\Models\ProductImages;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class ReviewController extends Controller {

  public function addReview(Request $request) {
    $this->authorize('edit', Auth::user());

    if (Auth::check()) {
      $review = New Review;
      $review->idusers = Auth::user()->id;
      $review->idproduct = $request->product_id;
      $review->content = $request->new_review_content;
      $review->rating = $request->new_rating;  
      $review->save();

      return response(200);
    }
    
    return response(401);  
  }

  public function destroy(Request $request) { 
    $review_iduser = $request->userID;
    $review_idproduct = $request->productID;

    $review = Review::where('idusers', $request->userID)
                    ->where('idproduct', $request->productID)
                    ->get()
                    ->first();

    $product = Product::findOrFail($request->productID);

    $product_reviews = DB::table('review')
                          ->where('idproduct', $request->productID)
                          ->get();

    $totalRating = $product_reviews->sum(function ($t) use ($review_iduser) {
      if ($t->idusers == $review_iduser) {
        return;
      }
      return $t->rating;
    });


    if (count($product_reviews) == 1) {
      $product->score = 0;
    } else {
      $product->score = $totalRating / (count($product_reviews) - 1);
    }

    $product->save();

    $review->delete();

    return response(200);
  }

  public function updateReview(Request $request) { 
    $this->authorize('edit', Auth::user());

    $review = Review::where('idusers', $request->userID)
                    ->where('idproduct', $request->productID)
                    ->get()
                    ->first();

    $review->content = $request->newContent;
    $review->save();

    return response(200);
  }
}