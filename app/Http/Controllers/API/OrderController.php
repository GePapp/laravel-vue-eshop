<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Customer;
use App\Order;

class OrderController extends Controller
{

  /* Create api auth. */

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $orders = Order::with('customer')->orderBy('created_at', 'DESC')->paginate(2);
        return $orders;
    }

    public function search(){
      // if condition to check that search input is't empty and the axios request has a q variable
        if ($search = \Request::get('q')) {
          $orders = Order::whereHas('customer', function ($query) use ($search) {
            $query->where('cart', 'LIKE', "%$search%")
                  ->orWhere('postcode', 'LIKE', "%$search%")
                  ->orWhere('country', 'LIKE', "%$search%")
                  ->orWhere('payment_id', 'LIKE', "%$search%")
                  ->orWhere('customers.name', 'LIKE', "%$search%");
          })->with('customer')->orderBy('created_at', 'desc')->paginate(2);
        }else{
            $orders = Order::with('customer')->orderBy('created_at', 'desc')->paginate(2);
        }
        return $orders;
    }

    public function setChecked($id){
      $order = Order::findOrFail($id);
      $order->unchecked = false;
      $order->save();
    }

    public function selectUnChecked(){
      $orders = Order::whereHas('customer', function ($query) {
        $query->where('unchecked', 1);
        })->with('customer')->orderBy('created_at', 'DESC')->paginate(2);
        return $orders;
    }

    public function printOrder($id) {
      /*$order = Order::find($id)->with('customer');*/
      $order = Order::whereHas('customer', function ($query) use ($id) {
        $query->where('orders.id', $id);
      })->with('customer')->get();
        return $order;

    }


}
