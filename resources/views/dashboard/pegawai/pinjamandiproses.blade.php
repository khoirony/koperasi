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
    <div class="card-body pt-5">

      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">Waktu</th>
            <th scope="col">Nama Peminjam</th>
            <th scope="col">Jumlah Pinjaman</th>
            <th scope="col">Jangka Waktu</th>
            <th scope="col">Status</th>
            <th scope="col">aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($pinjamanDiproses as $pinjaman)
          <tr>
            <th scope="row">{{ $pinjaman->created_at }}</th>
            <td>{{ $pinjaman->peminjam->nama }}</td>
            <td>Rp{{ number_format($pinjaman->jumlah) }},-</td>
            <td>{{ $pinjaman->jangka_waktu }}</td>
            <td>
              @switch($pinjaman->status_pinjaman)
                  @case(1)
                  <span class="badge bg-warning">{{ 'Sedang Diproses' }}</span>
                    @break
                  @case(2)
                    <span class="badge bg-success">{{ 'Sukses' }}</span>
                    @break
                  @case(3)
                    <span class="badge bg-danger">{{ 'Ditolak' }}</span>
                    @break
              @endswitch
            </td>
            <td>
              {{-- <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#id{{ $pinjaman->id }}"><i class="bi bi-image"></i></button> --}}
              <a href="/kelolatanggapan/{{ $pinjaman->id }}" class="btn btn-sm btn-primary"><i class="bi bi-pencil-square"></i></a> 
              <a href="/hapustanggapan/{{ $pinjaman->id }}" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a>
            </td>
          </tr>
          <div class="modal fade" id="id{{ $pinjaman->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content w-100">
                <div class="modal-header">
                  <h5 class="modal-title">Gambar Bukti</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  @if($pinjaman->gambar != null)
                  <div class="text-center">
                    <img src="{{ url('/aduan/'.$pinjaman->gambar) }}" alt="gambar" class="w-100">
                  </div>
                  @else
                  <div class="text-center">
                    -kosong-
                  </div>
                  @endif
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </tbody>
      </table>

    </div>
  </div>
</section>

@endsection