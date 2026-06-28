@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-suzuki text-white text-center py-3">
                <h5 class="mb-0 fw-bold">Form Registrasi Tamu</h5>
            </div>
            <div class="card-body p-4 border">
                <form action="{{ route('kunjungan.store') }}" method="POST">
                    @csrf

                    <h6 class="text-muted border-bottom pb-2 mb-3 small fw-bold">Informasi Pribadi</h6>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Nama Lengkap</label>
                        <input type="text" name="nama_tamu" class="form-control @error('nama_tamu') is-invalid @enderror" value="{{ old('nama_tamu') }}" required>
                        @error('nama_tamu') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small">Perusahaan / Instansi</label>
                            <input type="text" name="perusahaan" class="form-control @error('perusahaan') is-invalid @enderror" value="{{ old('perusahaan') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small">Nomor Handphone</label>
                            <input type="number" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp') }}" required>
                        </div>
                    </div>

                    <h6 class="text-muted border-bottom pb-2 mb-3 mt-4 small fw-bold">Informasi Kunjungan</h6>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Divisi / Departemen Tujuan</label>
                        <input type="text" name="divisi_tujuan" class="form-control" value="{{ old('divisi_tujuan') }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small">Keperluan</label>
                        <textarea name="keperluan" class="form-control" rows="3" required>{{ old('keperluan') }}</textarea>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-suzuki py-2 fw-bold">Proses Check-In</button>
                        <a href="{{ route('kunjungan.index') }}" class="btn btn-light border py-2">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
