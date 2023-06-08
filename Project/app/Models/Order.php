<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Order extends Model {
    protected $table = 'orders';

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    public static function getUserOrders($userID) {
        $userOrders = Order::where('idusers', $userID);
        
        return $userOrders;
    }

    public static function getOrderProducts($id) {
        $orderProducts = DB::table('productorder')
                        ->where('idorders', $id)
                        ->join('product', function ($join) {
                            $join->on('product.id', '=', 'productorder.idproduct');
                        })
                        ->get();

        return $orderProducts;
    }

    

    public function products() {
        return $this->belongsToMany(Product::Class, 'productorder', 'idorders', 'idproduct')->withPivot('quantity', 'totalprice');
    }
}
