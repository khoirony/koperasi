@extends('dashboard.layouts.main')

@section('container')

<div class="pagetitle">
    <h1>{{ $title }}</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item">Anggota</li>
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

@if(session()->has('error'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<section class="section dashboard">
    <div class="card">
        <div class="card-body p-5">
            <div class="text-center mb-5">
                <h1>Form Pinjaman</h1>
            </div>
            <!-- Floating Labels Form -->
            <form class="row g-3" action="/editpinjaman" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden"name="id" id="id" value="{{ $pinjaman?->id }}">
                <div class="col-8">
                    <label for="name" class="form-label">Jumlah Pinjaman</label>
                    <input type="number" class="form-control" name="jumlah" id="jumlah" value="{{ $pinjaman?->jumlah }}">
                </div>
                <div class="col-4">
                    <label for="name" class="form-label">Jangka Waktu (Bulan)</label>
                    <input type="number" class="form-control" name="jangka_waktu" id="jangka_waktu" value="{{ $pinjaman?->jangka_waktu }}">
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <textarea class="form-control @error('tujuan_pinjaman') is-invalid @enderror" name="tujuan_pinjaman" id="tujuan_pinjaman" style="height: 100px;" required>{{ $pinjaman?->tujuan_pinjaman }}</textarea>
                        <label for="floatingTextarea">Untuk Keperluan</label>
                        @error('tujuan_pinjaman')
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <hr>
                <div class="col-12">
                    <label for="name" class="form-label">Nama Peminjam</label>
                    <input type="text" class="form-control" name="nama" id="nama" value="{{ $pinjaman?->nama }}">
                </div>
                <div class="col-12">
                    <label for="nik" class="form-label">NIK</label>
                    <input type="text" class="form-control" name="nik" id="nik" value="{{ $pinjaman?->nik }}">
                </div>
                <div class="col-6">
                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                    <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" value="{{ $pinjaman?->tempat_lahir }}">
                </div>
                <div class="col-6">
                    <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir" value="{{ $pinjaman?->tgl_lahir }}">
                </div>
                <div class="col-12">
                    <label for="active" class="form-label">Jenis Kelamain</label>
                    <select class="form-select" name="jenis_kelamin" id="jenis_kelamin" aria-label="Default select example">
                        <option value="Laki-Laki" @if($pinjaman?->jenis_kelamin == 'Laki-Laki') selected @endif>Laki-Laki</option>
                        <option value="Perempuan" @if($pinjaman?->jenis_kelamin == 'Perempuan') selected @endif>Perempuan</option>
                    </select>
                </div>
                <div class="col-12">
                    <div class="form-floating">
                        <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat" style="height: 100px;" required>{{ $pinjaman?->alamat }}</textarea>
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
                    <input type="text" class="form-control" name="no_telp" id="no_telp" value="{{ $pinjaman?->no_telp }}">
                </div>
                <div class="col-12">
                    <label for="active" class="form-label">Status Perkawinan</label>
                    <select class="form-select" name="status_kawin" id="status_kawin" aria-label="Default select example">
                        <option value="Belum Kawin" @if($pinjaman?->status_kawin == 'Belum Kawin') selected @endif>Belum Kawin</option>
                        <option value="Kawin" @if($pinjaman?->status_kawin == 'Kawin') selected @endif>Kawin</option>
                    </select>
                </div>
                <div class="col-12">
                    <label for="pekerjaan" class="form-label">Pekerjaan</label>
                    <input type="text" class="form-control" name="pekerjaan" id="pekerjaan" value="{{ $pinjaman?->pekerjaan }}">
                </div>
                <div class="col-12">
                    <label for="kewarganegaraan" class="form-label">Kewarganegaraan</label>
                    <input type="text" class="form-control" name="kewarganegaraan" id="kewarganegaraan" value="{{ $pinjaman?->kewarganegaraan }}">
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form><!-- End floating Labels Form -->

        </div>
    </div>
</section>

@endsection
