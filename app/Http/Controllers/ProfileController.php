<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        return view('dashboard.profile', [
            'title' => 'Profile',
            'active' => 'profile'
        ]);
    }

    public function edit(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:5048',
        ]);

        
        $user = User::find($request->input('id'));
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . "_" . $file->getClientOriginalName();
            
            // Gunakan public_path agar tujuan upload jelas ke folder public/profpic
            $tujuan_upload = public_path('profpic');
            
            // Pindahkan file
            $file->move($tujuan_upload, $imageName);
            
            // Hapus foto lama jika ada (opsional tapi disarankan)
            if ($user->image && file_exists(public_path('profpic/' . $user->image))) {
                unlink(public_path('profpic/' . $user->image));
            }
    
            $user->image = $imageName;
        }
        $user->bio = $request->input('bio');
        $user->nik = $request->input('nik');
        $user->nama = $request->input('nama');
        $user->tempat_lahir = $request->input('tempat_lahir');
        $user->tgl_lahir = $request->input('tgl_lahir');
        $user->alamat = $request->input('alamat');
        $user->no_telp = $request->input('no_telp');
        $user->status_kawin = $request->input('status_kawin');
        $user->pekerjaan = $request->input('pekerjaan');
        $user->kewarganegaraan = $request->input('kewarganegaraan');
        $user->email = $request->input('email');
        $user->update();

        return redirect('/profile')->with('success', 'Data Sukses Diedit');
    }

    public function changepass(Request $request)
    {
        if (!(Hash::check($request->input('current_password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with('error','Current Password Tidak Sesuai. Harap Ulangi Lagi');
        }
             
        if(strcmp($request->input('current_password'), $request->input('password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with('error','Password baru tidak boleh sama dengan password lama, harap gunakan password yang berbeda.');
        }
        
        if(!(strcmp($request->input('password'), $request->input('password_confirm'))) == 0){
            //New password and confirm password are not same
            return redirect()->back()->with('error','Password Baru dan Ulangi Password Harus Sama.');
        }
            
        //Change Password
        $user = User::find(Auth::user()->id);
        $user->password = bcrypt($request->input('password'));
        $user->update();

        return redirect('/profile')->with('success', 'Password Sukses Diganti');
    }
}
