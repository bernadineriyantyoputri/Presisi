@extends('layouts.app')

@section('title', 'Pengaturan')

@section('content')

<div class="container-fluid py-4">

    {{-- Breadcrumb --}}
    <div class="mb-2">
        <small class="text-muted">
            Beranda >
            Pengaturan >
            <span class="text-primary fw-semibold">Ganti Password</span>
        </small>
    </div>

    <h2 class="fw-bold text-primary mb-4">
        Pengaturan
    </h2>

    {{-- Menu --}}
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('perangkat.pengaturan.profil') }}">
                <i class="bi bi-person me-1"></i>
                Profil Akun
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link active" href="{{ route('perangkat.pengaturan.password') }}">
                <i class="bi bi-lock me-1"></i>
                Ganti Password
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="bi bi-bell me-1"></i>
                Notifikasi
            </a>
        </li>
    </ul>

    <div class="card shadow-sm border-0 rounded-4">

        <div class="card-body p-5">

            <h4 class="fw-bold mb-2">
                Ganti Password
            </h4>

            <p class="text-muted mb-4">
                Ubah password secara berkala untuk menjaga keamanan akun Anda agar tetap
                terlindungi dari akses yang tidak sah.
            </p>

            <form action="{{ route('perangkat.pengaturan.password.update') }}" method="POST">

                @csrf
                @method('PUT')

                {{-- Password Lama --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        Password Saat Ini
                    </label>

                    <div class="input-group">

                        <input
                            type="password"
                            class="form-control"
                            id="password_lama"
                            name="password_lama"
                            placeholder="Masukkan password saat ini">

                        <button class="btn btn-outline-secondary"
                                type="button"
                                onclick="togglePassword('password_lama',this)">

                            <i class="bi bi-eye"></i>

                        </button>

                    </div>

                    @error('password_lama')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                </div>

                {{-- Password Baru --}}
                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Password Baru
                    </label>

                    <div class="input-group">

                        <input
                            type="password"
                            class="form-control"
                            id="password_baru"
                            name="password_baru"
                            placeholder="Masukkan password baru">

                        <button class="btn btn-outline-secondary"
                                type="button"
                                onclick="togglePassword('password_baru',this)">

                            <i class="bi bi-eye"></i>

                        </button>

                    </div>

                    @error('password_baru')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                </div>

                {{-- Konfirmasi --}}
                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Konfirmasi Password Baru
                    </label>

                    <div class="input-group">

                        <input
                            type="password"
                            class="form-control"
                            id="password_baru_confirmation"
                            name="password_baru_confirmation"
                            placeholder="Masukkan kembali password baru">

                        <button class="btn btn-outline-secondary"
                                type="button"
                                onclick="togglePassword('password_baru_confirmation',this)">

                            <i class="bi bi-eye"></i>

                        </button>

                    </div>

                </div>

                {{-- Ketentuan --}}
                <div class="alert border-0 rounded-4 mb-4"
                     style="background:#eef4ff;">

                    <div class="d-flex">

                        <i class="bi bi-info-circle-fill fs-4 text-primary me-3"></i>

                        <div>

                            <h6 class="fw-bold mb-2">
                                Ketentuan Password
                            </h6>

                            <ul class="mb-0 text-muted">

                                <li>Minimal 8 karakter</li>
                                <li>Mengandung huruf besar, huruf kecil, angka dan simbol.</li>
                                <li>Tidak boleh sama dengan password sebelumnya.</li>

                            </ul>

                        </div>

                    </div>

                </div>

                <button class="btn btn-primary px-4 py-2">

                    <i class="bi bi-lock-fill me-2"></i>

                    Simpan Password

                </button>

            </form>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>

function togglePassword(id,btn){

    let input=document.getElementById(id);
    let icon=btn.querySelector('i');

    if(input.type==="password"){

        input.type="text";
        icon.classList.replace("bi-eye","bi-eye-slash");

    }else{

        input.type="password";
        icon.classList.replace("bi-eye-slash","bi-eye");

    }

}

</script>

@endpush