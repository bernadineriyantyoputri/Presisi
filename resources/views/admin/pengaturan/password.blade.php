@extends('layouts.app')

@section('title', 'Pengaturan - Keamanan Akun')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
@endpush

@section('content')

    <div class="peng-page">
        <div class="peng-container">

            {{-- Header --}}
            <div class="peng-header">
                <h1 class="peng-title">Pengaturan</h1>
                <p class="peng-subtitle">Kelola profil, keamanan akun, serta konfigurasi sistem PRESISI.</p>
            </div>

            {{-- Alert --}}
            @if(session('success'))
                <div class="peng-alert peng-alert-success">
                    <i class="bi bi-check-circle-fill"></i>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Tabs --}}
            <div class="peng-tabs peng-tabs-pill">
                <a href="{{ route('admin.pengaturan.profil') }}" class="peng-tab">
                    <i class="bi bi-person-circle"></i> Profil Admin
                </a>
                <a href="{{ route('admin.pengaturan.password') }}" class="peng-tab active">
                    <i class="bi bi-shield-lock"></i> Keamanan Akun
                </a>
                <a href="{{ route('admin.pengaturan.tentang') }}" class="peng-tab">
                    <i class="bi bi-info-circle"></i> Tentang Sistem
                </a>
            </div>

            {{-- Card --}}
            <div class="peng-card">

                <form action="{{ route('admin.pengaturan.password.update') }}" method="POST" id="formUbahPassword">
                    @csrf
                    @method('PUT')

                    {{-- ===== Bagian atas: foto + nama + badge + lokasi + tombol simpan ===== --}}
                    <div class="peng-profile-top">
                        <div class="peng-profile-left">
                            <div class="peng-profile-photo-wrap">
                                @if($user->foto)
                                    <img src="{{ asset('storage/' . $user->foto) }}" alt="{{ $user->name }}"
                                        class="peng-avatar-photo">
                                @else
                                    <div class="peng-avatar-photo peng-avatar-fallback">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                                <span class="peng-photo-upload-btn" title="Ganti foto">
                                    <i class="bi bi-camera-fill"></i>
                                </span>
                            </div>

                            <div class="peng-profile-info">
                                <div class="peng-profile-name">{{ $user->name }}</div>
                                <span class="peng-profile-badge">{{ $user->unit_kerja ?? 'Pusat Data' }}</span>
                                <div class="peng-profile-location">
                                    <i class="bi bi-geo-alt-fill"></i>
                                    {{ $user->lokasi_kantor ?? 'Kantor Pusat Bapenda, Bandar Lampung' }}
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="peng-btn-save">
                            <i class="bi bi-check-circle"></i> Simpan Perubahan
                        </button>
                    </div>

                    {{-- ===== Bagian bawah: form ubah password ===== --}}
                    <div class="peng-card-body">
                        <div class="peng-password-section">

                            <h2 class="peng-section-title">Ubah Password</h2>

                            <div class="peng-field">
                                <label for="password_lama">Password Lama</label>
                                <div class="peng-password-wrap">
                                    <input type="password" name="password_lama" id="password_lama"
                                        class="peng-input @error('password_lama') is-invalid @enderror"
                                        autocomplete="current-password">
                                    <span class="peng-toggle-password" data-target="password_lama">
                                        <i class="bi bi-eye-slash"></i>
                                    </span>
                                </div>
                                @error('password_lama')
                                    <div class="peng-field-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="peng-field">
                                <label for="password_baru">Password Baru</label>
                                <div class="peng-password-wrap">
                                    <input type="password" name="password_baru" id="password_baru"
                                        class="peng-input @error('password_baru') is-invalid @enderror"
                                        autocomplete="new-password">
                                    <span class="peng-toggle-password" data-target="password_baru">
                                        <i class="bi bi-eye-slash"></i>
                                    </span>
                                </div>
                                @error('password_baru')
                                    <div class="peng-field-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="peng-field">
                                <label for="password_baru_confirmation">Konfirmasi Password Baru</label>
                                <div class="peng-password-wrap">
                                    <input type="password" name="password_baru_confirmation" id="password_baru_confirmation"
                                        class="peng-input @error('password_baru_confirmation') is-invalid @enderror"
                                        autocomplete="new-password">
                                    <span class="peng-toggle-password" data-target="password_baru_confirmation">
                                        <i class="bi bi-eye-slash"></i>
                                    </span>
                                </div>
                                @error('password_baru_confirmation')
                                    <div class="peng-field-error">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Syarat password --}}
                            <div class="peng-req-box">
                                <div class="peng-req-title">Persyaratan Password:</div>
                                <ul class="peng-req-list">
                                    <li class="peng-req-item" data-rule="length">
                                        <i class="bi bi-circle peng-req-icon"></i>
                                        Minimal 8 karakter
                                    </li>
                                    <li class="peng-req-item" data-rule="case">
                                        <i class="bi bi-circle peng-req-icon"></i>
                                        Mengandung huruf besar & kecil
                                    </li>
                                    <li class="peng-req-item" data-rule="symbol">
                                        <i class="bi bi-circle peng-req-icon"></i>
                                        Mengandung angka atau simbol
                                    </li>
                                </ul>
                            </div>

                            <button type="submit" class="peng-btn-save peng-btn-save-bottom">
                                <i class="bi bi-check-circle"></i> Simpan Perubahan
                            </button>

                        </div>
                    </div>

                </form>

            </div>

        </div>
    </div>

@endsection

@push('scripts')
    <script>
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
                    const item = document.querySelector('.peng-req-item[data-rule="' + rule + '"]');
                    const icon = item.querySelector('.peng-req-icon');
                    const passed = rules[rule](value);

                    item.classList.toggle('peng-req-done', passed);
                    icon.classList.toggle('bi-circle', !passed);
                    icon.classList.toggle('bi-check-circle-fill', passed);
                });
            }

            passwordInput.addEventListener('input', updateChecklist);
            updateChecklist();

            document.querySelectorAll('.peng-toggle-password').forEach(function (toggle) {
                toggle.addEventListener('click', function () {
                    const targetId = this.getAttribute('data-target');
                    const input = document.getElementById(targetId);
                    const icon = this.querySelector('i');

                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.remove('bi-eye-slash');
                        icon.classList.add('bi-eye');
                    } else {
                        input.type = 'password';
                        icon.classList.remove('bi-eye');
                        icon.classList.add('bi-eye-slash');
                    }
                });
            });
        })();
    </script>
@endpush