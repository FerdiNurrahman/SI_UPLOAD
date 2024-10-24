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
    $photoCount = Photo::count();

    foreach ($files as $index => $file) {
        $imageName = 'foto_' . ($photoCount + $index + 1) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('foto'), $imageName);

        // Simpan nama foto dan ID akun ke database
        Photo::create([
            'name' => $imageName,
            'account_id' => auth()->id(), // Menyimpan ID pengguna yang sedang login
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
