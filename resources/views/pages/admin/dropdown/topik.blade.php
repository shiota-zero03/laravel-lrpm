@extends('theme.layout')

@section('page', 'Dropdown Topik')
@section('breadcrumb', 'Topik')

@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Daftar Topik</h5>
                    <button type="button" onclick="openModal(0)" class="btn btn-primary rounded mb-3">
                        <i class="bi bi-plus"></i> Tambah Topik
                    </button>
                    <div class="table-responsive">
                        <table class="table" id="topik-datatable">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama Riset</th>
                                    <th scope="col">Nama Tema</th>
                                    <th scope="col">Nama Topik</th>
                                    <th scope="col">Aksi</th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="userModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong>Data Topik</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form">
                    <input type="hidden" id="id" name="id">
                    <div class="form-group mb-2">
                        <label class="form-control-label" for="id_riset">Riset Unggulan <span class="text-danger">*</span></label>
                        @php
                            $riset = \App\Models\SuperiorResearch::all();
                        @endphp
                        <select class="form-control" id="id_riset" name="id_riset">
                            <option value="" disabled>-- Pilih riset unggulan --</option>
                            @foreach ($riset as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_riset }}</option>
                            @endforeach
                        </select>
                        <small class="text-danger fst-italic" id="error_id_riset"></small>
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-control-label" for="id_tema">Tema <span class="text-danger">*</span></label>
                        <select class="form-control" id="id_tema" name="id_tema"></select>
                        <small class="text-danger fst-italic" id="error_id_tema"></small>
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-control-label" for="nama">Nama Topik <span class="text-danger">*</span></label>
                        <input class="form-control" id="nama" name="nama" type="text">
                        <small class="text-danger fst-italic" id="error_nama"></small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="d-flex">
                    <div class="spinner-border text-primary me-2 d-none" role="status" id="loading-submit">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" id="btn_save" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('custom_script')

<script src="{{ asset('assets/js/pages/topik.js') }}"></script>

@endpush