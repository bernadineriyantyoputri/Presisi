@extends('layouts.app')

@section('title', 'Input Laporan Retribusi - Selesai')

@section('content')

    <div class="laporan-wizard-page">

        <div class="d-flex justify-content-between align-items-start mb-4">
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
                <div class="step-top-item active "><div class="step-top-circle">5</div><span class="step-top-label">Selesai</span></div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            </div>
        @endif

        <div class="card shadow-sm border-0 mb-3">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">Pratinjau Laporan (PDF)</h5>
                    <a href="{{ route('perangkat.laporan.pdf', $laporan->id) }}?download=1"
                       class="btn btn-outline-primary btn-sm"
                       target="_blank">
                        <i class="bi bi-download me-1"></i> Download PDF
                    </a>
                </div>

                <div class="ratio" style="--bs-aspect-ratio: 130%;">
                    <iframe src="{{ route('perangkat.laporan.pdf', $laporan->id) }}"
                            style="border: 1px solid #e9ecef; border-radius: 8px;"
                            title="Preview Laporan Retribusi">
                    </iframe>
                </div>
            </div>
        </div>

        {{-- ACTION BUTTONS --}}
        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('perangkat.laporan.index') }}" class="btn btn-primary px-4">
                Selesai <i class="bi bi-check2 ms-1"></i>
            </a>
        </div>

    </div>

@endsection