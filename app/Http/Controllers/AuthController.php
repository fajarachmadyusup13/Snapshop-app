<?php

namespace Snapshop\Http\Controllers;

use Illuminate\Http\Request;
use Snapshop\Http\Requests;
use Snapshop\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Mail;
use Snapshop\Mail\verifyEmail;

class AuthController extends Controller
{
    public function __construct(User $user){
    	$this->user = $user;
    }

    public function postlogin(Request $request){
    	// $credentials = $request->only(['email','password']);
      $credentials0 = ['email' => $request->email, 'password' => $request->password, 'status' => '0'];
      $credentials = ['email' => $request->email, 'password' => $request->password, 'status' => '1'];
      $cust = User::where('email', $request->email)->first();
      // if(!$token = JWTAuth::attempt($credentials)){
      //   return response() -> json(['error' => 'Invalid credentials'], 401);
      // }

      if($token = JWTAuth::attempt($credentials0)){
        return response() -> json(['error' => 'registered but not verify'], 401);
      }elseif (!$token = JWTAuth::attempt($credentials)) {
        return response() -> json(['error' => 'Invalid credentials'], 401);
      }

      return response()->json(compact('token', 'cust'));
    }

    public function register(Request $request){
      $credentials = $request->only(['name', 'email','password','no_telp']);

      $credentials = [
        'name' => $credentials['name'],
        'email' => $credentials['email'],
        'no_telp' => $credentials['no_telp'],
        'password' => Hash::make($credentials['password']),
        'verifyToken' => Str::random(40)
      ];

      try {
        $user = $this->user->create($credentials);

        $thisUser = User::findOrFail($user->id);
        $this->sendEmail($thisUser);

        // return $user;

      } catch (Exception $e) {
        return response()->json(['error' => 'User already Exists'], 409);
      }

      $token = JWTAuth::fromUser($user);

      return response()->json(compact('token'));
    }

    public function sendEmail($thisUser){
        Mail::to($thisUser['email'])->send(new verifyEmail($thisUser));
    }

    public function verifyEmailFirst(){
        return view('email.verifyEmailFirst');
    }

    public function sendEmailDone($email, $verifyToken){
        $user = User::where(['email' => $email, 'verifyToken' => $verifyToken])->first();
        if ($user) {
            User::where(['email' => $email, 'verifyToken' => $verifyToken])->update(['status' => '1', 'verifyToken'=> NULL]);
            return 'Akun anda sudah aktif, Silahkan login kembali';
        } else {
            return 'user not found';
        }
    }
}
