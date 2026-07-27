@extends('layouts.app')

@section('title', 'Pengaturan - Pengaturan Sistem')

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
            <a href="{{ route('admin.pengaturan.password') }}" class="peng-tab">
                <i class="bi bi-shield-lock"></i> Keamanan Akun
            </a>
            <a href="{{ route('admin.pengaturan.sistem') }}" class="peng-tab active">
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

            <form action="{{ route('admin.pengaturan.sistem.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- ===== Bagian atas: judul + subjudul + tombol simpan ===== --}}
                <div class="peng-config-top">
                    <div class="peng-config-heading">
                        <div class="peng-config-icon">
                            <i class="bi bi-sliders"></i>
                        </div>
                        <div>
                            <div class="peng-config-title">Konfigurasi Sistem</div>
                            <div class="peng-config-subtitle">Kelola identitas dan parameter operasional platform PRESISI</div>
                        </div>
                    </div>

                    <button type="submit" class="peng-btn-save">
                        <i class="bi bi-save2"></i> Simpan Konfigurasi
                    </button>
                </div>

                {{-- ===== Bagian bawah: form (kiri) + logo & identitas (kanan) ===== --}}
                <div class="peng-card-body">
                    <div class="peng-config-grid">

                        {{-- Kolom kiri: field form --}}
                        <div class="peng-config-form-col">

                            <div class="peng-field">
                                <label for="nama_sistem">Nama Sistem</label>
                                <input type="text" name="nama_sistem" id="nama_sistem"
                                    class="peng-input @error('nama_sistem') is-invalid @enderror"
                                    value="{{ old('nama_sistem', $namaSistem ?? 'PRESISI') }}">
                                @error('nama_sistem')
                                    <div class="peng-field-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="peng-field">
                                <label for="tahun_anggaran_aktif">Tahun Anggaran Aktif</label>
                                <select name="tahun_anggaran_aktif" id="tahun_anggaran_aktif" class="peng-input peng-select">
                                    @php
                                        $tahunAktif = old('tahun_anggaran_aktif', $tahunAnggaranAktif ?? date('Y'));
                                        $daftarTahun = $daftarTahunAnggaran ?? range(date('Y') + 1, date('Y') - 4);
                                    @endphp
                                    @foreach($daftarTahun as $th)
                                        <option value="{{ $th }}" {{ (string) $tahunAktif === (string) $th ? 'selected' : '' }}>{{ $th }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="peng-field">
                                <label for="teks_footer">Teks Footer Website</label>
                                <textarea name="teks_footer" id="teks_footer" rows="3"
                                    class="peng-input peng-textarea @error('teks_footer') is-invalid @enderror">{{ old('teks_footer', $teksFooter ?? '© 2024 Bapenda Provinsi Lampung - PRESISI v1.0') }}</textarea>
                                @error('teks_footer')
                                    <div class="peng-field-error">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        {{-- Kolom kanan: logo & identitas --}}
                        <div class="peng-config-side-col">

                            <div class="peng-logo-box">
                                <div class="peng-logo-box-title">Logo &amp; Identitas</div>

                                <div class="peng-logo-item">
                                    <div class="peng-logo-item-label">Logo Sistem (PRESISI)</div>
                                    <div class="peng-logo-row">
                                        <div class="peng-logo-preview">
                                            @if(!empty($logoSistem))
                                                <img src="{{ asset('storage/'.$logoSistem) }}" alt="Logo Sistem">
                                            @else
                                                <i class="bi bi-shield-shaded"></i>
                                            @endif
                                        </div>
                                        <label for="logo_sistem" class="peng-btn-outline">Unggah Logo</label>
                                        <input type="file" name="logo_sistem" id="logo_sistem" accept="image/*" class="peng-photo-input">
                                    </div>
                                </div>

                                <div class="peng-logo-item">
                                    <div class="peng-logo-item-label">Logo Resmi Bapenda</div>
                                    <div class="peng-logo-row">
                                        <div class="peng-logo-preview">
                                            @if(!empty($logoBapenda))
                                                <img src="{{ asset('storage/'.$logoBapenda) }}" alt="Logo Bapenda">
                                            @else
                                                <i class="bi bi-bank2"></i>
                                            @endif
                                        </div>
                                        <label for="logo_bapenda" class="peng-btn-outline">Ganti Logo</label>
                                        <input type="file" name="logo_bapenda" id="logo_bapenda" accept="image/*" class="peng-photo-input">
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>

            </form>

        </div>

    </div>
</div>

@endsection