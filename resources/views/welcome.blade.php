<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Upload Foto</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.css" />
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 20px; }
        .dropzone { margin-bottom: 20px; border: 2px dashed #0087F7; padding: 30px; background-color: #f9f9f9; }
        .gallery img { width: 200px; margin: 10px; border-radius: 10px; }
    </style>
</head>
<body>
    <h1>Upload Foto</h1>
    <form action="/upload" class="dropzone" id="photo-dropzone" method="POST" enctype="multipart/form-data">
        @csrf
    </form>

    <h2>Foto yang diupload</h2>
    <div class="gallery">
        @foreach ($photos as $photo)
            <img src="{{ asset('foto/' . $photo->name) }}" alt="foto">
        @endforeach
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>
    <script>
        Dropzone.options.photoDropzone = {
            paramName: "file",
            maxFilesize: 2,  // Maksimal ukuran file 2 MB
            acceptedFiles: ".jpeg,.jpg,.png,.gif",  // Hanya file gambar yang diizinkan
            success: function (file, response) {
                location.reload();  // Refresh halaman setelah upload berhasil
            }
        };
    </script>
</body>
</html>
