@extends('pages.dosen.usulan-baru.buat-usulan.theme')

@section('fase')

<div>
    <h6 class="card-title my-0">5. Formulir Usulan :</h6>
    <div class="row">
        <div class="col-md-4 col-12 mb-2">
            <label class="fw-bold mb-1">Template Usulan :</label><br />
            @php
                $form = \App\Models\TemplateDocument::where('nama_template', 'formulir usulan')->first();
            @endphp
            @if(!$form->dokumen_template || $form->dokumen_template == null)
                <a class="btn btn-danger w-100">
                    <small><em>Belum ada dokumen template</em></small>
                </a>
            @else
                <a href="{{ asset('assets/storage/files/dokumen-template/'.$form->dokumen_template) }}" target="__blank" class="btn btn-warning text-white w-100">
                    <i class="bi bi-file-earmark-fill me-2"></i> Template {{ $form->nama_template }}
                </a>
            @endif
        </div>
        <div class="col-md-4 col-12 mb-2">
            <label for="upload-usulan" class="fw-bold mb-1">Upload Usulan <span class="text-danger">*</span> :</label><br />
            <button class="btn btn-primary w-100" id="upload-usulan">
                <i class="bi bi-cloud-arrow-up-fill me-2"></i>Upload/Ganti Usulan
            </button>
            <small class="text-danger fst-italic" id="error_dokumen"></small>
        </div>
        <div class="col-md-4 col-12 mb-2">
            <label for="download-usulan" class="fw-bold mb-1">Download Usulan :</label><br />
            @if(!$check_code->dokumen_usulan)
                <a class="btn btn-secondary w-100" id="download-usulan">
                    <small><em>Belum ada dokumen usulan</em></small>
                </a>
            @else
                <a href="{{ asset('assets/storage/files/dokumen-usulan/'.$check_code->dokumen_usulan) }}" class="btn btn-success w-100" id="download-usulan">
                    <i class="bi bi-cloud-arrow-down-fill me-2"></i>Download Usulan
                </a>
            @endif
        </div>
        <div class="col-12 mb-2">
            <label for="judul" class="fw-bold mb-1">Judul Usulan <span class="text-danger">*</span></label><br />
            <input value="{{ $check_code->judul_usulan }}" type="text" name="judul" id="judul" class="form-control" placeholder="judul usulan baru">
            <small class="text-danger fst-italic" id="error_judul"></small>
        </div>
        <div class="col-md-6 col-12 mb-2">
            <label for="skema" class="fw-bold mb-1">Skema <span class="text-danger">*</span></label><br />
            <select name="skema" id="skema" class="form-control">
                <option value="" disabled selected>-- Pilih skema --</option>
                @foreach(\App\Models\Schema::all() as $skema)
                    <option @if($check_code->skema == $skema->id) selected @endif value="{{ $skema->id }}">{{ $skema->nama_skema }}</option>
                @endforeach
            </select>
            <small class="text-danger fst-italic" id="error_skema"></small>
        </div>
        <div class="col-md-6 col-12 mb-2">
            <label for="riset" class="fw-bold mb-1">Riset Unggulan <span class="text-danger">*</span></label><br />
            <select name="riset" id="riset" class="form-control">
                <option value="" disabled selected>-- Pilih riset --</option>
                @foreach(\App\Models\SuperiorResearch::all() as $riset)
                    <option @if($check_code->riset_unggulan == $riset->id) selected @endif value="{{ $riset->id }}">{{ $riset->nama_riset }}</option>
                @endforeach
            </select>
            <small class="text-danger fst-italic" id="error_riset"></small>
        </div>
        <div class="col-md-6 col-12 mb-2">
            <label for="tema" class="fw-bold mb-1">Tema <span class="text-danger">*</span></label><br />
            <select name="tema" id="tema" class="form-control">
                {{-- <option value="" disabled selected>-- Pilih tema --</option>
                @foreach(\App\Models\Theme::all() as $tema)
                    <option @if($check_code->tema == $tema->id) selected @endif value="{{ $tema->id }}">{{ $tema->nama_tema }}</option>
                @endforeach --}}
            </select>
            <small class="text-danger fst-italic" id="error_tema"></small>
        </div>
        <div class="col-md-6 col-12 mb-2">
            <label for="topik" class="fw-bold mb-1">Topik <span class="text-danger">*</span></label><br />
            <select name="topik" id="topik" class="form-control">
                {{-- <option value="" disabled selected>-- Pilih topik --</option>
                @foreach(\App\Models\Topic::all() as $topik)
                    <option @if($check_code->topik == $topik->id) selected @endif value="{{ $topik->id }}">{{ $topik->nama_topik }}</option>
                @endforeach --}}
            </select>
            <small class="text-danger fst-italic" id="error_topik"></small>
        </div>
        <div class="col-md-6 col-12 mb-2">
            <label for="luaran" class="fw-bold mb-1">Target Luaran <span class="text-danger">*</span></label><br />
            <select name="luaran" id="luaran" class="form-control">
                <option value="" disabled selected>-- Pilih luaran --</option>
                @foreach(\App\Models\Outer::all() as $luaran)
                    <option @if($check_code->target_luaran == $luaran->id) selected @endif value="{{ $luaran->id }}">{{ $luaran->nama_luaran }}</option>
                @endforeach
            </select>
            <small class="text-danger fst-italic" id="error_luaran"></small>
        </div>
        <div class="col-md-6 col-12 mb-2">
            <label for="luaran_tambahan" class="fw-bold mb-1">Target Luaran Tambahan (optional)</label><br />
            <input  value="{{ $check_code->target_luaran_tambahan }}" type="text" id="luaran_tambahan" class="form-control" name="luaran_tambahan">
            <small class="text-danger fst-italic" id="error_luaran_tambahan"></small>
        </div>
    </div>
    <div class="d-md-flex">
        <button onclick="saveForm('prev')" class="btn btn-info text-white me-2 mb-2"><small>Sebelumnya</small></button>
        <button onclick="saveForm('draft')" class="btn btn-warning me-2 mb-2 text-white"><small>Jadikan Draft</small></button>
        <button onclick="saveForm('next')" class="btn btn-primary me-2 mb-2"><small>Selanjutnya</small></button>
        <div class="spinner-border text-primary me-2 mb-2 d-none" role="status" id="loading-submit">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>

<div class="modal fade" id="dokumenUsulanModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Data Dokumen Usulan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label" for="upload_dokumen_template">Upload Dokumen <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="file" class="form-control" name="upload_dokumen_template" id="upload_dokumen_template" accept=".doc, .docx, .pdf">
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
                    <button type="button" id="simpan_template" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="get_riset" value="{{ $check_code->riset_unggulan }}">
<input type="hidden" id="get_tema" value="{{ $check_code->tema }}">
<input type="hidden" id="get_topik" value="{{ $check_code->topik }}">
@endsection
@push('custom_script')
<script>
    $('#inner-1').addClass('active')
    $('#inner-2').addClass('active')
    const submission_code = $('#submission_code').val();
    $('#upload-usulan').on('click', function(){
        $('#loading-submit-template').addClass('d-none');
        $('#upload_dokumen_template').val('');
        $('#error_upload_dokumen_template').html('');
        $('#dokumenUsulanModal').modal('show');
    })
    $('#simpan_template').on('click', function(){
        $('#loading-submit-template').removeClass('d-none');
        if(!$('#upload_dokumen_template').prop('files')[0]) {
            $('#error_upload_dokumen_template').html('Dokumen template tidak boleh kosong');
            $('#loading-submit-template').addClass('d-none');
        } else {
            var formData = new FormData();

            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
            formData.append('dokumen_usulan', $('#upload_dokumen_template').prop('files')[0]);

            $.ajax({
                method: 'POST',
                url: submission_code+"/store/upload-dokumen/store",
                data: formData,
                contentType: false,
                processData:false,
                success: function(response){
                    $('#loading-submit-template').addClass('d-none');
                    location.reload()
                },
                error: function(error){
                    $('#loading-submit-template').addClass('d-none');
                }
            })
        }
    })
    function saveForm(event) {
        $('#loading-submit').removeClass('d-none')

        $('#error_judul').html('');
        $('#error_skema').html('');
        $('#error_riset').html('');
        $('#error_tema').html('');
        $('#error_topik').html('');
        $('#error_luaran').html('');
        $('#error_luaran_tambahan').html('');

        const formData = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            dokumen_usulan: "{{ $check_code->dokumen_usulan }}",
            judul_usulan: $('#judul').val(),
            skema: $('#skema').val(),
            riset_unggulan: $('#riset').val(),
            tema: $('#tema').val(),
            topik: $('#topik').val(),
            target_luaran: $('#luaran').val(),
            target_luaran_tambahan: $('#luaran_tambahan').val()
        }
        $.ajax({
            method: 'POST',
            url: submission_code+"/store/fase-2/"+event,
            data: formData,
            success: function(response){
                $('#loading-submit').addClass('d-none')
                if(event === 'next'){
                    document.location.href="?page="+response.data.page
                } else if(event === 'prev') {
                    document.location.href="?page=1"
                } else if(event === 'draft') {
                    document.location.href="{{ route('dosen.usulan-baru.index', $type) }}"
                }
            },
            error: function(error){
                console.error(error);
                if(error.status === 422) {
                    const errorResponse = error.responseJSON.errors
                    if(errorResponse['dokumen_usulan']) $('#error_dokumen').html(errorResponse['dokumen_usulan'][0]);
                    if(errorResponse['judul_usulan']) $('#error_judul').html(errorResponse['judul_usulan'][0]);
                    if(errorResponse['skema']) $('#error_skema').html(errorResponse['skema'][0]);
                    if(errorResponse['riset_unggulan']) $('#error_riset').html(errorResponse['riset_unggulan'][0]);
                    if(errorResponse['tema']) $('#error_tema').html(errorResponse['tema'][0]);
                    if(errorResponse['topik']) $('#error_topik').html(errorResponse['topik'][0]);
                    if(errorResponse['target_luaran']) $('#error_luaran').html(errorResponse['target_luaran'][0]);
                }
                $('#loading-submit').addClass('d-none')
            }
        })
    }
    $('#riset').on('change', function(){
        getTema($(this).val(), 0)
        getTopic(null, 0)
    })
    $('#tema').on('change', function(){
        getTopic($(this).val(), 0)
    })
    function getTema(id, tema){
        if(id === null || !id || id === '') {
            $('#tema').empty()
            $('#tema').append('<option value="" disabled selected>-- Pilih tema --</option>');
        } else {
            $.ajax({
                url: '/tema/riset/'+id,
                method: 'GET',
                success: function(response){
                    $('#tema').empty()
                    $('#tema').append('<option value="" disabled selected>-- Pilih tema --</option>');

                    $.each(response.data, function (index, item) {
                        $('#tema').append('<option value="' + item.id + '">' + item.nama_tema + '</option>');
                    });
                    if(id === null){
                        $('#tema').val('');
                    } else {
                        if(!tema || tema === 0 || tema === ''){
                            $('#tema').val('');
                        } else {
                            $('#tema').val(tema);
                        }
                    }
                },
                error: function(error){
                    console.error(error)
                }
            })
        }
    }
    function getTopic(id, topic){
        if(id === null || !id || id === '') {
            $('#topik').empty()
            $('#topik').append('<option value="" disabled selected>-- Pilih topik --</option>');
        } else {
            $.ajax({
                url: '/tema/tema/'+id,
                method: 'GET',
                success: function(response){
                    $('#topik').empty()
                    $('#topik').append('<option value="" disabled>-- Pilih topik --</option>');

                    $.each(response.data, function (index, item) {
                        $('#topik').append('<option value="' + item.id + '">' + item.nama_topik + '</option>');
                    });
                    if(id === null){
                        $('#topik').val('');
                    } else {
                        if(topic === 0 || !topic || topic === ''){
                            $('#topik').val('');
                        } else {
                            $('#topik').val(topic);
                        }
                    }
                },
                error: function(error){
                    console.error(error)
                }
            })
        }
    }
    getTema($('#get_riset').val(), $('#get_tema').val())
    getTopic($('#get_tema').val(), $('#get_topik').val())
</script>

@endpush
