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
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('reviewer.proposal.index', ['type' => $type]) }}" class="btn btn-info text-white"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
                        <a href="{{ route('reviewer.proposal.tracking', ['type' => $type, 'id' => $check_code->id]) }}" class="btn btn-primary">Lihat traking</a>
                    </div>
                    <div>
                        <h5 class="card-title my-0 fw-bold">Kode Pengajuan : {{ $check_code->submission_code }}</h5>
                        <h6 class="card-title my-0">1. Proposal Usulan :</h6>
                        <div class="row">
                            <div class="col-12 mb-2">
                                <label for="file-usulan" class="fw-bold mb-1">File Usulan :</label><br />
                                <a href="{{ asset('assets/storage/files/dokumen-proposal/'.$check_code->proposal_usulan) }}" class="btn btn-success w-100" id="file-usulan">
                                    <i class="bi bi-cloud-arrow-down-fill me-2"></i>Lihat dan Download Proposal
                                </a>
                            </div>
                        </div>
                        @if($check_code->status_proposal == 'Pending by Reviewer')
                            <div class="file_upload mb-3">
                                <label for="file_upload">Upload file pendukung</label>
                                <input type="file" name="file_upload" class="form-control" id="file_upload">
                            </div>
                            <div class="d-md-flex">
                                <button type="button" onclick="action('menyetujui')" class="btn btn-primary text-white me-2 mb-2"><small>Lanjutkan ke Admin</small></button>
                                <button type="button" onclick="action('menolak')" class="btn btn-danger me-2 mb-2 text-white"><small>Tolak</small></button>
                                <button type="button" onclick="action('mengembalikan')" class="btn btn-warning me-2 mb-2 text-white"><small>Kembalikan</small></button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('custom_script')

    <script>
        document.getElementById('{{ $type }}-menu').classList.remove('collapsed')
        document.getElementById('{{ $type }}-nav').classList.add('show')
        function action(action){
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
                                    var dataSend = new FormData();

                                    dataSend.append('_token', $('meta[name="csrf-token"]').attr('content'));
                                    dataSend.append('alasan', result.value);
                                    dataSend.append('dokumen_tambahan_usulan', $('#file_upload').prop('files')[0]);

                                    $.ajax({
                                        method: 'POST',
                                        data: dataSend,
                                        contentType: false,
                                        processData:false,
                                        url: "aksi/{{$check_code->id}}/"+(action === 'menolak' ? 'Rejected' : (action === 'mengembalikan' ? 'Revised' : 'Approved')),
                                        success: function(response){
                                            console.log(response)
                                            Swal.fire({
                                                text: response.message,
                                                icon: 'success'
                                            }).then((res) => {
                                                document.location.href="{{ route('reviewer.proposal.index', $check_code->tipe_submission) }}"
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
                        var dataSend = new FormData();

                        dataSend.append('_token', $('meta[name="csrf-token"]').attr('content'));
                        dataSend.append('dokumen_tambahan_usulan', $('#file_upload').prop('files')[0]);

                        $.ajax({
                            method: 'POST',
                            contentType: false,
                            processData:false,
                            data: dataSend,
                            url: "aksi/{{$check_code->id}}/Approved",
                            success: function(response){
                                console.log(response)
                                Swal.fire({
                                    text: response.message,
                                    icon: 'success'
                                }).then((res) => {
                                    document.location.href="{{ route('reviewer.proposal.index', $check_code->tipe_submission) }}"
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
    </script>

@endpush
