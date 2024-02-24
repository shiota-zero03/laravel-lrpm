@extends('pages.dosen.spk.buat-spk.theme')

@section('fase')

<div>
    <form action="" method="post" enctype="multipart/form-data">
        @csrf
        <h6 class="card-title my-0">8. SPK :</h6>
        <div class="row">
            <div class="col-md-4 col-12 mb-2">
                <label class="fw-bold mb-1">SPK :</label><br />
                @if(!$check_code->spk_download || $check_code->spk_download == null)
                    <a class="btn btn-danger w-100">
                        <small><em>Belum ada dokumen spk</em></small>
                    </a>
                @else
                    <a href="{{ asset('assets/storage/files/spk-download/'.$check_code->spk_download) }}" target="__blank" class="btn btn-warning text-white w-100">
                        <i class="bi bi-file-earmark-fill me-2"></i> SPK
                    </a>
                @endif
            </div>
            <div class="col-md-4 col-12 mb-2">
                <label for="spk" class="fw-bold mb-1">Upload SPK <span class="text-danger">*</span> :</label><br />
                <input accept=".doc, .docx, .pdf" type="file" id="spk" name="spk" class="form-control" @if(!$check_code->spk_upload) required @endif>
            </div>
            <div class="col-md-4 col-12 mb-2">
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
        <div class="d-md-flex">
            <a href="?page=1" class="btn btn-info text-white me-2 mb-2"><small>Sebelumnya</small></a>
            <a href="{{ route('dosen.spk.index', $type) }}" class="btn btn-warning text-white me-2 mb-2"><small>Draft</small></a>
            <button type="submit" class="btn btn-primary me-2 mb-2"><small>Selanjutnya</small></button>
            <div class="spinner-border text-primary me-2 mb-2 d-none" role="status" id="loading-submit">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </form>
</div>

@endsection
@push('custom_script')
<script>
    $('#inner-1').addClass('active')
    $('#inner-2').addClass('active')
</script>

@endpush
