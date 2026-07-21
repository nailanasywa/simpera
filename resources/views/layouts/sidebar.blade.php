<div id="sidebar">
    <div class="sidebar-wrapper active">

        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    <h4>SIMPERA</h4>
                </div>
                <div class="sidebar-toggler x">
                    <a href="#" class="sidebar-hide d-xl-none d-block">
                        <i class="bi bi-x bi-middle"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="sidebar-menu">
            <ul class="menu">
                {{-- Admin Sidebar --}}
                @if (auth()->user()->role == 'admin')
                    <li class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('admin.dashboard') }}" class="sidebar-link">
                            <i class="bi bi-grid-fill"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="sidebar-item has-sub {{ request()->routeIs('admin.user*') || request()->routeIs('admin.pasien*') ? 'active' : '' }}">
                        <a href="#" class="sidebar-link">
                            <i class="bi bi-database-fill"></i>
                            <span>Master Data</span>
                        </a>
                        <ul class="submenu">
                            <li class="submenu-item {{ request()->routeIs('admin.user*') ? 'active' : '' }}">
                                <a href="{{ route('admin.user') }}">Data User</a>
                            </li>
                            <li class="submenu-item {{ request()->routeIs('admin.pasien*') ? 'active' : '' }}">
                                <a href="{{ route('admin.pasien') }}">Data Pasien</a>
                            </li>
                        </ul>
                    </li>

                    <li class="sidebar-item has-sub {{ request()->routeIs('admin.kunjungan*') || request()->routeIs('admin.approval*') || request()->routeIs('admin.peminjaman*') ? 'active' : '' }}">
                        <a href="#" class="sidebar-link">
                            <i class="bi bi-journal-text"></i>
                            <span>Transaksi</span>
                        </a>
                        <ul class="submenu">
                            <li class="submenu-item {{ request()->routeIs('admin.kunjungan*') ? 'active' : '' }}">
                                <a href="{{ route('admin.kunjungan') }}">Kunjungan</a>
                            </li>
                            <li class="submenu-item {{ request()->routeIs('admin.approval*') ? 'active' : '' }}">
                                <a href="{{ route('admin.approval') }}">Approval Permintaan</a>
                            </li>
                            <li class="submenu-item {{ request()->routeIs('admin.peminjaman*') ? 'active' : '' }}">
                                <a href="{{ route('admin.peminjaman') }}">Peminjaman Aktif</a>
                            </li>
                        </ul>
                    </li>

                    <li class="sidebar-item {{ request()->routeIs('admin.laporan') ? 'active' : '' }}">
                        <a href="{{ route('admin.laporan') }}" class="sidebar-link">
                            <i class="bi bi-file-earmark-bar-graph-fill"></i>
                            <span>Laporan</span>
                        </a>
                    </li>

                {{-- Kepala Puskesmas --}}
                @elseif(auth()->user()->role == 'kepala_puskesmas')
                    <li class="sidebar-item {{ request()->routeIs('kepala.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('kepala.dashboard') }}" class="sidebar-link">
                            <i class="bi bi-grid-fill"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('kepala.laporan') ? 'active' : '' }}">
                        <a href="{{ route('kepala.laporan') }}" class="sidebar-link">
                            <i class="bi bi-file-earmark-bar-graph-fill"></i>
                            <span>Laporan</span>
                        </a>
                    </li>
                {{-- Petugas Sidebar --}}
                @else
                    <li class="sidebar-item {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('petugas.dashboard') }}" class="sidebar-link">
                            <i class="bi bi-grid-fill"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{ request()->routeIs('petugas.permintaan*') ? 'active' : '' }}">
                        <a href="{{ route('petugas.permintaan') }}" class="sidebar-link">
                            <i class="bi bi-folder2-open"></i>
                            <span>Peminjaman RM</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>

    </div>
</div>
