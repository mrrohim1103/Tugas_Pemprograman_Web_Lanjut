@extends('layouts.app')

@section('content')

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
</style>

<div class="card shadow-sm mb-4 border-0">
    <div class="card-header bg-suzuki py-3">
        <h6 class="m-0 fw-bold">Filter Periode Kunjungan</h6>
    </div>
    <div class="card-body bg-light border">
        <form method="GET" action="{{ route('kunjungan.index') }}">
            <div class="row align-items-end">
                <div class="col-md-4 mb-3 mb-md-0">
                    <label class="form-label small fw-bold">Dari Tanggal</label>
                    <input type="date" name="tgl_awal" class="form-control border-secondary" value="{{ $tgl_awal ?? '' }}" required>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <label class="form-label small fw-bold">Sampai Tanggal</label>
                    <input type="date" name="tgl_akhir" class="form-control border-secondary" value="{{ $tgl_akhir ?? '' }}" required>
                </div>
                <div class="col-md-4">
                    <div class="row g-2">
                        <div class="col-6">
                            <button type="submit" class="btn btn-suzuki w-100 fw-bold">Tampilkan</button>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('kunjungan.index') }}" class="btn btn-outline-suzuki w-100 fw-bold">Reset</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm mb-4 border-0">
    <div class="card-header bg-white border-bottom py-3">
        <h6 class="m-0 fw-bold text-suzuki">Grafik Jumlah Kunjungan Harian</h6>
    </div>
    <div class="card-body border">
        @if(isset($label_tgl) && count($label_tgl) > 0)
            <div style="height: 300px; position: relative;">
                <canvas id="visitorChart"></canvas>
            </div>
        @else
            <div class="text-center py-4 text-muted">
                Tidak ada data statistik untuk rentang tanggal ini.
            </div>
        @endif
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-suzuki py-3">
        <h5 class="mb-0 fw-bold">Daftar Kunjungan Rekaman</h5>
    </div>
    <div class="card-body border">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light text-suzuki">
                    <tr>
                        <th>Waktu Masuk</th>
                        <th>Nama Tamu</th>
                        <th>Perusahaan</th>
                        <th>Keperluan & Tujuan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($visits as $v)
                    <tr>
                        <td class="text-nowrap">{{ \Carbon\Carbon::parse($v->waktu_masuk)->format('d M Y - H:i') }} WIB</td>
                        <td class="fw-bold">{{ $v->guest->nama_tamu ?? '-' }}</td>
                        <td><span class="badge bg-light text-dark border border-secondary">{{ $v->guest->perusahaan ?? '-' }}</span></td>
                        <td>
                            <span class="fw-semibold">{{ $v->purpose->nama_keperluan ?? $v->catatan }}</span><br>
                            <small class="text-muted">{{ $v->department->nama_divisi ?? '-' }}</small>
                        </td>
                        <td>
                            @if($v->status == 'Masuk')
                                <span class="badge bg-suzuki rounded-pill px-3">Di Dalam Area</span>
                            @else
                                <span class="badge bg-secondary rounded-pill px-3">Selesai / Keluar</span><br>
                                <small class="text-muted">Out: {{ \Carbon\Carbon::parse($v->waktu_keluar)->format('H:i') }} WIB</small>
                            @endif
                        </td>
                        <td>
                            @if($v->status == 'Masuk')
                                <form action="{{ route('kunjungan.mengakhiri', $v->id_visit) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-suzuki btn-sm fw-bold" onclick="return confirm('Apakah tamu ini sudah meninggalkan area perusahaan?')">Checkout</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Tidak ada rekaman data kunjungan pada periode ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const labelsData = {!! json_encode($label_tgl ?? []) !!};
        const visitorData = {!! json_encode($data_visitor ?? []) !!};

        if(labelsData.length > 0) {
            const ctx = document.getElementById('visitorChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labelsData,
                    datasets: [{
                        label: 'Jumlah Kunjungan Tamu ',
                        data: visitorData,
                        backgroundColor: 'rgba(0, 51, 153, 0.8)',
                        borderColor: 'rgba(0, 51, 153, 1)',
                        borderWidth: 1,
                        borderRadius: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 }
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        }
    });
</script>
@endsection
