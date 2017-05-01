<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('verifyEmailFirst', 'Auth\RegisterController@verifyEmailFirst')->name('verifyEmailFirst');

Route::get('verify/{email}/{verifyToken}', 'Auth\RegisterController@sendEmailDone')->name('sendEmailDone');

Route::get('/home', 'HomeController@index');

Route::group(['prefix' => 'api'] , function() {

   	Route::post('login', 'AuthController@postlogin');

   	Route::post('register', 'AuthController@register');

    Route::get('verifyEmailFirst', 'AuthController@verifyEmailFirst')->name('verifyEmailFirst');

    Route::get('verify/{email}/{verifyToken}', 'AuthController@sendEmailDone')->name('sendEmailDone');
   	Route::group(['prefix' => 'v1' ,'middleware' => ['jwt.auth']], function() {

       	Route::resource('user', 'ApiController');

        Route::get('logout', function() {
          Auth::logout();
          return Redirect::to('/');
        });

        Route::get('produk', 'ProductController@getProduct');
        Route::post('carts/addcart', 'CartController@addCart');
        Route::post('carts/additem', 'CartController@addItem');


   	});

});

Route::group(['prefix' => 'admin','middleware' => 'auth:admin','namespace' => 'Admin'],function(){
    Route::resource('customers', 'CustomersController');
    Route::resource('brands', 'BrandsController');
    Route::resource('product-categories', 'ProductCategoriesController');
    Route::resource('products', 'ProductsController');
    Route::resource('admins', 'AdminsController');
    Route::resource('dashboard', 'DashboardController');

    Route::get('orders', [
        'uses' => 'OrdersController@index',
        'as' => 'orders.index',
    ]);
});

// Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
//     Route::get('/', 'Auth\LoginController@showLoginForm');
//     Route::post('login', 'Auth\LoginController@login');
//     Route::post('logout', 'Auth\LoginController@logout');
//     Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
//     Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
//     Route::post('password/reset', 'Auth\ResetPasswordController@reset');
//     Route::get('register', 'Auth\RegisterController@showRegistrationForm');
//     Route::post('register', 'Auth\RegisterController@register');
//     Route::get('home', 'HomeController@index');
// });

Route::group(['prefix' => 'admin','namespace' => 'admin'],function(){

    Route::get('/', 'Auth\LoginController@showLoginForm');
    // Authentication Routes...
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

    // Password Reset Routes...
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset.token');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::get('/home', 'HomeController@index');
});
