@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
<div class="col-lg-8">

<div class="d-flex align-items-center justify-content-between mb-4">
    <h5 class="mb-0 fw-bold"><i class="bi bi-tags-fill me-2 text-suzuki"></i>Kategori Tamu</h5>
    <a href="{{ route('kunjungan.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Dashboard</a>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-suzuki py-3"><h6 class="mb-0 fw-bold">Tambah Kategori Tamu</h6></div>
    <div class="card-body border p-4">
        <form action="{{ route('master.guest-categories.store') }}" method="POST">
            @csrf
            <div class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="form-label fw-bold small">Nama Kategori <span class="text-danger">*</span></label>
                    <input type="text" name="nama_kategori" class="form-control @error('nama_kategori') is-invalid @enderror" value="{{ old('nama_kategori') }}" placeholder="Contoh: Vendor, Tamu VIP">
                    @error('nama_kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <div class="form-check mt-4">
                        <input class="form-check-input" type="checkbox" name="butuh_pendampingan" id="pendampingan" value="1" {{ old('butuh_pendampingan') ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold small" for="pendampingan">Butuh Pendampingan</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-suzuki w-100 fw-bold">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-suzuki py-3"><h6 class="mb-0 fw-bold">Daftar Kategori ({{ $data->count() }})</h6></div>
    <div class="card-body p-0 border">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-suzuki">
                <tr><th class="ps-4">Nama Kategori</th><th class="text-center">Butuh Pendampingan</th><th class="text-center">Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                <tr>
                    <td class="ps-4 fw-bold">{{ $item->nama_kategori }}</td>
                    <td class="text-center">
                        @if($item->butuh_pendampingan)
                            <span class="badge" style="background-color:#003399;">Ya</span>
                        @else
                            <span class="badge bg-secondary">Tidak</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <form action="{{ route('master.guest-categories.destroy', $item->id_category) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash3"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center py-4 text-muted">Belum ada data kategori.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</div></div>
@endsection
