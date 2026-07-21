@extends('layouts.app')

@section('title', 'Input Laporan Retribusi - Step 1')

@section('content')

    <div class="laporan-wizard-page">
        <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
            <div>
                <h4 class="fw-bold mb-1">Input Laporan Retribusi</h4>
                <p class="text-muted small mb-0">Lengkapi form berikut untuk memproses laporan retribusi daerah bulanan.</p>
            </div>

            <div class="d-flex align-items-center step-wizard-top">
                <div class="step-top-item active"><div class="step-top-circle">1</div><span class="step-top-label">Jenis</span></div>
                <div class="step-top-line"></div>
                <div class="step-top-item"><div class="step-top-circle">2</div><span class="step-top-label">Objek</span></div>
                <div class="step-top-line"></div>
                <div class="step-top-item"><div class="step-top-circle">3</div><span class="step-top-label">Nominal</span></div>
                <div class="step-top-line"></div>
                <div class="step-top-item"><div class="step-top-circle">4</div><span class="step-top-label">Ringkasan</span></div>
                <div class="step-top-line"></div>
                <div class="step-top-item"><div class="step-top-circle">5</div><span class="step-top-label">Selesai</span></div>
            </div>
        </div>

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row g-4">
            <div class="col-md-8">
                <form method="POST" action="{{ route('perangkat.laporan.create.jenis') }}">
                    @csrf

                    <div class="wizard-card mb-3">
                        <h6 class="section-title">
                            <i class="bi bi-calendar3"></i>
                            Periode Laporan
                        </h6>
                        <div class="row g-3 mt-1">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Bulan Masa Retribusi</label>
                                <select name="bulan" class="form-select" required>
                                    <option value="">Pilih Bulan</option>
                                    @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $i => $namaBulan)
                                        <option value="{{ $i + 1 }}" {{ old('bulan') == ($i + 1) ? 'selected' : '' }}>
                                            {{ $namaBulan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Tahun</label>
                                <select name="tahun" class="form-select" required>
                                    <option value="">Pilih Tahun</option>
                                    @for($t = now()->year; $t >= now()->year - 3; $t--)
                                        <option value="{{ $t }}" {{ old('tahun', now()->year) == $t ? 'selected' : '' }}>{{ $t }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="wizard-card mb-3">
                        <h6 class="section-title">
                            <i class="bi bi-card-list"></i>
                            Jenis Retribusi Daerah
                        </h6>
                        <p class="text-muted small mb-3">Pilih salah satu jenis retribusi di bawah ini.</p>

                        <input type="hidden" name="jenis_retribusi_id" id="jenis_retribusi_id"
                            value="{{ old('jenis_retribusi_id') }}" required>

                        <div class="row g-3 mt-1">
                            @foreach($jenisRetribusi as $j)
                                <div class="col-md-4">
                                    <div class="jenis-card {{ old('jenis_retribusi_id') == $j->id ? 'selected' : '' }}"
                                        data-id="{{ $j->id }}" onclick="pilihJenis(this)">
                                        <div class="jenis-card-icon">
                                            <i class="bi bi-receipt"></i>
                                        </div>
                                        <div class="jenis-card-title">{{ $j->nama_jenis }}</div>
                                        <div class="jenis-card-check">
                                            <i class="bi bi-check-circle-fill"></i>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="wizard-footer">
                        <a href="{{ route('perangkat.laporan.index') }}" class="btn btn-batal">
                            Batal
                        </a>

                        <button class="btn btn-lanjut">
                            Lanjut ke Objek <i class="bi bi-arrow-right ms-1"></i>
                        </button>
                    </div>
                </form>
            </div>

            <div class="col-md-4">
                <div class="panduan-card">
                    <h6 class="fw-bold mb-3">Panduan Admin</h6>
                    <ul class="list-unstyled mb-0 small lh-lg">
                        <li class="mb-2 d-flex gap-2">
                            <i class="bi bi-info-circle"></i>
                            <span>Setiap langkah akan menampilkan pilihan yang sudah disaring sesuai pilihan
                                sebelumnya.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        function pilihJenis(el) {
            document.querySelectorAll('.jenis-card').forEach(function (card) {
                card.classList.remove('selected');
            });
            el.classList.add('selected');
            document.getElementById('jenis_retribusi_id').value = el.getAttribute('data-id');
        }
    </script>

@endsection@extends('layouts.app')

@section('title', 'Input Laporan Retribusi - Step 1')

@section('content')

    <div class="laporan-wizard-page">
        <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
            <div>
                <h4 class="fw-bold mb-1">Input Laporan Retribusi</h4>
                <p class="text-muted small mb-0">Lengkapi form berikut untuk memproses laporan retribusi daerah bulanan.</p>
            </div>

            <div class="d-flex align-items-center step-wizard-top">
                <div class="step-top-item active"><div class="step-top-circle">1</div><span class="step-top-label">Jenis</span></div>
                <div class="step-top-line"></div>
                <div class="step-top-item"><div class="step-top-circle">2</div><span class="step-top-label">Objek</span></div>
                <div class="step-top-line"></div>
                <div class="step-top-item"><div class="step-top-circle">3</div><span class="step-top-label">Nominal</span></div>
                <div class="step-top-line"></div>
                <div class="step-top-item"><div class="step-top-circle">4</div><span class="step-top-label">Ringkasan</span></div>
                <div class="step-top-line"></div>
                <div class="step-top-item"><div class="step-top-circle">5</div><span class="step-top-label">Selesai</span></div>
            </div>
        </div>

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row g-4">
            <div class="col-md-8">
                <form method="POST" action="{{ route('perangkat.laporan.create.jenis') }}">
                    @csrf

                    <div class="wizard-card mb-3">
                        <h6 class="section-title">
                            <i class="bi bi-calendar3"></i>
                            Periode Laporan
                        </h6>
                        <div class="row g-3 mt-1">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Bulan Masa Retribusi</label>
                                <select name="bulan" class="form-select" required>
                                    <option value="">Pilih Bulan</option>
                                    @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $i => $namaBulan)
                                        <option value="{{ $i + 1 }}" {{ old('bulan') == ($i + 1) ? 'selected' : '' }}>
                                            {{ $namaBulan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Tahun</label>
                                <select name="tahun" class="form-select" required>
                                    <option value="">Pilih Tahun</option>
                                    @for($t = now()->year; $t >= now()->year - 3; $t--)
                                        <option value="{{ $t }}" {{ old('tahun', now()->year) == $t ? 'selected' : '' }}>{{ $t }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="wizard-card mb-3">
                        <h6 class="section-title">
                            <i class="bi bi-card-list"></i>
                            Jenis Retribusi Daerah
                        </h6>
                        <p class="text-muted small mb-3">Pilih salah satu jenis retribusi di bawah ini.</p>

                        <input type="hidden" name="jenis_retribusi_id" id="jenis_retribusi_id"
                            value="{{ old('jenis_retribusi_id') }}" required>

                        <div class="row g-3 mt-1">
                            @foreach($jenisRetribusi as $j)
                                <div class="col-md-4">
                                    <div class="jenis-card {{ old('jenis_retribusi_id') == $j->id ? 'selected' : '' }}"
                                        data-id="{{ $j->id }}" onclick="pilihJenis(this)">
                                        <div class="jenis-card-icon">
                                            <i class="bi bi-receipt"></i>
                                        </div>
                                        <div class="jenis-card-title">{{ $j->nama_jenis }}</div>
                                        <div class="jenis-card-check">
                                            <i class="bi bi-check-circle-fill"></i>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="wizard-footer">
                        <a href="{{ route('perangkat.laporan.index') }}" class="btn btn-batal">
                            Batal
                        </a>

                        <button class="btn btn-lanjut">
                            Lanjut ke Objek <i class="bi bi-arrow-right ms-1"></i>
                        </button>
                    </div>
                </form>
            </div>

            <div class="col-md-4">
                <div class="panduan-card">
                    <h6 class="fw-bold mb-3">Panduan Admin</h6>
                    <ul class="list-unstyled mb-0 small lh-lg">
                        <li class="mb-2 d-flex gap-2">
                        <div class="admin-guide-list">

<div class="admin-guide-item">
    <i class="bi bi-info-circle"></i>
    <span>Setiap langkah akan menampilkan pilihan yang sudah disaring sesuai pilihan sebelumnya.</span>
</div>

<div class="admin-guide-item">
    <i class="bi bi-info-circle"></i>
    <span>Pemilihan objek akan menentukan parameter input pada langkah berikutnya.</span>
</div>

</div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        function pilihJenis(el) {
            document.querySelectorAll('.jenis-card').forEach(function (card) {
                card.classList.remove('selected');
            });
            el.classList.add('selected');
            document.getElementById('jenis_retribusi_id').value = el.getAttribute('data-id');
        }
    </script>

@endsection