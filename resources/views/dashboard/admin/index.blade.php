@extends('dashboard.layouts.main')

@section('container')

<div class="pagetitle">
  <h1>Dashboard</h1>
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

<section class="section dashboard">
  <div class="row">
    <div class="col-md-4">
      <div class="card info-card sales-card">
        <div class="card-body">
          <h5 class="card-title">Nasabah <span>| Aktif</span></h5>
          <div class="d-flex align-items-center">
            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
              <i class="bi bi-person-check-fill"></i>
            </div>
            <div class="ps-3">
              <h6>{{ $jmlNasabahActive }}</h6>
              <span class="text-success small pt-1 fw-bold">Nasabah</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card info-card sales-card">
        <div class="card-body">
          <h5 class="card-title">Nasabah <span>| Belum Aktif</span></h5>
          <div class="d-flex align-items-center">
            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
              <i class="bi bi-person-x-fill"></i>
            </div>
            <div class="ps-3">
              <h6>{{ $jmlNasabahInactive }}</h6>
              <span class="text-success small pt-1 fw-bold">Nasabah</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card info-card sales-card">
        <div class="card-body">
          <h5 class="card-title">Pinjaman <span>| Diproses</span></h5>
          <div class="d-flex align-items-center">
            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
              <i class="bi bi-hourglass-split text-warning"></i>
            </div>
            <div class="ps-3">
              <h6>{{ $pinjamanDiproses }}</h6>
              <span class="text-success small pt-1 fw-bold">Pinjaman</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card info-card sales-card">
        <div class="card-body">
          <h5 class="card-title">Pinjaman <span>| Ditolak</span></h5>
          <div class="d-flex align-items-center">
            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
              <i class="bi bi-clipboard2-x-fill text-danger"></i>
            </div>
            <div class="ps-3">
              <h6>{{ $pinjamanDitolak }}</h6>
              <span class="text-success small pt-1 fw-bold">Pinjaman</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card info-card sales-card">
        <div class="card-body">
          <h5 class="card-title">Pinjaman <span>| Diterima</span></h5>
          <div class="d-flex align-items-center">
            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
              <i class="bi bi-clipboard2-check-fill text-success"></i>
            </div>
            <div class="ps-3">
              <h6>{{ $pinjamanSukses }}</h6>
              <span class="text-success small pt-1 fw-bold">Pinjaman</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection