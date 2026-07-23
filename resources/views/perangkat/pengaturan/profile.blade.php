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
                <p class="text-muted small mb-0">Kelola informasi profil dan data perangkat daerah Anda.</p>
            </div>
        </div>

        {{-- Menu Tab --}}
        <ul class="nav nav-tabs-custom mb-4">
            <li class="nav-item">
                <a class="nav-link-custom active" href="#">
                    <i class="bi bi-person-fill me-1"></i> Profil Akun
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link-custom" href="{{ route('perangkat.pengaturan.password') }}">
                    <i class="bi bi-lock me-1"></i> Ganti Password
                </a>
            </li>

        </ul>

        <div class="row g-4">

            {{-- FORM --}}
            <div class="col-12">
                <div class="wizard-card">

                    <form action="{{ route('perangkat.pengaturan.profil.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- ===================== --}}
                        {{-- IDENTITAS PERANGKAT DAERAH --}}
                        {{-- ===================== --}}
                        <div class="section-title mb-3">
                            <i class="bi bi-building"></i>
                            Identitas Perangkat Daerah
                        </div>

                        <div class="row mt-3">
                            {{-- Nama Perangkat --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    Nama Perangkat Daerah
                                </label>
                                <div class="readonly-group">
                                    <input type="text" class="form-control" value="{{ $perangkat->nama_perangkat }}"
                                        readonly>
                                    <i class="bi bi-lock-fill lock-icon"></i>
                                </div>
                            </div>

                            {{-- Email Kantor --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    Email Instansi (Username)
                                </label>
                                <div class="readonly-group">
                                    <input type="email" class="form-control" value="{{ $perangkat->email }}" readonly>
                                    <i class="bi bi-lock-fill lock-icon"></i>
                                </div>
                            </div>
                        </div>

                        <div class="section-title mb-3">
                            <i class="bi bi-person-badge"></i>
                            Kepala Perangkat Daerah
                        </div>

                        <div class="row mt-3">
                            {{-- Kepala --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    Nama Lengkap (beserta Gelar)
                                </label>
                                <input type="text" name="kepala_perangkat" class="form-control"
                                    value="{{ old('kepala_perangkat', $perangkat->kepala_perangkat) }}">
                            </div>

                            {{-- Pangkat --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    Pangkat / Golongan
                                </label>

                                @php
                                    $daftarPangkat = [
                                        'Pembina Utama (IV/e)',
                                        'Pembina Utama Madya (IV/d)',
                                        'Pembina Utama Muda (IV/c)',
                                        'Pembina Tingkat I (IV/b)',
                                        'Pembina (IV/a)',
                                        'Penata Tingkat I (III/d)',
                                        'Penata (III/c)',
                                        'Penata Muda Tingkat I (III/b)',
                                        'Penata Muda (III/a)',
                                        'Pengatur Tingkat I (II/d)',
                                        'Pengatur (II/c)',
                                        'Pengatur Muda Tingkat I (II/b)',
                                        'Pengatur Muda (II/a)',
                                    ];
                                    $selectedPangkat = old('pangkat_golongan', $perangkat->pangkat_golongan);

                                    if ($selectedPangkat && !in_array($selectedPangkat, $daftarPangkat)) {
                                        array_unshift($daftarPangkat, $selectedPangkat);
                                    }
                                @endphp

                                <select name="pangkat_golongan" class="form-select">
                                    <option value="">-- Pilih Pangkat / Golongan --</option>
                                    @foreach($daftarPangkat as $pangkat)
                                        <option value="{{ $pangkat }}" {{ $selectedPangkat == $pangkat ? 'selected' : '' }}>
                                            {{ $pangkat }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- NIP --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    NIP
                                </label>
                                <input type="text" name="nip" class="form-control"
                                    value="{{ old('nip', $perangkat->nip) }}">
                            </div>
                        </div>

                        <div class="section-title mb-3">
                            <i class="bi bi-cash-coin"></i>
                            Bendahara Penerimaan
                        </div>

                        <div class="row mt-3">
                            {{-- Bendahara --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">
                                    Nama Bendahara
                                </label>
                                <input type="text" name="bendahara_penerimaan" class="form-control"
                                    value="{{ old('bendahara_penerimaan', $perangkat->bendahara_penerimaan) }}">
                            </div>

                            {{-- HP --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold">
                                    No. Handphone
                                </label>
                                <input type="text" name="no_hp" class="form-control"
                                    value="{{ old('no_hp', $perangkat->no_hp) }}">
                            </div>
                        </div>

                        <div class="wizard-footer d-flex justify-content-end">
                            <button type="submit" class="btn-lanjut">
                                <i class="bi bi-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection