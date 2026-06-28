@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-9 col-lg-8">

        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('kunjungan.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <h5 class="mb-0 fw-bold">Kelola Akun Admin</h5>
            </div>
            <a href="{{ route('admin.tambah-akun') }}" class="btn btn-suzuki btn-sm fw-bold">
                <i class="bi bi-person-plus-fill me-1"></i>Tambah Akun
            </a>
        </div>

        @if($errors->has('hapus'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $errors->first('hapus') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-suzuki py-3">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-people-fill me-2"></i>Daftar Akun Admin ({{ $admins->count() }})
                </h6>
            </div>
            <div class="card-body p-0 border">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-suzuki">
                            <tr>
                                <th class="ps-4">Nama Lengkap</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Dibuat</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($admins as $admin)
                            <tr>
                                <td class="ps-4 fw-bold">
                                    {{ $admin->nama_lengkap }}
                                    @if($admin->id_user === Auth::user()->id_user)
                                        <span class="badge ms-1" style="background-color:#003399;font-size:0.7rem;">Anda</span>
                                    @endif
                                </td>
                                <td class="text-muted">{{ $admin->username }}</td>
                                <td>{{ $admin->email }}</td>
                                <td class="text-muted small">
                                    {{ $admin->created_at ? \Carbon\Carbon::parse($admin->created_at)->format('d M Y') : '-' }}
                                </td>
                                <td class="text-center">
                                    @if($admin->id_user !== Auth::user()->id_user)
                                        <button
                                            type="button"
                                            class="btn btn-outline-danger btn-sm"
                                            onclick="konfirmasiHapus('{{ $admin->id_user }}', '{{ $admin->nama_lengkap }}')"
                                        >
                                            <i class="bi bi-trash3"></i> Hapus
                                        </button>
                                    @else
                                        <span class="text-muted small">—</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- Modal konfirmasi hapus --}}
<div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold text-danger">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Konfirmasi Hapus Akun
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="mb-1">Anda akan menghapus akun:</p>
                <p class="fw-bold fs-6" id="namaAkunHapus"></p>
                <p class="text-muted small mb-0">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                <form id="formHapus" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm fw-bold">
                        <i class="bi bi-trash3 me-1"></i>Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function konfirmasiHapus(id, nama) {
        document.getElementById('namaAkunHapus').textContent = nama;
        document.getElementById('formHapus').action = '/admin/kelola-akun/' + id;
        new bootstrap.Modal(document.getElementById('modalHapus')).show();
    }
</script>
@endsection
