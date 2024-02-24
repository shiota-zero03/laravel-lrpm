@extends('theme.layout')

@section('page', 'Publikasi')
@section('breadcrumb', $type == 'penelitian' ? 'Penelitian' : 'Pengabdian Masyarakat')
@section('breadcrumbs_sub_page', 'Kode: '.$check_code->submission_code)

@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between pt-4">
                        <a href="{{ route('prodi.publikasi.index', ['type' => $type]) }}" class="btn btn-info text-white"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
                        <a href="{{ route('prodi.publikasi.tracking', ['type' => $type, 'id' => $check_code->id]) }}" class="btn btn-primary">Lihat traking</a>
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
                        <h6 class="card-title my-0">10. Penilaian laporan akhir :</h6>
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
                                <label for="komentar" class="fw-bold">Komentar Reviewer :</label>
                                <div class="form-control">{{ $check_code->komentar_reviewer }}</div>
                            </div>
                        </div>
                        <h6 class="card-title my-0">13. Penilaian laporan final :</h6>
                        <a target="__blank" href="{{ route('penilaian.final.submission', $check_code->id) }}" class="btn btn-primary btn-sm w-100 mb-3">Lihat penilaian laporan final</a>
                        <h6 class="card-title my-0">14. Detail Publikasi :</h6>
                        <div class="row">
                            <div class="mb-2 form-group col-md-6">
                                <label for="luaran_publikasi" class="fw-bold mb-1">Target Luaran</label>
                                <input type="text" readonly value="{{ $check_code->luaran_publikasi }}" class="w-100 form-control" readonly>
                            </div>
                            <div class="mb-2 form-group col-md-6">
                                <label for="nama_jurnal" class="fw-bold mb-1">Judul Publikasi</label>
                                <input type="text" readonly value="{{ $check_code->judul_publikasi }}" class="w-100 form-control" readonly>
                            </div>
                            <div class="mb-2 form-group col-md-6">
                                <label for="nama_jurnal" class="fw-bold mb-1">Nama Jurnal</label>
                                <input type="text" readonly value="{{ $check_code->nama_jurnal }}" class="w-100 form-control" readonly>
                            </div>
                            <div class="mb-2 form-group col-md-6">
                                <label for="link_jurnal" class="fw-bold mb-1">Link Jurnal</label>
                                <input type="text" readonly value="{{ $check_code->link_jurnal }}" class="w-100 form-control" readonly>
                            </div>
                            <div class="col-12">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Status</th>
                                            <th>Dokumen View</th>
                                            <th>Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Submit</td>
                                            <td>
                                                @if($check_code->dokumen_submit)
                                                    <a target="__blank" class="btn btn-primary" href="{{ asset('assets/storage/files/publikasi/submit/'.$check_code->dokumen_submit) }}">Lihat Dokumen Submit Anda</a>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="text" readonly class="form-control" name="tanggal_submit" value="{{ $check_code->tanggal_submit }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Revision</td>
                                            <td>
                                                @if($check_code->dokumen_revision)
                                                    <a target="__blank" class="btn btn-primary" href="{{ asset('assets/storage/files/publikasi/revision/'.$check_code->dokumen_revision) }}">Lihat Dokumen Revision Anda</a>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="text" readonly class="form-control" name="tanggal_revision" value="{{ $check_code->tanggal_revision }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Accepted</td>
                                            <td>
                                                @if($check_code->dokumen_accepted)
                                                    <a target="__blank" class="btn btn-primary" href="{{ asset('assets/storage/files/publikasi/accepted/'.$check_code->dokumen_accepted) }}">Lihat Dokumen Accepted Anda</a>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="text" readonly class="form-control" name="tanggal_accepted" value="{{ $check_code->tanggal_accepted }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Publish</td>
                                            <td>
                                                @if($check_code->dokumen_publish)
                                                    <a target="__blank" class="btn btn-primary" href="{{ asset('assets/storage/files/publikasi/publish/'.$check_code->dokumen_publish) }}">Lihat Dokumen Publish Anda</a>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="text" readonly class="form-control" name="tanggal_publish" value="{{ $check_code->tanggal_publish }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Rejected</td>
                                            <td>
                                                @if($check_code->dokumen_rejected)
                                                    <a target="__blank" class="btn btn-primary" href="{{ asset('assets/storage/files/publikasi/rejected/'.$check_code->dokumen_rejected) }}">Lihat Dokumen Rejected Anda</a>
                                                @endif
                                            </td>
                                            <td>
                                                <input type="text" readonly class="form-control" name="tanggal_rejected" value="{{ $check_code->tanggal_rejected }}">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
    </script>

@endpush
