<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>E-Skincare Analyzer</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/feather/feather.css">
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/vendors/typicons/typicons.css">
    <link rel="stylesheet" href="assets/vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="assets/js/select.dataTables.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="assets/images/logo-Umi.ico" />
  </head>
  <body class="with-welcome-text">
    <div class="container-scroller">
      <!-- Navbar -->
      <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
          <div class="me-3">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
              <span class="icon-menu"></span>
            </button>
          </div>
          <div>
            <a class="navbar-brand brand-logo" href="{{route('dashboard.index')}}">
              <img src="assets/images/E-SkinAnalyzer.svg" alt="logo" />
            </a>
            <a class="navbar-brand brand-logo-mini" href="{{route('dashboard.index')}}">
              <img src="assets/images/logo-umi.ico" alt="logo" />
            </a>
          </div>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-top">
          <ul class="navbar-nav">
            <li class="nav-item fw-semibold d-none d-lg-block ms-0">
              <h1 class="welcome-text">Selamat Datang... <span class="text-black fw-bold">{{ Auth::user()->name }}</span></h1>
              <h3 class="welcome-sub-text"> </h3>
            </li>
            @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

          </ul>
          <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown d-none d-lg-block user-dropdown">
              <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <img class="img-xs rounded-circle" src="assets/images/faces/face2.jpg" alt="Profile image"> </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                <div class="dropdown-header text-center">
                  <img class="img-md rounded-circle" src="assets/images/faces/face2.jpg" alt="Profile image">
                  <p class="mb-1 mt-3 fw-semibold">{{ Auth::user()->name }}</p>
                  <p class="fw-light text-muted mb-0">{{ Auth::user()->email }}</p>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="dropdown-item">
                        <i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Logout
                    </button>
                </form>                
              </div>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>
      <!-- End-Navbar -->

      <div class="container-fluid page-body-wrapper">
        <!-- Sidebar -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item">
              <a class="nav-link" href="/dashboard">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Dashboard</span>
              </a>
            </li>
            <li class="nav-item nav-category">Master Data</li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('data-produk.index')}}">
                <i class="menu-icon mdi mdi-cube-outline"></i>
                <span class="menu-title">Data Produk</span>                
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('data-transaksi.index')}}">
                <i class="menu-icon mdi mdi-cash"></i>
                <span class="menu-title">Data Transaksi</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('proses-data.index')}}">
                <i class="menu-icon mdi mdi-sync"></i>
                <span class="menu-title">Data Proses</span>
              </a>
            </li>
            <li class="nav-item">
                <a class="nav-link"href="{{route('hasil.proses')}}">
                    <i class="menu-icon mdi mdi-chart-line"></i>
                    <span class="menu-title">Data Hasil</span>                    
                </a>
            </li>
            {{-- <li class="nav-item">
            <a class="nav-link" href="">
                <i class="menu-icon mdi mdi-file-document"></i>
                <span class="menu-title">Dokumentasi</span>
            </a>
            </li> --}}
          </ul>
        </nav>
        <!-- partial -->
        <div class="main-panel">
         <div class="content-wrapper">
          
           @yield('dashboard')
          </div>
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="assets/vendors/chart.js/chart.umd.js"></script>
    <script src="assets/vendors/progressbar.js/progressbar.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/template.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="assets/js/jquery.cookie.js" type="text/javascript"></script>
    <script src="assets/js/dashboard.js"></script>
    <!-- <script src="assets/js/Chart.roundedBarCharts.js"></script> -->
    <!-- End custom js for this page-->
    <!-- jQuery dan Bootstrap 4 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
      $(document).ready(function() {
          // Ketika tombol analyzer diklik
          $('#btnAnalyze').click(function(e) {
              e.preventDefault();
  
              // Menampilkan modal
              $('#modalTambah').modal('show');
  
              // Inisialisasi progress bar
              $('#progressBar').css('width', '0%');
              $('#progressStatus').text('Proses sedang berjalan...');
  
              let progress = 0;
              let interval = setInterval(function() {
                  if (progress < 90) { // Batasi progres hingga 90% sebelum AJAX selesai
                      progress += 10;
                      $('#progressBar').css('width', progress + '%');
                      $('#progressStatus').text('Proses berjalan ' + progress + '%...');
                  } else {
                      clearInterval(interval);
                  }
              }, 500); // Update progress setiap 500ms
  
              // Mulai proses dengan AJAX
              $.ajax({
                  url: '{{ route("proses.analyzer") }}',  // Ubah dengan route yang sesuai
                  method: 'GET',
                  data: {
                      // Bisa kirim parameter jika perlu
                  },
                  success: function(response) {
                      clearInterval(interval); // Hentikan interval setelah proses selesai
                      $('#progressBar').css('width', '100%');
                      $('#progressStatus').text('Proses selesai!');
  
                      // Setelah selesai, tampilkan hasil analisis
                      setTimeout(function() {
                          window.location.href = '{{ route("hasil.proses") }}'; // Ubah dengan route hasil Anda
                      }, 1000);
                  },
                  error: function(xhr, status, error) {
                      clearInterval(interval); // Hentikan interval jika terjadi error
                      $('#progressStatus').text('Terjadi kesalahan. Silakan coba lagi.');
                  }
              });
          });
      });
  </script>
  
  </body>
</html>