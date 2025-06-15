<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pinjaman;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $jmlPegawai   = User::where('role_id', 2)->count();
        $jmlPeminjamInactive  = User::where('role_id', 3)->where('is_active', 0)->count();
        $jmlPeminjamActive  = User::where('role_id', 3)->where('is_active', 1)->count();
        $pinjamanDiproses  = Pinjaman::where('status_pinjaman', 1)->count();
        $pinjamanSukses  = Pinjaman::where('status_pinjaman', 2)->count();
        $pinjamanDitolak  = Pinjaman::where('status_pinjaman', 3)->count();
        return view('dashboard.admin.index', [
            'title' => 'Dashboard',
            'jmlPegawai' => $jmlPegawai,
            'jmlPeminjamInactive' => $jmlPeminjamInactive,
            'jmlPeminjamActive' => $jmlPeminjamActive,
            'pinjamanDiproses' => $pinjamanDiproses,
            'pinjamanSukses' => $pinjamanSukses,
            'pinjamanDitolak' => $pinjamanDitolak
        ]);
    }

    public function tambahpegawai()
    {
        $users   = User::where('role_id', 2)->paginate(10);
        return view('dashboard.admin.tambahpegawai', [
            'title' => 'Tambah Pegawai',
            'users' => $users,
            'n' => 1
        ]);
    }

    public function storepegawai(Request $request)
    {   
        if(strcmp($request->input('repassword'), $request->input('password')) != 0){
            return redirect()->back()->with('error','Password dan repassword tidak boleh berbeda.');
        }

        $user = new User;
        $user->nama = $request->input('nama');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->role_id = 2;
        $user->is_active = 1;
        $user->save();

        return redirect('/tambahpegawai')->with('success', 'Data Pegawai Berhasil Ditambah');
    }

    public function editpegawai($id)
    {
        $users   = User::where('role_id', 2)->paginate(10);
        $pegawai = User::where('id', $id)->first();
        return view('dashboard.admin.editpegawai', [
            'title' => 'Edit pegawai',
            'users' => $users,
            'pegawai' => $pegawai,
            'n' => 1
        ]);
    }

    public function updatepegawai(Request $request)
    {   
        if(strcmp($request->input('repassword'), $request->input('password')) != 0){
            return redirect()->back()->with('error','Password dan repassword tidak boleh berbeda.');
        }

        $user = User::find($request->input('id'));
        $user->nama = $request->input('nama');
        $user->email = $request->input('email');
        $user->is_active = $request->input('is_active');
        if($request->input('password') != null && $request->input('repassword') != null){
            $user->password = bcrypt($request->input('password'));
        }
        
        $user->update();

        return redirect('/tambahpegawai')->with('success', 'Data Pegawai Berhasil Diupdate');
    }

    public function hapuspegawai($id)
    {
        $user = User::where('id', $id)->delete();
        return redirect('/tambahpegawai')->with('success', 'Pegawai Berhasil Dihapus');
    }
}
