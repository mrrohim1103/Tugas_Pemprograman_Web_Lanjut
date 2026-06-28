<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Buku Tamu PT Suzuki Indomobil Motor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        .link-suzuki {
            color: #003399;
        }
        .link-suzuki:hover {
            color: #002266;
        }
        .divider-text {
            color: #6c757d;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">

                <div class="text-center mb-4">
                    <h4 class="fw-bold text-dark">Sistem Buku Tamu</h4>
                    <p class="text-muted small">PT Suzuki Indomobil Motor</p>
                </div>

                <div class="card card-auth">
                    <div class="card-header card-header-auth text-center">
                        <h5 class="mb-0 fw-bold">Masuk ke Akun</h5>
                    </div>
                    <div class="card-body p-4">

                        {{-- Alert sukses (misal setelah logout) --}}
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show py-2 small" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('login') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-bold small">Email</label>
                                <input
                                    type="email"
                                    name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}"
                                    placeholder="contoh@email.com"
                                    autofocus
                                    required
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
                                    placeholder="Masukkan password"
                                    required
                                >
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <button type="submit" class="btn btn-suzuki py-2 fw-bold w-100">Masuk</button>
                            </div>
                        </form>

                        <hr class="my-3">
                        <div class="p-3 rounded-3 text-center" style="background-color:#f0f4ff; border: 1px dashed #93aef5;">
                            <p class="small mb-1" style="color:#374151;">Apakah Anda tamu yang ingin berkunjung?</p>
                            <a href="{{ route('tamu.form') }}" class="btn btn-sm fw-bold px-3 py-1" style="background-color:#003399;color:#fff;border-radius:6px;">
                                <i class="bi bi-pencil-square me-1"></i>Isi Form Kunjungan
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
