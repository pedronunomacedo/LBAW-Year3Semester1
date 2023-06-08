<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImages extends Model {
  // Don't add create and update timestamps in database.
  public $timestamps  = false;
  protected $table = 'productimages';

  public function getAllImages() {
    $allImages = ProductImages::all();

    return $allImages;
  }
}