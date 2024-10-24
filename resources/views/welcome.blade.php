<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Upload Foto</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.css" />
    <style>
        body { 
            font-family: Arial, sans-serif; 
            text-align: center; 
            padding: 20px; 
            background-color: #f0f0f0;
        }

        .dropzone { 
            margin-bottom: 20px; 
            border: 2px dashed #0087F7; 
            padding: 30px; 
            background-color: #f9f9f9; 
            border-radius: 10px;
        }

        .gallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .image-card {
            position: relative;
            width: 300px;
            height: 200px;
            overflow: hidden;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .image-card img {
            width: 100%;
            height: 100%;
            object-fit: contain;  /* Gambar tidak akan terpotong */
            transition: transform 0.3s ease;
            background-color: #f0f0f0; /* Tambahkan background jika ukuran gambar tidak penuh */
        }


        .image-card:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .image-card:hover img {
            transform: scale(1.1);
        }

        /* Tombol download dan hapus yang muncul saat gambar di-hover */
        .btn-container {
            position: absolute;
            bottom: 15px;
            left: 50%;
            transform: translateX(-50%);
            display: none;
            z-index: 10;
        }

        .btn-container a,
        .btn-container button {
            background-color: rgba(0, 123, 255, 0.8);
            color: white;
            border: none;
            padding: 10px 15px;
            margin: 5px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-container a:hover,
        .btn-container button:hover {
            background-color: rgba(0, 123, 255, 1);
        }

        /* Saat gambar di-hover, tombol akan muncul */
        .image-card:hover .btn-container {
            display: block;
        }

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
            <div class="image-card">
                <img src="{{ asset('foto/' . $photo->name) }}" alt="foto">
                <div class="btn-container">
                    <a href="{{ asset('foto/' . $photo->name) }}" download="{{ $photo->name }}">Download</a>
                    <button onclick="deletePhoto('{{ $photo->id }}')">Hapus</button>
                </div>
            </div>
        @endforeach
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        Dropzone.options.photoDropzone = {
            paramName: "file", // Nama parameter yang diterima server
            acceptedFiles: ".jpeg,.jpg,.png,.gif", // Hanya file gambar yang diizinkan
            uploadMultiple: true, // Mengizinkan upload beberapa file sekaligus
            parallelUploads: 10, // Jumlah file yang di-upload dalam sekali waktu (atur sesuai kebutuhan)
            maxFilesize: 20, // Batas ukuran file (dalam MB)
            success: function (file, response) {
                location.reload(); // Refresh halaman setelah upload berhasil
            }
        };

        function deletePhoto(id) {
            if (confirm('Apakah Anda yakin ingin menghapus foto ini?')) {
                $.ajax({
                    url: '/delete/' + id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert(response.success);
                        location.reload();
                    }
                });
            }
        }
    </script>
</body>
</html>
