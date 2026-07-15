@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endpush

@section('content')

    <div class="jr-page">

        {{-- ================= HEADER ================= --}}
        <div class="jr-header">
            <h3 class="jr-title">Manajemen Referensi Retribusi</h3>
            <p class="jr-subtitle">Kelola hierarki data retribusi daerah mulai dari jenis hingga detail objek.</p>
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
                            <div class="jr-icon-box" style="background-color: {{ $jenis->warna ?? '#EAF1FB' }};">
                                <i class="bi {{ $jenis->icon ?? 'bi-check2-square' }}"
                                    style="color: {{ $jenis->warna_icon ?? '#2F6FED' }};"></i>
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

                        <a href="{{ route('admin.data.jenis', $jenis->id) }}" class="jr-card-link">
                            Kelola <i class="bi bi-arrow-right"></i>
                        </a>

                    </div>

                    {{-- Modal Edit Jenis --}}
                    <div class="modal fade" id="modalEditJenis{{ $jenis->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <form action="{{ route('admin.jenis.update', $jenis->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-content jr-modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Jenis Retribusi</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <label class="form-label">Nama Jenis Retribusi</label>
                                        <input type="text" name="nama_jenis" class="form-control"
                                            value="{{ $jenis->nama_jenis }}" required>

                                        <label class="form-label mt-3">Deskripsi</label>
                                        <textarea name="deskripsi" class="form-control"
                                            rows="3">{{ $jenis->deskripsi }}</textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
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
                    <i class="bi bi-plus-lg"></i> Jasa Baru
                </button>
            </div>

        </div>

    </div>

    {{-- ================= MODAL: TAMBAH JENIS ================= --}}
    <div class="modal fade" id="modalJenis" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('admin.jenis.store') }}" method="POST">
                @csrf
                <div class="modal-content jr-modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Jenis Retribusi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label class="form-label">Nama Jenis Retribusi</label>
                        <input type="text" name="nama_jenis" class="form-control" required>

                        <label class="form-label mt-3">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection