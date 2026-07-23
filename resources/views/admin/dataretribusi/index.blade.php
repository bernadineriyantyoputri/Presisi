@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')

    <div class="page-header">
        <div>
            <h1>Manajemen Referensi Retribusi.</h1>
            <p>Kelola hierarki data retribusi daerah mulai dari jenis hingga detail objek</p>
        </div>
    </div>

        @if(session('success'))
            <div class="jr-alert jr-alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="jr-alert jr-alert-danger">
                {{ session('error') }}
            </div>
        @endif

        {{-- ================= SECTION: JENIS RETRIBUSI DAERAH ================= --}}
        <div class="jr-section">

            <div class="jr-section-heading">
                <i class="bi bi-diagram-3 jr-section-icon"></i>
                <span>Jenis Retribusi Daerah</span>
            </div>

            <div class="jr-card-grid">

                @foreach($data as $jenis)

                    <div class="jr-card">

                        <div class="jr-card-top">
                            <div class="jr-icon-box" style="background-color: {{ $jenis->warna ?? '#E7EAF3' }};">
                            <i class="bi
@if($jenis->nama_jenis == 'Jasa Umum')
    bi-bank2
@elseif($jenis->nama_jenis == 'Jasa Usaha')
    bi-shop-window
@elseif($jenis->nama_jenis == 'Jasa Perizinan Tertentu')
    bi-patch-check
@else
    bi-grid
@endif"
style="color: {{ $jenis->warna_icon ?? '#22345A' }};"></i>
                            </div>

                            <div class="jr-card-actions">
                                <button type="button" class="jr-edit-btn" data-bs-toggle="modal"
                                    data-bs-target="#modalEditJenis{{ $jenis->id }}" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </button>

                                <button type="button" class="jr-delete-btn" data-bs-toggle="modal"
                                    data-bs-target="#modalDeleteJenis{{ $jenis->id }}" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>

                        <h5 class="jr-card-title">{{ $jenis->nama_jenis }}</h5>

                        <p class="jr-card-desc">
                            {{ \Illuminate\Support\Str::limit($jenis->deskripsi, 90) }}
                        </p>

                        <a href="{{ route('admin.data.jenis', $jenis->id) }}"
   class="jr-manage-btn">
    Kelola
    <i class="bi bi-arrow-right"></i>
</a>

                    </div>

                    {{-- Modal Edit Jenis --}}
<div class="modal fade" id="modalEditJenis{{ $jenis->id }}" tabindex="-1">
<div class="modal-dialog modal-dialog-centered modal-lg">

        <form action="{{ route('admin.jenis.update', $jenis->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="modal-content jr-modal-content">

                {{-- Header --}}
                <div class="modal-header">

                    <div>
                        <h5 class="modal-title mb-1">
                            Edit Jenis Retribusi
                        </h5>

                        <small class="text-muted">
                            Perbarui informasi jenis retribusi.
                        </small>
                    </div>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                {{-- Body --}}
                <div class="modal-body">

                    <div class="mb-4">

                        <label class="form-label">
                            Nama Jenis Retribusi
                        </label>

                        <input
                            type="text"
                            name="nama_jenis"
                            class="form-control"
                            value="{{ $jenis->nama_jenis }}"
                            required>

                    </div>

                    

                </div>

                {{-- Footer --}}
                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn jr-btn-cancel"
                        data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>
                        Batal
                    </button>

                    <button
                        type="submit"
                        class="btn jr-btn-save">
                        <i class="bi bi-check-circle me-1"></i>
                        Simpan
                    </button>

                </div>

            </div>

        </form>

    </div>
</div>

                    {{-- Modal Hapus Jenis --}}
                    <div class="modal fade" id="modalDeleteJenis{{ $jenis->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <form action="{{ route('admin.jenis.destroy', $jenis->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="modal-content jr-modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Hapus Jenis Retribusi</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Apakah Anda yakin ingin menghapus jenis retribusi
                                            <strong>{{ $jenis->nama_jenis }}</strong>?</p>
                                        <p class="text-danger small mb-0">
                                            Tindakan ini tidak dapat dibatalkan dan dapat memengaruhi data terkait di bawahnya.
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                @endforeach

            </div>

            <div class="jr-footer-action">
                <button class="btn jr-btn-add" data-bs-toggle="modal" data-bs-target="#modalJenis">
                    <i class="bi bi-plus-lg"></i> Jenis Retribusi
                </button>
            </div>

        </div>

    </div>


    {{-- ================= MODAL: TAMBAH JENIS ================= --}}
<div class="modal fade" id="modalJenis" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('admin.jenis.store') }}" method="POST">
            @csrf

            <div class="modal-content jr-modal-content">

                {{-- Header --}}
                <div class="modal-header">
    <div>
        <h5 class="modal-title mb-1">Tambah Jenis Retribusi</h5>
        <small class="text-muted">
            Tambahkan kategori retribusi baru ke dalam sistem.
        </small>
    </div>

    <button type="button"
        class="btn-close"
        data-bs-dismiss="modal">
    </button>
</div>

                {{-- Body --}}
                <div class="modal-body">

                    <div class="mb-4">
                        <label class="form-label">
                            Nama Jenis Retribusi
                        </label>

                        <input
                            type="text"
                            name="nama_jenis"
                            class="form-control"
                            placeholder="Contoh : Jasa Umum"
                            required>
                    </div>

            
                </div>

                {{-- Footer --}}
                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn jr-btn-cancel"
                        data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>
                        Batal
                    </button>

                    <button
                        type="submit"
                        class="btn jr-btn-save">
                        <i class="bi bi-check-circle me-1"></i>
                        Simpan
                    </button>

                </div>

            </div>

        </form>
    </div>
</div> 
@endsection