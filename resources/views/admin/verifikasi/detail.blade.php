@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">

<div class="verif-page">
    <div class="verif-container">

        {{-- ============ HEADER / BREADCRUMB ============ --}}
        <div class="verif-topbar">
            <div>
                <a href="{{ route('admin.verifikasi') }}" class="verif-back">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                </a>

                <h1 class="verif-title">Detail Verifikasi Pendaftaran</h1>
                <p class="verif-subtitle">
                    Informasi lengkap permohonan pendaftaran akun perangkat daerah.
                </p>
            </div>

            <div class="verif-actions">
                @if($perangkat->status_verifikasi === 'Pending')

                    <form action="{{ route('admin.verifikasi.proses', $perangkat->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="verif-btn verif-btn-primary">
                            <i class="bi bi-check2-circle"></i> Verifikasi (ACC)
                        </button>
                    </form>

                    <form action="{{ route('admin.verifikasi.tolak', $perangkat->id) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Tolak permohonan ini?')">
                        @csrf
                        <button class="verif-btn verif-btn-danger">
                            <i class="bi bi-x-circle"></i> Tolak
                        </button>
                    </form>

                @elseif($perangkat->status_verifikasi === 'Terverifikasi')

                    @if($perangkat->is_active)
                        <form action="{{ route('admin.verifikasi.nonaktifkan', $perangkat->id) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Nonaktifkan akun ini? Perangkat Daerah tidak akan bisa login.')">
                            @csrf
                            <button class="verif-btn verif-btn-outline-danger">
                                <i class="bi bi-slash-circle"></i> Nonaktifkan Akun
                            </button>
                        </form>
                    @else
                        <form action="{{ route('admin.verifikasi.aktifkan', $perangkat->id) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Aktifkan kembali akun ini?')">
                            @csrf
                            <button class="verif-btn verif-btn-outline-success">
                                <i class="bi bi-play-circle"></i> Aktifkan Akun
                            </button>
                        </form>
                    @endif

                    <button type="button" class="verif-btn verif-btn-outline-warning d-inline" data-bs-toggle="modal"
                        data-bs-target="#resetPasswordModal">
                        <i class="bi bi-key-fill"></i> Reset Password
                    </button>

                @elseif($perangkat->status_verifikasi === 'Ditolak')

                    <button class="verif-btn verif-btn-disabled" disabled>
                        <i class="bi bi-x-octagon"></i> Permohonan Ditolak
                    </button>

                @endif
            </div>
        </div>

        {{-- ============ PASSWORD BARU (tampil sekali saja, setelah aksi apa pun yang menghasilkannya) ============ --}}
        @if(session('password_baru'))
            <div class="alert alert-success">
                <h6 class="fw-bold mb-2">Password berhasil direset</h6>
                <p class="mb-2">Password sementara:</p>
                <div class="fs-4 fw-bold text-primary">{{ session('password_baru') }}</div>
                <small class="text-muted">
                    Catat password ini dan berikan kepada Perangkat Daerah. Setelah login, mereka dapat
                    menggantinya melalui menu Pengaturan.
                </small>
            </div>
        @endif

        {{-- ============ LETTERHEAD / IDENTITY CARD ============ --}}
        <div class="verif-letterhead">
            <div class="verif-letterhead-rule"></div>

            <div class="verif-letterhead-body">
                <div class="verif-identity">
                    <div class="verif-emblem">
                        <i class="bi bi-bank2"></i>
                    </div>
                    <div>
                        <h2 class="verif-instansi-name">{{ $perangkat->nama_perangkat }}</h2>
                        <p class="verif-instansi-label">Perangkat Daerah</p>
                    </div>
                </div>

                {{-- Official "stamp" style status indicator --}}
                <div class="verif-stamp-wrap">
                    @if($perangkat->status_verifikasi === 'Terverifikasi')
                        @if(!$perangkat->is_active)
                            <span class="verif-chip verif-chip-muted">Nonaktif</span>
                        @else
                            <span class="verif-chip verif-chip-success">Akun Aktif</span>
                        @endif
                    @elseif($perangkat->status_verifikasi === 'Ditolak')
                        <div class="verif-stamp verif-stamp-danger"><span>DITOLAK</span></div>
                    @else
                        <div class="verif-stamp verif-stamp-pending"><span>MENUNGGU</span></div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ============ INFORMASI LENGKAP ============ --}}
        <div class="verif-card">
            <div class="verif-card-header">
                <i class="bi bi-file-earmark-text"></i>
                Informasi Lengkap Pendaftaran
            </div>

            <div class="verif-card-body">
                <div class="verif-grid">

                    {{-- Kolom Kiri --}}
                    <div class="verif-section">
                        <h3 class="verif-section-title">
                            <span class="verif-section-number">01</span>
                            Data Perangkat Daerah
                        </h3>

                        <div class="verif-field">
                            <label>Nama Perangkat Daerah</label>
                            <div class="verif-value">{{ $perangkat->nama_perangkat }}</div>
                        </div>

                        <div class="verif-field">
                            <label>Nama Kepala Perangkat</label>
                            <div class="verif-value">{{ $perangkat->kepala_perangkat }}</div>
                        </div>

                        <div class="verif-field">
                            <label>Pangkat / Golongan</label>
                            <div class="verif-value">{{ $perangkat->pangkat_golongan }}</div>
                        </div>

                        <div class="verif-field">
                            <label>NIP Kepala</label>
                            <div class="verif-value verif-value-mono">{{ $perangkat->nip }}</div>
                        </div>
                    </div>

                    <div class="verif-divider"></div>

                    {{-- Kolom Kanan --}}
                    <div class="verif-section">
                        <h3 class="verif-section-title">
                            <span class="verif-section-number">02</span>
                            Data Bendahara
                        </h3>

                        <div class="verif-field">
                            <label>Nama Bendahara Penerimaan</label>
                            <div class="verif-value">{{ $perangkat->bendahara_penerimaan }}</div>
                        </div>

                        <div class="verif-field">
                            <label>Nomor HP</label>
                            <div class="verif-value verif-value-mono">{{ $perangkat->no_hp }}</div>
                        </div>

                        <div class="verif-field">
                            <label>Email</label>
                            <div class="verif-value">{{ $perangkat->email }}</div>
                        </div>

                        <div class="verif-field">
                            <label>Tanggal Pendaftaran</label>
                            <div class="verif-value">{{ $perangkat->created_at->format('d F Y H:i') }} WIB</div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="verif-card-footer">
                <i class="bi bi-shield-lock"></i>
                Dokumen ini dihasilkan otomatis oleh sistem dan bersifat rahasia untuk keperluan verifikasi internal.
            </div>
        </div>

    </div>
</div>

{{-- Modal Reset Password --}}
<div class="modal fade" id="resetPasswordModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-key-fill me-2"></i>
                    Reset Password
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p class="mb-3">Password akun berikut akan direset:</p>

                <div class="alert alert-light border">
                    <strong>{{ $perangkat->nama_perangkat }}</strong>
                    <br>
                    <small>{{ $perangkat->email }}</small>
                </div>

                <div class="alert alert-warning mb-0">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Password sementara akan dibuat otomatis. Pengguna diwajibkan mengganti password
                    setelah berhasil login.
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>

                <form action="{{ route('admin.verifikasi.reset-password', $perangkat->id) }}" method="POST">
                    @csrf
                    <button class="btn btn-warning">
                        <i class="bi bi-key-fill me-1"></i>
                        Reset Password
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

@endsection