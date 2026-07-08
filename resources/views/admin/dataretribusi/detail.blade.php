@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold">{{ $rincian->nama_rincian }}</h3>
            <p class="text-muted mb-0">
                Daftar Detail Retribusi
            </p>
        </div>

        <button class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#modalDetail">

            + Tambah Detail

        </button>

    </div>

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    <div class="row">

        @forelse($rincian->detail as $detail)

        <div class="col-lg-4 col-md-6 mb-4">

            <div class="card shadow-sm border-0 h-100">

                <div class="card-body">

                    <div class="text-center mb-3">
                        <i class="bi bi-file-earmark-text text-primary"
                           style="font-size:50px;"></i>
                    </div>

                    <h5 class="fw-bold text-center">

                        {{ $detail->nama_detail }}

                    </h5>

                    @if(!empty($detail->kode_rekening))

                        <p class="text-muted text-center mb-0">
                            Kode Rekening :
                            <strong>{{ $detail->kode_rekening }}</strong>
                        </p>

                    @endif

                </div>

            </div>

        </div>

        @empty

        <div class="col-12">

            <div class="alert alert-warning">

                Belum ada Detail Retribusi.

            </div>

        </div>

        @endforelse

    </div>

</div>


{{-- Modal Tambah Detail --}}

<div class="modal fade"
     id="modalDetail"
     tabindex="-1">

    <div class="modal-dialog">

        <form action="{{ route('admin.detail.store') }}"
              method="POST">

            @csrf

            <input type="hidden"
                   name="rincian_id"
                   value="{{ $rincian->id }}">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">

                        Tambah Detail Retribusi

                    </h5>

                    <button class="btn-close"
                            data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="mb-3">

                        <label class="form-label">
                            Nama Detail
                        </label>

                        <input type="text"
                               name="nama_detail"
                               class="form-control"
                               required>

                    </div>

                    <div>

                        <label class="form-label">
                            Kode Rekening
                        </label>

                        <input type="text"
                               name="kode_rekening"
                               class="form-control">

                    </div>

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