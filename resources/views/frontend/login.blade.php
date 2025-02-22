@extends('layout.fe')

@section('login')
<div class="container-fluid page-body-wrapper full-page-wrapper" data-aos="zoom-in" data-aos-duration="1500">
    <div class="content-wrapper d-flex align-items-center auth px-0">
      <div class="row w-100 mx-0">
        <div class="col-lg-4 mx-auto">
          <div class="auth-form-light text-left py-5 px-4 px-sm-5">
            <div class="brand-logo">
              <h4>Form Login E-SkinCare Analyzer!</h4>
            </div>
            <h4>Selamat datang!!! </h4>
            <h6 class="fw-light">Silahkan login untuk masuk ke aplikasi.</h6>
            <form class="pt-3" action="{{ url('login') }}" method="POST">
              @csrf
              <div class="form-group">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" class="form-control form-control-lg" id="email" placeholder="Silahkan isi email anda">
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>
              <div class="form-group position-relative">
                <label for="password">Password</label>
                <div class="input-group">
                    <input type="password" name="password" class="form-control form-control-lg" id="password" placeholder="Silahkan isi password anda">
                    <div class="input-group-append">
                        <span class="input-group-text bg-white">
                            <i class="mdi mdi-eye-off" id="togglePassword" style="cursor: pointer; font-size: 20px;"></i>
                        </span>
                    </div>
                </div>
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>
            
              <div class="mt-3 d-grid gap-2">
                <button type="submit" class="btn btn-primary">Login</button>
              </div>
              <div class="my-2 d-flex justify-content-between align-items-center">
                
                <a href="{{route('password.index')}}" class="auth-link text-black">Lupa password?</a>
              </div>
            </form>
            <script>
              document.addEventListener("DOMContentLoaded", function() {
                  const passwordField = document.getElementById("password");
                  const togglePassword = document.getElementById("togglePassword");
          
                  togglePassword.addEventListener("click", function() {
                      if (passwordField.type === "password") {
                          passwordField.type = "text";
                          togglePassword.classList.remove("mdi-eye-off");
                          togglePassword.classList.add("mdi-eye");
                      } else {
                          passwordField.type = "password";
                          togglePassword.classList.remove("mdi-eye");
                          togglePassword.classList.add("mdi-eye-off");
                      }
                  });
              });
          </script>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection