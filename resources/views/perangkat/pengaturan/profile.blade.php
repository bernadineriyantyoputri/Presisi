@extends('layouts.app')

@section('title', 'Pengaturan')

@section('content')

    <div class="container-fluid py-4">

        {{-- Breadcrumb --}}
        <div class="mb-2">
            <small class="text-muted">
                Beranda >
                Pengaturan >
                <span class="text-primary fw-semibold">Edit Profil</span>
            </small>
        </div>

        <h3 class="fw-bold mb-4">
            Edit Profil Akun
        </h3>

        {{-- Menu --}}
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a class="nav-link active" href="#">
                    <i class="bi bi-person-fill me-1"></i>
                    Profil Akun
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('perangkat.pengaturan.password') }}">
                    <i class="bi bi-key"></i>
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

        <div class="row">

            {{-- FORM --}}
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-4">
                        <form action="{{ route('perangkat.pengaturan.profil.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                {{-- Nama Perangkat --}}
                                <div class="col-md-6 mb-3">

                                    <label class="form-label fw-semibold readonly-label">
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
                                    <label class="form-label fw-semibold readonly-label">
                                        Alamat Surel Kantor
                                    </label>
                                    <div class="readonly-group">
                                        <input type="email" class="form-control" value="{{ $perangkat->email }}" readonly>
                                        <i class="bi bi-lock-fill lock-icon"></i>
                                    </div>
                                </div>

                                {{-- Kepala --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Nama Kepala Perangkat Daerah
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
                                        NIP Kepala Perangkat Daerah
                                    </label>
                                    <input type="text" name="nip" class="form-control"
                                        value="{{ old('nip', $perangkat->nip) }}">
                                </div>

                                {{-- Bendahara --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">
                                        Nama Bendahara Penerimaan
                                    </label>
                                    <input type="text" name="bendahara_penerimaan" class="form-control"
                                        value="{{ old('bendahara_penerimaan', $perangkat->bendahara_penerimaan) }}">
                                </div>

                                {{-- HP --}}
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-semibold">
                                        Nomor HP Bendahara Penerimaan
                                    </label>
                                    <input type="text" name="no_hp" class="form-control"
                                        value="{{ old('no_hp', $perangkat->no_hp) }}">
                                </div>
                            </div>
                            <hr>
                            <div class="text-end">
                                <a href="{{ route('perangkat') }}" class="btn btn-outline-secondary">
                                    Batal
                                </a>

                                <button type="submit" class="btn btn-primary ms-2">
                                    <i class="bi bi-save"></i>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- SIDEBAR KANAN --}}
            <div class="col-lg-4">
                <div class="card shadow-sm rounded-4 border-0 mb-3">
                    <div class="card-body">
                        <h5 class="fw-bold mb-4">
                            Status Keanggotaan
                        </h5>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Status Akun</span>
                            <span class="badge bg-success">
                                Aktif
                            </span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Terdaftar Sejak</span>
                            <strong>
                                {{ Auth::user()->created_at->format('d M Y') }}
                            </strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Level Akses</span>
                            <strong>Administrator OPD</strong>
                        </div>
                    </div>
                </div>
                <div class="card bg-primary text-white rounded-4 border-0 mb-3">
                    <div class="card-body">
                        <h5>Keamanan Akun</h5>
                        <p class="small mb-3">
                            Pastikan data akun yang dimasukkan benar agar proses pelaporan berjalan lancar.
                        </p>
                        <a href="#" class="text-warning text-decoration-none">
                            Lihat Panduan
                        </a>
                    </div>
                </div>
                <div class="card rounded-4 shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="fw-bold">
                            Butuh Bantuan?
                        </h6>
                        <small class="text-muted">
                            Hubungi Helpdesk Bapenda apabila mengalami kendala.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection