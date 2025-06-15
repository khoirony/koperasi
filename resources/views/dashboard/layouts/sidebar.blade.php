  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      @if(Auth::user()->role_id == 1)
      <li class="nav-item">
        <a class="nav-link collapsed" href="/admin">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="/tambahpegawai">
          <i class="bi bi-person-plus-fill"></i>
          <span>List Pegawai</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="/tambahpeminjam">
          <i class="bi bi-person-plus"></i>
          <span>List Peminjam</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#pinjaman-admin" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Pinjaman</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="pinjaman-admin" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="/pinjamandiproses">
              <i class="bi bi-circle"></i><span>Pinjaman Diproses</span>
            </a>
          </li>
          <li>
            <a href="/pinjamanditolak">
              <i class="bi bi-circle"></i><span>Pinjaman Ditolak</span>
            </a>
          </li>
          <li>
            <a href="/pinjamanditerima">
              <i class="bi bi-circle"></i><span>Pinjaman Diterima</span>
            </a>
          </li>
        </ul>
      </li>
      @endif

      @if(Auth::user()->role_id == 2)
      <li class="nav-item">
        <a class="nav-link collapsed" href="/pegawai">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="/tambahpeminjam">
          <i class="bi bi-person-plus"></i>
          <span>Tambah Peminjam</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#pinjaman-pegawai" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Pinjaman</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="pinjaman-pegawai" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="/pinjamandiproses">
              <i class="bi bi-circle"></i><span>Pinjaman Diproses</span>
            </a>
          </li>
          <li>
            <a href="/pinjamanditolak">
              <i class="bi bi-circle"></i><span>Pinjaman Ditolak</span>
            </a>
          </li>
          <li>
            <a href="/pinjamanditerima">
              <i class="bi bi-circle"></i><span>Pinjaman Diterima</span>
            </a>
          </li>
        </ul>
      </li>
      @endif

      @if(Auth::user()->role_id == 3)
      <li class="nav-item">
        <a class="nav-link collapsed" href="/peminjam">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="/ajukanpinjaman">
          <i class="bi bi-journal-plus"></i>
          <span>Ajukan Pinjaman</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="/historypinjaman">
          <i class="bi bi-journal-bookmark"></i>
          <span>History Pinjaman</span>
        </a>
      </li>
      @endif
    </ul>

  </aside><!-- End Sidebar-->