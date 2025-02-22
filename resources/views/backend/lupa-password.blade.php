@extends('layout.fe')

@section('login')
<div class="container-fluid page-body-wrapper full-page-wrapper" data-aos="zoom-in" data-aos-duration="1500">
    <div class="content-wrapper d-flex align-items-center auth px-0">
      <div class="row w-100 mx-0">
        <div class="col-lg-4 mx-auto">
          <div class="auth-form-light text-left py-5 px-4 px-sm-5">
            <div class="brand-logo">
              <h4>E-SkinCare Analyzer!</h4>
            </div>
            <h6 class="fw-light">Silahkan masukan email yg terdaftar</h6>
            <form class="pt-3" method="POST" action="{{ route('password.updatePassword') }}">
              @csrf
              <div class="form-group">
                <label for="Email">Email</label>
                <input id="email" name="email" type="email" class="form-control form-control-lg" id="email" placeholder="Silahkan isi email anda">
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>
              <div class="form-group position-relative">
                <label for="password">Password Baru</label>
                <div class="input-group">
                    <input type="password" name="password" class="form-control form-control-lg" id="password" placeholder="Silahkan isi password anda">
                    <div class="input-group-append">
                        <span class="input-group-text bg-white border-left-0">
                            <i class="mdi mdi-eye-off" id="togglePassword" style="cursor: pointer;"></i>
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="form-group position-relative">
                <label for="confirm_password">Konfirmasi Password</label>
                <div class="input-group">
                    <input type="password" name="password_confirmation" class="form-control form-control-lg" id="confirm_password" placeholder="Silahkan isi password anda">
                    <div class="input-group-append">
                        <span class="input-group-text bg-white border-left-0">
                            <i class="mdi mdi-eye-off" id="toggleConfirmPassword" style="cursor: pointer;"></i>
                        </span>
                    </div>
                </div>
            </div>
            
              <div class="mt-3 d-grid gap-2">
                <button type="submit" class="btn btn-primary">Login</button>
              </div>
            </form>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const passwordField = document.getElementById("password");
                    const confirmPasswordField = document.getElementById("confirm_password");
                    const togglePassword = document.getElementById("togglePassword");
                    const toggleConfirmPassword = document.getElementById("toggleConfirmPassword");
            
                    // Fungsi Toggle untuk Password Baru
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
            
                    // Fungsi Toggle untuk Konfirmasi Password
                    toggleConfirmPassword.addEventListener("click", function() {
                        if (confirmPasswordField.type === "password") {
                            confirmPasswordField.type = "text";
                            toggleConfirmPassword.classList.remove("mdi-eye-off");
                            toggleConfirmPassword.classList.add("mdi-eye");
                        } else {
                            confirmPasswordField.type = "password";
                            toggleConfirmPassword.classList.remove("mdi-eye");
                            toggleConfirmPassword.classList.add("mdi-eye-off");
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