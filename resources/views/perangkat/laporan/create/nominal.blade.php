@extends('layouts.app')

@section('title', 'Input Laporan Retribusi - Step 3')

@section('content')

    <div class="container-fluid py-4 px-4">

        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h4 class="fw-bold mb-1">Input Laporan Retribusi</h4>
                <p class="text-muted small mb-0">
                    Langkah 3 dari 5: Isi Nominal Realisasi
                </p>
            </div>

            <div class="d-flex align-items-center step-wizard-top">
                <div class="step-top-item active"><div class="step-top-circle">1</div><span class="step-top-label">Jenis</span></div>
                <div class="step-top-line"></div>
                <div class="step-top-item active"><div class="step-top-circle">2</div><span class="step-top-label">Objek</span></div>
                <div class="step-top-line"></div>
                <div class="step-top-item active"><div class="step-top-circle">3</div><span class="step-top-label">Rincian</span></div>
                <div class="step-top-line"></div>
                <div class="step-top-item active"><div class="step-top-circle">4</div><span class="step-top-label">Nominal</span></div>
                <div class="step-top-line"></div>
                <div class="step-top-item"><div class="step-top-circle">5</div><span class="step-top-label">Selesai</span></div>
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
            <div class="alert alert-warning alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-4">
            <div class="col-md-8">

                {{-- Ringkasan pilihan dari step sebelumnya --}}
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-body p-4">
                        <h6 class="section-title">
                            <i class="bi bi-clipboard-check me-2 text-primary"></i>
                            Ringkasan Objek Retribusi
                        </h6>

                        <div class="border rounded p-3 bg-light mt-3">
                            <div class="row">
                                <div class="col-md-4 text-muted small">Objek</div>
                                <div class="col-md-8 fw-semibold">{{ $objek->nama_objek }}</div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4 text-muted small">Rincian Objek</div>
                                <div class="col-md-8 fw-semibold">{{ $rincian->nama_rincian }}</div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4 text-muted small">Detail Objek</div>
                                <div class="col-md-8 fw-semibold">
                                    {{ $detail->nama_detail ?? '—' }}
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('perangkat.laporan.create.objek.show') }}?objek_id={{ $objek->id }}&rincian_id={{ $rincian->id }}"
                           class="small text-decoration-none d-inline-block mt-2">
                            <i class="bi bi-pencil me-1"></i> Ubah pilihan objek/rincian/detail
                        </a>
                    </div>
                </div>

                {{-- Form nominal --}}
                <form method="POST" action="{{ route('perangkat.laporan.create.nominal.store') }}" id="formNominal">
                    @csrf
                    <input type="hidden" name="objek_id" value="{{ $objek->id }}">
                    <input type="hidden" name="rincian_id" value="{{ $rincian->id }}">
                    <input type="hidden" name="detail_retribusi_id" value="{{ $detail->id ?? '' }}">

                    <div class="card shadow-sm border-0 mb-3">
                        <div class="card-body p-4">
                            <h6 class="fw-bold">Nominal Realisasi</h6>
                            <p class="text-muted small">
                                @if($detail)
                                    Masukkan nominal realisasi untuk detail objek <strong>{{ $detail->nama_detail }}</strong>.
                                @else
                                    Rincian objek ini tidak memiliki detail. Masukkan nominal realisasi langsung untuk rincian <strong>{{ $rincian->nama_rincian }}</strong>.
                                @endif
                            </p>

                            <div class="border rounded p-3 bg-light">
                                <label class="form-label small">Nominal Realisasi (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" id="nominal_display"
                                           class="form-control"
                                           value="{{ old('realisasi_bulan_ini') ? number_format(old('realisasi_bulan_ini'), 0, ',', '.') : '' }}"
                                           placeholder="Masukkan nominal tanpa titik (contoh: 1000000)">
                                    <input type="hidden" name="realisasi_bulan_ini" id="realisasi_bulan_ini"
                                           value="{{ old('realisasi_bulan_ini') }}">
                                </div>
                            </div>
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" name="konfirmasi" id="konfirmasi" required>
                                <label class="form-check-label small" for="konfirmasi">
                                    Saya menyatakan bahwa data yang dikirim sudah sesuai dengan data yang sebenarnya dan dapat dipertanggungjawabkan kebenarannya.
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center py-3 border-top">
                        <a href="{{ route('perangkat.laporan.create.objek.show') }}?objek_id={{ $objek->id }}&rincian_id={{ $rincian->id }}"
                           class="text-muted small text-decoration-none">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                        <div>
                            <button type="submit" class="btn btn-primary px-4" id="btnLanjut" disabled>
                                Selanjutnya <i class="bi bi-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const nominalDisplay = document.getElementById('nominal_display');
    const nominalHidden = document.getElementById('realisasi_bulan_ini');
    const btnLanjut = document.getElementById('btnLanjut');

    function checkReady() {
        if (btnLanjut) btnLanjut.disabled = !(nominalHidden && nominalHidden.value);
    }

    if (nominalDisplay) {
        nominalDisplay.addEventListener('input', function () {
            const raw = this.value.replace(/\D/g, '');
            this.value = raw ? new Intl.NumberFormat('id-ID').format(raw) : '';
            nominalHidden.value = raw;
            checkReady();
        });
    }

    checkReady();
});
</script>
@endpush
@endsection