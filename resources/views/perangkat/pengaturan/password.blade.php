@extends('layouts.app')

@section('title', 'Edit Profil')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/perangkat.css') }}">
    <style>
        .password-field {
            position: relative;
        }
        .password-field .form-control {
            padding-right: 44px;
        }
        .password-field .btn-toggle-eye {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            width: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: transparent;
            border: none;
            color: #6c757d;
            padding: 0;
        }
        .password-field .btn-toggle-eye:hover {
            color: #343a40;
        }
        .password-field .btn-toggle-eye:focus {
            outline: none;
            box-shadow: none;
        }
    </style>
@endpush

@section('content')

<div class="laporan-wizard-page pengaturan-page">

    <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
        <div>
            <h4 class="fw-bold mb-1">Edit Profil Akun</h4>
            <p class="text-muted small mb-0">Perbarui password akun Anda secara berkala untuk menjaga keamanan.</p>
        </div>
    </div>

    {{-- Menu Tab --}}
    <ul class="nav-tabs-custom mb-4">
        <li class="nav-item">
            <a class="nav-link-custom" href="{{ route('perangkat.pengaturan.profil') }}">
                <i class="bi bi-person me-1"></i> Profil Akun
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link-custom active" href="{{ route('perangkat.pengaturan.password') }}">
                <i class="bi bi-lock me-1"></i> Ganti Password
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link-custom" href="#">
                <i class="bi bi-bell me-1"></i> Notifikasi
            </a>
        </li>
    </ul>

    <div class="wizard-card">

        <div class="section-title mb-2">
            <i class="bi bi-shield-lock"></i>
            Ganti Password
        </div>

        <p class="text-muted small mb-4">
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

                <div class="password-field">
                    <input
                        type="password"
                        class="form-control"
                        id="password_lama"
                        name="password_lama"
                        placeholder="Masukkan password saat ini">

                    <button class="btn-toggle-eye"
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

                <div class="password-field">
                    <input
                        type="password"
                        class="form-control"
                        id="password_baru"
                        name="password_baru"
                        placeholder="Masukkan password baru">

                    <button class="btn-toggle-eye"
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

                <div class="password-field">
                    <input
                        type="password"
                        class="form-control"
                        id="password_baru_confirmation"
                        name="password_baru_confirmation"
                        placeholder="Masukkan kembali password baru">

                    <button class="btn-toggle-eye"
                            type="button"
                            onclick="togglePassword('password_baru_confirmation',this)">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            {{-- Ketentuan --}}
            <div class="ketentuan-box mb-4">
                <div class="d-flex">
                    <div>
                        <h6 class="fw-bold mb-2">Ketentuan Password</h6>
                        <ul class="mb-0 text-muted">
                            <li>Minimal 8 karakter</li>
                            <li>Mengandung huruf besar, huruf kecil, angka dan simbol.</li>
                            <li>Tidak boleh sama dengan password sebelumnya.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-lanjut">
                <i class="bi bi-lock-fill me-2"></i>
                Simpan Password
            </button>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function togglePassword(id, btn) {
    let input = document.getElementById(id);
    let icon = btn.querySelector('i');

    if (input.type === "password") {
        input.type = "text";
        icon.classList.replace("bi-eye", "bi-eye-slash");
    } else {
        input.type = "password";
        icon.classList.replace("bi-eye-slash", "bi-eye");
    }
}
</script>
@endpush