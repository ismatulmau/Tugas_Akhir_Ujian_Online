<div class="sidebar" data-background-color="dark">
    <!-- Sidebar Header with Logo and School Name -->
    <div class="sidebar-logo">
        <div class="logo-header" data-background-color="dark" style="display: flex; align-items: center; padding: 15px 20px;">
            <a href="{{ route('admin.dashboard') }}" class="logo" style="display: flex; align-items: center; text-decoration: none;">
                <img src="{{ asset('assets/img/logo_telematika.png') }}" alt="SMK Telematika Indramayu" class="navbar-brand" height="50">
                <div style="margin-left: 10px; color: white;">
                    <h4 style="margin: 0; font-weight: 600; font-size: 1.1rem;">SMK Telematika</h4>
                    <p style="margin: 0; font-weight: 600; font-size: 1.1rem;">Indramayu</p>
                </div>
            </a>
            
        </div>
    </div>

    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item {{ request()->is('master-data*') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#base" class="nav-link collapsed" aria-expanded="false">
                        <i class="fas fa-layer-group"></i>
                        <p>Master Data</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="base">
                        <ul class="nav nav-collapse">
                            <li class="nav-item {{ request()->routeIs('kelas.index') ? 'active' : '' }}">
                                <a href="{{ route('kelas.index') }}" class="nav-link">
                                    <span class="sub-item">Daftar Kelas</span>
                                </a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('mapel.index') ? 'active' : '' }}">
                                <a href="{{ route('mapel.index') }}" class="nav-link">
                                    <span class="sub-item">Mata Pelajaran</span></a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('siswa.index') ? 'active' : '' }}">
                                <a href="{{ route('siswa.index') }}" class="nav-link"><span class="sub-item">Daftar Siswa</span></a>
                            </li>
                        </ul>
                    </div> 
                </li>

                <!-- BANK SOAL -->
                <li class="nav-item {{ request()->is('bank-soal*') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#sidebarLayouts" class="nav-link {{ request()->is('bank-soal*') ? '' : 'collapsed' }}" aria-expanded="{{ request()->is('bank-soal*') ? 'true' : 'false' }}">
                        <i class="fas fa-th-list"></i>
                        <p>Bank Soal</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ request()->is('bank-soal*') ? 'show' : '' }}" id="sidebarLayouts">
                        <ul class="nav nav-collapse">
                            <li class="nav-item {{ request()->routeIs('bank-soal.index') ? 'active' : '' }}">
                                <a href="{{ route('bank-soal.index') }}" class="nav-link"><span class="sub-item">Bank Soal</span></a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- STATUS UJIAN -->
                <li class="nav-item {{ request()->is('status-ujian*') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#forms" class="nav-link {{ request()->is('status-ujian*') ? '' : 'collapsed' }}" aria-expanded="{{ request()->is('status-ujian*') ? 'true' : 'false' }}">
                        <i class="fas fa-pen-square"></i>
                        <p>Status Ujian</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ request()->is('status-ujian*') ? 'show' : '' }}" id="forms">
                        <ul class="nav nav-collapse">
                            <li class="nav-item {{ request()->routeIs('setting-ujian.index') ? 'active' : '' }}">
                                <a href="{{ route('setting-ujian.index') }}" class="nav-link"><span class="sub-item">Kelola Ujian</span></a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('jadwal.ujian') ? 'active' : '' }}">
                                <a href="{{ route('jadwal.ujian') }}" class="nav-link"><span class="sub-item">Jadwal Ujian</span></a>
                            </li>
                            
                        </ul>
                    </div>
                </li>

<li class="nav-item {{ request()->routeIs('rekap.nilai.index') ? 'active' : '' }}">
                    <a href="{{ route('rekap.nilai.index') }}" class="nav-link">
                        <i class="fas fa-table"></i>
                        <p>Rekap Nilai</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>