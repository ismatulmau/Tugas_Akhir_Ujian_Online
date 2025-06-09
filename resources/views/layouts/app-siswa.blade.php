<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard Siswa')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        .navbar-custom {
            background-color: #001a33 !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand {
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .student-welcome {
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.9);
        }
        .student-name {
            color: white;
            font-weight: 500;
        }
        .avatar-container {
            transition: all 0.3s ease;
        }
        .avatar-container:hover {
            transform: scale(1.05);
        }
        .dropdown-menu {
            border-radius: 8px;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        .dropdown-item {
            padding: 8px 16px;
            border-radius: 4px;
        }
        .dropdown-item:hover {
            background-color: #f8f9fa;
            color: #001a33;
        }
    </style>
</head>
<body>

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom py-2">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
    <img src="{{ asset('assets/img/logo_telematika.png') }}" alt="navbar brand" class="navbar-brand" height="50">
    <span class="text-white" style="margin: 0; font-weight: 600; font-size: 1.1rem;">SMK Telematika Indramayu</span>
</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                @php
                    $siswa = Auth::guard('siswa')->user();
                @endphp
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown">
                            @if($siswa)
                                <div class="d-flex flex-column me-3 text-end">
                                    <span class="student-welcome">Selamat datang</span>
                                    <span class="student-name">{{ $siswa->nama_siswa }}</span>
                                </div>
                                <div class="avatar-container">
                                    @if($siswa->gambar)
                                        <img src="{{ asset('storage/' . $siswa->gambar) }}" width="36" height="36" class="rounded-circle object-fit-cover border border-2 border-white">
                                    @else
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                            <i class="fas fa-user text-primary"></i>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end mt-2">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Konten halaman --}}
    <div class="container mt-4">
        @yield('content')
    </div>

    {{-- JS Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>