<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Buku Tamu - PT Suzuki Indomobil Motor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        .bg-suzuki {
            background-color: #003399 !important;
            color: #ffffff !important;
        }
        .btn-suzuki {
            background-color: #003399;
            color: #ffffff;
            border: 1px solid #003399;
        }
        .btn-suzuki:hover {
            background-color: #002266;
            color: #ffffff;
        }
        .btn-outline-suzuki {
            color: #003399;
            border-color: #003399;
            background-color: transparent;
        }
        .btn-outline-suzuki:hover {
            background-color: #003399;
            color: #ffffff;
        }
        .text-suzuki {
            color: #003399 !important;
        }
        .navbar-brand:hover {
            opacity: 0.9;
        }
        .dropdown-item:active {
            background-color: #003399;
        }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-suzuki mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('kunjungan.index') }}">
                <i class="bi bi-journal-bookmark-fill me-2"></i>Buku Tamu | PT Suzuki Indomobil Motor
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain"
                aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    @auth
                        {{-- Dropdown user --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#"
                               id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="bg-white text-suzuki rounded-circle d-inline-flex align-items-center justify-content-center fw-bold"
                                      style="width:32px;height:32px;font-size:0.85rem;">
                                    {{ strtoupper(substr(Auth::user()->nama_lengkap, 0, 1)) }}
                                </span>
                                <span>{{ Auth::user()->nama_lengkap }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userDropdown">
                                <li>
                                    <span class="dropdown-item-text small text-muted">{{ Auth::user()->email }}</span>
                                </li>
                                <li><hr class="dropdown-divider my-1"></li>
                                {{-- Master Data --}}
                                <li><h6 class="dropdown-header small">Master Data</h6></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('master.locations') }}">
                                        <i class="bi bi-geo-alt-fill me-2"></i>Lokasi
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('master.departments') }}">
                                        <i class="bi bi-building me-2"></i>Departemen
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('master.rooms') }}">
                                        <i class="bi bi-door-open-fill me-2"></i>Ruangan
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('master.guest-categories') }}">
                                        <i class="bi bi-tags-fill me-2"></i>Kategori Tamu
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('master.visit-purposes') }}">
                                        <i class="bi bi-clipboard2-check-fill me-2"></i>Keperluan Kunjungan
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('master.roles') }}">
                                        <i class="bi bi-shield-fill me-2"></i>Role
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger" href="{{ route('master.blacklist') }}">
                                        <i class="bi bi-slash-circle-fill me-2"></i>Daftar Hitam
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider my-1"></li>
                                {{-- Akun Admin --}}
                                <li><h6 class="dropdown-header small">Akun Admin</h6></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.tambah-akun') }}">
                                        <i class="bi bi-person-plus-fill me-2"></i>Tambah Akun Admin
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.kelola-akun') }}">
                                        <i class="bi bi-people-fill me-2"></i>Kelola Akun Admin
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider my-1"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right me-2"></i>Keluar
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Masuk
                            </a>
                        </li>
                        <li class="nav-item ms-lg-2">
                            <a class="btn btn-light text-suzuki btn-sm fw-bold px-3" href="{{ route('register') }}">
                                Daftar
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
