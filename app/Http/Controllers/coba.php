<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class coba extends Controller
{
    public function index(){
        return view('dashboard/board');
    }
}
