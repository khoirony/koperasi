@extends('dashboard.layouts.main')

@section('container')

<div class="pagetitle">
  <h1>{{ $title }}</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item">Home</li>
      @if(Auth::user()->role_id == 1)
        <li class="breadcrumb-item">Admin</li>
      @endif
      <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
  </nav>
</div>@if(session()->has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle me-1"></i>
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session()->has('error') || $errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <div class="d-flex align-items-center">
        <i class="bi bi-exclamation-octagon-fill me-2 fs-4"></i>
        <div>
            <strong>Terjadi Kesalahan:</strong>
            @if(session()->has('error'))
                <p class="mb-0">{{ session('error') }}</p>
            @endif
            @if($errors->any())
                <ul class="mb-0 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<section class="section dashboard">
  <div class="card">
    <div class="card-body pt-4">

      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th scope="col">Waktu</th>
            <th scope="col">Nama Peminjam</th>
            <th scope="col">Jumlah Pinjaman</th>
            <th scope="col">Jangka Waktu</th>
            <th scope="col">Status</th>
            <th scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($pinjamanDitolak as $pinjaman)
          <tr>
            <th scope="row">{{ $pinjaman->created_at->format('d/m/Y H:i') }}</th>
            <td>{{ $pinjaman->peminjam?->nama ?? '-' }}</td>
            <td>Rp{{ number_format($pinjaman->jumlah ?? 0) }},-</td>
            <td>{{ $pinjaman->jangka_waktu }} Bulan</td>
            <td>
              <span class="badge bg-danger text-white">Ditolak</span>
            </td>
            <td>
              <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalTanggapan{{ $pinjaman->id }}">
                <i class="bi bi-pencil-square"></i>
              </button>
              <a href="/hapustanggapan/{{ $pinjaman->id }}" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">
                <i class="bi bi-trash"></i>
              </a>
            </td>
          </tr>

          <div class="modal fade" id="modalTanggapan{{ $pinjaman->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
              <form action="/kelolatanggapan" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $pinjaman->id }}">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Form Pinjaman: {{ $pinjaman->peminjam?->nama }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body row g-3 px-4">
                    <div class="col-md-6">
                        <label class="form-label small text-muted">NIK</label>
                        <input type="text" class="form-control bg-light" value="{{ $pinjaman->nik }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small text-muted">No. Telepon</label>
                        <input type="text" class="form-control bg-light" value="{{ $pinjaman->no_telp }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small text-muted">Tempat, Tgl Lahir</label>
                        <input type="text" class="form-control bg-light" value="{{ $pinjaman->tempat_lahir }}, {{ $pinjaman->tgl_lahir }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small text-muted">Pekerjaan</label>
                        <input type="text" class="form-control bg-light" value="{{ $pinjaman->pekerjaan }}" readonly>
                    </div>
                    <div class="col-12">
                        <label class="form-label small text-muted">Alamat Lengkap</label>
                        <textarea class="form-control bg-light" rows="2" readonly>{{ $pinjaman->alamat }}</textarea>
                    </div>
                    
                    <hr class="my-4">
                    <h6 class="fw-bold text-primary"><i class="bi bi-reply-all"></i> Berikan Tanggapan Admin</h6>

                    <div class="col-md-6">
                        <label class="form-label">Jumlah Pinjaman</label>
                        <input type="text" class="form-control bg-light" value="Rp{{ number_format($pinjaman->jumlah) }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Bunga Perbulan (%)</label>
                        <input type="number" step="0.01" class="form-control" name="bunga_perbulan" value="{{ $pinjaman->bunga_perbulan }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Tanggapan Anda</label>
                        <textarea class="form-control" name="tanggapan" rows="4" required placeholder="Tulis catatan atau alasan di sini...">{{ $pinjaman->tanggapan }}</textarea>
                    </div>
                    
                    <div class="col-12 mt-3">
                        <label class="form-label d-block fw-bold">Ubah Status Pinjaman :</label>
                        <div class="d-flex gap-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status_pinjaman" id="p{{ $pinjaman->id }}" value="1" {{ $pinjaman->status_pinjaman == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="p{{ $pinjaman->id }}">Diproses</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status_pinjaman" id="t{{ $pinjaman->id }}" value="3" {{ $pinjaman->status_pinjaman == 3 ? 'checked' : '' }}>
                                <label class="form-check-label text-danger fw-bold" for="t{{ $pinjaman->id }}">Ditolak</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status_pinjaman" id="s{{ $pinjaman->id }}" value="2" {{ $pinjaman->status_pinjaman == 2 ? 'checked' : '' }}>
                                <label class="form-check-label text-success fw-bold" for="s{{ $pinjaman->id }}">Diterima</label>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Submit Tanggapan</button>
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
</section>

@endsection