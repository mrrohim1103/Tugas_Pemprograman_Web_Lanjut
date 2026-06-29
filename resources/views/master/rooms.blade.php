@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
<div class="col-lg-9">

<div class="d-flex align-items-center justify-content-between mb-4">
    <h5 class="mb-0 fw-bold"><i class="bi bi-door-open-fill me-2 text-suzuki"></i>Master Ruangan</h5>
    <a href="{{ route('kunjungan.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Dashboard</a>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-suzuki py-3"><h6 class="mb-0 fw-bold">Tambah Ruangan Baru</h6></div>
    <div class="card-body border p-4">
        <form action="{{ route('master.rooms.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold small">Nama Ruangan <span class="text-danger">*</span></label>
                    <input type="text" name="nama_ruangan" class="form-control @error('nama_ruangan') is-invalid @enderror" value="{{ old('nama_ruangan') }}" placeholder="Contoh: Ruang Rapat 1">
                    @error('nama_ruangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold small">Lokasi</label>
                    <select name="id_location" class="form-select">
                        <option value="">-- Pilih Lokasi --</option>
                        @foreach($locations as $loc)
                            <option value="{{ $loc->id_location }}">{{ $loc->nama_lokasi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold small">Kapasitas (orang)</label>
                    <input type="number" name="kapasitas" class="form-control" value="{{ old('kapasitas') }}" placeholder="Contoh: 20" min="1">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-suzuki w-100 fw-bold">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-suzuki py-3"><h6 class="mb-0 fw-bold">Daftar Ruangan ({{ $data->count() }})</h6></div>
    <div class="card-body p-0 border">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-suzuki">
                <tr><th class="ps-4">Nama Ruangan</th><th>Lokasi</th><th>Kapasitas</th><th class="text-center">Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                <tr>
                    <td class="ps-4 fw-bold">{{ $item->nama_ruangan }}</td>
                    <td class="text-muted">{{ $item->location->nama_lokasi ?? '-' }}</td>
                    <td>{{ $item->kapasitas ? $item->kapasitas . ' orang' : '-' }}</td>
                    <td class="text-center">
                        <form action="{{ route('master.rooms.destroy', $item->id_room) }}" method="POST" onsubmit="return confirm('Hapus ruangan ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash3"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center py-4 text-muted">Belum ada data ruangan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</div></div>
@endsection
