@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
<div class="col-lg-10">

<div class="d-flex align-items-center justify-content-between mb-4">
    <h5 class="mb-0 fw-bold"><i class="bi bi-slash-circle-fill me-2 text-danger"></i>Daftar Hitam Tamu</h5>
    <a href="{{ route('kunjungan.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Dashboard</a>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-danger bg-opacity-90 py-3"><h6 class="mb-0 fw-bold text-white">Tambah ke Daftar Hitam</h6></div>
    <div class="card-body border p-4">
        <form action="{{ route('master.blacklist.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-bold small">Nama Tamu <span class="text-danger">*</span></label>
                    <input type="text" name="nama_tamu" class="form-control @error('nama_tamu') is-invalid @enderror" value="{{ old('nama_tamu') }}" placeholder="Nama tamu">
                    @error('nama_tamu')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold small">Perusahaan</label>
                    <input type="text" name="perusahaan" class="form-control" value="{{ old('perusahaan') }}" placeholder="Perusahaan">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold small">Alasan <span class="text-danger">*</span></label>
                    <input type="text" name="alasan" class="form-control @error('alasan') is-invalid @enderror" value="{{ old('alasan') }}" placeholder="Alasan diblokir">
                    @error('alasan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-danger w-100 fw-bold">Tambah</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-suzuki py-3"><h6 class="mb-0 fw-bold">Daftar Hitam ({{ $data->count() }})</h6></div>
    <div class="card-body p-0 border">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-suzuki">
                <tr><th class="ps-4">Nama Tamu</th><th>Perusahaan</th><th>Alasan</th><th>Dilaporkan Oleh</th><th>Tanggal</th><th class="text-center">Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                <tr>
                    <td class="ps-4 fw-bold text-danger">{{ $item->nama_tamu }}</td>
                    <td class="text-muted">{{ $item->perusahaan ?? '-' }}</td>
                    <td>{{ $item->alasan }}</td>
                    <td class="text-muted small">{{ $item->reportedBy->nama_lengkap ?? '-' }}</td>
                    <td class="text-muted small">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</td>
                    <td class="text-center">
                        <form action="{{ route('master.blacklist.destroy', $item->id_blacklist) }}" method="POST" onsubmit="return confirm('Hapus dari daftar hitam?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash3"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-4 text-muted">Tidak ada data daftar hitam.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</div></div>
@endsection
