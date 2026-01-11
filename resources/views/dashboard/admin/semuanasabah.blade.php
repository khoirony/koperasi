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
      
      <div class="row g-3 mb-4">
        <div class="col-md-3">
            <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modalTambahNasabah">
                <i class="bi bi-person-plus"></i> Tambah Nasabah Baru
            </button>
        </div>
        <div class="col-md-9">
            <form action="/semuanasabah" method="GET" class="row g-2">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama atau email..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">-- Semua Status --</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Belum Aktif</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-1">
                    <button type="submit" class="btn btn-secondary w-100"><i class="bi bi-search"></i></button>
                    <a href="/semuanasabah" class="btn btn-outline-secondary w-100"><i class="bi bi-arrow-clockwise"></i></a>
                </div>
            </form>
        </div>
      </div>

      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Nama Nasabah</th>
            <th scope="col">Email</th>
            <th scope="col">Status</th>
            <th scope="col" width="15%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($users as $index => $user)
          <tr>
            <th scope="row">{{ $users->firstItem() + $index }}</th>
            <td>{{ $user?->nama }}</td>
            <td>{{ $user?->email }}</td>
            <td>
              @if($user?->is_active == 1) 
                <span class="badge bg-success">Aktif</span>
              @else 
                <span class="badge bg-danger">Belum Aktif</span>
              @endif
            </td>
            <td>
              <div class="d-flex gap-1">
                <form action="/nasabah/toggle-status/{{ $user->id }}" method="POST">
                  @csrf
                  @method('PUT')
                  @if($user->is_active == 1)
                    <button type="submit" class="btn btn-sm btn-warning" title="Nonaktifkan Nasabah">
                      <i class="bi bi-person-x"></i>
                    </button>
                  @else
                    <button type="submit" class="btn btn-sm btn-success" title="Aktifkan Nasabah">
                      <i class="bi bi-person-check"></i>
                    </button>
                  @endif
                </form>
            
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $user->id }}" title="Edit Data">
                  <i class="bi bi-pencil-square"></i>
                </button>
            
                <a href="/hapusnasabah/{{ $user->id }}" class="btn btn-sm btn-danger" onclick="return confirm('Hapus nasabah ini?')" title="Hapus">
                  <i class="bi bi-trash"></i>
                </a>
              </div>
            </td>
          </tr>

          <div class="modal fade" id="modalEdit{{ $user->id }}" tabindex="-1">
            <div class="modal-dialog">
              <form action="/updatenasabah/{{ $user->id }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Edit Nasabah: {{ $user->nama }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body row g-3">
                    <div class="col-12">
                      <label class="form-label">Nama Lengkap</label>
                      <input type="text" class="form-control" name="nama" value="{{ $user->nama }}" required>
                    </div>
                    <div class="col-12">
                      <label class="form-label">Email</label>
                      <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                    </div>
                    <div class="col-12">
                      <label class="form-label">Status</label>
                      <select class="form-select" name="is_active">
                        <option value="1" {{ $user->is_active == 1 ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ $user->is_active == 0 ? 'selected' : '' }}>Belum Aktif</option>
                      </select>
                    </div>
                    <div class="col-12">
                      <hr>
                      <small class="text-muted">Kosongkan password jika tidak ingin diubah</small>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Password Baru</label>
                      <input type="password" class="form-control" name="password">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Ulangi Password</label>
                      <input type="password" class="form-control" name="repassword">
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
      </table>
      
      {{ $users->links() }}

    </div>
  </div>
</section>

<div class="modal fade" id="modalTambahNasabah" tabindex="-1">
  <div class="modal-dialog">
    <form action="/tambahnasabah" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Nasabah Baru</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body row g-3">
          <div class="col-12">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" name="nama" required>
          </div>
          <div class="col-12">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" required>
          </div>
          <div class="col-12">
            <label class="form-label">Status</label>
            <select class="form-select" name="is_active">
              <option value="1">Aktif</option>
              <option value="0">Belum Aktif</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" name="password" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Ulangi Password</label>
            <input type="password" class="form-control" name="repassword" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success">Simpan Nasabah</button>
        </div>
      </div>
    </form>
  </div>
</div>

@endsection