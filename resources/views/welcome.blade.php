@extends('layout.main')

@section('content')
<main class="app-content">
    <div class="app-title">
        <h1><i class="fa fa-cloud-upload"></i> Upload Foto</h1>
        <p>Upload foto dan kelola foto yang telah diupload</p>
    </div>
    <style>
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
            width: 150px;
            height: 150px;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .image-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            background-color: #f0f0f0;
        }

        .image-card:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .btn-container {
            position: absolute;
            bottom: 10px;
            left: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            padding: 0 10px;
            display: none;
            z-index: 10;
        }

        .btn-container a,
        .btn-container button {
            background-color: rgba(0, 123, 255, 0.8);
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 12px;
        }

        .btn-container a:hover,
        .btn-container button:hover {
            background-color: rgba(0, 123, 255, 1);
        }

        .image-card:hover .btn-container {
            display: flex;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
        }

            .modal-content {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px; /* Add padding for better spacing */
            background-color: white; /* Ensure a white background */
            border-radius: 10px; /* Round corners for a nicer look */
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); /* Add subtle shadow */
            max-width: 60vw; /* Set maximum width relative to the viewport */
            max-height: 90vh; /* Set maximum height relative to the viewport */
        }

            .modal-content img {
            max-width: 100%; /* Ensure image scales correctly */
            max-height: 80vh; /* Restrict height to avoid overflow */
            width: auto; /* Allow width to adjust automatically */
            height: auto; /* Allow height to adjust automatically */
            object-fit: contain; /* Maintain image aspect ratio */
        }


        .modal-btn-container {
            position: absolute;
            bottom: 20px;
            display: flex;
            gap: 10px;
            left: 50%;
            transform: translateX(-50%);
        }

        .modal-btn-container a,
        .modal-btn-container button {
            background-color: rgba(0, 123, 255, 0.8);
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        .modal-btn-container a:hover,
        .modal-btn-container button:hover {
            background-color: rgba(0, 123, 255, 1);
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Upload Foto</h3>
                <form action="/upload" class="dropzone" id="photo-dropzone" method="POST" enctype="multipart/form-data">
                    @csrf
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Foto yang diupload</h3>
                <div class="gallery d-flex flex-wrap">
                    @foreach ($photos as $photo)
                    <div class="image-card mb-4" ondblclick="openModal('{{ asset('foto/' . $photo->name) }}', '{{ $photo->id }}')">
                        <img src="{{ asset('foto/' . $photo->name) }}" class="img-fluid" alt="foto">
                        <div class="btn-container">
                            <a href="{{ asset('foto/' . $photo->name) }}" class="btn btn-primary btn-sm" download="{{ $photo->name }}">Download</a>
                            <button class="btn btn-danger btn-sm" onclick="deletePhoto('{{ $photo->id }}')">Hapus</button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk pratinjau gambar -->
    <div id="photo-modal" class="modal">
        <div class="modal-content">
            <img id="modal-image" class="img-fluid" src="" alt="Preview">
        </div>
        <div class="modal-btn-container">
            <a id="modal-download" class="btn btn-primary" href="" download="">Download</a>
            <button id="modal-delete" class="btn btn-danger" onclick="">Hapus</button>
        </div>
    </div>

    <script>
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
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Anda tidak akan bisa mengembalikan foto ini!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
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
                                text: 'Foto telah dihapus.',
                                confirmButtonText: 'Oke',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan saat menghapus foto.',
                                confirmButtonText: 'Oke'
                            });
                        }
                    });
                }
            });
        }

        function openModal(imageSrc, photoId) {
            const modal = document.getElementById('photo-modal');
            const modalImage = document.getElementById('modal-image');

            modalImage.src = imageSrc;

            // Periksa apakah gambar portrait atau landscape
            const img = new Image();
            img.src = imageSrc;
            img.onload = function () {
                if (this.width > this.height) {
                    // Landscape
                    modalImage.style.objectFit = 'contain';
                } else {
                    // Portrait
                    modalImage.style.objectFit = 'contain';
                }
            };

            document.getElementById('modal-download').href = imageSrc;
            document.getElementById('modal-delete').setAttribute('onclick', `deletePhoto(${photoId})`);
            modal.style.display = 'flex';

            // Menutup modal saat klik di luar gambar
            modal.addEventListener('click', function(event) {
                if (event.target === modal) closeModal();
            });

            // Tambah listener untuk tombol ESC
            document.addEventListener('keydown', escKeyListener);
        }

        function closeModal() {
            const modal = document.getElementById('photo-modal');
            modal.style.display = 'none';
            modal.removeEventListener('keydown', escKeyListener);
        }

        function escKeyListener(event) {
            if (event.key === "Escape") {
                closeModal();
            }
        }
    </script>
</main>
@endsection
