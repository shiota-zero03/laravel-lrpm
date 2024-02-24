@extends('theme.layout')

@section('page', 'Daftar Pengguna')
@section('breadcrumb', 'Daftar Pengguna')
@section('breadcrumbs_sub_page',$pengguna)

@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Daftar Pengguna</h5>
                    <button type="button" onclick="openModal(0)" class="btn btn-primary rounded mb-3">
                        <i class="bi bi-plus"></i> Tambah Pengguna
                    </button>
                    <div class="table-responsive">
                        <table class="table" id="user-datatable">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    @if($role == 'dosen' || $role == 'admin' || $role == 'reviewer')
                                        <th scope="col">NIM/NIDN</th>
                                    @endif
                                    <th scope="col">Nama</th>
                                    <th scope="col">Email</th>
                                    @if($role == 'program-studi' || $role == 'fakultas')
                                        <th scope="col">Fakultas</th>
                                    @endif
                                    @if($role == 'dosen' || $role == 'program-studi')
                                        <th scope="col">Jurusan</th>
                                    @endif
                                    @if($role == 'reviewer')
                                        <th scope="col">Jabatan</th>
                                    @endif
                                    <th scope="col">Status</th>
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
                <h5 class="modal-title"><strong>Data Pengguna</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form">
                    <input type="hidden" id="id" name="id">
                    <div class="form-group mb-2">
                        <label class="form-control-label" for="name">Nama Lengkap <span class="text-danger">*</span></label>
                        <input class="form-control" id="name" name="name" type="text">
                        <small class="text-danger fst-italic" id="error_name"></small>
                    </div>
                    @if($role == 'dosen' || $role == 'reviewer')
                        <div class="form-group mb-2">
                            <label class="form-control-label" for="nidn">NIDN <span class="text-danger">*</span></label>
                            <input class="form-control" id="nidn" name="nidn" type="text">
                            <small class="text-danger fst-italic" id="error_nidn"></small>
                        </div>
                    @endif
                    @if($role == 'admin')
                        <div class="form-group mb-2">
                            <label class="form-control-label" for="unit">Unit/Departemen <span class="text-danger">*</span></label>
                            <input class="form-control" id="unit" name="unit" type="text">
                            <small class="text-danger fst-italic" id="error_unit"></small>
                        </div>
                    @endif
                    @if($role == 'reviewer')
                        <div class="form-group mb-2">
                            <label class="form-control-label" for="unit">Institusi <span class="text-danger">*</span></label>
                            <input class="form-control" id="unit" name="unit" type="text">
                            <small class="text-danger fst-italic" id="error_unit"></small>
                        </div>
                    @endif
                    @if($role == 'admin' || $role == 'dosen' || $role == 'reviewer')
                        <div class="form-group mb-2">
                            <label class="form-control-label" for="jabatan">Jabatan <span class="text-danger">*</span></label>
                            <select name="jabatan" id="jabatan" class="form-control">
                                <option value="" disabled>--Pilih Jabatan Fungsional--</option>
                                @foreach($jabatan as $position)
                                    <option value="{{ $position->id }}">{{ $position->nama_jabatan }}</option>
                                @endforeach
                            </select>
                            <small class="text-danger fst-italic" id="error_jabatan"></small>
                        </div>
                    @endif
                    <div class="form-group mb-2">
                        <label class="form-control-label" for="email">Email <span class="text-danger">*</span></label>
                        <input class="form-control" id="email" name="email" type="text">
                        <small class="text-danger fst-italic" id="error_email"></small>
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-control-label" for="password">Password <span id="default">(Default: 12345678) </span><span class="text-danger">*</span></label>
                        <input class="form-control" disabled value="12345678" id="password" name="password" type="password">
                        <small class="text-danger fst-italic" id="error_password"></small>
                    </div>
                    <div class="form-group mb-2">
                        <label class="form-control-label" for="no_hp">Nomor Hp <span class="text-danger">*</span></label>
                        <input class="form-control" id="no_hp" name="no_hp" type="number">
                        <small class="text-danger fst-italic" id="error_no_hp"></small>
                    </div>
                    @if($role == 'dosen' || $role == 'program-studi' || $role == 'fakultas')
                        <div class="form-group mb-2">
                            <label class="form-control-label" for="fakultas">Fakultas <span class="text-danger">*</span></label>
                            <select name="fakultas" id="fakultas" class="form-control">
                                <option value="" disabled>--Pilih Fakultas--</option>
                                @foreach($fakultas as $fak)
                                    <option value="{{ $fak->id }}">{{ $fak->nama_fakultas }}</option>
                                @endforeach
                            </select>
                            <small class="text-danger fst-italic" id="error_fakultas"></small>
                        </div>
                        @if($role == 'dosen' || $role == 'program-studi')
                            <div class="form-group mb-2">
                                <label class="form-control-label" for="prodi">Program Studi <span class="text-danger">*</span></label>
                                <select name="prodi" id="prodi" class="form-control">
                                    <option value="" disabled>--Pilih Program Studi--</option>
                                </select>
                                <small class="text-danger fst-italic" id="error_prodi"></small>
                            </div>
                        @endif
                    @endif
                    @if( $role == 'dosen')
                        <div class="form-group mb-2">
                            <label class="form-control-label" for="id_sinta">ID Sinta <span class="text-danger">*</span></label>
                            <input class="form-control" id="id_sinta" name="id_sinta" type="text">
                            <small class="text-danger fst-italic" id="error_id_sinta"></small>
                        </div>
                        <div class="form-group mb-2">
                            <label class="form-control-label" for="id_google_scholar">ID Google Scholar <span class="text-danger">*</span></label>
                            <input class="form-control" id="id_google_scholar" name="id_google_scholar" type="text">
                            <small class="text-danger fst-italic" id="error_id_google_scholar"></small>
                        </div>
                        <div class="form-group mb-2">
                            <label class="form-control-label" for="id_scopus">ID Scopus <span class="text-danger">*</span></label>
                            <input class="form-control" id="id_scopus" name="id_scopus" type="text">
                            <small class="text-danger fst-italic" id="error_id_scopus"></small>
                        </div>
                    @endif
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
<input type="hidden" id="role" value="{{$role}}">
@endsection

@push('custom_script')

<script src="{{ asset('assets/js/pages/user.js') }}"></script>

@endpush