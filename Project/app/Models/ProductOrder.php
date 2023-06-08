<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ProductOrder extends Model {
    protected $table = 'productorder';

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    // protected $fillable = [
    //     'quantity', 
    //     'totalprice', 
    //     'idproduct',
    //     'irorders'
    // ];
}