@extends('pages.dosen.usulan-baru.buat-usulan.theme')

@section('fase')

<div>
    <h6 class="card-title my-0">6. RAB : <a onclick="openRABModal()" style="cursor: pointer" class="text-white border-none outline-none px-2 py-1 rounded bg-success"><i class="bi bi-plus-square"></i></a></h6>
    <div class="table-responsive">
        <table class="table table-bordered table-striped" style="font-size: 14px">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Harga Satuan</th>
                    <th>Volume</th>
                    <th>Total Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="body-rab-tabel">
                <tr>
                    <td colspan="5" class="text-center"><small><em>Tidak ada data rab</em></small></td>
                </tr>
            </tbody>
        </table>
    </div>
    <input type="hidden" id="banyak_rab">
    <div class="d-md-flex">
        <button onclick="saveForm('prev')" class="btn btn-info text-white me-2 mb-2"><small>Sebelumnya</small></button>
        <button onclick="saveForm('draft')" class="btn btn-warning me-2 mb-2 text-white"><small>Jadikan Draft</small></button>
        <button onclick="saveForm('next')" class="btn btn-primary me-2 mb-2"><small>Selanjutnya</small></button>
        <div class="spinner-border text-primary me-2 mb-2 d-none" role="status" id="loading-submit">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>

<div class="modal fade" id="rabModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Item RAB</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label" for="nama_item">Nama Item <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <select name="nama_item" id="nama_item" class="form-control">
                            <option value="" disabled selected>-- Pilih item --</option>
                            @foreach(\App\Models\Rab::all() as $rab)
                                <option value="{{ $rab->id }}">{{ $rab->nama_item }}</option>
                            @endforeach
                            <option value="0">Lainnya</option>
                        </select>
                        <input type="text" class="form-control mt-2 d-none" name="nama_item" id="nama_item_lainnya" placeholder="tulis item lainnya disini">
                        <div class="col-12"><small id="error_nama_item" class="text-danger fst-italic"></small></div>
                    </div>
                    <label class="col-sm-3 col-form-label" for="harga_satuan">Harga Satuan <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input min="1" type="number" class="form-control mt-2" name="harga_satuan" id="harga_satuan" >
                        <div class="col-12"><small id="error_harga_satuan" class="text-danger fst-italic"></small></div>
                    </div>
                    <label class="col-sm-3 col-form-label" for="volume">Volume <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input min="1" type="number" class="form-control mt-2" name="volume" id="volume" >
                        <div class="col-12"><small id="error_volume" class="text-danger fst-italic"></small></div>
                    </div>
                    <label class="col-sm-3 col-form-label" for="total">Total Harga <span class="text-danger">*</span></label>
                    <div class="col-sm-9">
                        <input type="text" readonly disabled class="form-control mt-2" name="total" id="total" >
                        <div class="col-12"><small id="error_total" class="text-danger fst-italic"></small></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="d-flex">
                    <div class="spinner-border text-primary me-2 d-none" role="status" id="loading-submit-rab">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" id="simpan_template" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('custom_script')

<script src="{{ asset('assets/js/pages/usulan-baru-rab.js') }}"></script>

<script>
    $('#inner-1').addClass('active')
    $('#inner-2').addClass('active')
    $('#inner-3').addClass('active')
    function saveForm(event){
        if(event === 'next') {
            if($('#banyak_rab').val() > 0) {
                document.location.href="?page=4"
            } else {
                swal.fire({
                    text: 'Harap masukkan minimal satu data rab',
                    icon: 'error'
                })
            }
        } else if(event === 'prev') {
            document.location.href="?page=2" 
        } else if(event === 'draft') {
            document.location.href="{{ route('dosen.usulan-baru.index', $type) }}"
        }
    }
</script>
@endpush
