<?php

namespace Snapshop\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Snapshop\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Snapshop\Models\Product;
use Snapshop\Http\Controllers\response;

class ProductController extends Controller
{
  public function getProduct()
    {
    $product = Product::all();
    return response()
        ->json($product);
  }

  public function showProduct($id){
    $request = Product::where('product_id', $id)->get();
    return response()->json($request);
  }

  public function insertProduct(Request $request){
    $input = $request->only('nama_product', 'price', 'stock', 'description');

    $query = Product::create($input);
    if($query){
      $data['success'] = 'success';
      return $data;
    }else{
      $data['success'] = 'error';
      return $data;
    }
  }

  public function updateProduct(Request $req, $id){
    $input = $req->only('nama_product', 'price', 'stock', 'description');
    $product = Product::where('product_id', $id);

    $query = $product->update($input);
    if($query){
      $data['success'] = 'success';
      return $data;
    }else{
      $data['success'] = 'error';
      return $data;
    }
  }

  public function desProduct($id){
    $product=Product::where('product_id', $id);

    if(is_null($product))
    {
      return Response::json("not found",404);
    }

    $success=$product->delete();

    if(!$success)
    {
      return \Response::json("error deleting",500);
    }

    return \Response::json("success",200);
    }
}
