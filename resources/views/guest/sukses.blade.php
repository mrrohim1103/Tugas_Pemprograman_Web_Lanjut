<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check-In Berhasil - PT Suzuki Indomobil Motor</title>
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
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }
        .card-sukses {
            border: none;
            border-radius: 20px;
            box-shadow: 0 8px 40px rgba(0, 51, 153, 0.13);
            max-width: 480px;
            width: 100%;
        }
        .icon-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #d1fae5;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }
        .icon-circle i {
            font-size: 2.5rem;
            color: #059669;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 0.6rem 0;
            border-bottom: 1px solid #f3f4f6;
            font-size: 0.9rem;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            color: #6b7280;
            font-weight: 500;
            flex-shrink: 0;
            margin-right: 1rem;
        }
        .info-value {
            font-weight: 600;
            color: #111827;
            text-align: right;
        }
        .badge-masuk {
            background-color: #003399;
            color: #fff;
            padding: 0.3em 0.8em;
            border-radius: 20px;
            font-size: 0.8rem;
        }
        .btn-daftar-lagi {
            background-color: var(--suzuki-blue);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            padding: 0.65rem 1.5rem;
            transition: background 0.2s;
        }
        .btn-daftar-lagi:hover {
            background-color: var(--suzuki-dark);
            color: #fff;
        }
        .header-logo {
            font-size: 0.8rem;
            color: #6b7280;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        .header-logo strong {
            color: var(--suzuki-blue);
        }
    </style>
</head>
<body>

    <div class="header-logo">
        <i class="bi bi-journal-bookmark-fill me-1" style="color: #003399;"></i>
        <strong>Buku Tamu Digital</strong> &mdash; PT Suzuki Indomobil Motor
    </div>

    <div class="card card-sukses">
        <div class="card-body p-4 p-md-5">

            {{-- Icon sukses --}}
            <div class="icon-circle">
                <i class="bi bi-check-circle-fill"></i>
            </div>

            <h4 class="fw-bold text-center mb-1">Check-In Berhasil!</h4>
            <p class="text-muted text-center small mb-4">
                Kunjungan Anda telah tercatat. Silakan menunggu di area resepsionis.
            </p>

            {{-- Detail kunjungan --}}
            <div class="bg-light rounded-3 p-3 mb-4">

                <div class="info-row">
                    <span class="info-label"><i class="bi bi-person me-1"></i>Nama</span>
                    <span class="info-value">{{ $visit->guest->nama_tamu }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label"><i class="bi bi-building me-1"></i>Perusahaan</span>
                    <span class="info-value">{{ $visit->guest->perusahaan }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label"><i class="bi bi-telephone me-1"></i>No. HP</span>
                    <span class="info-value">{{ $visit->guest->no_hp }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label"><i class="bi bi-clock me-1"></i>Waktu Masuk</span>
                    <span class="info-value">
                        {{ \Carbon\Carbon::parse($visit->waktu_masuk)->format('d M Y - H:i') }} WIB
                    </span>
                </div>

                <div class="info-row">
                    <span class="info-label"><i class="bi bi-card-text me-1"></i>Catatan</span>
                    <span class="info-value" style="max-width: 60%; word-break: break-word;">
                        {{ $visit->catatan }}
                    </span>
                </div>

                <div class="info-row">
                    <span class="info-label"><i class="bi bi-circle-fill me-1" style="font-size:0.6rem;color:#059669;"></i>Status</span>
                    <span class="info-value">
                        <span class="badge-masuk">Di Dalam Area</span>
                    </span>
                </div>

            </div>

            {{-- Tombol daftar lagi --}}
            <div class="d-grid">
                <a href="{{ route('tamu.form') }}" class="btn btn-daftar-lagi text-center">
                    <i class="bi bi-arrow-left-circle me-2"></i>Daftarkan Tamu Lain
                </a>
            </div>

        </div>
    </div>

    <p class="text-muted small mt-4 text-center">
        <i class="bi bi-shield-check me-1"></i>Data terlindungi &amp; hanya digunakan untuk keperluan internal.
    </p>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
