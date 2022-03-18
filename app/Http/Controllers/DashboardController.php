<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        // return auth()->user()->createToken('api_token');
        return view('home');
    }
}
