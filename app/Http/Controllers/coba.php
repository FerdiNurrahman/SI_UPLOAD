<?php

namespace App\Http\Controllers;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class coba extends Controller
{
    public function index(){
        $categories = Photo::select('category', DB::raw('count(*) as total'))
        ->groupBy('category')
        ->get();

         // Konversi data untuk digunakan di Chart.js
    $categoryNames = $categories->pluck('category')->toArray();
    $categoryTotals = $categories->pluck('total')->toArray();

        $totalPhotos = Photo::count(); // Menghitung total foto yang ada di database
        return view('dashboard/board', compact('totalPhotos','categoryNames', 'categoryTotals'));
    }
}
