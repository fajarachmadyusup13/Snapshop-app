<?php

namespace Snapshop\Http\Controllers\Admin;

use Snapshop\Models\Order;
use Illuminate\Http\Request;
use Snapshop\Http\Controllers\Controller;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
        public function index()
        {
            $orders = Order::all();

            $params = [
                'title' => 'Orders Listing',
                'orders' => $orders,
            ];

            return view('admin.orders.orders_list')->with($params);
        }
    }
