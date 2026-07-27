@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="dashboard-perangkat">

    <div class="header-card mb-4">
        <div>
            <h2 class="judul-halaman mb-1">{{ $sapaan ?? 'Selamat pagi' }}, {{ $namaInstansi ?? $akun->name }}</h2>
            <p class="text-muted mb-0">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
        </div>
        <div class="clock-badge" id="clockBadge">
            <div class="clock-time" id="clockTime">--:--</div>
            <div class="clock-label">WIB</div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-label">Laporan bulan ini</div>
                <div class="stat-value">{{ $statusLaporanBulanIni ?? 'Belum submit' }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-label">Total laporan tahun ini</div>
                <div class="stat-value">{{ $totalLaporanTahunIni ?? 0 }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-label">Realisasi terhadap target</div>
                <div class="stat-value text-primary-navy">{{ $realisasiTarget ?? 0 }}%</div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <a href="{{ route('perangkat.laporan.create') }}" class="action-card action-card-primary text-decoration-none">
                <i class="bi bi-file-earmark-text"></i>
                <div>
                    <div class="action-title">Input laporan baru</div>
                    <div class="action-desc">Isi laporan realisasi retribusi bulan ini</div>
                </div>
            </a>
        </div>
        <div class="col-md-6">
            <a href="{{ route('perangkat.riwayat') }}" class="action-card action-card-secondary text-decoration-none">
                <i class="bi bi-clock-history"></i>
                <div>
                    <div class="action-title">Lihat riwayat laporan</div>
                    <div class="action-desc">Semua laporan yang pernah diinput</div>
                </div>
            </a>
        </div>
    </div>

    <div class="wizard-card">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="section-title mb-0">Laporan terbaru</h3>
            <a href="{{ route('perangkat.riwayat') }}" class="small fw-semibold text-decoration-none">Lihat semua</a>
        </div>

        @forelse($laporanTerbaru ?? [] as $laporan)
        <div class="d-flex justify-content-between align-items-center py-2 border-top">
            <div>
                <div class="fw-bold">{{ $laporan->bulan }} {{ $laporan->tahun }}</div>
                <div class="text-muted small">Rp {{ number_format($laporan->jumlah, 0, ',', '.') }}</div>
            </div>
            <span class="badge-status {{ $laporan->status === 'submit' ? 'badge-submit' : 'badge-draft' }}">
                {{ $laporan->status === 'submit' ? 'Sudah submit' : 'Draft' }}
            </span>
        </div>
        @empty
        <div class="text-muted py-3">Belum ada laporan yang diinput.</div>
        @endforelse
    </div>

</div>
@endsection

@push('scripts')
<script>
    function updateClock() {
        const now = new Date();
        // Convert ke WIB (UTC+7)
        const wibString = now.toLocaleTimeString('en-GB', {
            timeZone: 'Asia/Jakarta',
            hour: '2-digit',
            minute: '2-digit'
        });
        document.getElementById('clockTime').textContent = wibString;
    }
    updateClock();
    setInterval(updateClock, 1000);
</script>
@endpush