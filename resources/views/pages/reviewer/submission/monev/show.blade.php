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
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('reviewer.monev.index', ['type' => $type]) }}" class="btn btn-info text-white"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
                        <a href="{{ route('reviewer.monev.tracking', ['type' => $type, 'id' => $check_code->id]) }}" class="btn btn-primary">Lihat traking</a>
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
                        <h6 class="card-title my-0">2. Laporan Akhir :</h6>
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
                        <h6 class="card-title my-0">3. Penilaian :</h6>
                        <label for="download-usulan" class="fw-bold mb-1">Download Penilaian :</label><br />
                        <a target="__blank" href="{{ route('penilaian.submission', $check_code->id) }}" class="btn btn-primary btn-sm w-100">Lihat penilaian laporan akhir</a>
                        <h6 class="card-title my-0">4. PPT Monev :</h6>
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
                        <form method="post" action="" enctype="multipart/form-data">
                            @csrf
                            <h6 class="card-title my-0">5. Penilaian Monev :</h6>
                            <div class="row">
                                @if($check_code->status_monev == 'Waiting for Schedule')
                                    <div class="col-md-4 col-12 mb-2">
                                        <label class="fw-bold mb-1">Template Form Penilaian :</label><br />
                                        @php
                                            $fti = ['FTI', 'FAKULTAS TEKNIK DAN INFORMATIKA', 'FAKULTAS TEKNIK DAN INFORMATIKA (FTI)'];
                                            $fbis = ['FBIS', 'FAKULTAS BISNIS DAN ILMU SOSIAL', 'FAKULTAS BISNIS DAN ILMU SOSIAL (FBIS)'];
                                            $find_user = \App\Models\User::find($check_code->id_pengaju);
                                            $fakultas_user = \App\Models\Faculty::find($find_user->fakultas);
                                            if( in_array(strtoupper($fakultas_user->nama_fakultas), $fti) ) $form = \App\Models\TemplateDocument::where('nama_template', 'Form Penilaian FTI')->first();
                                            elseif( in_array(strtoupper($fakultas_user->nama_fakultas), $fbis) ) $form = \App\Models\TemplateDocument::where('nama_template', 'Form Penilaian FBIS')->first();
                                        @endphp
                                        @if(!$form->dokumen_template || $form->dokumen_template == null)
                                            <a class="btn btn-danger w-100">
                                                <small><em>Belum ada ppt monev</em></small>
                                            </a>
                                        @else
                                            <a href="{{ asset('assets/storage/files/dokumen-template/'.$form->dokumen_template) }}" target="__blank" class="btn btn-warning text-white w-100">
                                                <i class="bi bi-file-earmark-fill me-2"></i> Template {{ $form->nama_template }}
                                            </a>
                                        @endif
                                    </div>
                                    <div class="col-md-4 col-12 mb-2">
                                        <label for="penilaian" class="fw-bold mb-1">Upload Penilaian <span class="text-danger">*</span> :</label><br />
                                        <input accept=".doc, .docx, .ppt" type="file" id="penilaian" name="penilaian" class="form-control" required>
                                    </div>
                                @elseif($check_code->status_monev == 'Returned to Reviewer')
                                    <div class="col-md-4 col-12 mb-2">
                                        <label class="fw-bold mb-1">Template Form Penilaian :</label><br />
                                        @php
                                            $fti = ['FTI', 'FAKULTAS TEKNIK DAN INFORMATIKA', 'FAKULTAS TEKNIK DAN INFORMATIKA (FTI)'];
                                            $fbis = ['FBIS', 'FAKULTAS BISNIS DAN ILMU SOSIAL', 'FAKULTAS BISNIS DAN ILMU SOSIAL (FBIS)'];
                                            $find_user = \App\Models\User::find($check_code->id_pengaju);
                                            $fakultas_user = \App\Models\Faculty::find($find_user->fakultas);
                                            if( in_array(strtoupper($fakultas_user->nama_fakultas), $fti) ) $form = \App\Models\TemplateDocument::where('nama_template', 'Form Penilaian FTI')->first();
                                            elseif( in_array(strtoupper($fakultas_user->nama_fakultas), $fbis) ) $form = \App\Models\TemplateDocument::where('nama_template', 'Form Penilaian FBIS')->first();
                                        @endphp
                                        @if(!$form->dokumen_template || $form->dokumen_template == null)
                                            <a class="btn btn-danger w-100">
                                                <small><em>Belum ada ppt monev</em></small>
                                            </a>
                                        @else
                                            <a href="{{ asset('assets/storage/files/dokumen-template/'.$form->dokumen_template) }}" target="__blank" class="btn btn-warning text-white w-100">
                                                <i class="bi bi-file-earmark-fill me-2"></i> Template {{ $form->nama_template }}
                                            </a>
                                        @endif
                                    </div>
                                    <div class="col-md-4 col-12 mb-2">
                                        <label for="penilaian" class="fw-bold mb-1">Upload Penilaian <span class="text-danger">*</span> :</label><br />
                                        <input accept=".doc, .docx, .ppt" type="file" id="penilaian" name="penilaian" class="form-control" required>
                                    </div>
                                @endif
                                <div class="@if($check_code->status_monev == 'Waiting for Schedule' || $check_code->status_monev == 'Returned to Reviewer') col-md-4 @else col-12 @endif col-12 mb-2">
                                    <label for="download-usulan" class="fw-bold mb-1">Download Penilaian :</label><br />
                                    @if(!$check_code->dokumen_tambahan_monev)
                                        <a class="btn btn-secondary w-100" id="download-usulan">
                                            <small><em>Belum ada penilaian</em></small>
                                        </a>
                                    @else
                                        <a href="{{ asset('assets/storage/files/form-penilaian/'.$check_code->dokumen_tambahan_monev) }}" class="btn btn-success w-100" id="download-usulan">
                                            <i class="bi bi-cloud-arrow-down-fill me-2"></i>@if($check_code->status_monev == 'Returned to Reviewer')Lihat penilaian sebelumnya @else Download penilaian @endif
                                        </a>
                                    @endif
                                </div>
                                <div class="col-12 mb-2">
                                    <label for="komentar" class="fw-bold">Komentar Reviewer :</label>
                                    <textarea name="komentar" id="komentar" class="form-control border border-dark" required @if($check_code->status_monev !== 'Waiting for Schedule') @if($check_code->status_monev !== 'Returned to Reviewer') readonly @endif  @endif rows="5">{{ $check_code->komentar_reviewer }}</textarea>
                                </div>
                            </div>
                            @if($check_code->status_monev == 'Waiting for Schedule' || $check_code->status_monev == 'Returned to Reviewer')
                                <div class="d-md-flex">
                                    <button class="btn btn-primary">Simpan</button>
                                </div>
                            @endif
                        </form>
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
