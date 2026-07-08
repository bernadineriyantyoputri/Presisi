@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold">{{ $objek->nama_objek }}</h3>
            <p class="text-muted mb-0">
                Daftar Rincian Retribusi
            </p>
        </div>

        <button class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#modalRincian">

            + Tambah Rincian

        </button>

    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">

        @forelse($objek->rincian as $rincian)

        <div class="col-lg-4 col-md-6 mb-4">

            <div class="card shadow-sm border-0 h-100">

                <div class="card-body text-center">

                    <i class="bi bi-list-ul text-primary"
                       style="font-size:50px;"></i>

                    <h5 class="mt-3">

                        {{ $rincian->nama_rincian }}
                    </h5>

                    <a href="{{ route('admin.data.rincian', $rincian->id) }}"
                       class="btn btn-outline-primary mt-3">

                        Kelola
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-warning">
                Belum ada rincian retribusi.
            </div>
        </div>
        @endforelse
    </div>
</div>


<div class="modal fade"
     id="modalRincian"
     tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.rincian.store') }}"
              method="POST">
            @csrf
            <input type="hidden"
                   name="objek_id"
                   value="{{ $objek->id }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Tambah Rincian Retribusi
                    </h5>
                    <button class="btn-close"
                            data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <label class="form-label">
                        Nama Rincian
                    </label>
                    <input type="text"
                           name="nama_rincian"
                           class="form-control"
                           required>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button class="btn btn-primary">
                        Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection