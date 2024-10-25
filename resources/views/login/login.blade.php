<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Login &mdash; Upload</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/dist/assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/dist/assets/modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="assets/dist/assets/modules/bootstrap-social/bootstrap-social.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/dist/assets/css/style.css">
  <link rel="stylesheet" href="assets/dist/assets/css/components.css">
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="card card-primary">
              <div class="card-header"><h4>Login</h4></div>

              <div class="card-body">
                <form method="POST" action="{{ url('/login') }}" class="needs-validation" novalidate="">
                  @csrf
                  <div class="form-group">
                      <label for="email">Email atau Username</label>
                      <input id="email" type="text" placeholder="Masukkan Email atau Username" class="form-control" name="email" tabindex="1" required autofocus>
                      <div class="invalid-feedback">
                          Silakan masukkan email atau username
                      </div>
                  </div>

                  <div class="form-group">
                      <div class="d-block">
                          <label for="password" class="control-label">Password</label>
                      </div>
                      <input id="password" type="password" placeholder="Masukkan Password" class="form-control" name="password" tabindex="2" required>
                      <div class="invalid-feedback">
                          Silakan masukkan password
                      </div>
                  </div>
                  <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                          Login
                      </button>
                  </div>
              </form>              
              </div>
            </div>
            <div class="mt-5 text-muted text-center">
              Belum punya akun? I Don't Care
            </div>
            <div class="simple-footer">
              Hak Cipta &copy; {{ date('Y') }}
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="assets/dist/assets/modules/jquery.min.js"></script>
  <script src="assets/dist/assets/modules/popper.js"></script>
  <script src="assets/dist/assets/modules/tooltip.js"></script>
  <script src="assets/dist/assets/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/dist/assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="assets/dist/assets/modules/moment.min.js"></script>
  <script src="assets/dist/assets/js/stisla.js"></script>
  
  <!-- Template JS File -->
  <script src="assets/dist/assets/js/scripts.js"></script>
  <script src="assets/dist/assets/js/custom.js"></script>
</body>
</html>
