<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
    	$title = 'Admin dashboard';
    	return view('admin.index', compact('title'));
    }
}
