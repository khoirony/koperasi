@extends('dashboard.layouts.main')

@section('container')

<div class="pagetitle">
    <h1>{{ $title }}</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item">Admin</li>
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
    <div class="row">
        <div class="col-lg-5">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Form Pegawai</h5>

                    <!-- Vertical Form -->
                    <form action="/tambahpegawai" method="POST" class="row g-3">
                        @csrf
                        <div class="col-12">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" name="nama" id="nama">
                        </div>
                        <div class="col-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email">
                        </div>
                        <div class="col-12">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="col-12">
                            <label for="repassword" class="form-label">Re-Password</label>
                            <input type="password" class="form-control" id="repassword" name="repassword">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form><!-- Vertical Form -->
                    <!-- End General Form Elements -->

                </div>
            </div>

        </div>

        <div class="col-lg-7">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Daftar Pegawai</h5>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Status</th>
                                <th scope="col" width="17%">aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <th scope="row">{{ $n++ }}</th>
                                <td>{{ $user?->nama ?? '-' }}</td>
                                <td>{{ $user?->email ?? '-' }}</td>

                                <td>
                                    @if($user?->is_active == 1) 
                                        <span class="px-3 py-1 bg-primary text-white rounded-pill">Aktif</span>
                                    @else 
                                        <span class="px-3 py-1 bg-danger text-white rounded-pill">Belum Aktif</span>
                                    @endif
                                </td>

                                <td>
                                    <a href="/editpegawai/{{ $user?->id }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil-square"></i>
                                    </a> 
                                    <a href="/hapuspegawai/{{ $user?->id }}" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>
</section>

@endsection
