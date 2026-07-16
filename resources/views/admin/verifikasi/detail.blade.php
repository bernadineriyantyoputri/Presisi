@extends('layouts.app')

@section('content')

<div class="container-fluid p-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <a href="{{ route('admin.verifikasi') }}"
                class="text-decoration-none text-secondary">
                ← Kembali ke Daftar
            </a>

            <h2 class="fw-bold mt-2">
                Detail Verifikasi Pendaftaran
            </h2>

            <p class="text-muted">
                Informasi lengkap permohonan pendaftaran akun perangkat daerah.
            </p>
        </div>

        <div class="d-flex gap-2">

            @if($perangkat->status_verifikasi === 'Pending')

                <form action="{{ route('admin.verifikasi.proses', $perangkat->id) }}"
                      method="POST"
                      class="d-inline">
                    @csrf

                    <button class="btn btn-primary">
                        Verifikasi (ACC)
                    </button>

                </form>

                <form action="{{ route('admin.verifikasi.tolak', $perangkat->id) }}"
                      method="POST"
                      class="d-inline"
                      onsubmit="return confirm('Tolak permohonan ini?')">
                    @csrf

                    <button class="btn btn-danger">
                        Tolak
                    </button>

                </form>

            @elseif($perangkat->status_verifikasi === 'Terverifikasi')

                @if($perangkat->is_active)

                    <form action="{{ route('admin.verifikasi.nonaktifkan', $perangkat->id) }}"
                          method="POST"
                          class="d-inline"
                          onsubmit="return confirm('Nonaktifkan akun ini? Perangkat Daerah tidak akan bisa login.')">
                        @csrf

                        <button class="btn btn-outline-danger">
                            Nonaktifkan Akun
                        </button>

                    </form>

                @else

                    <form action="{{ route('admin.verifikasi.aktifkan', $perangkat->id) }}"
                          method="POST"
                          class="d-inline"
                          onsubmit="return confirm('Aktifkan kembali akun ini?')">
                        @csrf

                        <button class="btn btn-outline-success">
                            Aktifkan Akun
                        </button>

                    </form>

                @endif

            @elseif($perangkat->status_verifikasi === 'Ditolak')

                <button class="btn btn-danger" disabled>
                    Permohonan Ditolak
                </button>

            @endif

        </div>

    </div>

    {{-- Card Instansi --}}
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center">

                <div class="d-flex align-items-center">

                    <div class="bg-primary rounded-circle d-flex justify-content-center align-items-center"
                        style="width:70px;height:70px;">

                        <i class="bi bi-building text-white fs-2"></i>

                    </div>

                    <div class="ms-3">

                        <h3 class="fw-bold mb-1">
                            {{ $perangkat->nama_perangkat }}
                        </h3>

                        <p class="text-muted mb-0">
                            Perangkat Daerah
                        </p>

                    </div>

                </div>

                <div class="d-flex gap-2">

                    @if($perangkat->status_verifikasi === 'Terverifikasi')

                        <span class="badge bg-success fs-6">
                            Terverifikasi
                        </span>

                        @if(!$perangkat->is_active)
                            <span class="badge bg-secondary fs-6">
                                Nonaktif
                            </span>
                        @endif

                    @elseif($perangkat->status_verifikasi === 'Ditolak')

                        <span class="badge bg-danger fs-6">
                            Ditolak
                        </span>

                    @else

                        <span class="badge bg-warning text-dark fs-6">
                            Menunggu Verifikasi
                        </span>

                    @endif

                </div>

            </div>

        </div>

    </div>

    {{-- Informasi --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header fw-bold">
            Informasi Lengkap Pendaftaran
        </div>

        <div class="card-body">

            <div class="row">

                {{-- Kolom Kiri --}}
                <div class="col-md-6">

                    <h5 class="fw-bold mb-4">
                        Data Perangkat Daerah
                    </h5>

                    <div class="mb-3">
                        <label class="text-muted">Nama Perangkat Daerah</label>
                        <div class="fw-semibold">
                            {{ $perangkat->nama_perangkat }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted">Nama Kepala Perangkat</label>
                        <div class="fw-semibold">
                            {{ $perangkat->kepala_perangkat }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted">Pangkat / Golongan</label>
                        <div class="fw-semibold">
                            {{ $perangkat->pangkat_golongan }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted">NIP Kepala</label>
                        <div class="fw-semibold">
                            {{ $perangkat->nip }}
                        </div>
                    </div>

                </div>

                {{-- Kolom Kanan --}}
                <div class="col-md-6">

                    <h5 class="fw-bold mb-4">
                        Data Bendahara
                    </h5>

                    <div class="mb-3">
                        <label class="text-muted">
                            Nama Bendahara Penerimaan
                        </label>

                        <div class="fw-semibold">
                            {{ $perangkat->bendahara_penerimaan }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted">
                            Nomor HP
                        </label>

                        <div class="fw-semibold">
                            {{ $perangkat->no_hp }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted">
                            Email
                        </label>

                        <div class="fw-semibold">
                            {{ $perangkat->email }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted">
                            Tanggal Pendaftaran
                        </label>

                        <div class="fw-semibold">
                            {{ $perangkat->created_at->format('d F Y H:i') }}
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection