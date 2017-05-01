<?php

namespace Snapshop\Http\Controllers;
use Snapshop\Models\Cart;
use Snapshop\Models\Product;
use Snapshop\Models\Order;
use Snapshop\Models\Brand;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class CartController extends Controller
{
  // public function __construct(){
  //   $$this->addCart();
  // }

  public function addCart(){
    $cart =  new Cart();
    $cart->user_id=Auth::user()->id;
    $cart->save();
    return response()->json("BOOOMM");
  }

  public function addItem (Request $request){
      $inputs = $request->only(['product_id', 'quantity']);
      // $productId = $request->input('product_id');

      $cart    = Cart::where('user_id',Auth::user()->id)->orderBy('id', 'desc')->first();
      $product = Product::find($inputs['product_id']);
      // if(!$cart){
      //     $cart =  new Cart();
      //     $cart->user_id=Auth::user()->id;
      //     $cart->save();
      // }

      $order    = new Order();
      $subtotal = $product->price * $inputs['quantity'];
      $order->cart_id   = $cart->id;
      $order->product_id= $inputs['product_id'];
      $order->quantity  = $inputs['quantity'];
      $order->sub_total = $subtotal;
      $order->save();


      $items            = $cart->orders()->get();
      $item_quantity    = $cart->orders()->where('product_id', $inputs['product_id'])->sum('quantity');
      $current_quantity = $product->stock - $item_quantity;
      $total_amount     = 0;

      foreach ($items as $item) {
        $total_amount += $item->sub_total;
      }

      $product->stock  = $current_quantity;
      $product->save();

      $cart->total_amount = $total_amount;
      $cart->save();

      // return response()->json($items);
      return response()->json(compact('total_amount', 'product_item', 'items'));
  }


}
