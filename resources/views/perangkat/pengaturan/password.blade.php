@extends('layouts.app')

@section('title', 'Edit Profil')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/perangkat.css') }}">
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
                <div class="mb-2">
                    <label class="form-label fw-semibold">
                        Password Saat Ini
                    </label>

                    <div class="password-field">
                        <input type="password" class="form-control" id="password_lama" name="password_lama"
                            placeholder="Masukkan password saat ini">

                        <button class="btn-toggle-eye" type="button" onclick="togglePassword('password_lama',this)">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>

                    @error('password_lama')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                                {{-- Password Baru --}}
                <div class="mb-2">
                    <label class="form-label fw-semibold">
                        Password Baru
                    </label>

                    <div class="password-field">
                        <input type="password" class="form-control" id="password_baru" name="password_baru"
                            placeholder="Masukkan password baru">

                        <button class="btn-toggle-eye" type="button" onclick="togglePassword('password_baru',this)">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>

                    @error('password_baru')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Konfirmasi --}}
                <div class="mb-2">
                    <label class="form-label fw-semibold">
                        Konfirmasi Password Baru
                    </label>

                    <div class="password-field">
                        <input type="password" class="form-control" id="password_baru_confirmation"
                            name="password_baru_confirmation" placeholder="Masukkan kembali password baru">

                        <button class="btn-toggle-eye" type="button"
                            onclick="togglePassword('password_baru_confirmation',this)">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>

                    {{-- Checklist syarat password --}}
                    <div class="password-req-box mt-2">
                        <div class="password-req-title">Persyaratan Password:</div>
                        <ul class="password-req-list">
                            <li class="password-req-item" data-rule="length">
                                <i class="bi bi-circle password-req-icon"></i>
                                Minimal 8 karakter
                            </li>
                            <li class="password-req-item" data-rule="case">
                                <i class="bi bi-circle password-req-icon"></i>
                                Mengandung huruf besar & kecil
                            </li>
                            <li class="password-req-item" data-rule="symbol">
                                <i class="bi bi-circle password-req-icon"></i>
                                Mengandung angka atau simbol
                            </li>
                        </ul>
                    </div>
                </div>

                <button type="submit" class="btn-lanjut ms-auto d-block">
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

        (function () {
            const passwordInput = document.getElementById('password_baru');
            if (!passwordInput) return;

            const rules = {
                length: (v) => v.length >= 8,
                case: (v) => /[a-z]/.test(v) && /[A-Z]/.test(v),
                symbol: (v) => /[0-9]/.test(v) || /[^A-Za-z0-9]/.test(v),
            };

            function updateChecklist() {
                const value = passwordInput.value;
                Object.keys(rules).forEach((rule) => {
                    const item = document.querySelector('.password-req-item[data-rule="' + rule + '"]');
                    const icon = item.querySelector('.password-req-icon');
                    const passed = rules[rule](value);

                    item.classList.toggle('password-req-done', passed);
                    icon.classList.toggle('bi-circle', !passed);
                    icon.classList.toggle('bi-check-circle-fill', passed);
                });
            }

            passwordInput.addEventListener('input', updateChecklist);
            updateChecklist();
        })();
    </script>
@endpush