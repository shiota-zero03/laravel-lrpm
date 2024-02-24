@extends('pages.dosen.usulan-baru.buat-usulan.theme')

@section('fase')

<div>
    <h6 class="card-title my-0">1. Identitas Pengusul :</h6>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hovered">
            <tbody>
                <tr>
                    <th>Nama</th>
                    <td>:&nbsp; {{ auth()->user()->name }}</td>
                    <th>NIDN</th>
                    <td>:&nbsp; {{ auth()->user()->nidn }}</td>
                </tr>
                <tr>
                    <th>Jabatan</th>
                    <td>:&nbsp; {{ \App\Models\Position::find(auth()->user()->jabatan)->nama_jabatan }}</td>
                    <th>Email</th>
                    <td>:&nbsp; {{ auth()->user()->email }}</td>
                </tr>
                    <th>Nomor Hp</th>
                    <td>:&nbsp; {{ auth()->user()->no_hp }}</td>
                    <th>ID Sinta</th>
                    <td>:&nbsp; {{ auth()->user()->id_sinta }}</td>
                </tr>
                <tr>
                    <th>ID Google Scholar</th>
                    <td>:&nbsp; {{ auth()->user()->id_google_scholar }}</td>
                    <th>ID Scopus</th>
                    <td>:&nbsp; {{ auth()->user()->id_scopus }}</td>
                </tr>
                <tr>
                    <th>Fakultas</th>
                    <td>:&nbsp; {{ \App\Models\Faculty::find(auth()->user()->fakultas)->nama_fakultas }}</td>
                    <th>Program Studi</th>
                    <td>:&nbsp; {{ \App\Models\Department::find(auth()->user()->prodi)->nama_prodi }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <h6 class="card-title my-0">2. Mitra (wajib diisi jika skema yang akan anda pilih berupa KDN/KLN):</h6>  
    <div class="row">
        <div class="form-group col-md-4">
            <label for="nama_mitra" class="fw-bold mb-1">Nama Mitra</label>
            <input type="text" value="{{ $check_code->nama_mitra }}" name="nama_mitra" id="nama_mitra" class="form-control" placeholder="Tulis nama mitra anda disini">
            <small id="error_nama_mitra" class="text-danger fst-italic"></small>
            
        </div> 
        <div class="form-group col-md-4">
            <label for="institusi_mitra" class="fw-bold mb-1">Institusi Mitra</label>
            <input type="text" value="{{ $check_code->institusi_mitra }}" name="institusi_mitra" id="institusi_mitra" class="form-control" placeholder="Tulis institusi mitra anda disini">
            <small id="error_institusi_mitra" class="text-danger fst-italic"></small>
        </div> 
        <div class="form-group col-md-4">
            <label for="pendanaan_mitra" class="fw-bold mb-1">Pendanaan Mitra</label>
            <select name="pendanaan_mitra" id="pendanaan_mitra" class="form-control">
                <option value="" selected disabled>--Pilih pendanaan mitra anda--</option>
                @foreach(\App\Models\MitraFunding::all() as $pendanaan_mitra)
                    <option @if($check_code->id_pendanaan_mitra == $pendanaan_mitra->id) selected @endif value="{{ $pendanaan_mitra->id }}">{{ $pendanaan_mitra->nama_pendanaan }}</option>
                @endforeach
                @if($check_code->id_pendanaan_mitra)
                    <option value="">--Batalkan pendanaan--</option>
                @endif
            </select>
            <small id="error_pendanaan_mitra" class="text-danger fst-italic"></small>
        </div> 
    </div>
    <h6 class="card-title my-0">3. Tambah Dosen : <a style="cursor: pointer" onclick="openDosenModal(0)" class="text-white border-none outline-none px-2 py-1 rounded bg-success"><i class="bi bi-plus-square"></i></a></h6>
    <div class="table-responsive">
        <table class="table table-bordered table-striped" style="font-size: 14px">
            <thead>
                <tr>
                    <th>NIDN</th>
                    <th>Nama</th>
                    <th>Tugas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="body-dosen-tabel">
                <tr>
                    <td colspan="4" class="text-center"><small><em>Tidak ada data dosen</em></small></td>
                </tr>
            </tbody>
        </table>
    </div>
    <h6 class="card-title my-0">4. Tambah Mahasiswa : <a style="cursor: pointer" onclick="openMahasiswaModal(0)" class="text-white border-none outline-none px-2 py-1 rounded bg-success"><i class="bi bi-plus-square"></i></a></h6>
    <div class="table-responsive">
        <table class="table table-bordered table-striped" style="font-size: 14px">
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Tugas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="body-mahasiswa-tabel">
                <tr>
                    <td colspan="4" class="text-center"><small><em>Tidak ada data mahasiswa</em></small></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="d-md-flex">
        <button onclick="saveForm('draft')" class="btn btn-warning me-2 mb-2 text-white"><small>Jadikan Draft</small></button>
        <button onclick="saveForm('next')" class="btn btn-primary me-2 mb-2"><small>Selanjutnya</small></button>
        <div class="spinner-border text-primary me-2 mb-2 d-none" role="status" id="loading-submit">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>

<div class="modal fade" id="dosenModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Data Dosen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id_dosen" name="id_dosen">
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label" for="nama_dosen">Nama <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="nama_dosen" id="nama_dosen">
                        <div class="col-12"><small id="error_nama_dosen" class="text-danger fst-italic"></small></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label" for="pendidikan_dosen">Pendidikan <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="pendidikan_dosen" id="pendidikan_dosen">
                        <div class="col-12"><small id="error_pendidikan_dosen" class="text-danger fst-italic"></small></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label" for="nidn_dosen">NIDN <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" name="nidn_dosen" id="nidn_dosen">
                        <div class="col-12"><small id="error_nidn_dosen" class="text-danger fst-italic"></small></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label" for="instansi_dosen">Instansi <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="instansi_dosen" id="instansi_dosen">
                        <div class="col-12"><small id="error_instansi_dosen" class="text-danger fst-italic"></small></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label" for="jabatan_dosen">Jabatan <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="jabatan_dosen" id="jabatan_dosen">
                        <div class="col-12"><small id="error_jabatan_dosen" class="text-danger fst-italic"></small></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label" for="fakultas_dosen">Fakultas <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="fakultas_dosen" id="fakultas_dosen">
                        <div class="col-12"><small id="error_fakultas_dosen" class="text-danger fst-italic"></small></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label" for="program_studi_dosen">Program Studi <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="program_studi_dosen" id="program_studi_dosen">
                        <div class="col-12"><small id="error_program_studi_dosen" class="text-danger fst-italic"></small></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label" for="id_sinta">Sinta ID <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="id_sinta" id="id_sinta">
                        <div class="col-12"><small id="error_id_sinta" class="text-danger fst-italic"></small></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label" for="tugas_dosen">Tugas <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <textarea name="tugas_dosen" cols="30" rows="5" class="form-control" id="tugas_dosen"></textarea>
                        <div class="col-12"><small id="error_tugas_dosen" class="text-danger fst-italic"></small></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="d-flex">
                    <div class="spinner-border text-primary me-2 d-none" role="status" id="loading-submit-dosen">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" id="simpan_dosen" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mahasiswaModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Data Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id_mahasiswa" name="id_mahasiswa">
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label" for="nama_mahasiswa">Nama <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="nama_mahasiswa" id="nama_mahasiswa">
                        <div class="col-12"><small id="error_nama_mahasiswa" class="text-danger fst-italic"></small></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label" for="nidn_mahasiswa">NIM <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" name="nidn_mahasiswa" id="nidn_mahasiswa">
                        <div class="col-12"><small id="error_nidn_mahasiswa" class="text-danger fst-italic"></small></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label" for="fakultas_mahasiswa">Fakultas <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="fakultas_mahasiswa" id="fakultas_mahasiswa">
                        <div class="col-12"><small id="error_fakultas_mahasiswa" class="text-danger fst-italic"></small></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label" for="program_studi_mahasiswa">Program Studi <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="program_studi_mahasiswa" id="program_studi_mahasiswa">
                        <div class="col-12"><small id="error_program_studi_mahasiswa" class="text-danger fst-italic"></small></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label" for="tugas_mahasiswa">Tugas <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <textarea name="tugas_mahasiswa" cols="30" rows="5" class="form-control" id="tugas_mahasiswa"></textarea>
                        <div class="col-12"><small id="error_tugas_mahasiswa" class="text-danger fst-italic"></small></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="d-flex">
                    <div class="spinner-border text-primary me-2 d-none" role="status" id="loading-submit-mahasiswa">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" id="simpan_mahasiswa" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('custom_script')

<script src="{{ asset('assets/js/pages/usulan-baru-tambah-participant.js') }}"></script>
<script>
    $('#inner-1').addClass('active')
    function saveForm(event) {
        $('#loading-submit').removeClass('d-none')
        $('#error_nama_mitra').html(''),
        $('#error_institusi_mitra').html(''),
        $('#error_pendanaan_mitra').html('')

        const formData = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            nama_mitra: $('#nama_mitra').val(),
            institusi_mitra: $('#institusi_mitra').val(),
            id_pendanaan_mitra: $('#pendanaan_mitra').val()
        }
        $.ajax({
            method: 'POST',
            url: submission_code+"/store/fase-1/"+event,
            data: formData,
            success: function(response){
                if(event === 'next'){
                    $('#loading-submit').addClass('d-none')
                    document.location.href="?page=2"
                } else if(event === 'draft') {
                    document.location.href="{{ route('dosen.usulan-baru.index', $type) }}"
                }
            },
            error: function(error){
                if(error.status === 422) {
                    const errorResponse = error.responseJSON.errors
                    if(errorResponse['nama_mitra']) $('#error_nama_mitra').html(errorResponse['nama_mitra'][0]);
                    if(errorResponse['institusi_mitra']) $('#error_institusi_mitra').html(errorResponse['institusi_mitra'][0]);
                    if(errorResponse['id_pendanaan_mitra']) $('#error_pendanaan_mitra').html(errorResponse['id_pendanaan_mitra'][0]);
                }
                $('#loading-submit').addClass('d-none')
            }
        })
    }
</script>

@endpush
