<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Address;
use App\Models\Faq;
use App\Models\User;
use App\Models\ProductOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller {
    public function showOrders() {
        $this->authorize('show', Auth::user());
        $user = Auth::user();
        $userOrders = Order::where('idusers', '=', $user->id)->get();

        return view('pages.orders', ['userOrders' => $userOrders]);
    }

    public function showOrder(Request $request) {
        $this->authorize('show', Auth::user());
        $order = Order::findOrFail($request->order_id);
        $address = Address::findOrFail($order->idaddress);

        return view('pages.order', ['order' => $order, 'address' => $address]);
    }

    public function addOrdersProduct(Request $request) {
        $this->authorize('edit', Auth::user());
        if (Auth::check()) {
            $user = Auth::user();
            $order = new Order;
            $order->idaddress = $request->id;
            $order->idusers = $user->id;
            $order->save();

            $products = $user->shopcart()->get();

            foreach ($products as $product) {
                $order->products()->attach($product, array('quantity' => $product->pivot->quantity, 'totalprice' => $product->pivot->quantity * $product->price));
            }

            return response(json_encode("Added Order #".$order->id." to your orders"), 200);
        } else {
            return response(json_encode("Something went wrong with the order"), 401);
        }
        
    }

    public function searchOrders(Request $search_request) {
        $this->authorize('admin', Auth::user());

        $searchedOrders = DB::table('orders')
                        ->join('users', 'users.id', '=', 'orders.idusers')
                        ->distinct('orders.idusers')
                        ->paginate(20);

        $allOrderStates = ["In process", "Preparing", "Dispatched", "Delivered", "Cancelled"];
        
        return view('pages.searchOrders', ['searchOrders' => $searchedOrders, 'searchStr' => $search_request->search, 'allOrderStates' => $allOrderStates] );
    }

    public static function getAllOrdersWithUsername () {
        $this->authorize('admin', Auth::user());
        
        $allOrdersWithUsername = DB::table('orders')
                                ->join('users', function ($join) {
                                    $join->on('orders.idusers', '=', 'users.id');
                                })
                                ->join('address', function ($join) {
                                    $join->on('orders.idaddress', '=', 'address.id');
                                })
                                ->orderBy('orderdate', 'DESC')
                                ->get();

        return $allOrdersWithUsername;
    }
}
