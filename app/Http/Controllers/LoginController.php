<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class LoginController extends Controller
{
    public function index(){
        return view('login.index', [
            'title' => 'Login Koperasi Simpan Pinjam'
        ]);
    }

    public function authenticate(Request $request){
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', 'like', "%" . $request->email . "%")->first();
        
        if($user->is_active == 0){
            return back()->with('loginError', 'Akun Anda Belum Aktif, Silahkan hubungi admin/pegawai koperasi untuk mengaktifkan');
        }

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();

            if($user->role_id == 1){
                return redirect()->intended('/admin');
            }
            
            if($user->role_id == 2){
                return redirect()->intended('/nasabah');
            }
        }

        return back()->with('loginError', 'Login Failed!');
    }

    public function logout(Request $request){
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    }
}
