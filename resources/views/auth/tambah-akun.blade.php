@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7 col-lg-6">

        <div class="d-flex align-items-center mb-4 gap-2">
            <a href="{{ route('kunjungan.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h5 class="mb-0 fw-bold">Tambah Akun Admin</h5>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-suzuki py-3">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-person-plus-fill me-2"></i>Form Akun Admin Baru
                </h6>
            </div>
            <div class="card-body p-4 border">

                <form action="{{ route('admin.tambah-akun.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-bold small">Nama Lengkap</label>
                        <input
                            type="text"
                            name="nama_lengkap"
                            class="form-control @error('nama_lengkap') is-invalid @enderror"
                            value="{{ old('nama_lengkap') }}"
                            placeholder="Nama lengkap admin"
                            autofocus
                        >
                        @error('nama_lengkap')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small">Username</label>
                        <input
                            type="text"
                            name="username"
                            class="form-control @error('username') is-invalid @enderror"
                            value="{{ old('username') }}"
                            placeholder="Username unik"
                        >
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small">Email</label>
                        <input
                            type="email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}"
                            placeholder="email@suzuki.com"
                        >
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small">Password</label>
                            <input
                                type="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Minimal 6 karakter"
                            >
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small">Konfirmasi Password</label>
                            <input
                                type="password"
                                name="password_confirmation"
                                class="form-control"
                                placeholder="Ulangi password"
                            >
                        </div>
                    </div>

                    <div class="d-grid mt-2">
                        <button type="submit" class="btn btn-suzuki py-2 fw-bold">
                            <i class="bi bi-person-check-fill me-2"></i>Simpan Akun Admin
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>
@endsection
