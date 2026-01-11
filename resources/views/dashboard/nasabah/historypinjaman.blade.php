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
    <div class="card-body pt-5">
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">Waktu</th>
            <th scope="col">Nama Peminjam</th>
            <th scope="col">Jumlah Pinjaman</th>
            <th scope="col">Jangka Waktu</th>
            <th scope="col">Tanggapan</th>
            <th scope="col">Diproses Oleh</th>
            <th scope="col">Status</th>
            <th scope="col">aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($historyPinjaman as $pinjaman)
          <tr>
            <th scope="row">{{ $pinjaman?->created_at }}</th>
            <td>{{ $pinjaman?->peminjam?->nama ?? '-' }}</td>
            <td>Rp{{ number_format($pinjaman?->jumlah ?? 0) }},-</td>
            <td>{{ $pinjaman?->jangka_waktu ?? 0 }} bulan</td>
            <td>{{ $pinjaman?->tanggapan ?? '- Belum Ada -' }}</td>
            <td>{{ $pinjaman?->pegawai?->nama ?? '-Belum Ada-' }}</td>
            <td>
              @switch($pinjaman?->status_pinjaman)
                  @case(1)
                  <span class="badge bg-warning">{{ 'Sedang Diproses' }}</span>
                    @break
                  @case(2)
                    <span class="badge bg-success">{{ 'Diterima' }}</span>
                    @break
                  @case(3)
                    <span class="badge bg-danger">{{ 'Ditolak' }}</span>
                    @break
              @endswitch
            </td>
            <td>
              @if($pinjaman?->status_pinjaman != 2)
                <a href="/editpinjaman/{{ $pinjaman?->id }}" class="btn btn-sm btn-primary"><i class="bi bi-pencil-square"></i></a> 
                <a href="/hapuspinjaman/{{ $pinjaman?->id }}" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a>
              @else
                <a href="/notapinjaman/{{ $pinjaman?->id }}" target="_blank" class="btn btn-sm btn-success"><i class="bi bi-receipt"></i></a> 
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</section>

@endsection