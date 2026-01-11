<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Pinjaman;
use App\Models\Tabungan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $jmlNasabahInactive  = User::where('role_id', 2)->where('is_active', 0)->count();
        $jmlNasabahActive  = User::where('role_id', 2)->where('is_active', 1)->count();
        $pinjamanDiproses  = Pinjaman::where('status_pinjaman', 1)->count();
        $pinjamanSukses  = Pinjaman::where('status_pinjaman', 2)->count();
        $pinjamanDitolak  = Pinjaman::where('status_pinjaman', 3)->count();
        return view('dashboard.admin.index', [
            'title' => 'Dashboard',
            'jmlNasabahInactive' => $jmlNasabahInactive,
            'jmlNasabahActive' => $jmlNasabahActive,
            'pinjamanDiproses' => $pinjamanDiproses,
            'pinjamanSukses' => $pinjamanSukses,
            'pinjamanDitolak' => $pinjamanDitolak
        ]);
    }

    public function semuaNasabah(Request $request)
    {
        $query = User::where('role_id', 2);

        $query->when($request->search, function ($q) use ($request) {
            return $q->where(function($sub) use ($request) {
                $sub->where('nama', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        });

        $query->when($request->status !== null && $request->status !== '', function ($q) use ($request) {
            return $q->where('is_active', $request->status);
        });

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('dashboard.admin.semuanasabah', [
            'title' => 'Kelola Nasabah',
            'users' => $users
        ]);
    }

    public function toggleNasabahStatus($id)
    {
        $user = User::findOrFail($id);
        
        $user->is_active = $user->is_active == 1 ? 0 : 1;
        $user->save();

        $pesan = $user->is_active == 1 ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Nasabah $user->nama berhasil $pesan.");
    }

    public function storeNasabah(Request $request)
    {   
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email,' . ($id ?? ''),
            'password' => 'nullable|min:5',
            'repassword' => 'same:password',
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar di sistem.',
            'password.min' => 'Password minimal terdiri dari 5 karakter.',
            'repassword.same' => 'Konfirmasi password tidak cocok dengan password baru.',
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'is_active' => $request->is_active,
            'password' => bcrypt($request->password),
            'role_id' => 2
        ]);

        return redirect('/semuanasabah')->with('success', 'Data Nasabah Berhasil Ditambah');
    }

    public function updateNasabah(Request $request, $id)
    {   
        $user = User::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email,' . ($id ?? ''),
            'password' => 'nullable|min:5',
            'repassword' => 'same:password',
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar di sistem.',
            'password.min' => 'Password minimal terdiri dari 5 karakter.',
            'repassword.same' => 'Konfirmasi password tidak cocok dengan password baru.',
        ]);

        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->is_active = $request->is_active;

        if($request->filled('password')){
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect('/semuanasabah')->with('success', 'Data Nasabah Berhasil Diupdate');
    }

    public function hapusNasabah($id)
    {
        $user = User::where('id', $id)->first();
        if(!$user){
            abort(404);
        }

        try{
            DB::beginTransaction();
            $user->delete();
            DB::commit();
            return redirect('/semuanasabah')->with('success', 'Nasabah '. $user->nama .'  Berhasil Dihapus');
        } catch (\Exception $e) {
            return redirect('/semuanasabah')->with('error', 'Nasabah '. $user->nama .' Gagal Dihapus Karena Memiliki Data Pinjaman');
        }
    }

    public function pinjamandiproses()
    {
        $pinjamanDiproses  = Pinjaman::where('status_pinjaman', 1)->orderBy('created_at', 'desc')->get();
        return view('dashboard.admin.pinjamandiproses', [
            'title' => 'Pinjaman Diproses',
            'pinjamanDiproses' => $pinjamanDiproses
        ]);
    }

    // Pastikan storetanggapan menggunakan redirect back atau ke link spesifik
    public function storetanggapan(Request $request)
    {
        $pinjaman = Pinjaman::findOrFail($request->input('id'));
        $pinjaman->id_admin = Auth::user()->id;
        $pinjaman->bunga_perbulan = $request->input('bunga_perbulan');
        $pinjaman->tanggapan = $request->input('tanggapan');
        $pinjaman->status_pinjaman = $request->input('status_pinjaman');
        $pinjaman->update();

        $stat = match((int)$request->status_pinjaman) {
            1 => 'Diproses',
            2 => 'Diterima',
            3 => 'Ditolak',
            default => 'Diperbarui'
        };

        if($request->status_pinjaman == 1){
            return redirect('/pinjamandiproses')->with('success', 'Pinjaman Berhasil ' . $stat);
        }elseif($request->status_pinjaman == 2){
            return redirect('/pinjamanditerima')->with('success', 'Pinjaman Berhasil ' . $stat);
        }elseif($request->status_pinjaman == 3){
            return redirect('/pinjamanditolak')->with('success', 'Pinjaman Berhasil ' . $stat);
        }
        return back()->with('success', 'Pinjaman Berhasil ' . $stat);
    }

    public function hapustanggapan($id)
    {
        $pinjaman = Pinjaman::where('id', $id)->first();

        if(!$pinjaman){
            abort(404);
        }

        $pinjaman->delete();
        return back()->with('success', 'Tanggapan Berhasil Dihapus');
    }

    public function pinjamanditolak()
    {
        $pinjamanDitolak  = Pinjaman::where('status_pinjaman', 3)->orderBy('updated_at', 'desc')->get();
        return view('dashboard.admin.pinjamanditolak', [
            'title' => 'Pinjaman Ditolak',
            'pinjamanDitolak' => $pinjamanDitolak
        ]);
    }

    public function pinjamanditerima()
    {
        $pinjamanDiterima  = Pinjaman::where('status_pinjaman', 2)->orderBy('updated_at', 'desc')->get();
        return view('dashboard.admin.pinjamanditerima', [
            'title' => 'Pinjaman Diterima',
            'pinjamanDiterima' => $pinjamanDiterima
        ]);
    }

    public function semuatabungan(Request $request)
    {
        $query = Tabungan::with('nasabah');

        $query->when($request->search, function ($q) use ($request) {
            return $q->whereHas('nasabah', function ($nasabahQuery) use ($request) {
                $nasabahQuery->where('nama', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('nik', 'like', '%' . $request->search . '%');
            });
        });

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

        $nasabah = User::where('role_id', 2)->get();

        return view('dashboard.admin.semuatabungan', [
            'title' => 'Tabungan Nasabah',
            'semuaTabungan' => $semuaTabungan,
            'totalUang' => $totalUang,
            'nasabah' => $nasabah
        ]);
    }

    public function storeTabungan(Request $request)
    {
        $validatedData = $request->validate([
            'id_nasabah' => 'required',
            'jumlah_uang' => 'required|numeric',
            'aksi' => 'required',
            'status' => 'required',
            'created_at' => 'required|date',
        ]);

        $jumlahInput = abs($request->jumlah_uang);
        if ($request->aksi == 'Ambil' && $request->status == 2) {
            $saldoSaatIni = Tabungan::where('id_nasabah', $request->id_nasabah)
                                    ->where('status', 2)
                                    ->sum('jumlah_uang');

            if ($saldoSaatIni < $jumlahInput) {
                return redirect('/semuatabungan')->with('error', 'Gagal! Saldo nasabah tidak mencukupi. Saldo saat ini: Rp' . number_format($saldoSaatIni));
            }
        }

        if ($request->aksi == 'Ambil') {
            $validatedData['jumlah_uang'] = -abs($request->jumlah_uang);
        } else {
            $validatedData['jumlah_uang'] = abs($request->jumlah_uang);
        }
        Tabungan::create($validatedData);

        return redirect('/semuatabungan')->with('success', 'Data tabungan berhasil ditambahkan!');
    }

    public function updateTabungan(Request $request, $id)
    {
        $tabungan = Tabungan::findOrFail($id);
        
        $validatedData = $request->validate([
            'jumlah_uang' => 'required|numeric',
            'aksi' => 'required',
            'status' => 'required',
            'created_at' => 'required|date',
        ]);

        $jumlahBaru = abs($request->jumlah_uang);
        if ($request->aksi == 'Ambil' && $request->status == 2) {
            $saldoTanpaTransaksiIni = Tabungan::where('id_nasabah', $tabungan->id_nasabah)
                                            ->where('status', 2)
                                            ->where('id', '!=', $id)
                                            ->sum('jumlah_uang');

            if ($saldoTanpaTransaksiIni < $jumlahBaru) {
                return redirect('/semuatabungan')->with('error', 'Update Gagal! Saldo tidak mencukupi. Saldo saat ini: Rp' . number_format($saldoTanpaTransaksiIni));
            }
        }

        if ($request->aksi == 'Ambil') {
            $validatedData['jumlah_uang'] = -abs($request->jumlah_uang);
        } else {
            $validatedData['jumlah_uang'] = abs($request->jumlah_uang);
        }
        $tabungan->update($validatedData);

        return redirect('/semuatabungan')->with('success', 'Data tabungan berhasil diperbarui!');
    }

    public function destroyTabungan($id)
    {
        Tabungan::destroy($id);
        return redirect('/semuatabungan')->with('success', 'Data berhasil dihapus!');
    }
}
