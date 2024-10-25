<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\acccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
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
        return view('admin.content', compact('totalPhotos', 'userNames', 'userTotals')); // Pastikan ini sesuai dengan nama tampilan
    }

    public function TampilFoto()
    {
        $account_id = auth()->id();
        $photos = Photo::where('account_id', $account_id)->get(); // Tampilkan foto milik akun yang sedang login
      
    
        return view('welcome', compact('photos'));
    }
    

    // Method untuk menyimpan foto yang diupload
    public function store(Request $request)
    {
        $request->validate([
            'file.*' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        $files = $request->file('file');
        $userId = auth()->id(); // Dapatkan ID pengguna yang sedang login

        foreach ($files as $file) {
            // Ambil nama asli file tanpa ekstensi
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            // Ambil ekstensi file
            $extension = $file->getClientOriginalExtension();
            // Format nama file menjadi "id.nama.ext"
            $imageName = $userId . '.' . $originalName . '.' . $extension;

            // Simpan file di direktori 'public/foto'
            $file->move(public_path('foto'), $imageName);

            // Simpan nama file dan ID akun ke database
            Photo::create([
                'name' => $imageName,
                'account_id' => $userId, // Menyimpan ID pengguna yang sedang login
            ]);
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
