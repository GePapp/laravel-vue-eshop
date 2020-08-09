<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use Session;

class CartController extends Controller
{
  // Index
public function getIndex() {
  $products = Product::paginate(4);
  return View('shop.index')->withProducts($products);
}

// Show Product
public function show($id)
{
  $product = Product::find($id);
  return view('shop.show', compact('product'));
}

public function getAddToCart(Request $request, $id) {
  $product = Product::find($id);
  $oldCart = Session::has('cart') ? Session::get('cart') : null;
  $cart = new Cart($oldCart);
  $cart->add($product, $product->id);
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
  return view('shop.shopping-cart', ['products' => $cart->items, 'totalPrice' => $cart->totalPrice]);
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
