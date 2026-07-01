@extends('layouts.app')

@section('title', 'Input Laporan Retribusi - Step 1')

@section('content')

    <div class="container-fluid py-4 px-4">

        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h4 class="fw-bold mb-1">Input Laporan Retribusi</h4>
                <p class="text-muted small mb-0">Langkah 1 dari 5: Periode &amp; Jenis Retribusi</p>
            </div>

            <div class="d-flex align-items-center step-wizard-top">
                <div class="step-top-item active"><div class="step-top-circle">1</div><span class="step-top-label">Jenis</span></div>
                <div class="step-top-line"></div>
                <div class="step-top-item"><div class="step-top-circle">2</div><span class="step-top-label">Objek</span></div>
                <div class="step-top-line"></div>
                <div class="step-top-item"><div class="step-top-circle">3</div><span class="step-top-label">Rincian</span></div>
                <div class="step-top-line"></div>
                <div class="step-top-item"><div class="step-top-circle">4</div><span class="step-top-label">Detail</span></div>
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

                    <div class="card shadow-sm border-0 mb-3">
                        <div class="card-body p-4">
                            <h6 class="section-title">
                                <i class="bi bi-calendar3 me-2 text-primary"></i>
                                Periode Laporan
                            </h6>
                            <div class="row g-3 mt-1">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small">Bulan Masa Retribusi</label>
                                    <select name="bulan" class="form-select" required>
                                        <option value="">Pilih Bulan</option>
                                        @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $namaBulan)
                                            <option value="{{ $i + 1 }}" {{ old('bulan') == ($i + 1) ? 'selected' : '' }}>{{ $namaBulan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small">Tahun</label>
                                    <select name="tahun" class="form-select" required>
                                        <option value="">Pilih Tahun</option>
                                        @for($t = now()->year; $t >= now()->year - 3; $t--)
                                            <option value="{{ $t }}" {{ old('tahun', now()->year) == $t ? 'selected' : '' }}>{{ $t }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0 mb-3">
                        <div class="card-body p-4">
                            <h6 class="section-title">
                                <i class="bi bi-card-list me-2 text-primary"></i>
                                Jenis Retribusi Daerah
                            </h6>
                            <p class="text-muted small mb-3">Pilih salah satu jenis retribusi di bawah ini.</p>

                            <input type="hidden" name="jenis_retribusi_id" id="jenis_retribusi_id" value="{{ old('jenis_retribusi_id') }}" required>

                            <div class="row g-3 mt-1">
                                @foreach($jenisRetribusi as $j)
                                    <div class="col-md-4">
                                        <div class="jenis-card {{ old('jenis_retribusi_id') == $j->id ? 'selected' : '' }}"
                                             data-id="{{ $j->id }}"
                                             onclick="pilihJenis(this)">
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
                    </div>

                    <div class="d-flex justify-content-between align-items-center py-3 border-top">
                        <a href="{{ route('perangkat.laporan.index') }}" class="text-muted small text-decoration-none">Batal</a>
                        <button type="submit" class="btn btn-primary px-4">
                            Lanjut ke Objek <i class="bi bi-arrow-right ms-1"></i>
                        </button>
                    </div>
                </form>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm" style="background:#1e2d3d; color:#fff;">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3">Panduan Admin</h6>
                        <ul class="list-unstyled mb-0 small lh-lg">
                            <li class="mb-2">
                                <i class="bi bi-info-circle me-2" style="color:#7eb8f7;"></i>
                                Setiap langkah akan menampilkan pilihan yang sudah disaring sesuai pilihan sebelumnya.
                            </li>
                        </ul>
                    </div>
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