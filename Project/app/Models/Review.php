<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model {
  // Don't add create and update timestamps in database.
  public $timestamps  = false;
  protected $table = 'review';

  public function getAllReviews() {
    $allReviews = Reveiews::all();

    return $allReviews;
  }

  public static function getProductReviews($id) {
    $productReviews = Review::where('idProduct', $id);
    
    return $productReviews;
  }
}