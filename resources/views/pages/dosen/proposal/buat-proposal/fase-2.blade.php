@extends('pages.dosen.proposal.buat-proposal.theme')

@section('fase')

<div>
    <h6 class="card-title my-0">7. Formulir Usulan :</h6>
    <div class="row">
        <div class="col-md-4 col-12 mb-2">
            <label class="fw-bold mb-1">Template Usulan :</label><br />
            @php
                $form = \App\Models\TemplateDocument::where('nama_template', 'Proposal')->first();
            @endphp
            @if(!$form->dokumen_template || $form->dokumen_template == null)
                <a class="btn btn-danger w-100">
                    <small><em>Belum ada dokumen proposal</em></small>
                </a>
            @else
                <a href="{{ asset('assets/storage/files/dokumen-template/'.$form->dokumen_template) }}" target="__blank" class="btn btn-warning text-white w-100">
                    <i class="bi bi-file-earmark-fill me-2"></i> Template {{ $form->nama_template }}
                </a>
            @endif
        </div>
        <div class="col-md-4 col-12 mb-2">
            <label for="upload-usulan" class="fw-bold mb-1">Upload Proposal <span class="text-danger">*</span> :</label><br />
            <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#dokumenUsulanModal">
                <i class="bi bi-cloud-arrow-up-fill me-2"></i>Upload/Ganti Proposal
            </button>
            <small class="text-danger fst-italic" id="error_dokumen"></small>
        </div>
        <div class="col-md-4 col-12 mb-2">
            <label for="download-usulan" class="fw-bold mb-1">Download Proposal :</label><br />
            @if(!$check_code->proposal_usulan)
                <a class="btn btn-secondary w-100" id="download-usulan">
                    <small><em>Belum ada dokumen proposal</em></small>
                </a>
            @else
                <a href="{{ asset('assets/storage/files/dokumen-proposal/'.$check_code->proposal_usulan) }}" class="btn btn-success w-100" id="download-usulan">
                    <i class="bi bi-cloud-arrow-down-fill me-2"></i>Download Proposal
                </a>
            @endif
        </div>
    </div>
    <div class="d-md-flex">
        <a href="?page=1" class="btn btn-info text-white me-2 mb-2"><small>Sebelumnya</small></a>
        <a href="{{ route('dosen.proposal.index', $type) }}" class="btn btn-warning text-white me-2 mb-2"><small>Draft</small></a>
        <button onclick="nextPart()" class="btn btn-primary me-2 mb-2"><small>Selanjutnya</small></button>
        <div class="spinner-border text-primary me-2 mb-2 d-none" role="status" id="loading-submit">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>

<div class="modal fade" id="dokumenUsulanModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Data Dokumen Proposal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form enctype="multipart/form-data" action="{{ route('dosen.proposal.update', ['type' => $type, 'submission_code' => $check_code->submission_code]) }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label" for="upload_dokumen_template">Upload Dokumen <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input required type="file" class="form-control" name="upload_dokumen_template" id="upload_dokumen_template" accept=".doc, .docx, .pdf">
                            <div class="col-12"><small id="error_upload_dokumen_template" class="text-danger fst-italic"></small></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex">
                        <div class="spinner-border text-primary me-2 d-none" role="status" id="loading-submit-template">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" id="simpan_template" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<input type="hidden" value="{{ $check_code->proposal_usulan ? $check_code->proposal_usulan : 0 }}" id="proposal-usulan-check">
@endsection
@push('custom_script')
<script>
    $('#inner-1').addClass('active')
    $('#inner-2').addClass('active')
    function nextPart()
    {
        if($('#proposal-usulan-check').val() === '0'){
            $('#error_dokumen').html('Upload proposal terlebih dahulu')
        } else {
            document.location.href="?page=3"
        }
    }
</script>

@endpush
