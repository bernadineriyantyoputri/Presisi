@extends('layouts.app')

@section('title', 'Pengaturan - Profil Admin')

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
            <a href="{{ route('admin.pengaturan.profil') }}" class="peng-tab active">
                <i class="bi bi-person-circle"></i> Profil Admin
            </a>
            <a href="{{ route('admin.pengaturan.password') }}" class="peng-tab">
                <i class="bi bi-shield-lock"></i> Keamanan Akun
            </a>
            <a href="{{ route('admin.pengaturan.sistem') }}" class="peng-tab">
                <i class="bi bi-gear"></i> Pengaturan Sistem
            </a>
            <a href="{{ route('admin.pengaturan.tentang') }}" class="peng-tab">
                <i class="bi bi-info-circle"></i> Tentang Sistem
            </a>
            <a href="{{ route('admin.pengaturan.notifikasi') }}" class="peng-tab">
                <i class="bi bi-bell"></i> Pengaturan Notifikasi
            </a>
        </div>

        {{-- Card --}}
        <div class="peng-card">

            <form action="{{ route('admin.pengaturan.profil.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- ===== Bagian atas: foto + nama + badge + lokasi + tombol simpan ===== --}}
                <div class="peng-profile-top">
                    <div class="peng-profile-left">
                        <div class="peng-profile-photo-wrap">
                            @if($user->foto)
    <img
        id="fotoPreviewImg"
        src="{{ asset('storage/'.$user->foto) }}"
        alt="{{ $user->name }}"
        class="peng-avatar-photo"
        style="display:block;"
    >

    <div
        id="fotoPreviewFallback"
        class="peng-avatar-photo peng-avatar-fallback"
        style="display:none;"
    >
        {{ strtoupper(substr($user->name, 0, 1)) }}
    </div>
@else
    <img
        id="fotoPreviewImg"
        src=""
        alt="Preview"
        class="peng-avatar-photo"
        style="display:none;"
    >

    <div
        id="fotoPreviewFallback"
        class="peng-avatar-photo peng-avatar-fallback"
    >
        {{ strtoupper(substr($user->name, 0, 1)) }}
    </div>
@endif
                            <label for="foto" class="peng-photo-upload-btn" title="Ganti foto">
                                <i class="bi bi-camera-fill"></i>
                            </label>
                            <input type="file" name="foto" id="foto" accept="image/*" class="peng-photo-input">
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

                {{-- ===== Bagian bawah: form (kiri) + info keanggotaan & zona berbahaya (kanan) ===== --}}
                <div class="peng-card-body">
                    <div class="peng-profile-grid">

                        {{-- Kolom kiri: field form --}}
                        <div class="peng-profile-form-col">

                            <div class="peng-field">
                                <label for="name">Nama Lengkap</label>
                                <input type="text" name="name" id="name" class="peng-input @error('name') is-invalid @enderror"
                                    value="{{ old('name', $user->name) }}">
                                @error('name')
                                    <div class="peng-field-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="peng-field">
                                <label for="email">Email Dinas</label>
                                <input type="email" name="email" id="email" class="peng-input @error('email') is-invalid @enderror"
                                    value="{{ old('email', $user->email) }}">
                                @error('email')
                                    <div class="peng-field-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="peng-field">
                                <label for="no_telepon">Nomor Telepon</label>
                                <input type="text" name="no_telepon" id="no_telepon" class="peng-input @error('no_telepon') is-invalid @enderror"
                                    value="{{ old('no_telepon', $user->no_telepon) }}">
                                @error('no_telepon')
                                    <div class="peng-field-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="peng-field">
                                <label for="jabatan">Jabatan</label>
                                <select name="jabatan" id="jabatan" class="peng-input peng-select">
                                    @php
                                        $daftarJabatan = [
                                            'Kepala Badan',
                                            'Sekretaris',
                                            'Kepala Bidang Pengelolaan Data',
                                            'Kepala Bidang Pendapatan Asli Daerah',
                                            'Kepala Sub Bagian',
                                            'Staf Administrator',
                                        ];
                                        $jabatanAktif = old('jabatan', $user->jabatan);
                                    @endphp
                                    <option value="">Pilih Jabatan</option>
                                    @foreach($daftarJabatan as $j)
                                        <option value="{{ $j }}" {{ $jabatanAktif === $j ? 'selected' : '' }}>{{ $j }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        {{-- Kolom kanan: info keanggotaan + zona berbahaya --}}
                        <div class="peng-profile-side-col">

                            <div class="peng-info-box">
                                <div class="peng-info-box-title">
                                    <i class="bi bi-info-circle"></i> Informasi Keanggotaan
                                </div>
                                <div class="peng-info-row">
                                    <span>ID Pegawai</span>
                                    <strong>{{ $user->id_pegawai ?? '-' }}</strong>
                                </div>
                                <div class="peng-info-row">
                                    <span>Terdaftar Sejak</span>
                                    <strong>{{ optional($user->created_at)->translatedFormat('d F Y') ?? '-' }}</strong>
                                </div>
                                <div class="peng-info-row">
                                    <span>Terakhir Login</span>
                                    <strong>{{ optional($user->last_login_at ?? null)->translatedFormat('d F Y, H:i') ?? '-' }} WIB</strong>
                                </div>
                                <div class="peng-info-row">
                                    <span>Sesi Aktif</span>
                                    <strong class="peng-session-active">
                                        <span class="peng-dot"></span> Desktop
                                    </strong>
                                </div>
                            </div>

                            <div class="peng-danger-box">
                                <div class="peng-danger-title">Zona Berbahaya</div>
                                <p class="peng-danger-text">
                                    Aksi di bawah ini bersifat permanen dan memerlukan verifikasi otentikasi ganda.
                                </p>
                                <button type="button" class="peng-btn-danger"
                                    onclick="alert('Fitur ini belum tersedia.')">
                                    Nonaktifkan Akun Sementara
                                </button>
                            </div>

                        </div>

                    </div>
                </div>

            </form>

        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
    document.getElementById('foto').addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;

    if (!file.type.startsWith('image/')) {
        alert('File harus berupa gambar.');
        this.value = '';
        return;
    }

    if (file.size > 2 * 1024 * 1024) {
        alert('Ukuran gambar maksimal 2MB.');
        this.value = '';
        return;
    }

    const reader = new FileReader();

    reader.onload = function (e) {
        document.getElementById('fotoPreviewImg').src = e.target.result;
        document.getElementById('fotoPreviewImg').style.display = 'block';
        document.getElementById('fotoPreviewFallback').style.display = 'none';
    };

    reader.readAsDataURL(file);
});
</script>
@endpush