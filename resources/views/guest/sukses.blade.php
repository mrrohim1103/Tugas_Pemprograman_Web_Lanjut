<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check-In Berhasil - PT Suzuki Indomobil Motor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root { --suzuki-blue: #003399; --suzuki-dark: #002266; }
        body { background: linear-gradient(135deg, #e8eeff 0%, #f5f7ff 100%); min-height: 100vh; font-family: 'Segoe UI', sans-serif; padding: 2rem 1rem; }
        .card-sukses { border: none; border-radius: 20px; box-shadow: 0 8px 40px rgba(0,51,153,0.13); max-width: 520px; width: 100%; margin: 0 auto; }
        .icon-circle { width: 80px; height: 80px; border-radius: 50%; background-color: #d1fae5; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; }
        .info-row { display: flex; justify-content: space-between; align-items: flex-start; padding: 0.55rem 0; border-bottom: 1px solid #f3f4f6; font-size: 0.88rem; }
        .info-row:last-child { border-bottom: none; }
        .info-label { color: #6b7280; font-weight: 500; flex-shrink: 0; margin-right: 1rem; }
        .info-value { font-weight: 600; color: #111827; text-align: right; word-break: break-word; max-width: 60%; }
        .badge-masuk { background-color: #003399; color: #fff; padding: 0.3em 0.8em; border-radius: 20px; font-size: 0.8rem; }
        .btn-daftar-lagi { background-color: var(--suzuki-blue); color: #fff; border: none; border-radius: 8px; font-weight: 700; padding: 0.65rem 1.5rem; }
        .btn-daftar-lagi:hover { background-color: var(--suzuki-dark); color: #fff; }
        /* Star rating */
        .star-rating { display: flex; flex-direction: row-reverse; justify-content: center; gap: 4px; }
        .star-rating input { display: none; }
        .star-rating label { font-size: 2rem; color: #d1d5db; cursor: pointer; transition: color 0.15s; }
        .star-rating input:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label { color: #f59e0b; }
    </style>
</head>
<body>

    <div class="text-center mb-3" style="font-size:0.8rem;color:#6b7280;">
        <i class="bi bi-journal-bookmark-fill me-1" style="color:#003399;"></i>
        <strong style="color:#003399;">Buku Tamu Digital</strong> &mdash; PT Suzuki Indomobil Motor
    </div>

    <div class="card-sukses">
        <div class="card-body p-4 p-md-5">

            <div class="icon-circle">
                <i class="bi bi-check-circle-fill fs-1 text-success"></i>
            </div>
            <h4 class="fw-bold text-center mb-1">Check-In Berhasil!</h4>
            <p class="text-muted text-center small mb-4">Kunjungan Anda telah tercatat. Silakan menunggu di area resepsionis.</p>

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
                    <span class="info-label"><i class="bi bi-diagram-3 me-1"></i>Tujuan</span>
                    <span class="info-value">{{ $visit->department->nama_divisi ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label"><i class="bi bi-clipboard2-check me-1"></i>Keperluan</span>
                    <span class="info-value">{{ $visit->purpose->nama_keperluan ?? '-' }}</span>
                </div>
                @if($visit->room)
                <div class="info-row">
                    <span class="info-label"><i class="bi bi-door-open me-1"></i>Ruangan</span>
                    <span class="info-value">{{ $visit->room->nama_ruangan }}</span>
                </div>
                @endif
                @if($visit->vehicles->count())
                <div class="info-row">
                    <span class="info-label"><i class="bi bi-car-front me-1"></i>Kendaraan</span>
                    <span class="info-value">{{ $visit->vehicles->first()->plat_nomor }} ({{ $visit->vehicles->first()->jenis_kendaraan ?? '-' }})</span>
                </div>
                @endif
                <div class="info-row">
                    <span class="info-label"><i class="bi bi-clock me-1"></i>Waktu Masuk</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($visit->waktu_masuk)->format('d M Y - H:i') }} WIB</span>
                </div>
                <div class="info-row">
                    <span class="info-label"><i class="bi bi-circle-fill me-1" style="font-size:0.55rem;color:#059669;"></i>Status</span>
                    <span class="info-value"><span class="badge-masuk">Di Dalam Area</span></span>
                </div>
            </div>

            {{-- Form Feedback --}}
            @if(!$visit->feedback)
            <div class="border rounded-3 p-3 mb-4" style="background:#fffbeb;">
                <p class="fw-bold small text-center mb-2" style="color:#92400e;">
                    <i class="bi bi-star-fill me-1 text-warning"></i>Bagaimana pengalaman check-in Anda?
                </p>
                @if(session('success'))
                    <div class="alert alert-success py-2 small text-center">{{ session('success') }}</div>
                @endif
                <form action="{{ route('tamu.feedback', $visit->id_visit) }}" method="POST">
                    @csrf
                    <div class="star-rating mb-3">
                        @for($i = 5; $i >= 1; $i--)
                            <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" {{ old('rating') == $i ? 'checked' : '' }}>
                            <label for="star{{ $i }}"><i class="bi bi-star-fill"></i></label>
                        @endfor
                    </div>
                    @error('rating')<div class="text-danger small text-center mb-2">{{ $message }}</div>@enderror
                    <textarea name="komentar" class="form-control form-control-sm mb-3" rows="2"
                        placeholder="Komentar tambahan (opsional)...">{{ old('komentar') }}</textarea>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-sm fw-bold" style="background:#f59e0b;color:#fff;border-radius:8px;">
                            <i class="bi bi-send-fill me-1"></i>Kirim Feedback
                        </button>
                    </div>
                </form>
            </div>
            @else
            <div class="alert alert-success py-2 small text-center mb-4">
                <i class="bi bi-check-circle me-1"></i>Feedback sudah dikirim. Terima kasih!
            </div>
            @endif

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
