@extends('pages.dosen.publikasi.buat-proposal.theme')

@section('fase')

<div>
    <form action="" method="post" enctype="multipart/form-data">
        @csrf
        <h6 class="card-title my-0">14. Data Publikasi :</h6>
        <div class="row">
            <div class="form-group col-md-6 mb-2">
                <div class="card p-2 border border-dark">
                    <label for="luaran_publikasi" class="fw-bold mb-1">Target Luaran Usulan</label>
                    <div class="form-control">{{ \App\Models\Outer::find($check_code->target_luaran)->nama_luaran }}</div>
                    <label for="luaran_publikasi" class="fw-bold mb-1 mt-1">Target Luaran Publikasi</label>
                    <select required name="luaran_publikasi" id="luaran_publikasi" class="form-control">
                        <option value="" selected disabled>--Pilih target luaran anda--</option>
                        @foreach(\App\Models\Outer::all() as $luaran_publikasi)
                            <option @if($check_code->luaran_publikasi == $luaran_publikasi->id) selected @endif value="{{ $luaran_publikasi->id }}">{{ $luaran_publikasi->nama_luaran }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group col-md-6 mb-2">
                <div class="card p-2 border border-dark">
                    <label for="nama_jurnal" class="fw-bold mb-1">Judul Usulan</label>
                    <div class="form-control">{{ $check_code->judul_usulan }}</div>
                    <label for="nama_jurnal" class="fw-bold mb-1 mt-1">Judul Publikasi</label>
                    <input required type="text" value="{{ $check_code->judul_publikasi }}" name="judul_publikasi" id="judul_publikasi" class="form-control" placeholder="Tulis nama jurnal anda disini">
                </div>
            </div>
            <div class="col-12">
                <div class="card p-2 border border-dark">
                    <div class="row">
                        <div class="form-group col-md-6 mb-2">
                            <label for="nama_jurnal" class="fw-bold mb-1">Nama Jurnal</label>
                            <input required type="text" value="{{ $check_code->nama_jurnal }}" name="nama_jurnal" id="nama_jurnal" class="form-control" placeholder="Tulis nama jurnal anda disini">
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label for="link_jurnal" class="fw-bold mb-1">Link Jurnal</label>
                            <input required type="text" value="{{ $check_code->link_jurnal }}" name="link_jurnal" id="link_jurnal" class="form-control" placeholder="Tulis link jurnal anda disini">
                        </div>
                        <div class="col-12">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>Dokumen Upload</th>
                                        <th>Dokumen View</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Submit</td>
                                        <td>
                                            <input type="file" class="form-control" name="dokumen_submit" >
                                        </td>
                                        <td>
                                            @if($check_code->dokumen_submit)
                                                <a target="__blank" class="btn btn-primary" href="{{ asset('assets/storage/files/publikasi/submit/'.$check_code->dokumen_submit) }}">Lihat Dokumen Submit Anda</a>
                                            @endif
                                        </td>
                                        <td>
                                            <input type="date" class="form-control" name="tanggal_submit" value="{{ $check_code->tanggal_submit }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Revision</td>
                                        <td>
                                            <input type="file" class="form-control" name="dokumen_revision" >
                                        </td>
                                        <td>
                                            @if($check_code->dokumen_revision)
                                                <a target="__blank" class="btn btn-primary" href="{{ asset('assets/storage/files/publikasi/revision/'.$check_code->dokumen_revision) }}">Lihat Dokumen Revision Anda</a>
                                            @endif
                                        </td>
                                        <td>
                                            <input type="date" class="form-control" name="tanggal_revision" value="{{ $check_code->tanggal_revision }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Accepted</td>
                                        <td>
                                            <input type="file" class="form-control" name="dokumen_accepted" >
                                        </td>
                                        <td>
                                            @if($check_code->dokumen_accepted)
                                                <a target="__blank" class="btn btn-primary" href="{{ asset('assets/storage/files/publikasi/accepted/'.$check_code->dokumen_accepted) }}">Lihat Dokumen Accepted Anda</a>
                                            @endif
                                        </td>
                                        <td>
                                            <input type="date" class="form-control" name="tanggal_accepted" value="{{ $check_code->tanggal_accepted }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Publish</td>
                                        <td>
                                            <input type="file" class="form-control" name="dokumen_publish" >
                                        </td>
                                        <td>
                                            @if($check_code->dokumen_publish)
                                                <a target="__blank" class="btn btn-primary" href="{{ asset('assets/storage/files/publikasi/publish/'.$check_code->dokumen_publish) }}">Lihat Dokumen Publish Anda</a>
                                            @endif
                                        </td>
                                        <td>
                                            <input type="date" class="form-control" name="tanggal_publish" value="{{ $check_code->tanggal_publish }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Rejected</td>
                                        <td>
                                            <input type="file" class="form-control" name="dokumen_rejected" >
                                        </td>
                                        <td>
                                            @if($check_code->dokumen_rejected)
                                                <a target="__blank" class="btn btn-primary" href="{{ asset('assets/storage/files/publikasi/rejected/'.$check_code->dokumen_rejected) }}">Lihat Dokumen Rejected Anda</a>
                                            @endif
                                        </td>
                                        <td>
                                            <input type="date" class="form-control" name="tanggal_rejected" value="{{ $check_code->tanggal_rejected }}">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-md-flex">
            <a href="?page=1" class="btn btn-info text-white me-2 mb-2"><small>Sebelumnya</small></a>
            <button type="submit" class="btn btn-success text-white me-2 mb-2"><small>Simpan Data Publikasi</small></button>
            @if($check_code->dokumen_submit && $check_code->tanggal_submit)
                @if( ($check_code->dokumen_accepted && $check_code->tanggal_accepted) )
                    @if($check_code->dokumen_publish && $check_code->tanggal_publish)
                        <a href="?page=3" class="btn btn-primary text-white me-2 mb-2"><small>Selanjutnya</small></a>
                    @endif
                @elseif($check_code->dokumen_rejected && $check_code->tanggal_rejected)
                    <a href="?page=3" class="btn btn-primary text-white me-2 mb-2"><small>Selanjutnya</small></a>
                @endif
            @endif
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
