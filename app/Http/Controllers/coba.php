<?php

namespace App\Http\Controllers;
use App\Models\Photo;
use Illuminate\Http\Request;

class coba extends Controller
{
    public function index(){
        $totalPhotos = Photo::count(); // Menghitung total foto yang ada di database
        return view('dashboard/board', compact('totalPhotos'));
    }
}
