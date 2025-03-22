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
     public function index()
     {
         return view('backend.lupa-password'); 
     }

      public function updatePassword(Request $request)
      {

          $validated = $request->validate([
              'email' => 'required|email|exists:users,email',
              'password' => 'required|confirmed|min:8',
          ]);

          $user = User::where('email', $request->email)->first();
          
          if ($user) {
              $user->password = Hash::make($request->password);
              $user->save();
  
              return redirect()->route('login')->with('status', 'Password berhasil diperbarui.');
          }
  
          return back()->withErrors(['email' => 'Email tidak ditemukan.']);
      }
 
     
}
