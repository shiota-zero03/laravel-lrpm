@extends('theme.layout')

@section('page', 'Monev')
@section('breadcrumb', $type == 'penelitian' ? 'Penelitian' : 'Pengabdian Masyarakat')
@section('breadcrumbs_sub_page', 'Kode: '.$check_code->submission_code)

@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between pt-4">
                        <a href="{{ route('admin.monev.index', ['type' => $type]) }}" class="btn btn-info text-white"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
                        <a href="{{ route('admin.monev.tracking', ['type' => $type, 'id' => $check_code->id]) }}" class="btn btn-primary">Lihat traking</a>
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
                                <a href="{{ asset('assets/storage/files/dokumen-proposal/'.$check_code->proposal_usulan) }}" class="btn btn-success w-100" id="file-usulan">
                                    <i class="bi bi-cloud-arrow-down-fill me-2"></i>Lihat dan Download Proposal
                                </a>
                            </div>
                        </div>
                        <h6 class="card-title my-0">8. SPK :</h6>
                        <div class="row">
                            <div class="col-12 mb-2">
                                <label for="download-usulan" class="fw-bold mb-1">Download SPK :</label><br />
                                @if(!$check_code->spk_upload)
                                    <a class="btn btn-secondary w-100" id="download-usulan">
                                        <small><em>Belum ada dokumen SPK</em></small>
                                    </a>
                                @else
                                    <a href="{{ asset('assets/storage/files/spk-upload/'.$check_code->spk_upload) }}" class="btn btn-success w-100" id="download-usulan">
                                        <i class="bi bi-cloud-arrow-down-fill me-2"></i>Download SPK
                                    </a>
                                @endif
                            </div>
                        </div>
                        <h6 class="card-title my-0">9. Laporan Akhir :</h6>
                        <div class="row">
                            <div class="col-12 mb-2">
                                <label for="download-usulan" class="fw-bold mb-1">Download Laporan Akhir :</label><br />
                                @if(!$check_code->laporan_akhir)
                                    <a class="btn btn-secondary w-100" id="download-usulan">
                                        <small><em>Belum ada dokumen laporan akhir</em></small>
                                    </a>
                                @else
                                    <a href="{{ asset('assets/storage/files/laporan-akhir/'.$check_code->laporan_akhir) }}" class="btn btn-success w-100" id="download-usulan">
                                        <i class="bi bi-cloud-arrow-down-fill me-2"></i>Download Laporan Akhir
                                    </a>
                                @endif
                            </div>
                        </div>

                        <h6 class="card-title my-0">10. Penilaian Laporan Akhir :</h6>
                        <label for="download-usulan" class="fw-bold mb-1">Download Penilaian Laporan Akhir :</label><br />
                        <a target="__blank" href="{{ route('penilaian.submission', $check_code->id) }}" class="btn btn-primary btn-sm w-100 mb-3">Lihat penilaian laporan akhir</a>

                        <h6 class="card-title my-0">11. PPT Monev :</h6>
                        <div class="row">
                            <div class="col-12 mb-2">
                                <label for="download-usulan" class="fw-bold mb-1">Download PPT Monev :</label><br />
                                @if(!$check_code->ppt_laporan)
                                    <a class="btn btn-secondary w-100" id="download-usulan">
                                        <small><em>Belum ada dokumen PPT Monev</em></small>
                                    </a>
                                @else
                                    <a href="{{ asset('assets/storage/files/ppt-monev/'.$check_code->ppt_laporan) }}" class="btn btn-success w-100" id="download-usulan">
                                        <i class="bi bi-cloud-arrow-down-fill me-2"></i>Download PPT Monev
                                    </a>
                                @endif
                            </div>
                        </div>

                        <h6 class="card-title my-0">12. Penilaian Monev :</h6>
                        <div class="row">
                            <div class="col-12 mb-2">
                                <label for="download-usulan" class="fw-bold mb-1">Download Penilaian :</label><br />
                                @if(!$check_code->dokumen_tambahan_monev)
                                    <a class="btn btn-secondary w-100" id="download-usulan">
                                        <small><em>Belum ada penilaian</em></small>
                                    </a>
                                @else
                                    <a href="{{ asset('assets/storage/files/form-penilaian/'.$check_code->dokumen_tambahan_monev) }}" class="btn btn-success w-100" id="download-usulan">
                                        <i class="bi bi-cloud-arrow-down-fill me-2"></i>Download penilaian
                                    </a>
                                @endif
                            </div>
                            <div class="col-12 mb-2">
                                <label for="komentar" class="fw-bold">Komentar Reviewer :</label>
                                <div class="form-control">{{ $check_code->komentar_reviewer }}</div>
                            </div>
                        </div>


                        @if($check_code->status_monev == 'Pending by Admin')
                            <div class="d-md-flex">
                                <button type="button" onclick="action('menyetujui')" class="btn btn-primary text-white me-2 mb-2"><small>Setujui</small></button>
                                <button type="button" onclick="action('mengembalikan')" class="btn btn-warning me-2 mb-2 text-white"><small>Kembalikan</small></button>
                            </div>
                        @endif
                        @if($check_code->status_monev == 'Waiting for Schedule')
                            <div>
                                <label for=""><b>Tanggal sidang : </b>{{ date('d-m-Y H:i', strtotime($check_code->waktu_sidang)) }}</label></br>
                                <button type="button" onclick="action('gantijadwal')" class="btn btn-warning me-2 my-2 text-white"><small>Ganti tanggal sidang</small></button>
                            </div>
                        @endif
                        @if($check_code->status_monev == 'Waiting for Validation')
                            <div class="d-md-flex">
                                <button type="button" onclick="action('setujui')" class="btn btn-primary me-2 mb-2 text-white"><small>Kirim Komentar ke Pengusul</small></button>
                                <button type="button" onclick="action('to_reviewer')" class="btn btn-warning me-2 mb-2 text-white"><small>Kembalikan ke Reviewer</small></button>
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
                text: 'Anda yakin ingin '+(action === 'to_reviewer' ? ('mengembalikan data ini ke reviewer ?') : (action === 'gantijadwal' ? 'mengganti jadwal sidang ? ' : (action+' data ini ?'))),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "Ya",
                cancelButtonText: "tidak"
            }).then((result) => {
                if (result.isConfirmed) {
                    if(action === 'mengembalikan'){
                        Swal.fire({
                            text: "Tulis alasan pengembalian ppt monev",
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
                                        text: 'Harap masukkan alasan pengembalian usulan',
                                        icon: 'error'
                                    });
                                } else {
                                    $.ajax({
                                        method: 'POST',
                                        data: {
                                            _token: $('meta[name="csrf-token"]').attr('content'),
                                            alasan: result.value
                                        },
                                        url: "aksi/{{$check_code->id}}/Revised",
                                        success: function(response){
                                            console.log(response)
                                            Swal.fire({
                                                text: response.message,
                                                icon: 'success'
                                            }).then((res) => {
                                                document.location.href="{{ route('admin.monev.index', $check_code->tipe_submission) }}"
                                            });
                                        },
                                        error: function(error) {
                                            console.error(error);
                                        }
                                    })
                                }
                            }
                        });
                    } else if(action === 'menyetujui') {
                        Swal.fire({
                            text: "Tulis tanggal pengajuan sidang pengusul",
                            input: "datetime-local",
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
                                        text: 'Harap masukkan tanggal pengajuan sidang',
                                        icon: 'error'
                                    });
                                } else {
                                    $.ajax({
                                        method: 'POST',
                                        data: {
                                            _token: $('meta[name="csrf-token"]').attr('content'),
                                            waktu_sidang: result.value
                                        },
                                        url: "aksi/{{$check_code->id}}/Approved",
                                        success: function(response){
                                            console.log(response)
                                            Swal.fire({
                                                text: response.message,
                                                icon: 'success'
                                            }).then((res) => {
                                                document.location.href="{{ route('admin.monev.index', $check_code->tipe_submission) }}"
                                            });
                                        },
                                        error: function(error) {
                                            Swal.fire({
                                                text: error.responseJSON.message,
                                                icon: 'error'
                                            })
                                        }
                                    })
                                }
                            }
                        })
                    } else if(action === 'gantijadwal') {
                        Swal.fire({
                            text: "Tulis tanggal pengajuan sidang pengusul",
                            input: "datetime-local",
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
                                        text: 'Harap masukkan tanggal pengajuan sidang',
                                        icon: 'error'
                                    });
                                } else {
                                    $.ajax({
                                        method: 'POST',
                                        data: {
                                            _token: $('meta[name="csrf-token"]').attr('content'),
                                            waktu_sidang: result.value
                                        },
                                        url: "aksi/{{$check_code->id}}/Approved",
                                        success: function(response){
                                            console.log(response)
                                            Swal.fire({
                                                text: response.message,
                                                icon: 'success'
                                            }).then((res) => {
                                                document.location.href="{{ route('admin.monev.index', $check_code->tipe_submission) }}"
                                            });
                                        },
                                        error: function(error) {
                                            Swal.fire({
                                                text: error.responseJSON.message,
                                                icon: 'error'
                                            })
                                        }
                                    })
                                }
                            }
                        })
                    } else if(action === 'to_reviewer'){
                        Swal.fire({
                            text: "Tulis alasan pengembalian penilaian",
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
                                        text: 'Harap masukkan alasan pengembalian penilaian',
                                        icon: 'error'
                                    });
                                } else {
                                    $.ajax({
                                        method: 'POST',
                                        data: {
                                            _token: $('meta[name="csrf-token"]').attr('content'),
                                            alasan: result.value
                                        },
                                        url: "aksi/{{$check_code->id}}/ToReviewer",
                                        success: function(response){
                                            console.log(response)
                                            Swal.fire({
                                                text: response.message,
                                                icon: 'success'
                                            }).then((res) => {
                                                document.location.href="{{ route('admin.monev.index', $check_code->tipe_submission) }}"
                                            });
                                        },
                                        error: function(error) {
                                            console.error(error);
                                        }
                                    })
                                }
                            }
                        });
                    } else if(action === 'setujui') {
                        $.ajax({
                            method: 'POST',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                            },
                            url: "aksi/{{$check_code->id}}/Disetujui",
                            success: function(response){
                                console.log(response)
                                Swal.fire({
                                    text: response.message,
                                    icon: 'success'
                                }).then((res) => {
                                    document.location.href="{{ route('admin.monev.index', $check_code->tipe_submission) }}"
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
