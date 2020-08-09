<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Customer;
use App\Order;

class CustomerController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth:api');
  }

  public function index()
  {
      $customers = Customer::find(1)->orderBy('name', 'ASC')->paginate(2);
      return $customers;
  }

  public function search(){
    // if condition to check that search input is't empty and the axios request has a q variable
      if ($search = \Request::get('q')) {
        $customers = Customer::where(function ($query) use ($search) {
          $query->where('name', 'LIKE', "%$search%");
        })->orderBy('name', 'ASC')->paginate(2);
      }else{
          $customers = Customer::find(1)->orderBy('name', 'ASC')->paginate(2);
      }
      return $customers;
  }

}
