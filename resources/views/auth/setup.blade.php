<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup Akun Admin - Buku Tamu PT Suzuki Indomobil Motor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f4ff;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .card-auth {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0, 51, 153, 0.12);
        }
        .card-header-auth {
            background-color: #003399;
            color: #ffffff;
            border-radius: 12px 12px 0 0 !important;
            padding: 1.5rem;
        }
        .btn-suzuki {
            background-color: #003399;
            color: #ffffff;
            border: none;
        }
        .btn-suzuki:hover {
            background-color: #002266;
            color: #ffffff;
        }
        .form-control:focus {
            border-color: #003399;
            box-shadow: 0 0 0 0.2rem rgba(0, 51, 153, 0.15);
        }
        .notice-box {
            background-color: #fff8e1;
            border: 1px solid #ffe082;
            border-radius: 8px;
            font-size: 0.82rem;
            color: #7a5c00;
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">

                <div class="text-center mb-4">
                    <h4 class="fw-bold text-dark">Sistem Buku Tamu</h4>
                    <p class="text-muted small">PT Suzuki Indomobil Motor</p>
                </div>

                <div class="card card-auth">
                    <div class="card-header card-header-auth text-center">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-shield-lock-fill me-2"></i>Setup Akun Admin Pertama
                        </h5>
                    </div>
                    <div class="card-body p-4">

                        <div class="notice-box p-3 mb-4">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i>
                            <strong>Perhatian:</strong> Halaman ini hanya muncul sekali selama tabel akun masih kosong.
                            Setelah akun berhasil dibuat, halaman ini otomatis tidak bisa diakses lagi.
                        </div>

                        <form action="{{ route('setup.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-bold small">Nama Lengkap</label>
                                <input
                                    type="text"
                                    name="nama_lengkap"
                                    class="form-control @error('nama_lengkap') is-invalid @enderror"
                                    value="{{ old('nama_lengkap') }}"
                                    placeholder="Nama lengkap admin"
                                    autofocus
                                >
                                @error('nama_lengkap')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small">Username</label>
                                <input
                                    type="text"
                                    name="username"
                                    class="form-control @error('username') is-invalid @enderror"
                                    value="{{ old('username') }}"
                                    placeholder="Username unik"
                                >
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small">Email</label>
                                <input
                                    type="email"
                                    name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}"
                                    placeholder="email@suzuki.com"
                                >
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small">Password</label>
                                <input
                                    type="password"
                                    name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Minimal 6 karakter"
                                >
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold small">Konfirmasi Password</label>
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    class="form-control"
                                    placeholder="Ulangi password"
                                >
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-suzuki py-2 fw-bold">
                                    <i class="bi bi-person-check-fill me-2"></i>Buat Akun & Masuk
                                </button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
