<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pinjaman;
use App\Models\Tabungan;
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

    public function semuatabungan(Request $request)
    {
        $query = Tabungan::with('nasabah')->where('id_nasabah', Auth::user()->id);

        $query->when($request->aksi, function ($q) use ($request) {
            return $q->where('aksi', $request->aksi);
        });

        $query->when($request->status, function ($q) use ($request) {
            return $q->where('status', $request->status);
        });

        $query->when($request->tgl_mulai, function ($q) use ($request) {
            return $q->whereDate('created_at', '>=', $request->tgl_mulai);
        });

        $query->when($request->tgl_selesai, function ($q) use ($request) {
            return $q->whereDate('created_at', '<=', $request->tgl_selesai);
        });
        $totalUang = $query->clone()->where('status', 2)->sum('jumlah_uang');
        $semuaTabungan = $query->latest()->paginate(10)->withQueryString();

        return view('dashboard.nasabah.tabungansaya', [
            'title' => 'Tabungan Saya',
            'semuaTabungan' => $semuaTabungan,
            'totalUang' => $totalUang
        ]);
    }

    public function storeTabungan(Request $request)
    {
        $validatedData = $request->validate([
            'jumlah_uang' => 'required|numeric',
            'aksi' => 'required',
        ]);

        $jumlahInput = abs($request->jumlah_uang);
        if ($request->aksi == 'Ambil') {
            $saldoSaatIni = Tabungan::where('id_nasabah', Auth::user()->id)
                                    ->where('status', 2)
                                    ->sum('jumlah_uang');

            if ($saldoSaatIni < $jumlahInput) {
                return redirect('/tabungansaya')->with('error', 'Gagal! Saldo nasabah tidak mencukupi. Saldo saat ini: Rp' . number_format($saldoSaatIni));
            }
        }

        if ($request->aksi == 'Ambil') {
            $validatedData['jumlah_uang'] = -abs($request->jumlah_uang);
        } else {
            $validatedData['jumlah_uang'] = abs($request->jumlah_uang);
        }

        $tabungan = new Tabungan();
        $tabungan->id_nasabah = Auth::user()->id;
        $tabungan->jumlah_uang = $request->input('jumlah_uang');
        $tabungan->aksi = $request->input('aksi');
        $tabungan->status = 1;
        $tabungan->save();

        return redirect('/tabungansaya')->with('success', 'Data tabungan berhasil ditambahkan!');
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

    public function historypinjaman(Request $request)
    {
        $query = Pinjaman::where('id_nasabah', Auth::user()->id);

        $query->when($request->search, function ($q) use ($request) {
            return $q->where(function($sub) use ($request) {
                $sub->where('jumlah', 'like', '%' . $request->search . '%')
                    ->orWhere('tujuan_pinjaman', 'like', '%' . $request->search . '%');
            });
        });

        $query->when($request->status, function ($q) use ($request) {
            return $q->where('status_pinjaman', $request->status);
        });

        $query->when($request->tgl_mulai, function ($q) use ($request) {
            return $q->whereDate('created_at', '>=', $request->tgl_mulai);
        });

        $query->when($request->tgl_selesai, function ($q) use ($request) {
            return $q->whereDate('created_at', '<=', $request->tgl_selesai);
        });

        $historyPinjaman = $query->latest()->paginate(10)->withQueryString();

        return view('dashboard.nasabah.historypinjaman', [
            'title' => 'History Pinjaman',
            'historyPinjaman' => $historyPinjaman
        ]);
    }

    public function storeedit(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|numeric',
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
        
        $pinjaman = Pinjaman::findOrFail($id);

        // Proteksi: Jika sudah diterima (2), tidak boleh diedit via backend
        if($pinjaman->status_pinjaman == 2){
            return redirect('/historypinjaman')->with('error', 'Pinjaman yang sudah diterima tidak boleh diubah');
        }

        $pinjaman->update([
            'jumlah' => $request->jumlah,
            'jangka_waktu' => $request->jangka_waktu,
            'tujuan_pinjaman' => $request->tujuan_pinjaman,
            'nik' => $request->nik,
            'nama' => $request->nama,
            'tempat_lahir' => $request->tempat_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tgl_lahir' => $request->tgl_lahir,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'status_kawin' => $request->status_kawin,
            'pekerjaan' => $request->pekerjaan,
            'kewarganegaraan' => $request->kewarganegaraan,
            'status_pinjaman' => 1, // Otomatis balik ke "Diproses" setelah edit
        ]);

        return redirect('/historypinjaman')->with('success', 'Data Pinjaman Berhasil Diperbarui');
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
