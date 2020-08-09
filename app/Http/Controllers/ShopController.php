<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Map;
use App\Cart;
use Session;

class ShopController extends Controller
{
  // Index
  public function getIndex() {
      $map = Map::paginate(4);
      return View('pages.shop.index')->withMaps($map);
  }

  // Show Product
  public function show($id)
  {
    $map = Map::find($id);
    return view('pages.shop.show', compact('map'));
  }

  public function getAddToCart(Request $request, $id) {
      $map = Map::find($id);
      $oldCart = Session::has('cart') ? Session::get('cart') : null;
      $cart = new Cart($oldCart);
      $cart->add($map, $map->id);
      $request->session()->put('cart', $cart);
      // dd($request->session()->get('cart'));
      return redirect()->route('shop.index');
  }
  public function getCart() {
      if (!Session::has('cart')) {
        return redirect()->route('shop.index');
      }
      $oldCart = Session::get('cart');
      $cart = new Cart($oldCart);
      return view('pages.shop.shopping-cart', ['maps' => $cart->items, 'totalPrice' => $cart->totalPrice]);
  }
  public function getReduceByOne($id) {
      $oldCart = Session::has('cart') ? Session::get('cart') : null;
      $cart = new Cart($oldCart);
      $cart->reduceByOne($id);
      if (count($cart->items) > 0) {
          Session::put('cart', $cart);
      } else {
          Session::forget('cart');
      }
      return redirect()->route('shop.shoppingCart');
  }
  public function getRemoveItem($id) {
      $oldCart = Session::has('cart') ? Session::get('cart') : null;
      $cart = new Cart($oldCart);
      $cart->removeItem($id);
      if (count($cart->items) > 0) {
          Session::put('cart', $cart);
      } else {
          Session::forget('cart');
      }

      return redirect()->route('shop.shoppingCart');
  }
}
