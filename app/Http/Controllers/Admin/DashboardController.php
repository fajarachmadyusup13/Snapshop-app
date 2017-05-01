<?php

namespace Snapshop\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Snapshop\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(){
    	return view('admin.dashboard.dashboard');
    }
}
