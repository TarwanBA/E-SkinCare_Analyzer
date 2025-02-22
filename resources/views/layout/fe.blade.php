<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>E-Skincare Analyzer </title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{asset ('assets/vendors/feather/feather.css')}}">
    <link rel="stylesheet" href="{{asset ('assets/vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset ('assets/vendors/ti-icons/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset ('assets/vendors/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset ('assets/vendors/typicons/typicons.css')}}">
    <link rel="stylesheet" href="{{asset ('assets/vendors/simple-line-icons/css/simple-line-icons.css')}}">
    <link rel="stylesheet" href="{{asset ('assets/vendors/css/vendor.bundle.base.css')}}">
    <link rel="stylesheet" href="{{asset ('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
    <!-- endinject -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{asset ('assets/css/style.css')}}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{asset ('assets/images/logo-Umi.ico')}}" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  </head>
  <body>
    <div class="container-scroller">
     @yield('login')
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
   
    <script src="{{asset ('assets/vendors/js/vendor.bundle.base.js')}}"></script>
    <script src="{{asset ('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <!-- endinject -->

    <!-- inject:js -->
    <script src="{{asset ('assets/js/off-canvas.js')}}"></script>
    <script src="{{asset ('assets/js/template.js')}}"></script>
    <script src="{{asset ('assets/js/settings.js')}}"></script>
    <script src="{{asset ('assets/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset ('assets/js/todolist.js')}}"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
      </script>

   
  </body>
</html>