@extends('layout.main')
@section('content')

<main class="app-content">
  <div class="app-title">
    <div>
      <h1><i class="bi bi-speedometer"></i> Dashboard</h1>
      <p>Sistem Informasi Upload Foto</p>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6 col-lg-3">
      <div class="widget-small primary coloured-icon"><i class="icon bi bi-people fs-1"></i>
        <div class="info">
          <h4>Users</h4>
          <p><b>5</b></p>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="widget-small info coloured-icon"><i class="icon bi bi-heart fs-1"></i>
        <div class="info">
          <h4>Likes</h4>
          <p><b>25</b></p>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="widget-small warning coloured-icon">
        <i class="icon bi bi-folder2 fs-1"></i>
        <div class="info">
          <h4>Uploads</h4>
          <p><b>{{ $totalPhotos }}</b></p> <!-- Menampilkan total upload foto -->
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="widget-small danger coloured-icon"><i class="icon bi bi-star fs-1"></i>
        <div class="info">
          <h4>Stars</h4>
          <p><b>500</b></p>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="tile">
        <h3 class="tile-title">Statistik Unggahan Mingguan</h3>
        <div class="ratio ratio-16x9">
          <div id="salesChart"></div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="tile">
        <h3 class="tile-title">Unggahan per Pengguna</h3>
        <div class="ratio ratio-16x9">
          <canvas id="userUploadChart"></canvas> <!-- Tetap menggunakan canvas -->
        </div>
      </div>
    </div>
  </div>
</main>

<script>
  var ctx = document.getElementById('userUploadChart').getContext('2d');
  var userUploadChart = new Chart(ctx, {
      type: 'pie', // Tetap menggunakan pie chart
      data: {
          labels: @json($userNames), // Menggunakan data nama pengguna dari controller
          datasets: [{
              label: 'Jumlah Foto yang Diunggah',
              data: @json($userTotals), // Menggunakan data jumlah upload dari controller
              backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(255, 206, 86, 0.2)',
                  'rgba(75, 192, 192, 0.2)',
                  'rgba(153, 102, 255, 0.2)',
                  'rgba(255, 159, 64, 0.2)',
                  'rgba(199, 199, 199, 0.2)'
              ],
              borderColor: [
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(255, 206, 86, 1)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(153, 102, 255, 1)',
                  'rgba(255, 159, 64, 1)',
                  'rgba(199, 199, 199, 1)'
              ],
              borderWidth: 1
          }]
      },
      options: {
          responsive: true,
          maintainAspectRatio: false,
      }
  });
</script>
@endsection
