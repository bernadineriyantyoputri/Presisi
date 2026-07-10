@extends('layouts.app')

@section('title', 'Input Laporan Retribusi - Ringkasan')

@section('content')

    <div class="laporan-wizard-page">

        <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
            <div>
                <h4 class="fw-bold mb-1">Input Laporan Retribusi</h4>
                <p class="text-muted small mb-0">
                    Lengkapi form berikut untuk memproses laporan retribusi daerah bulanan.
                </p>
            </div>

            <div class="d-flex align-items-center step-wizard-top">
                <div class="step-top-item active"><div class="step-top-circle">1</div><span class="step-top-label">Jenis</span></div>
                <div class="step-top-line"></div>
                <div class="step-top-item active"><div class="step-top-circle">2</div><span class="step-top-label">Objek</span></div>
                <div class="step-top-line"></div>
                <div class="step-top-item active"><div class="step-top-circle">3</div><span class="step-top-label">Nominal</span></div>
                <div class="step-top-line"></div>
                <div class="step-top-item active"><div class="step-top-circle">4</div><span class="step-top-label">Ringkasan</span></div>
                <div class="step-top-line"></div>
                <div class="step-top-item "><div class="step-top-circle">5</div><span class="step-top-label">Selesai</span></div>
            </div>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-warning">{{ session('error') }}</div>
        @endif

        @php
            $nominalRealisasi = (float) ($wizard['realisasi_bulan_ini'] ?? 0);
        @endphp

        <form method="POST" action="{{ route('perangkat.laporan.store') }}" id="formSubmitFinal">
            @csrf
            <input type="hidden" name="action" id="actionInput" value="submit">

            <div class="ringkasan-final-card mb-4">

                <div class="ringkasan-final-header">
                    <h6 class="fw-bold mb-1">Ringkasan Laporan</h6>
                    <p class="text-muted small mb-0">
                        Mohon periksa kembali seluruh data laporan Anda sebelum melakukan pengiriman final.
                    </p>
                </div>

                <div class="ringkasan-final-body">

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <div class="ringkasan-final-label">Bulan Masa Retribusi</div>
                            <div class="ringkasan-final-value">{{ $bulanNama }} {{ $wizard['tahun'] ?? '' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="ringkasan-final-label">Jenis Retribusi</div>
                            <div class="ringkasan-final-value">{{ $jenis->nama_jenis }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="ringkasan-final-label">Objek Retribusi</div>
                            <div class="ringkasan-final-value">{{ $objek->nama_objek }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="ringkasan-final-label">Rincian Objek</div>
                            <div class="ringkasan-final-value">{{ $rincian->nama_rincian }}</div>
                        </div>
                        @if($detail)
                            <div class="col-md-6">
                                <div class="ringkasan-final-label">Detail Objek</div>
                                <div class="ringkasan-final-value">{{ $detail->nama_detail }}</div>
                            </div>
                        @endif
                    </div>

                    <div class="laporan-table-box">
                        <div class="laporan-table-header">
                            <div>Objek Retribusi</div>
                            <div>Nominal Realisasi (Rp)</div>
                        </div>

                        <div class="laporan-table-row">
                            <div>
                                @if($detail)
                                    <div class="laporan-table-title">{{ $detail->nama_detail }}</div>
                                    <div class="laporan-table-sub">{{ $rincian->nama_rincian }}</div>
                                @else
                                    <div class="laporan-table-title">{{ $rincian->nama_rincian }}</div>
                                    <div class="laporan-table-sub">Tidak ada detail objek</div>
                                @endif
                            </div>
                            <div class="laporan-table-nominal">
                                {{ number_format($nominalRealisasi, 0, ',', '.') }}
                            </div>
                        </div>

                        <div class="laporan-table-total">
                            <div>Total Realisasi</div>
                            <div>Rp {{ number_format($nominalRealisasi, 0, ',', '.') }}</div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="konfirmasi" id="konfirmasi" required>
                        <label class="form-check-label small" for="konfirmasi">
                            Saya menyatakan bahwa data yang dikirim sudah sesuai dengan data yang sebenarnya
                            dan dapat dipertanggungjawabkan kebenarannya.
                        </label>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">
                    <a href="{{ route('perangkat.laporan.create.nominal.show') }}" class="text-muted small text-decoration-none">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('perangkat.laporan.create') }}" class="btn btn-batal">Batal</a>
                <button type="submit" class="btn btn-lanjut" id="btnSubmitFinal">
                    Submit <i class="bi bi-arrow-right ms-1"></i>
                </button>
            </div>
        </form>

    </div>

@endsection