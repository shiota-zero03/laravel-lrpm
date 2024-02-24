@extends('theme.layout')

@section('page', 'Usulan Baru')
@section('breadcrumb', 'Usulan Baru')
@section('breadcrumbs_sub_page', 'Kode: '.$check_code->submission_code)

@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div>
                        <div class="d-flex justify-content-between mt-3">
                            <a href="{{ route('dosen.usulan-baru.index', ['type' => $type]) }}" class="btn btn-info text-white"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
                            <a href="{{ route('dosen.usulan-baru.show', ['type' => $type, 'id' => $check_code->id]) }}" class="btn btn-primary">Lihat traking</a>
                        </div>
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
                                @if( $check_code->dokumen_usulan )
                                    <a href="{{ asset('assets/storage/files/dokumen-usulan/'.$check_code->dokumen_usulan) }}" class="btn btn-success w-100" id="file-usulan">
                                        <i class="bi bi-cloud-arrow-down-fill me-2"></i>Lihat dan Download Usulan
                                    </a>
                                @else
                                    <div class="form-control border border-danger text-danger fw-bold fst-italic text-uppercase text-center">
                                        Belum ada file usulan
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6 col-12 mb-2">
                                <label for="judul" class="fw-bold mb-1">Judul Usulan :</label><br />
                                <input type="text" readonly value="{{ $check_code->judul_usulan ? $check_code->judul_usulan : 'Belum ada judul usulan' }}" class="w-100 form-control" readonly>
                            </div>
                            <div class="col-md-6 col-12 mb-2">
                                <label for="skema" class="fw-bold mb-1">Skema :</label><br />
                                <input type="text" readonly value="{{ $check_code->skema ? \App\Models\Schema::find($check_code->skema)->nama_skema : 'Belum ada skema' }}" class="w-100 form-control" readonly>
                            </div>
                            <div class="col-md-6 col-12 mb-2">
                                <label for="riset" class="fw-bold mb-1">Riset Unggulan :</label><br />
                                <input type="text" readonly value="{{ $check_code->riset_unggulan ? \App\Models\SuperiorResearch::find($check_code->riset_unggulan)->nama_riset : 'Belum ada riset unggulan' }}" class="w-100 form-control" readonly>
                            </div>
                            <div class="col-md-6 col-12 mb-2">
                                <label for="tema" class="fw-bold mb-1">Tema :</label><br />
                                <input type="text" readonly value="{{ $check_code->tema ? \App\Models\Theme::find($check_code->tema)->nama_tema : 'Belum ada tema' }}" class="w-100 form-control" readonly>
                            </div>
                            <div class="col-md-6 col-12 mb-2">
                                <label for="topik" class="fw-bold mb-1">Topik :</label><br />
                                <input type="text" readonly value="{{ $check_code->topik ? \App\Models\Topic::find($check_code->topik)->nama_topik : 'Belum ada topik' }}" class="w-100 form-control" readonly>
                            </div>
                            <div class="col-md-6 col-12 mb-2">
                                <label for="luaran" class="fw-bold mb-1">Target Luaran :</label><br />
                                <input type="text" readonly value="{{ $check_code->target_luaran ? \App\Models\Outer::find($check_code->target_luaran)->nama_luaran : 'Belum ada target luaran' }}" class="w-100 form-control" readonly>
                            </div>
                            <div class="col-md-6 col-12 mb-2">
                                <label for="luaran_tambahan" class="fw-bold mb-1">Target Luaran Tambahan (optional)</label><br />
                                <input type="text" readonly value="{{ $check_code->target_luaran_tambahan ? $check_code->target_luaran_tambahan : 'Tidak ada target luaran tambahan' }}" class="w-100 form-control" readonly>
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
                                    @if(\App\Models\RabSubmission::where('id_submission', $check_code->id)->get()->count() > 0)
                                        @foreach (\App\Models\RabSubmission::where('id_submission', $check_code->id)->get() as $rab)
                                            <tr>
                                                <td>{{ $rab->nama_item }}</td>
                                                <td>{{ $rab->harga }}</td>
                                                <td>{{ $rab->volume }}</td>
                                                <td>{{ $rab->total }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center"><small><em>Tidak ada data rab</em></small></td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('custom_script')

@endpush
