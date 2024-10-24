<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Upload Foto</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            object-fit: contain;
            background-color: #f0f0f0;
        }

        .image-card:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

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

        .image-card:hover .btn-container {
            display: block;
        }

       /* Modal Preview */
        .modal {
            display: none;
            position: fixed;
            z-index: 999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8); /* Background dengan transparansi */
        }

        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 90%;
            height: 90%;
            max-width: 1000px; /* Batas maksimal ukuran gambar */
            max-height: 100%;
        }

        .modal-content img {
            width: 100%;
            height: 100%;
            object-fit: contain; /* Gambar akan menyesuaikan tanpa terpotong */
        }

        .modal-close {
            position: absolute;
            top: 20px;
            right: 40px;
            color: white;
            font-size: 35px;
            font-weight: bold;
            cursor: pointer;
        }

        /* Tombol download dan hapus di modal */
        .modal-btn-container {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
        }


        .modal-btn-container a,
        .modal-btn-container button {
            background-color: rgba(0, 123, 255, 0.8);
            color: white;
            border: none;
            padding: 15px 20px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 16px;
        }

        .modal-btn-container a:hover,
        .modal-btn-container button:hover {
            background-color: rgba(0, 123, 255, 1);
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
            <div class="image-card" ondblclick="openModal('{{ asset('foto/' . $photo->name) }}', '{{ $photo->id }}')">
                <img src="{{ asset('foto/' . $photo->name) }}" alt="foto">
                <div class="btn-container">
                    <a href="{{ asset('foto/' . $photo->name) }}" download="{{ $photo->name }}">Download</a>
                    <button onclick="deletePhoto('{{ $photo->id }}')">Hapus</button>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal untuk preview besar -->
    <div id="photo-modal" class="modal">
        <span class="modal-close" onclick="closeModal()">&times;</span>
        <div class="modal-content">
            <img id="modal-image" src="" alt="Preview">
        </div>
        <div class="modal-btn-container">
            <a id="modal-download" href="" download="">Download</a>
            <button id="modal-delete" onclick="">Hapus</button>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function showSuccessMessage(message) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: message,
                confirmButtonText: 'Oke',
                allowOutsideClick: false,
                allowEscapeKey: false,
            });
        }

        function showErrorMessage(message) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: message,
                confirmButtonText: 'Oke',
                timer: 3000,
                timerProgressBar: true
            });
        }

        Dropzone.options.photoDropzone = {
            paramName: "file",
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            uploadMultiple: true,
            parallelUploads: 10,
            maxFilesize: 20,
            success: function (file, response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Foto berhasil di-upload!',
                    confirmButtonText: 'Oke',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                }).then(() => {
                    location.reload();
                });
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
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.success,
                            confirmButtonText: 'Oke',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                        }).then(() => {
                            location.reload();
                        });
                    }
                });
            }
        }

        // Fungsi untuk membuka modal dengan preview besar
        function openModal(imageSrc, photoId) {
            document.getElementById('modal-image').src = imageSrc;
            document.getElementById('modal-download').href = imageSrc;
            document.getElementById('modal-delete').setAttribute('onclick', `deletePhoto(${photoId})`);
            document.getElementById('photo-modal').style.display = 'block';
        }

        // Fungsi untuk menutup modal
        function closeModal() {
            document.getElementById('photo-modal').style.display = 'none';
        }
    </script>
</body>
</html>
