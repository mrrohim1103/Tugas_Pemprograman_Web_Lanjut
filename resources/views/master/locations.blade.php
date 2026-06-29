@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
<div class="col-lg-9">

<div class="d-flex align-items-center justify-content-between mb-4">
    <h5 class="mb-0 fw-bold"><i class="bi bi-geo-alt-fill me-2 text-suzuki"></i>Master Lokasi</h5>
    <a href="{{ route('kunjungan.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Dashboard</a>
</div>

{{-- Form Tambah --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-suzuki py-3"><h6 class="mb-0 fw-bold">Tambah Lokasi Baru</h6></div>
    <div class="card-body border p-4">
        <form action="{{ route('master.locations.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold small">Nama Lokasi <span class="text-danger">*</span></label>
                    <input type="text" name="nama_lokasi" class="form-control @error('nama_lokasi') is-invalid @enderror" value="{{ old('nama_lokasi') }}" placeholder="Contoh: Gedung A">
                    @error('nama_lokasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold small">Alamat</label>
                    <input type="text" name="alamat" class="form-control" value="{{ old('alamat') }}" placeholder="Alamat lengkap">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-suzuki w-100 fw-bold">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Tabel Data --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-suzuki py-3"><h6 class="mb-0 fw-bold">Daftar Lokasi ({{ $data->count() }})</h6></div>
    <div class="card-body p-0 border">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-suzuki">
                <tr><th class="ps-4">Nama Lokasi</th><th>Alamat</th><th>Dibuat</th><th class="text-center">Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                <tr>
                    <td class="ps-4 fw-bold">{{ $item->nama_lokasi }}</td>
                    <td class="text-muted">{{ $item->alamat ?? '-' }}</td>
                    <td class="text-muted small">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</td>
                    <td class="text-center">
                        <form action="{{ route('master.locations.destroy', $item->id_location) }}" method="POST" onsubmit="return confirm('Hapus lokasi ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash3"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center py-4 text-muted">Belum ada data lokasi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</div></div>
@endsection
