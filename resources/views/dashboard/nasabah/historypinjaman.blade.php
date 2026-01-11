@extends('dashboard.layouts.main')

@section('container')
<div class="pagetitle">
  <h1>{{ $title }}</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item">Home</li>
      <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
  </nav>
</div>

@if(session()->has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session()->has('error') || $errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Terjadi Kesalahan:</strong>
    <ul class="mb-0 mt-1">
        @if(session('error')) <li>{{ session('error') }}</li> @endif
        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<section class="section">
  <div class="card">
    <div class="card-body pt-4">
      <form action="/historypinjaman" method="GET" class="card p-3 bg-light mb-4 border-0">
        <div class="row g-3">
          <div class="col-md-4">
            <label class="form-label small fw-bold">Cari Pinjaman</label>
            <input type="text" name="search" class="form-control" placeholder="Cari jumlah atau keperluan..." value="{{ request('search') }}">
          </div>
          <div class="col-md-4">
            <label class="form-label small fw-bold">Status</label>
            <select name="status" class="form-select">
              <option value="">-- Semua Status --</option>
              <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Diproses</option>
              <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Diterima</option>
              <option value="3" {{ request('status') == '3' ? 'selected' : '' }}>Ditolak</option>
            </select>
          </div>
          <div class="col-md-2">
            <label class="form-label small fw-bold">Dari Tanggal</label>
            <input type="date" name="tgl_mulai" class="form-control" value="{{ request('tgl_mulai') }}">
          </div>
          <div class="col-md-2">
            <label class="form-label small fw-bold">Sampai Tanggal</label>
            <input type="date" name="tgl_selesai" class="form-control" value="{{ request('tgl_selesai') }}">
          </div>
          <div class="col-12 d-flex gap-2 justify-content-end">
            <a href="/historypinjaman" class="btn btn-secondary px-4">
              <i class="bi bi-arrow-clockwise"></i> Reset
            </a>
            <button type="submit" class="btn btn-primary px-4">
              <i class="bi bi-filter"></i> Terapkan Filter
            </button>
          </div>
        </div>
      </form>
      
      <div class="table-responsive">
        <table class="table table-striped align-middle">
          <thead>
            <tr>
              <th>Waktu</th>
              <th>Jumlah</th>
              <th>Jangka</th>
              <th>Tujuan Pinjaman</th>
              <th>Tanggapan Admin</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($historyPinjaman as $pinjaman)
            <tr>
              <td>{{ $pinjaman->created_at->format('d/m/Y H:i') }}</td>
              <td>Rp{{ number_format($pinjaman->jumlah) }}</td>
              <td>{{ $pinjaman->jangka_waktu }} bln</td>
              <td class="small">{{ $pinjaman->tanggapan ?? '-' }}</td>
              <td class="small">{{ $pinjaman->tujuan_pinjaman ?? '-' }}</td>
              <td>
                @if($pinjaman->status_pinjaman == 1) <span class="badge bg-warning text-dark">Diproses</span>
                @elseif($pinjaman->status_pinjaman == 2) <span class="badge bg-success">Diterima</span>
                @else <span class="badge bg-danger">Ditolak</span> @endif
              </td>
              <td>
                @if($pinjaman->status_pinjaman != 2)
                  <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditPinjaman{{ $pinjaman->id }}">
                    <i class="bi bi-pencil-square"></i>
                  </button>
                  <a href="/hapuspinjaman/{{ $pinjaman->id }}" class="btn btn-sm btn-danger" onclick="return confirm('Batalkan pengajuan ini?')">
                    <i class="bi bi-trash"></i>
                  </a>
                @else
                  <a href="/notapinjaman/{{ $pinjaman->id }}" target="_blank" class="btn btn-sm btn-success" title="Lihat Nota">
                    <i class="bi bi-receipt"></i> Nota
                  </a>
                @endif
              </td>
            </tr>

            <div class="modal fade" id="modalEditPinjaman{{ $pinjaman->id }}" tabindex="-1">
              <div class="modal-dialog modal-lg">
                <form action="/editpinjaman/{{ $pinjaman->id }}" method="POST">
                  @csrf
                  @method('PUT')
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Perbaiki Pengajuan Pinjaman</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body row g-3">
                      <div class="col-md-6">
                        <label class="form-label">Nama Lengkap (Sesuai KTP)</label>
                        <input type="text" name="nama" class="form-control" value="{{ $pinjaman->nama }}" required>
                      </div>
                      <div class="col-md-6">
                        <label class="form-label">NIK</label>
                        <input type="text" name="nik" class="form-control" value="{{ $pinjaman->nik }}" required>
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control" value="{{ $pinjaman->tempat_lahir }}" required>
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tgl_lahir" class="form-control" value="{{ $pinjaman->tgl_lahir }}" required>
                      </div>
                      <div class="col-md-4">
                        <label class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select">
                          <option value="Laki-laki" {{ $pinjaman->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                          <option value="Perempuan" {{ $pinjaman->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                      </div>
                      <div class="col-12">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea name="alamat" class="form-control" rows="2" required>{{ $pinjaman->alamat }}</textarea>
                      </div>
                      <div class="col-md-6">
                        <label class="form-label">Pekerjaan</label>
                        <input type="text" name="pekerjaan" class="form-control" value="{{ $pinjaman->pekerjaan }}" required>
                      </div>
                      <div class="col-md-6">
                        <label class="form-label">No. Telepon</label>
                        <input type="text" name="no_telp" class="form-control" value="{{ $pinjaman->no_telp }}" required>
                      </div>
                      
                      <hr class="my-3">
                      
                      <div class="col-md-6">
                        <label class="form-label fw-bold text-primary">Jumlah Pinjaman (Rp)</label>
                        <input type="number" name="jumlah" class="form-control border-primary" value="{{ $pinjaman->jumlah }}" required>
                      </div>
                      <div class="col-md-6">
                        <label class="form-label fw-bold text-primary">Jangka Waktu (Bulan)</label>
                        <input type="number" name="jangka_waktu" class="form-control border-primary" value="{{ $pinjaman->jangka_waktu }}" required>
                      </div>
                      <div class="col-12">
                        <label class="form-label">Tujuan Penggunaan Dana</label>
                        <textarea name="tujuan_pinjaman" class="form-control" rows="3" required>{{ $pinjaman->tujuan_pinjaman }}</textarea>
                      </div>
                      
                      {{-- Hidden fields for required data that stays same or simplified --}}
                      <input type="hidden" name="status_kawin" value="{{ $pinjaman->status_kawin }}">
                      <input type="hidden" name="kewarganegaraan" value="{{ $pinjaman->kewarganegaraan }}">
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
        </table>
      </div>
    </div>
  </div>
</section>
@endsection