@extends('dashboard.layouts.main')

@section('container')

<div class="pagetitle">
    <h1>{{ $title }}</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            @if(Auth::user()->role == 1)
                <li class="breadcrumb-item">Admin</li>
            @elseif(Auth::user()->role == 2)
                <li class="breadcrumb-item">Pegawai</li>
            @endif
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
    </nav>
</div><!-- End Page Title -->
@if(session()->has('success'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session()->has('loginError'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    {{ session('loginError') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<section class="section dashboard">
    <div class="card">
        <div class="card-body p-5">
            <div class="text-center">
                <h1>Form Pinjaman</h1>
            </div>
            <!-- Floating Labels Form -->
            <form class="row g-3" action="/kelolatanggapan" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="id" value="{{ $id }}">
                <div class="col-12 mt-5">
                    <div class="form-floating">
                        <input class="form-control bg-light" type="text" value="{{ $pinjaman->nama }}" readonly>
                        <label>pinjaman Dari</label>
                    </div>
                </div>

                <div class="col-12">
                    <label for="nik" class="form-label">NIK</label>
                    <input type="text" class="form-control" name="nik" id="nik" value="{{ $pinjaman->nik }}" readonly>
                </div>
                <div class="col-6">
                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                    <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" value="{{ $pinjaman->tempat_lahir }}" readonly>
                </div>
                <div class="col-6">
                    <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir" value="{{ $pinjaman->tgl_lahir }}" readonly>
                </div>
                <div class="col-12">
                    <label for="active" class="form-label">Jenis Kelamin</label>
                    <input type="text" class="form-control" name="jenis_kelamin" id="jenis_kelamin" value="{{ $pinjaman->jenis_kelamin }}" readonly>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat" style="height: 100px;" readonly>{{ $pinjaman->alamat }}</textarea>
                        <label for="floatingTextarea">Alamat Lengkap</label>
                        @error('alamat')
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <label for="no_telp" class="form-label">Nomor Telfon</label>
                    <input type="text" class="form-control" name="no_telp" id="no_telp" value="{{ $pinjaman->no_telp }}" readonly>
                </div>
                <div class="col-12">
                    <label for="active" class="form-label">Status Perkawinan</label>
                    <input type="text" class="form-control" name="status_kawin" id="status_kawin" value="{{ $pinjaman->status_kawin }}" readonly>
                </div>
                <div class="col-12">
                    <label for="pekerjaan" class="form-label">Pekerjaan</label>
                    <input type="text" class="form-control" name="pekerjaan" id="pekerjaan" value="{{ $pinjaman->pekerjaan }}" readonly>
                </div>
                <div class="col-12">
                    <label for="kewarganegaraan" class="form-label">Kewarganegaraan</label>
                    <input type="text" class="form-control" name="kewarganegaraan" id="kewarganegaraan" value="{{ $pinjaman->kewarganegaraan }}" readonly>
                </div>

                <hr>

                <div class="col-8">
                    <label for="name" class="form-label">Jumlah Pinjaman</label>
                    <input type="number" class="form-control" name="jumlah" id="jumlah" value="{{ $pinjaman->jumlah }}" readonly>
                </div>
                <div class="col-4">
                    <label for="name" class="form-label">Jangka Waktu (Bulan)</label>
                    <input type="number" class="form-control" name="jangka_waktu" id="jangka_waktu" value="{{ $pinjaman->jangka_waktu }}" readonly>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <textarea class="form-control @error('tujuan_pinjaman') is-invalid @enderror" name="tujuan_pinjaman" id="tujuan_pinjaman" style="height: 100px;" readonly>{{ $pinjaman->tujuan_pinjaman }}</textarea>
                        <label for="floatingTextarea">Untuk Keperluan</label>
                        @error('tujuan_pinjaman')
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12">
                    <label for="name" class="form-label">Bunga Perbulan (%)</label>
                    <input type="number" class="form-control" name="bunga_perbulan" id="bunga_perbulan" value="{{ $pinjaman->bunga_perbulan }}">
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <textarea class="form-control @error('tanggapan') is-invalid @enderror" name="tanggapan" id="tanggapan" style="height: 250px;" required>{{ $pinjaman->tanggapan }}</textarea>
                        <label for="floatingTextarea">Masukkan Tanggapan</label>
                        @error('tanggapan')
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12 d-flex">
                    <div class="form-check">
                        Status :
                    </div>
                    <div class="form-check ms-2">
                        <input class="form-check-input" type="radio" name="status_pinjaman" id="status_pinjaman" value="1" {{ ($pinjaman->status_pinjaman === 1) ? 'checked' : '' }}>
                        <label class="form-check-label" for="status_pinjaman">
                          Diproses
                        </label>
                    </div>
                    <div class="form-check ms-2">
                        <input class="form-check-input" type="radio" name="status_pinjaman" id="status_pinjaman" value="3" {{ ($pinjaman->status_pinjaman === 3) ? 'checked' : '' }}>
                        <label class="form-check-label" for="status_pinjaman">
                          Ditolak
                        </label>
                    </div>
                    <div class="form-check ms-2">
                        <input class="form-check-input" type="radio" name="status_pinjaman" id="status_pinjaman" value="2" {{ ($pinjaman->status_pinjaman === 2) ? 'checked' : '' }}>
                        <label class="form-check-label" for="status_pinjaman">
                          Diterima
                        </label>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
            </form><!-- End floating Labels Form -->

        </div>
    </div>
</section>

@endsection
