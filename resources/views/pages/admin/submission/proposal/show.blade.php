@extends('theme.layout')

@section('page', 'Proposal')
@section('breadcrumb', $type == 'penelitian' ? 'Penelitian' : 'Pengabdian Masyarakat')
@section('breadcrumbs_sub_page', 'Kode: '.$check_code->submission_code)

@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between pt-4">
                        <a href="{{ route('admin.proposal.index', ['type' => $type]) }}" class="btn btn-info text-white"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
                        <a href="{{ route('admin.proposal.tracking', ['type' => $type, 'id' => $check_code->id]) }}" class="btn btn-primary">Lihat traking</a>
                    </div>
                    <div>
                        <h5 class="card-title my-0 fw-bold">Kode Pengajuan : {{ $check_code->submission_code }}</h5>
                        <h6 class="card-title my-0">1. Identitas Pengusul :</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hovered">
                                <tbody>
                                    <tr>
                                        <th>Nama</th>
                                        <td>:&nbsp; {{ $user->name }}</td>
                                        <th>NIDN</th>
                                        <td>:&nbsp; {{ $user->nidn }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jabatan</th>
                                        <td>:&nbsp; {{ \App\Models\Position::find($user->jabatan)->nama_jabatan }}</td>
                                        <th>Email</th>
                                        <td>:&nbsp; {{ $user->email }}</td>
                                    </tr>
                                        <th>Nomor Hp</th>
                                        <td>:&nbsp; {{ $user->no_hp }}</td>
                                        <th>ID Sinta</th>
                                        <td>:&nbsp; {{ $user->id_sinta }}</td>
                                    </tr>
                                    <tr>
                                        <th>ID Google Scholar</th>
                                        <td>:&nbsp; {{ $user->id_google_scholar }}</td>
                                        <th>ID Scopus</th>
                                        <td>:&nbsp; {{ $user->id_scopus }}</td>
                                    </tr>
                                    <tr>
                                        <th>Fakultas</th>
                                        <td>:&nbsp; {{ \App\Models\Faculty::find($user->fakultas)->nama_fakultas }}</td>
                                        <th>Program Studi</th>
                                        <td>:&nbsp; {{ \App\Models\Department::find($user->prodi)->nama_prodi }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <h6 class="card-title my-0">2. Mitra :</h6>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="nama_mitra" class="fw-bold mb-1">Nama Mitra</label>
                                <input type="text" readonly value="{{ $check_code->nama_mitra ? $check_code->nama_mitra : 'Tidak memilih mitra' }}" class="w-100 form-control" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="institusi_mitra" class="fw-bold mb-1">Institusi Mitra</label>
                                <input type="text" readonly value="{{ $check_code->institusi_mitra ? $check_code->institusi_mitra : 'Tidak memilih mitra' }}" class="w-100 form-control" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="pendanaan_mitra" class="fw-bold mb-1">Pendanaan Mitra</label>
                                <input type="text" readonly value="{{ $check_code->id_pendanaan_mitra ? \App\Models\MitraFunding::find($check_code->id_pendanaan_mitra)->nama_pendanaan : 'Tidak memilih mitra' }}" class="w-100 form-control" readonly>
                            </div>
                        </div>
                        <h6 class="card-title my-0">3. Partisipan Dosen : </h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" style="font-size: 14px">
                                <thead>
                                    <tr>
                                        <th>NIDN</th>
                                        <th>Nama</th>
                                        <th>Tugas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(\App\Models\Participant::where('id_submission', $check_code->id)->where('role', 'Dosen')->get()->count() > 0)
                                        @foreach (\App\Models\Participant::where('id_submission', $check_code->id)->where('role', 'Dosen')->get() as $dosen)
                                            <tr>
                                                <td>{{ $dosen->nidn }}</td>
                                                <td>{{ $dosen->nama }}</td>
                                                <td>{{ $dosen->tugas }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3" class="text-center"><small><em>Tidak ada data dosen</em></small></td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <h6 class="card-title my-0">4. Partisipan Mahasiswa : </h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" style="font-size: 14px">
                                <thead>
                                    <tr>
                                        <th>NIM</th>
                                        <th>Nama</th>
                                        <th>Tugas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(\App\Models\Participant::where('id_submission', $check_code->id)->where('role', 'Mahasiswa')->get()->count() > 0)
                                        @foreach (\App\Models\Participant::where('id_submission', $check_code->id)->where('role', 'Mahasiswa')->get() as $mahasiswa)
                                            <tr>
                                                <td>{{ $mahasiswa->nidn }}</td>
                                                <td>{{ $mahasiswa->nama }}</td>
                                                <td>{{ $mahasiswa->tugas }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center"><small><em>Tidak ada data dosen</em></small></td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <h6 class="card-title my-0">5. Formulir Usulan :</h6>
                        <div class="row">
                            <div class="col-md-6 col-12 mb-2">
                                <label for="file-usulan" class="fw-bold mb-1">File Usulan :</label><br />
                                <a href="{{ asset('assets/storage/files/dokumen-usulan/'.$check_code->dokumen_usulan) }}" class="btn btn-success w-100" id="file-usulan">
                                    <i class="bi bi-cloud-arrow-down-fill me-2"></i>Lihat dan Download Usulan
                                </a>
                            </div>
                            <div class="col-md-6 col-12 mb-2">
                                <label for="judul" class="fw-bold mb-1">Judul Usulan :</label><br />
                                <input type="text" readonly value="{{ $check_code->judul_usulan }}" class="w-100 form-control" readonly>
                            </div>
                            <div class="col-md-6 col-12 mb-2">
                                <label for="skema" class="fw-bold mb-1">Skema :</label><br />
                                <input type="text" readonly value="{{ \App\Models\Schema::find($check_code->skema)->nama_skema }}" class="w-100 form-control" readonly>
                            </div>
                            <div class="col-md-6 col-12 mb-2">
                                <label for="riset" class="fw-bold mb-1">Riset Unggulan :</label><br />
                                <input type="text" readonly value="{{ \App\Models\SuperiorResearch::find($check_code->riset_unggulan)->nama_riset }}" class="w-100 form-control" readonly>
                            </div>
                            <div class="col-md-6 col-12 mb-2">
                                <label for="tema" class="fw-bold mb-1">Tema :</label><br />
                                <input type="text" readonly value="{{ \App\Models\Theme::find($check_code->tema)->nama_tema }}" class="w-100 form-control" readonly>
                            </div>
                            <div class="col-md-6 col-12 mb-2">
                                <label for="topik" class="fw-bold mb-1">Topik :</label><br />
                                <input type="text" readonly value="{{ \App\Models\Topic::find($check_code->topik)->nama_topik }}" class="w-100 form-control" readonly>
                            </div>
                            <div class="col-md-6 col-12 mb-2">
                                <label for="luaran" class="fw-bold mb-1">Target Luaran :</label><br />
                                <input type="text" readonly value="{{ \App\Models\Outer::find($check_code->target_luaran)->nama_luaran }}" class="w-100 form-control" readonly>
                            </div>
                            <div class="col-md-6 col-12 mb-2">
                                <label for="luaran_tambahan" class="fw-bold mb-1">Target Luaran Tambahan (optional)</label><br />
                                <input type="text" readonly value="{{ $check_code->target_luaran_tambahan }}" class="w-100 form-control" readonly>
                            </div>
                        </div>
                        <h6 class="card-title my-0">6. RAB : </h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" style="font-size: 14px">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Harga Satuan</th>
                                        <th>Volume</th>
                                        <th>Total Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (\App\Models\RabSubmission::where('id_submission', $check_code->id)->get() as $rab)
                                        <tr>
                                            <td>{{ $rab->nama_item }}</td>
                                            <td>{{ $rab->harga }}</td>
                                            <td>{{ $rab->volume }}</td>
                                            <td>{{ $rab->total }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <h6 class="card-title my-0">7. Proposal Usulan :</h6>
                        <div class="row">
                            <div class="col-12 mb-2">
                                <label for="file-usulan" class="fw-bold mb-1">File Usulan :</label><br />
                                @if( $check_code->proposal_usulan )
                                    <a href="{{ asset('assets/storage/files/dokumen-proposal/'.$check_code->proposal_usulan) }}" class="btn btn-success w-100" id="file-usulan">
                                        <i class="bi bi-cloud-arrow-down-fill me-2"></i>Lihat dan Download Proposal
                                    </a>
                                @else
                                    <div class="form-control border border-danger text-danger fw-bold fst-italic text-uppercase text-center">
                                        Belum ada proposal
                                    </div>
                                @endif
                            </div>
                        </div>
                        @if($check_code->status_proposal == 'Pending by Admin')
                            <div class="d-md-flex">
                                <button type="button" onclick="action('menyetujui')" class="btn btn-primary text-white me-2 mb-2"><small>Lanjutkan ke Reviewer</small></button>
                                <button type="button" onclick="action('menolak')" class="btn btn-danger me-2 mb-2 text-white"><small>Tolak</small></button>
                                <button type="button" onclick="action('mengembalikan')" class="btn btn-warning me-2 mb-2 text-white"><small>Kembalikan</small></button>
                            </div>
                        @endif

                        @if($check_code->status_proposal == 'Waiting for SPK')
                            <form method="post" action="{{ route('admin.proposal.spkUpload', ['type' => $type, 'submission_code' => $check_code->submission_code]) }}" enctype="multipart/form-data" class="mt-2">
                                @csrf
                                <label for="spk">Upload SPK disini</label>
                                <input type="file" id="spk" name="spk" required class="form-control mb-1">
                                <button type="submit" class="btn btn-primary text-white me-2 mb-2"><small>Upload dan Setujui</small></button>
                            </form>
                        @endif
                        @if($check_code->status_proposal == 'Waiting for Validation')
                            <div class="d-md-flex">
                                <button type="button" onclick="action('validasi')" class="btn btn-warning text-white me-2 mb-2"><small>Validasi @if( $check_code->second_status == 'Rejected' ) Penolakan @elseif( $check_code->second_status == 'Returned' ) Pengembalian @elseif( $check_code->second_status == 'Approved' ) Persetujuan @endif</small></button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="reviewerSelected" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih reviewer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <label class="col-12 col-form-label" for="reviewer">Pilih reviewer untuk usulan ini <span class="text-danger">*</span></label>
                    <div class="col-12">
                        <select name="reviewer" id="reviewer" class="form-control" required>
                            <option value="" disabled selected>-- Pilih reviewer --</option>
                            @foreach($reviewer as $review)
                                <option value="{{ $review->id }}">{{ $review->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-danger fst-italic" id="error_reviewer"></small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="d-flex">
                    <div class="spinner-border text-primary me-2 d-none" role="status" id="loading-submit-template">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" id="simpan_usulan" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="reviewer-proposal" value="{{ $check_code->review_proposal_by }}">
@endsection
@push('custom_script')

    <script>
        document.getElementById('{{ $type }}-menu').classList.remove('collapsed')
        document.getElementById('{{ $type }}-nav').classList.add('show')
        function action(action){
            if(action === 'menyetujui'){
                if(!$('input[name=reviewer-proposal]').val() || $('input[name=reviewer-proposal]').val() === null || $('input[name=reviewer-proposal]').val() === ''){
                    $('#reviewerSelected').modal('show')
                }
            } else {
                Swal.fire({
                    text: 'Anda yakin ingin '+action+' data ini ?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: "Ya",
                    cancelButtonText: "tidak"
                }).then((result) => {
                    if (result.isConfirmed) {
                        if(action === 'menolak' || action === 'mengembalikan'){
                            Swal.fire({
                                text: "Tulis alasan penolakan atau pengembalian pengajuan",
                                input: "text",
                                showCancelButton: true,
                                confirmButtonText: "Kirim",
                                showLoaderOnConfirm: true,
                                preConfirm: async (text) => {
                                    return text
                                },
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    if(!result.value || result.value === ''){
                                        Swal.fire({
                                            text: 'Harap masukkan alasan penolakan atau pengembalian usulan',
                                            icon: 'error'
                                        });
                                    } else {
                                        $.ajax({
                                            method: 'POST',
                                            data: {
                                                _token: $('meta[name="csrf-token"]').attr('content'),
                                                alasan: result.value
                                            },
                                            url: "aksi/{{$check_code->id}}/"+(action === 'menolak' ? 'Rejected' : (action === 'mengembalikan' ? 'Revised' : 'Approved')),
                                            success: function(response){
                                                console.log(response)
                                                Swal.fire({
                                                    text: response.message,
                                                    icon: 'success'
                                                }).then((res) => {
                                                    document.location.href="{{ route('admin.proposal.index', $check_code->tipe_submission) }}"
                                                });
                                            },
                                            error: function(error) {
                                                console.error(error);
                                            }
                                        })
                                    }
                                }
                            });
                        } else {
                            $.ajax({
                                method: 'POST',
                                data: {
                                    _token: $('meta[name="csrf-token"]').attr('content'),
                                },
                                url: "aksi/{{$check_code->id}}/Validation",
                                success: function(response){
                                    console.log(response)
                                    Swal.fire({
                                        text: response.message,
                                        icon: 'success'
                                    }).then((res) => {
                                        document.location.href="{{ route('admin.proposal.index', $check_code->tipe_submission) }}"
                                    });
                                },
                                error: function(error) {
                                    console.error(error);
                                }
                            })
                        }
                    }
                })
            }
        }
        $('#simpan_usulan').on('click', function(){
            $('#error_reviewer').html('')
            $('#loading-submit-template').removeClass('d-none')
            saveData()
        })

        function saveData(){
            if(!$('input[name=reviewer-proposal]').val() || $('input[name=reviewer-proposal]').val() === null || $('input[name=reviewer-proposal]').val() === ''){
                if(!$('select[name=reviewer]').val()) {
                    $('#loading-submit-template').addClass('d-none')
                    $('#error_reviewer').html('Harap pilih reviewer')
                } else {
                    const formData = {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        reviewer: $('select[name=reviewer]').val()
                    }
                    Swal.fire({
                        text: 'Anda yakin ingin menyetujui data ini ?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: "Ya",
                        cancelButtonText: "tidak"
                    }).then((result) => {
                        $('#loading-submit-template').addClass('d-none')
                        if(result.isConfirmed){
                            $.ajax({
                                method: 'POST',
                                data: formData,
                                url: "aksi/{{$check_code->id}}/Approved",
                                success: function(response){
                                    console.log(response)
                                    Swal.fire({
                                        text: response.message,
                                        icon: 'success'
                                    }).then((res) => {
                                        document.location.href="{{ route('admin.proposal.index', $check_code->tipe_submission) }}"
                                    });
                                },
                                error: function(error) {
                                    console.error(error);
                                }
                            })
                        }
                    })
                }
            }
        }
    </script>

@endpush
