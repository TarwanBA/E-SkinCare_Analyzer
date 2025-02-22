<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Str;

class UserController extends Controller
{
     // Menampilkan form untuk lupa password
     public function index()
     {
         return view('backend.lupa-password'); 
     }

      // Fungsi untuk memproses update password
      public function updatePassword(Request $request)
      {
          // Validasi input
          $validated = $request->validate([
              'email' => 'required|email|exists:users,email',
              'password' => 'required|confirmed|min:8',
          ]);
  
          // Temukan pengguna berdasarkan email
          $user = User::where('email', $request->email)->first();
          
          if ($user) {
              // Update password dengan password baru yang sudah di-hash
              $user->password = Hash::make($request->password);
              $user->save();
  
              return redirect()->route('login')->with('status', 'Password berhasil diperbarui.');
          }
  
          return back()->withErrors(['email' => 'Email tidak ditemukan.']);
      }
 
     
}
