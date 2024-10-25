<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Support\Facades\DB;

class Coba extends Controller
{
    public function index()
    {
        // Ambil data pengguna dan jumlah foto yang diupload per pengguna
        $uploadsByUser = Photo::select('account_id', DB::raw('count(*) as total'))
            ->groupBy('account_id')
            ->with('account') // Mengambil relasi akun dari model Photo
            ->get();

        // Konversi data untuk digunakan di Chart.js
        $userNames = $uploadsByUser->pluck('account.username')->toArray(); // Ambil username dari account
        $userTotals = $uploadsByUser->pluck('total')->toArray(); // Ambil total upload dari pengguna

        $totalPhotos = Photo::count(); // Menghitung total foto yang ada di database
        return view('dashboard/board', compact('totalPhotos', 'userNames', 'userTotals'));
    }
}
