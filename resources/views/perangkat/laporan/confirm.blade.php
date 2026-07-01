@extends('layouts.app')

@section('title', 'Input Laporan Retribusi - Ringkasan')

@section('content')

    <div class="container-fluid py-4 px-4">

        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h4 class="fw-bold mb-1">Input Laporan Retribusi</h4>
                <p class="text-muted small mb-0">
                    Lengkapi form berikut untuk memproses laporan retribusi daerah bulanan.
                </p>
            </div>

            <div class="d-flex align-items-center step-wizard-top">
                <div class="step-top-item done">
                    <div class="step-top-circle"></div>
                    <span class="step-top-label">Konfigurasi</span>
                </div>
                <div class="step-top-line"></div>
                <div class="step-top-item done">
                    <div class="step-top-circle"></div>
                    <span class="step-top-label">Rincian</span>
                </div>
                <div class="step-top-line"></div>
                <div class="step-top-item active">
                    <div class="step-top-circle">3</div>
                    <span class="step-top-label">Selesai</span>
                </div>
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

            <div class="card shadow-sm border-0 mb-3">
                <div class="card-body p-4">

                    <h5 class="fw-bold mb-1">Ringkasan Laporan</h5>
                    <p class="text-muted small mb-0">
                        Mohon periksa kembali seluruh data laporan Anda sebelum melakukan pengiriman final.
                    </p>

                    <hr class="my-4">

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="text-muted small text-uppercase mb-1">Bulan Masa Retribusi</div>
                            <div class="fw-semibold">{{ $bulanNama }} {{ $wizard['tahun'] ?? '' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted small text-uppercase mb-1">Jenis Retribusi</div>
                            <div class="fw-semibold">{{ $jenis->nama_jenis }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted small text-uppercase mb-1">Objek Retribusi</div>
                            <div class="fw-semibold">{{ $objek->nama_objek }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted small text-uppercase mb-1">Rincian Objek</div>
                            <div class="fw-semibold">{{ $rincian->nama_rincian }}</div>
                        </div>
                        @if($detail)
                            <div class="col-md-6">
                                <div class="text-muted small text-uppercase mb-1">Detail Objek</div>
                                <div class="fw-semibold">{{ $detail->nama_detail }}</div>
                            </div>
                        @endif
                    </div>

                    <div class="border rounded mt-4 overflow-hidden">
                        <table class="table mb-0 align-middle">
                            <thead>
                                <tr class="text-muted small text-uppercase">
                                    <th class="ps-3 fw-semibold">Objek Retribusi</th>
                                    <th class="pe-3 text-end fw-semibold">Nominal Realisasi (Rp)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="ps-3 py-3">
                                        @if($detail)
                                            <div class="fw-bold">{{ $detail->nama_detail }}</div>
                                            <div class="text-muted small">{{ $rincian->nama_rincian }}</div>
                                        @else
                                            <div class="fw-bold">{{ $rincian->nama_rincian }}</div>
                                            <div class="text-muted small">Tidak ada detail objek</div>
                                        @endif
                                    </td>
                                    <td class="pe-3 text-end py-3">
                                        {{ number_format($nominalRealisasi, 0, ',', '.') }}
                                    </td>
                                </tr>
                                <tr class="bg-light">
                                    <td class="ps-3 py-3 fw-bold">Total Realisasi</td>
                                    <td class="pe-3 text-end py-3 fw-bold">
                                        Rp {{ number_format($nominalRealisasi, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('perangkat.laporan.create') }}" class="btn btn-light border px-4">Batal</a>
                <button type="submit" class="btn btn-primary px-4" id="btnSubmitFinal">
                    Submit <i class="bi bi-arrow-right ms-1"></i>
                </button>
            </div>
        </form>

    </div>

@endsection