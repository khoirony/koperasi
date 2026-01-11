<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pinjaman;
use App\Models\User;

class NasabahController extends Controller
{
    public function index()
    {
        $pinjamanDiproses  = Pinjaman::where('status_pinjaman', 1)->where('id_nasabah', Auth::user()->id)->count();
        $pinjamanSukses  = Pinjaman::where('status_pinjaman', 2)->where('id_nasabah', Auth::user()->id)->count();
        $pinjamanDitolak  = Pinjaman::where('status_pinjaman', 3)->where('id_nasabah', Auth::user()->id)->count();
        return view('dashboard.nasabah.index', [
            'title' => 'Dashboard',
            'pinjamanDiproses' => $pinjamanDiproses,
            'pinjamanSukses' => $pinjamanSukses,
            'pinjamanDitolak' => $pinjamanDitolak
        ]);
    }

    public function ajukanpinjaman()
    {
        $user = User::where('id', Auth::user()->id)->first();
        return view('dashboard.nasabah.ajukanpinjaman', [
            'title' => 'Ajukan Pinjaman',
            'user' => $user,
        ]);
    }

    public function storepinjaman(Request $request)
    {
        $request->validate([
            'jumlah' => 'required',
            'jangka_waktu' => 'required',
            'tujuan_pinjaman' => 'required',
            'nik' => 'required',
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
            'status_kawin' => 'required',
            'pekerjaan' => 'required',
            'kewarganegaraan' => 'required',
        ]);
           
        $pinjaman = new Pinjaman();
        $pinjaman->id_nasabah = Auth::user()->id;
        $pinjaman->jumlah = $request->input('jumlah');
        $pinjaman->jangka_waktu = $request->input('jangka_waktu');
        $pinjaman->tujuan_pinjaman = $request->input('tujuan_pinjaman');
        $pinjaman->nik = $request->input('nik');
        $pinjaman->nama = $request->input('nama');
        $pinjaman->tempat_lahir = $request->input('tempat_lahir');
        $pinjaman->tgl_lahir = $request->input('tgl_lahir');
        $pinjaman->tempat_lahir = $request->input('tempat_lahir');
        $pinjaman->alamat = $request->input('alamat');
        $pinjaman->no_telp = $request->input('no_telp');
        $pinjaman->status_kawin = $request->input('status_kawin');
        $pinjaman->pekerjaan = $request->input('pekerjaan');
        $pinjaman->kewarganegaraan = $request->input('kewarganegaraan');
        $pinjaman->status_pinjaman = 1;
        $pinjaman->save();

        return redirect('/historypinjaman')->with('success', 'Pinjaman Sukses Diajukan, Silahkan tunggu sampai admin menerima.');
    }

    public function historypinjaman()
    {
        $historyPinjaman = Pinjaman::where('id_nasabah', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        return view('dashboard.nasabah.historypinjaman', [
            'title' => 'History Pinjaman',
            'historyPinjaman' => $historyPinjaman
        ]);
    }

    public function editpinjaman($id)
    {
        $pinjaman  = Pinjaman::where('id', $id)->first();
        if(!$pinjaman){
            abort(404);
        }

        if($pinjaman?->status_pinjaman == 2){
            return redirect('/historypinjaman')->with('error', 'Pinjaman yang sudah diterima tidak boleh diubah');
        }

        return view('dashboard.nasabah.editpinjaman', [
            'title' => 'Kelola Pinjaman',
            'pinjaman' => $pinjaman,
        ]);
    }

    public function storeedit(Request $request)
    {
        $request->validate([
            'jumlah' => 'required',
            'jangka_waktu' => 'required',
            'tujuan_pinjaman' => 'required',
            'nik' => 'required',
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
            'status_kawin' => 'required',
            'pekerjaan' => 'required',
            'kewarganegaraan' => 'required',
        ]);
        
        
        $pinjaman = Pinjaman::find($request->input('id'));

        if($pinjaman->status_pinjaman == 2){
            return redirect('/historypinjaman')->with('error', 'Pinjaman yang sudah diterima tidak boleh diubah');
        }

        $pinjaman->jumlah = $request->input('jumlah');
        $pinjaman->jangka_waktu = $request->input('jangka_waktu');
        $pinjaman->tujuan_pinjaman = $request->input('tujuan_pinjaman');
        $pinjaman->nik = $request->input('nik');
        $pinjaman->nama = $request->input('nama');
        $pinjaman->tempat_lahir = $request->input('tempat_lahir');
        $pinjaman->jenis_kelamin = $request->input('jenis_kelamin');
        $pinjaman->tgl_lahir = $request->input('tgl_lahir');
        $pinjaman->alamat = $request->input('alamat');
        $pinjaman->no_telp = $request->input('no_telp');
        $pinjaman->status_kawin = $request->input('status_kawin');
        $pinjaman->pekerjaan = $request->input('pekerjaan');
        $pinjaman->kewarganegaraan = $request->input('kewarganegaraan');
        $pinjaman->status_pinjaman = 1;
        $pinjaman->update();

        return redirect('/historypinjaman')->with('success', 'Pinjaman Sukses Diedit');
    }

    public function hapuspinjaman($id)
    {
        $pinjaman = Pinjaman::where('id', $id)->first();

        if(!$pinjaman){
            abort(404);
        }
        
        if($pinjaman->status_pinjaman == 2){
            return redirect('/historypinjaman')->with('error', 'Pinjaman yang sudah diterima tidak boleh dihapus');
        }
            
        $pinjaman->delete();
        return redirect('/historypinjaman')->with('success', 'Pinjaman Berhasil Dihapus');
    }

    public function notapinjaman($id)
    {
        $pinjaman  = Pinjaman::where('id', $id)->first();

        if(!$pinjaman){
            abort(404);
        }

        if($pinjaman->status_pinjaman != 2){
            return redirect('/historypinjaman')->with('error', 'Pinjaman belum diterima');
        }

        return view('dashboard.nasabah.notapinjaman', [
            'title' => 'Nota Pinjaman',
            'pinjaman' => $pinjaman
        ]);
    }
}
