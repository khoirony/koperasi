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
            <th scope="col">Tgl</th>
            <th scope="col">Nama Peminjam</th>
            <th scope="col">Jumlah Pinjaman</th>
            <th scope="col">Jangka Waktu</th>
            <th scope="col">Bunga</th>
            <th scope="col">Realisasi</th>
            <th scope="col">Status</th>
            <th scope="col">Tanggapan</th>
            <th scope="col" width="10%">aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($pinjamanDiterima as $pinjaman)
          <tr>
            <th scope="row">{{ $pinjaman?->created_at }}</th>
            <td>{{ $pinjaman?->peminjam?->nama ?? '-' }}</td>
            <td>Rp{{ number_format($pinjaman?->jumlah ?? 0) }},-</td>
            <td>{{ $pinjaman?->jangka_waktu ?? 0 }} bulan</td>
            <td>{{ $pinjaman?->bunga_perbulan ?? 0 }}%</td>
            <td>
              @php
                $realisasiperbulan = $pinjaman?->jumlah*($pinjaman?->bunga_perbulan/100)
              @endphp
              Rp{{ number_format($pinjaman?->jumlah+($realisasiperbulan*$pinjaman?->jangka_waktu)) }},-
            </td>
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
            <td>{{ $pinjaman?->tanggapan }}</td>
            <td>
              <a href="/kelolatanggapan/{{ $pinjaman?->id }}" class="btn btn-sm btn-primary"><i class="bi bi-pencil-square"></i></a> 
              <a href="/hapustanggapan/{{ $pinjaman?->id }}" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>

    </div>
  </div>
</section>

@endsection