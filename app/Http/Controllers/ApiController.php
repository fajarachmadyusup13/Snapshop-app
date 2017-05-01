<?php

namespace Snapshop\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Snapshop\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Snapshop\Models\produk;
use Snapshop\Http\Controllers\response;

class ApiController extends Controller
{

  public function __construct(User $user){
    $this->user = $user;
  }

  //menampilkan semua index
	public function index(){
		return $this->user->all();
	}

  public function show($id){
    $data = $this->user->where('id', '=', $id)->get();

    return response()->json(compact('data'), 200);
  }

	public function getProduct()
	  {
	  $produk = Produk::all();
	  return response()
	      ->json($produk);
	}

	public function showProduct($id){
		$request = Produk::where('product_id', $id)->get();
		return response()->json($request);
	}

	public function insertProduk(Request $request){
		$input = $request->only('nama_produk', 'price', 'stock', 'description');

		$query = Produk::create($input);
		if($query){
			$data['success'] = 'success';
			return $data;
		}else{
			$data['success'] = 'error';
			return $data;
		}
	}

	public function updateProduk(Request $req, $id){
		$input = $req->only('nama_produk', 'price', 'stock', 'description');
		$produk = Produk::where('product_id', $id);

		$query = $produk->update($input);
		if($query){
			$data['success'] = 'success';
			return $data;
		}else{
			$data['success'] = 'error';
			return $data;
		}
	}

	public function desProduk($id){
		$produk=Produk::where('product_id', $id);

		if(is_null($produk))
		{
			return Response::json("not found",404);
		}

		$success=$produk->delete();

		if(!$success)
		{
			return \Response::json("error deleting",500);
		}

		return \Response::json("success",200);
		}
}
