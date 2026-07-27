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

                    <button type="button" class="verif-btn verif-btn-primary" data-bs-toggle="modal" data-bs-target="#accModal">
                        <i class="bi bi-check2-circle"></i> Verifikasi (ACC)
                    </button>

                    <button type="button" class="verif-btn verif-btn-danger" data-bs-toggle="modal" data-bs-target="#tolakModal">
                        <i class="bi bi-x-circle"></i> Tolak
                    </button>

                @elseif($perangkat->status_verifikasi === 'Terverifikasi')

                    @if($perangkat->is_active)
                        <button type="button" class="verif-btn verif-btn-outline-danger" data-bs-toggle="modal" data-bs-target="#nonaktifModal">
                            <i class="bi bi-slash-circle"></i> Nonaktifkan Akun
                        </button>
                    @else
                        <button type="button" class="verif-btn verif-btn-outline-success" data-bs-toggle="modal" data-bs-target="#aktifModal">
                            <i class="bi bi-play-circle"></i> Aktifkan Akun
                        </button>
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

        {{-- ============ PASSWORD BARU (tampil sekali saja, setelah reset) ============ --}}
        @if(session('password_baru'))
            <div class="verif-card mb-4">
                <div class="verif-card-header is-success">
                    <i class="bi bi-check-circle-fill"></i>
                    Password Berhasil Direset
                </div>
                <div class="verif-card-body" style="padding-bottom:24px;">
                    <p class="mb-3" style="color:var(--verif-text-muted); font-size:0.92rem;">
                        Sampaikan password sementara berikut kepada Perangkat Daerah secara langsung dan aman.
                    </p>
                    <div class="verif-password-box">
                        <label>Password Sementara</label>
                        <div class="verif-password-value">{{ session('password_baru') }}</div>
                    </div>
                    <small class="d-block mt-3" style="color:var(--verif-text-muted);">
                        Pengguna wajib menggantinya melalui menu Pengaturan setelah berhasil login.
                    </small>
                </div>
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

{{-- ================================================================
     MODAL: Verifikasi (ACC)
================================================================ --}}
<div class="modal fade" id="accModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content verif-modal-content">
            <div class="modal-header">
                <div>
                    <div class="verif-modal-icon is-navy"><i class="bi bi-check2-circle"></i></div>
                    <h5 class="modal-title">Verifikasi Pendaftaran</h5>
                    <p class="verif-modal-subtitle">Setujui permohonan akun perangkat daerah berikut.</p>
                </div>
                <button type="button" class="verif-modal-close" data-bs-dismiss="modal" aria-label="Tutup">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <div class="modal-body">
                <div class="verif-modal-infobox">
                    <strong>{{ $perangkat->nama_perangkat }}</strong>
                    <small>{{ $perangkat->email }}</small>
                </div>
                <div class="verif-modal-warning">
                    <i class="bi bi-info-circle-fill"></i>
                    <span>Setelah diverifikasi, akun akan otomatis aktif dan Perangkat Daerah dapat login menggunakan email terdaftar.</span>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="verif-modal-btn-cancel" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Batal
                </button>
                <form action="{{ route('admin.verifikasi.proses', $perangkat->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="verif-modal-btn-confirm is-success">
                        <i class="bi bi-check2-circle"></i> Verifikasi Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ================================================================
     MODAL: Tolak Permohonan
================================================================ --}}
<div class="modal fade" id="tolakModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content verif-modal-content">
            <div class="modal-header">
                <div>
                    <div class="verif-modal-icon is-danger"><i class="bi bi-x-circle"></i></div>
                    <h5 class="modal-title">Tolak Permohonan</h5>
                    <p class="verif-modal-subtitle">Tindakan ini akan menolak pendaftaran akun berikut.</p>
                </div>
                <button type="button" class="verif-modal-close" data-bs-dismiss="modal" aria-label="Tutup">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <div class="modal-body">
                <div class="verif-modal-infobox">
                    <strong>{{ $perangkat->nama_perangkat }}</strong>
                    <small>{{ $perangkat->email }}</small>
                </div>
                <div class="verif-modal-warning is-danger">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <span>Tindakan ini tidak dapat dibatalkan. Perangkat Daerah harus mengajukan pendaftaran ulang jika ditolak.</span>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="verif-modal-btn-cancel" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Batal
                </button>
                <form action="{{ route('admin.verifikasi.tolak', $perangkat->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="verif-modal-btn-confirm is-danger">
                        <i class="bi bi-check2-circle"></i> Ya, Tolak Permohonan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ================================================================
     MODAL: Nonaktifkan Akun
================================================================ --}}
<div class="modal fade" id="nonaktifModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content verif-modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title">Nonaktifkan Akun</h5>
                    <p class="verif-modal-subtitle">Akun tidak akan bisa digunakan untuk login sampai diaktifkan kembali.</p>
                </div>
                <button type="button" class="verif-modal-close" data-bs-dismiss="modal" aria-label="Tutup">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <div class="modal-body">
                <div class="verif-modal-infobox">
                    <strong>{{ $perangkat->nama_perangkat }}</strong>
                    <small>{{ $perangkat->email }}</small>
                </div>
                <div class="verif-modal-warning is-danger">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <span>Perangkat Daerah tidak akan bisa login selama akun berstatus nonaktif.</span>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="verif-modal-btn-cancel" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Batal
                </button>
                <form action="{{ route('admin.verifikasi.nonaktifkan', $perangkat->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="verif-modal-btn-confirm is-danger">
                        <i class="bi bi-check2-circle"></i> Nonaktifkan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ================================================================
     MODAL: Aktifkan Kembali Akun
================================================================ --}}
<div class="modal fade" id="aktifModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content verif-modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title">Aktifkan Kembali Akun</h5>
                    <p class="verif-modal-subtitle">Akun akan dapat digunakan untuk login kembali.</p>
                </div>
                <button type="button" class="verif-modal-close" data-bs-dismiss="modal" aria-label="Tutup">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <div class="modal-body">
                <div class="verif-modal-infobox">
                    <strong>{{ $perangkat->nama_perangkat }}</strong>
                    <small>{{ $perangkat->email }}</small>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="verif-modal-btn-cancel" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Batal
                </button>
                <form action="{{ route('admin.verifikasi.aktifkan', $perangkat->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="verif-modal-btn-confirm is-success">
                        <i class="bi bi-check2-circle"></i> Aktifkan Akun
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ================================================================
     MODAL: Reset Password
================================================================ --}}
<div class="modal fade" id="resetPasswordModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content verif-modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title">Reset Password</h5>
                    <p class="verif-modal-subtitle">Password akun berikut akan direset secara otomatis.</p>
                </div>
                <button type="button" class="verif-modal-close" data-bs-dismiss="modal" aria-label="Tutup">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <div class="modal-body">
                <div class="verif-modal-infobox">
                    <strong>{{ $perangkat->nama_perangkat }}</strong>
                    <small>{{ $perangkat->email }}</small>
                </div>
                <div class="verif-modal-warning">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <span>Pengguna wajib mengganti password ini setelah berhasil login. Sampaikan password baru secara langsung dan aman.</span>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="verif-modal-btn-cancel" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Batal
                </button>
                <form action="{{ route('admin.verifikasi.reset-password', $perangkat->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="verif-modal-btn-confirm is-navy">
                        <i class="bi bi-check2-circle"></i> Reset Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection