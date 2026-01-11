@extends('dashboard.layouts.main')

@section('container')
<div class="pagetitle">
  <h1>{{ $title }}</h1>
  </div>

@if(session()->has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session()->has('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert"> {{-- Ubah warning ke danger --}}
    <i class="bi bi-exclamation-triangle me-1"></i> {{-- Tambah icon biar jelas --}}
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<section class="section dashboard">
  <div class="card">
    <div class="card-body pt-3">
      
      <div class="d-flex justify-content-between mb-3">
          <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-circle"></i> Tambah Tabungan
          </button>
      </div>

      <form action="/semuatabungan" method="GET" class="card p-3 bg-light mb-4">
        <div class="row g-3">
          <div class="col-md-4">
            <label class="form-label">Cari Nama</label>
            <input type="text" name="search" class="form-control" placeholder="Nama nasabah..." value="{{ request('search') }}">
          </div>
          <div class="col-md-4">
            <label class="form-label">Dari Tanggal</label>
            <input type="date" name="tgl_mulai" class="form-control" value="{{ request('tgl_mulai') }}">
          </div>
          <div class="col-md-4">
            <label class="form-label">Sampai Tanggal</label>
            <input type="date" name="tgl_selesai" class="form-control" value="{{ request('tgl_selesai') }}">
          </div>
          <div class="col-md-4">
            <select name="aksi" class="form-select">
              <option value="">-- Semua Jenis (Tabung/Ambil) --</option>
              <option value="Tabung" {{ request('aksi') == 'Tabung' ? 'selected' : '' }}>Tabung</option>
              <option value="Ambil" {{ request('aksi') == 'Ambil' ? 'selected' : '' }}>Ambil</option>
            </select>
          </div>
          <div class="col-md-4">
            <select name="status" class="form-select">
              <option value="">-- Semua Status --</option>
              <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Diproses</option>
              <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Sukses</option>
              <option value="3" {{ request('status') == '3' ? 'selected' : '' }}>Ditolak</option>
            </select>
          </div>
          <div class="col-md-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary w-100">
              <i class="bi bi-filter"></i> Filter
            </button>
            <a href="/semuatabungan" class="btn btn-secondary w-100">
              <i class="bi bi-arrow-clockwise"></i> Reset
            </a>
          </div>
        </div>
      </form>

      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">Tgl</th>
            <th scope="col">Nama Peminjam</th>
            <th scope="col">Jumlah Uang</th>
            <th scope="col">Tabung/Ambil</th>
            <th scope="col">Status</th>
            <th scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($semuaTabungan as $tabungan)
          <tr>
            <td>{{ $tabungan?->created_at->format('d/m/Y') }}</td>
            <td>{{ $tabungan?->nasabah?->nama ?? '-' }}</td>
            <td>Rp{{ number_format($tabungan?->jumlah_uang) }}</td>
            <td>{{ $tabungan?->aksi }}</td>
            <td>
                @if($tabungan?->status == 1) <span class="badge bg-warning">Diproses</span>
                @elseif($tabungan?->status == 2) <span class="badge bg-success">Sukses</span>
                @else <span class="badge bg-danger">Ditolak</span> @endif
            </td>
            <td>
              <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $tabungan->id }}">
                <i class="bi bi-pencil-square"></i>
              </button>
              <a href="/hapustabungan/{{ $tabungan->id }}" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                <i class="bi bi-trash"></i>
              </a>
            </td>
          </tr>

          <div class="modal fade" id="modalEdit{{ $tabungan->id }}" tabindex="-1">
            <div class="modal-dialog">
              <form action="/semuatabungan/{{ $tabungan->id }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Edit Tabungan: {{ $tabungan->nasabah?->nama }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    <div class="mb-3">
                      <label class="form-label">Jumlah Uang</label>
                      <input type="number" name="jumlah_uang" class="form-control" value="{{ $tabungan->jumlah_uang }}" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Aksi</label>
                      <select name="aksi" class="form-select">
                        <option value="Tabung" {{ $tabungan->aksi == 'Tabung' ? 'selected' : '' }}>Tabung</option>
                        <option value="Ambil" {{ $tabungan->aksi == 'Ambil' ? 'selected' : '' }}>Ambil</option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Status</label>
                      <select name="status" class="form-select">
                        <option value="1" {{ $tabungan->status == 1 ? 'selected' : '' }}>Diproses</option>
                        <option value="2" {{ $tabungan->status == 2 ? 'selected' : '' }}>Sukses</option>
                        <option value="3" {{ $tabungan->status == 3 ? 'selected' : '' }}>Ditolak</option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Tanggal Transaksi</label>
                      <input type="date" name="created_at" class="form-control" 
                             value="{{ \Carbon\Carbon::parse($tabungan?->created_at)->format('Y-m-d') }}" required>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          @endforeach
        </tbody>

        <tfoot>
          <tr class="table-dark">
            <th colspan="2" class="text-end">TOTAL SALDO (SUKSES):</th>
            <th colspan="4">
              {{-- Warna teks hijau jika positif, merah jika negatif --}}
              <span class="{{ $totalUang < 0 ? 'text-danger' : 'text-success' }}">
                Rp{{ number_format($totalUang ?? 0) }},-
              </span>
            </th>
          </tr>
          <tr class="table-light">
            <td colspan="6" class="text-muted small">
              <i class="bi bi-info-circle"></i> 
              * Total di atas hanya menghitung transaksi dengan status <strong>Sukses</strong>. 
              Transaksi <strong>Ambil</strong> otomatis mengurangi saldo.
            </td>
          </tr>
        </tfoot>
      </table>
      {{ $semuaTabungan->links() }}
    </div>
  </div>
</section>

<div class="modal fade" id="modalTambah" tabindex="-1">
  <div class="modal-dialog">
    <form action="/semuatabungan" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Data Tabungan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Pilih Nasabah</label>
            <select name="id_nasabah" class="form-select" required>
              <option value="">-- Pilih Nasabah --</option>
              @foreach($nasabah as $n)
                <option value="{{ $n->id }}">{{ $n->nama }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Jumlah Uang</label>
            <input type="number" name="jumlah_uang" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Jenis Aksi</label>
            <select name="aksi" class="form-select" required>
              <option value="Tabung">Tabung</option>
              <option value="Ambil">Ambil</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
              <option value="1">Diproses</option>
              <option value="2">Sukses</option>
              <option value="3">Ditolak</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Tanggal Transaksi</label>
            <input type="date" name="created_at" class="form-control" value="{{ date('Y-m-d') }}" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success">Simpan Data</button>
        </div>
      </div>
    </form>
  </div>
</div>

@endsection