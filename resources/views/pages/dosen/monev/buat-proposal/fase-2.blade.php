@extends('pages.dosen.monev.buat-proposal.theme')

@section('fase')

<div>
    <form action="" method="post" enctype="multipart/form-data">
        @csrf
        <h6 class="card-title my-0">9. Laporan Akhir :</h6>
        <div class="row">
            <div class="col-md-4 col-12 mb-2">
                <label class="fw-bold mb-1">Template PPT Monev :</label><br />
                @php
                    $form = \App\Models\TemplateDocument::where('nama_template', 'PPT Monev')->first();
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
                <label for="ppt_monev" class="fw-bold mb-1">Upload PPT <span class="text-danger">*</span> :</label><br />
                <input accept=".ppt, .pptx" type="file" id="ppt_monev" name="ppt_monev" class="form-control" @if(!$check_code->ppt_laporan) required @endif>
            </div>
            <div class="col-md-4 col-12 mb-2">
                <label for="download-usulan" class="fw-bold mb-1">Download PPT :</label><br />
                @if(!$check_code->ppt_laporan)
                    <a class="btn btn-secondary w-100" id="download-usulan">
                        <small><em>Belum ada ppt monev</em></small>
                    </a>
                @else
                    <a href="{{ asset('assets/storage/files/laporan-akhir/'.$check_code->ppt_laporan) }}" class="btn btn-success w-100" id="download-usulan">
                        <i class="bi bi-cloud-arrow-down-fill me-2"></i>Download PPT
                    </a>
                @endif
            </div>
        </div>
        <div class="d-md-flex">
            <a href="?page=1" class="btn btn-info text-white me-2 mb-2"><small>Sebelumnya</small></a>
            <a href="{{ route('dosen.monev.index', $type) }}" class="btn btn-warning text-white me-2 mb-2"><small>Draft</small></a>
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
