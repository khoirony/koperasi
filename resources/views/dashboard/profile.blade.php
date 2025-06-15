@extends('dashboard.layouts.main')

@section('container')
<div class="pagetitle">
    <h1>Profile</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            @if(Auth::user()->role_id == 1)
                <li class="breadcrumb-item">Admin</li>
            @elseif(Auth::user()->role_id == 2)
                <li class="breadcrumb-item">Pegawai</li>
            @else
                <li class="breadcrumb-item">Anggota</li>
            @endif
            <li class="breadcrumb-item active">Profile</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

@if(session()->has('success'))
<div class="alert alert-warning alert-dismissible fade show" role_id="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session()->has('error'))
<div class="alert alert-warning alert-dismissible fade show" role_id="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<section class="section profile">
    <div class="row">
        <div class="col-xl-4">

            <div class="card">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                    @if (Auth::user()->image == null)
                    <img src="/img/profile-img.jpg" alt="Profile" class="rounded-circle">
                    @else
                    <img src="{{ url('/profpic/'.Auth::user()->image) }}" alt="Profile" class="rounded-circle">
                    @endif
                    <h2>{{ Auth::user()->nama }}</h2>
                    <h3>{{ Auth::user()->email }}</h3>
                </div>
            </div>

        </div>

        <div class="col-xl-8">

            <div class="card">
                <div class="card-body pt-3">
                    <!-- Bordered Tabs -->
                    <ul class="nav nav-tabs nav-tabs-bordered">

                        @if(Auth::user()->role_id == 2 || Auth::user()->role_id == 3)
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab"
                                data-bs-target="#profile-overview">Overview</button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit
                                Profile</button>
                        </li>
                        @endif

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab"
                                data-bs-target="#profile-change-password">Change Password</button>
                        </li>
                    </ul>
                    
                    <div class="tab-content pt-2">
                        @if(Auth::user()->role_id == 2 || Auth::user()->role_id == 3)
                        <div class="tab-pane fade show active profile-overview" id="profile-overview">
                            <h5 class="card-title">Tentang</h5>
                            <p class="small fst-italic">{{ Auth::user()->bio ?? '-' }}</p>

                            <h5 class="card-title">Profile Details</h5>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label ">Nama Lengkap</div>
                                <div class="col-lg-9 col-md-8">{{ Auth::user()->nama ?? '-' }}</div>
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">NIK</div>
                                <div class="col-lg-9 col-md-8">{{ Auth::user()->nik ?? '-' }}</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Tempat, Tanggal Lahir</div>
                                <div class="col-lg-9 col-md-8">{{ Auth::user()->tempat_lahir.', '.Auth::user()->tgl_lahir }}</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Jenis Kelamin</div>
                                <div class="col-lg-9 col-md-8">{{ Auth::user()->jenis_kelamin ?? '-' }}</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Alamat</div>
                                <div class="col-lg-9 col-md-8">{{ Auth::user()->alamat ?? '-' }}</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">No Telp</div>
                                <div class="col-lg-9 col-md-8">{{ Auth::user()->no_telp ?? '-' }}</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Status Perkawinan</div>
                                <div class="col-lg-9 col-md-8">{{ Auth::user()->status_kawin ?? '-' }}</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Pekerjaan</div>
                                <div class="col-lg-9 col-md-8">{{ Auth::user()->pekerjaan ?? '-' }}</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Kewarganegaraan</div>
                                <div class="col-lg-9 col-md-8">{{ Auth::user()->kewarganegaraan ?? '-' }}</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Email</div>
                                <div class="col-lg-9 col-md-8">{{ Auth::user()->email }}</div>
                            </div>
                        </div>

                        <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                            <!-- Profile Edit Form -->
                            <form action="/profile" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" id="id" value="{{ Auth::user()->id }}">
                                <div class="row mb-3">
                                    <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile
                                        Image</label>
                                    <div class="col-md-8 col-lg-9">
                                        @if (Auth::user()->image == null)
                                        <img src="/img/profile-img.jpg" alt="Profile">
                                        @else
                                        <img src="{{ url('/profpic/'.Auth::user()->image) }}" alt="Profile">
                                        @endif
                                        <div class="pt-2">
                                            <input name="image" id="image" type="file" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="nama" class="col-md-4 col-lg-3 col-form-label">Nama Lengkap</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="nama" type="text" class="form-control" id="nama"
                                            value="{{ Auth::user()->nama }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="bio" class="col-md-4 col-lg-3 col-form-label">Tentang</label>
                                    <div class="col-md-8 col-lg-9">
                                        <textarea name="bio" class="form-control" id="tentang"
                                            style="height: 100px">{{ Auth::user()->bio }}</textarea>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="nik" class="col-md-4 col-lg-3 col-form-label">NIK</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="nik" type="text" class="form-control" id="nik"
                                            value="{{ Auth::user()->nik }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="tempat_lahir" class="col-md-4 col-lg-3 col-form-label">Tempat Lahir</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="tempat_lahir" type="text" class="form-control" id="tempat_lahir"
                                            value="{{ Auth::user()->tempat_lahir }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="tgl_lahir" class="col-md-4 col-lg-3 col-form-label">Tanggal Lahir</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="tgl_lahir" type="text" class="form-control" id="tgl_lahir" value="{{ Auth::user()->tgl_lahir }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="jenis_kelamin" class="col-md-4 col-lg-3 col-form-label">Jenis Kelamin</label>
                                    <div class="col-md-8 col-lg-9">
                                        <select class="form-select" name="jenis_kelamin" id="jenis_kelamin" aria-label="Default select example">
                                            <option value="Laki-Laki" @if(Auth::user()->jenis_kelamin == 'Laki-Laki') selected @endif>Laki-Laki</option>
                                            <option value="Perempuan" @if(Auth::user()->jenis_kelamin == 'Perempuan') selected @endif>Perempuan</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="alamat" class="col-md-4 col-lg-3 col-form-label">Alamat</label>
                                    <div class="col-md-8 col-lg-9">
                                        <textarea name="alamat" class="form-control" id="alamat"
                                            style="height: 100px">{{ Auth::user()->alamat }}</textarea>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="no_telp" class="col-md-4 col-lg-3 col-form-label">No Telfon</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="no_telp" type="text" class="form-control" id="no_telp"
                                            value="{{ Auth::user()->no_telp }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="status_kawin" class="col-md-4 col-lg-3 col-form-label">Status Perkawinan</label>
                                    <div class="col-md-8 col-lg-9">
                                        <select class="form-select" name="status_kawin" id="status_kawin" aria-label="Default select example">
                                            <option value="Belum Kawin" @if(Auth::user()->status_kawin == 'Belum Kawin') selected @endif>Belum Kawin</option>
                                            <option value="Kawin" @if(Auth::user()->status_kawin == 'Kawin') selected @endif>Kawin</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="pekerjaan" class="col-md-4 col-lg-3 col-form-label">Pekerjaan</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="pekerjaan" type="text" class="form-control" id="pekerjaan"
                                            value="{{ Auth::user()->pekerjaan }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="kewarganegaraan" class="col-md-4 col-lg-3 col-form-label">Kewarganegaraan</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="kewarganegaraan" type="text" class="form-control" id="kewarganegaraan"
                                            value="{{ Auth::user()->kewarganegaraan }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="email" type="email" class="form-control" id="Email"
                                            value="{{ Auth::user()->email }}">
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form><!-- End Profile Edit Form -->

                        </div>
                        @endif

                        <div class="tab-pane fade @if(Auth::user()->role_id == 1) show active @endif pt-3" id="profile-change-password">
                            <!-- Change Password Form -->
                            <form action="/changepass" method="POST">
                                @csrf
                                <div class="row mb-3">
                                    <label for="current_password" class="col-md-4 col-lg-3 col-form-label">Current
                                        Password</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="current_password" type="password" class="form-control"
                                            id="current_password" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="Password" class="col-md-4 col-lg-3 col-form-label">New
                                        Password</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="password" type="password" class="form-control" id="Password" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password_confirm" class="col-md-4 col-lg-3 col-form-label">Re-enter New
                                        Password</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="password_confirm" type="password" class="form-control"
                                            id="password_confirm" required>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Change Password</button>
                                </div>
                            </form><!-- End Change Password Form -->

                        </div>

                    </div><!-- End Bordered Tabs -->

                </div>
            </div>

        </div>
    </div>
</section>
@endsection