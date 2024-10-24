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
            'file.*' => 'required|image|mimes:jpeg,png,jpg,gif',  // Validasi setiap file gambar
        ]);

        $files = $request->file('file');
        $photoCount = Photo::count(); // Hitung jumlah foto yang ada saat ini di database

        foreach ($files as $index => $file) {
            // Buat nama baru berdasarkan urutan
            $imageName = 'foto_' . ($photoCount + $index + 1) . '.' . $file->getClientOriginalExtension();
            
            // Pindahkan file ke folder public/foto
            $file->move(public_path('foto'), $imageName);

            // Simpan nama foto ke database
            Photo::create(['name' => $imageName]);
        }

        return response()->json(['success' => 'Foto berhasil di-upload']);
    }

    // Method untuk menghapus foto
    public function destroy($id)
    {
        $photo = Photo::findOrFail($id);

        // Hapus file dari folder public/foto
        $filePath = public_path('foto/' . $photo->name);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Hapus data dari database
        $photo->delete();

        // Update ulang nama file agar tetap urut setelah ada penghapusan
        $photos = Photo::orderBy('id')->get();
        foreach ($photos as $index => $photo) {
            $newName = 'foto_' . ($index + 1) . '.' . pathinfo($photo->name, PATHINFO_EXTENSION);
            // Rename file secara fisik di storage
            $oldPath = public_path('foto/' . $photo->name);
            $newPath = public_path('foto/' . $newName);
            if (file_exists($oldPath)) {
                rename($oldPath, $newPath);
            }
            // Update nama file di database
            $photo->update(['name' => $newName]);
        }

        return response()->json(['success' => 'Foto berhasil dihapus']);
    }
}
