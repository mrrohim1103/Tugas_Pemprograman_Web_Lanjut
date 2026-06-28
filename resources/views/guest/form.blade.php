<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kunjungan - PT Suzuki Indomobil Motor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --suzuki-blue: #003399;
            --suzuki-dark: #002266;
        }
        body {
            background: linear-gradient(135deg, #e8eeff 0%, #f5f7ff 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }
        .header-banner {
            background-color: var(--suzuki-blue);
            color: #fff;
            padding: 1.25rem 0;
            margin-bottom: 2rem;
            box-shadow: 0 2px 8px rgba(0,51,153,0.2);
        }
        .header-banner h5 {
            margin: 0;
            font-weight: 700;
            font-size: 1rem;
        }
        .header-banner p {
            margin: 0;
            font-size: 0.8rem;
            opacity: 0.85;
        }
        .card-form {
            border: none;
            border-radius: 16px;
            box-shadow: 0 6px 32px rgba(0, 51, 153, 0.1);
        }
        .section-label {
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--suzuki-blue);
            border-bottom: 2px solid #e0e7ff;
            padding-bottom: 0.4rem;
            margin-bottom: 1rem;
        }
        .form-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #374151;
        }
        .form-control {
            border-radius: 8px;
            border-color: #d1d5db;
            font-size: 0.9rem;
            padding: 0.6rem 0.85rem;
        }
        .form-control:focus {
            border-color: var(--suzuki-blue);
            box-shadow: 0 0 0 0.2rem rgba(0, 51, 153, 0.12);
        }
        .form-control.is-invalid:focus {
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.15);
        }
        .btn-submit {
            background-color: var(--suzuki-blue);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 1rem;
            padding: 0.75rem;
            transition: background 0.2s;
        }
        .btn-submit:hover {
            background-color: var(--suzuki-dark);
            color: #fff;
        }
        .step-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background-color: var(--suzuki-blue);
            color: #fff;
            font-size: 0.75rem;
            font-weight: 700;
            margin-right: 0.5rem;
            flex-shrink: 0;
        }
        .footer-note {
            font-size: 0.78rem;
            color: #6b7280;
            text-align: center;
            margin-top: 1.5rem;
            padding-bottom: 2rem;
        }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="header-banner">
        <div class="container d-flex align-items-center gap-3">
            <i class="bi bi-journal-bookmark-fill fs-3"></i>
            <div>
                <h5>Buku Tamu Digital</h5>
                <p>PT Suzuki Indomobil Motor</p>
            </div>
        </div>
    </div>

    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6">

                <div class="text-center mb-4">
                    <h4 class="fw-bold text-dark">Form Pendaftaran Tamu</h4>
                    <p class="text-muted small">Silakan isi data di bawah ini untuk mencatat kunjungan Anda</p>
                </div>

                <div class="card card-form">
                    <div class="card-body p-4">

                        <form action="{{ route('tamu.store') }}" method="POST" novalidate>
                            @csrf

                            {{-- Bagian 1: Data Pribadi --}}
                            <div class="section-label d-flex align-items-center">
                                <span class="step-badge">1</span> Data Pribadi
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    name="nama_tamu"
                                    id="nama_tamu"
                                    class="form-control @error('nama_tamu') is-invalid @enderror"
                                    value="{{ old('nama_tamu') }}"
                                    placeholder="Masukkan nama lengkap Anda"
                                    autofocus
                                    inputmode="text"
                                >
                                @error('nama_tamu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Perusahaan / Instansi <span class="text-danger">*</span></label>
                                    <input
                                        type="text"
                                        name="perusahaan"
                                        class="form-control @error('perusahaan') is-invalid @enderror"
                                        value="{{ old('perusahaan') }}"
                                        placeholder="Nama perusahaan"
                                    >
                                    @error('perusahaan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nomor HP <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0 text-muted">
                                            <i class="bi bi-phone"></i>
                                        </span>
                                        <input
                                            type="tel"
                                            name="no_hp"
                                            class="form-control border-start-0 @error('no_hp') is-invalid @enderror"
                                            value="{{ old('no_hp') }}"
                                            placeholder="08xxxxxxxxxx"
                                        >
                                        @error('no_hp')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Bagian 2: Info Kunjungan --}}
                            <div class="section-label d-flex align-items-center mt-3">
                                <span class="step-badge">2</span> Informasi Kunjungan
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Divisi / Departemen yang Dituju <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    name="divisi_tujuan"
                                    class="form-control @error('divisi_tujuan') is-invalid @enderror"
                                    value="{{ old('divisi_tujuan') }}"
                                    placeholder="Contoh: HRD, Marketing, Finance..."
                                >
                                @error('divisi_tujuan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Keperluan Kunjungan <span class="text-danger">*</span></label>
                                <textarea
                                    name="keperluan"
                                    class="form-control @error('keperluan') is-invalid @enderror"
                                    rows="3"
                                    placeholder="Jelaskan keperluan kunjungan Anda secara singkat..."
                                >{{ old('keperluan') }}</textarea>
                                @error('keperluan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-submit">
                                    <i class="bi bi-check2-circle me-2"></i>Daftarkan Kunjungan Saya
                                </button>
                            </div>
                        </form>

                    </div>
                </div>

                <p class="footer-note">
                    <i class="bi bi-shield-check me-1"></i>
                    Data Anda aman dan hanya digunakan untuk keperluan pencatatan kunjungan.
                </p>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Blokir input angka pada field nama_tamu secara real-time
        const namaTamu = document.getElementById('nama_tamu');

        namaTamu.addEventListener('keypress', function (e) {
            if (/[0-9]/.test(e.key)) {
                e.preventDefault();
            }
        });

        namaTamu.addEventListener('input', function () {
            this.value = this.value.replace(/[0-9]/g, '');
        });

        // Blokir paste yang mengandung angka
        namaTamu.addEventListener('paste', function (e) {
            e.preventDefault();
            const pasted = (e.clipboardData || window.clipboardData).getData('text');
            const cleaned = pasted.replace(/[0-9]/g, '');
            document.execCommand('insertText', false, cleaned);
        });
    </script>
</body>
</html>
