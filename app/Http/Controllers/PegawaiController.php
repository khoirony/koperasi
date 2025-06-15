<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Pegawai;
use App\Models\Aduan;
use App\Models\Pinjaman;

class PegawaiController extends Controller
{
    public function index()
    {
        $jmlPeminjamInactive  = User::where('role_id', 3)->where('is_active', 0)->count();
        $jmlPeminjamActive  = User::where('role_id', 3)->where('is_active', 1)->count();
        $pinjamanDiproses  = Pinjaman::where('status_pinjaman', 1)->count();
        $pinjamanSukses  = Pinjaman::where('status_pinjaman', 2)->count();
        $pinjamanDitolak  = Pinjaman::where('status_pinjaman', 3)->count();
        return view('dashboard.pegawai.index', [
            'title' => 'Dashboard',
            'jmlPeminjamInactive' => $jmlPeminjamInactive,
            'jmlPeminjamActive' => $jmlPeminjamActive,
            'pinjamanDiproses' => $pinjamanDiproses,
            'pinjamanSukses' => $pinjamanSukses,
            'pinjamanDitolak' => $pinjamanDitolak
        ]);
    }

    public function tambahpeminjam()
    {
        $users   = User::where('role_id', 3)->paginate(10);
        return view('dashboard.pegawai.tambahpeminjam', [
            'title' => 'Tambah Peminjam',
            'users' => $users
        ]);
    }

    public function storepeminjam(Request $request)
    {   
        if(strcmp($request->input('repassword'), $request->input('password')) != 0){
            return redirect()->back()->with('error','Password dan repassword tidak boleh berbeda.');
        }

        $user = new User;
        $user->nama = $request->input('nama');
        $user->email = $request->input('email');
        $user->is_active = $request->input('is_active');
        $user->password = bcrypt($request->input('password'));
        $user->role_id = 3;
        $user->save();

        return redirect('/tambahpeminjam')->with('success', 'Data Peminjam Berhasil Ditambah');
    }

    public function editpeminjam($id)
    {
        $users   = User::where('role_id', 3)->paginate(10);
        $peminjam = User::where('id', $id)->first();
        return view('dashboard.pegawai.editpeminjam', [
            'title' => 'Edit peminjam',
            'users' => $users,
            'peminjam' => $peminjam,
            'n' => 1
        ]);
    }

    public function updatepeminjam(Request $request)
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
        $user->role_id = 3;
        $user->update();

        return redirect('/tambahpeminjam')->with('success', 'Data Peminjam Berhasil Diupdate');
    }

    public function hapuspeminjam($id)
    {
        $user = User::where('id', $id)->delete();
        return redirect('/tambahpeminjam')->with('success', 'peminjam Berhasil Dihapus');
    }

    public function pinjamandiproses()
    {
        $pinjamanDiproses  = Pinjaman::where('status_pinjaman', 1)->orderBy('created_at', 'desc')->get();
        return view('dashboard.pegawai.pinjamandiproses', [
            'title' => 'Pengaduan Masuk',
            'pinjamanDiproses' => $pinjamanDiproses
        ]);
    }

    public function kelolatanggapan($id)
    {
        $pinjaman  = Pinjaman::where('id', $id)->first();
        return view('dashboard.pegawai.kelolatanggapan', [
            'title' => 'Kelola pinjaman',
            'pinjaman' => $pinjaman,
            'id' => $id
        ]);
    }

    public function storetanggapan(Request $request)
    {
        $aduan = Pinjaman::find($request->input('id'));
        $aduan->id_pegawai = Auth::user()->id;
        $aduan->bunga_perbulan = $request->input('bunga_perbulan');
        $aduan->tanggapan = $request->input('tanggapan');
        $aduan->status_pinjaman = $request->input('status_pinjaman');
        $aduan->update();

        switch($request->input('status_pinjaman')){
            case 1: 
                $stat = 'Diproses'; 
                $link = 'pinjamandiproses';
                break;
            case 2: 
                $stat = 'Diterima';
                $link = 'pinjamanditerima';
                break;
            case 3: 
                $stat = 'Ditolak';
                $link = 'pinjamanditolak';
                break;
        }

        return redirect('/'.$link)->with('success', 'Aduan Berhasil '. $stat);
    }

    public function hapustanggapan($id)
    {
        $aduan = Pinjaman::where('id', $id)->delete();
        return back()->with('success', 'Aduan Berhasil Dihapus');
    }

    public function pinjamanditolak()
    {
        $pinajamanDitolak  = Pinjaman::where('status_pinjaman', 3)->orderBy('updated_at', 'desc')->get();
        return view('dashboard.pegawai.pinjamanditolak', [
            'title' => 'Pinjaman Ditolak',
            'pinajamanDitolak' => $pinajamanDitolak
        ]);
    }

    public function pinjamanditerima()
    {
        $pinjamanDiterima  = Pinjaman::where('status_pinjaman', 2)->orderBy('updated_at', 'desc')->get();
        return view('dashboard.pegawai.pinjamanditerima', [
            'title' => 'Pinjaman Diterima',
            'pinjamanDiterima' => $pinjamanDiterima
        ]);
    }

}
