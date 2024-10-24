<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    // Method untuk menampilkan halaman beranda
    public function index()
    {
        $photos = Photo::all();  // Mengambil semua foto dari database
        return view('welcome', compact('photos'));
    }

    // Method untuk menyimpan foto yang diupload
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',  // Validasi hanya file gambar
        ]);

        $image = $request->file('file');
        $imageName = time() . '.' . $image->getClientOriginalExtension();

        // Simpan foto ke folder public/foto
        $image->move(public_path('foto'), $imageName);

        // Simpan nama foto ke database
        Photo::create(['name' => $imageName]);

        return response()->json(['success' => 'Foto berhasil di-upload']);
    }
}
