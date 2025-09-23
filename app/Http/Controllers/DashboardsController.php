<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardsController extends Controller
{
    public function bfp () {

        return view('PAGES/BFP_BDRRMC/dashboard');
    }

    public function admin () {
        
        return view('PAGES/admin/dashboard');
    }
}
