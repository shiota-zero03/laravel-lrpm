@extends('theme.layout')

@section('page', 'Laporan Akhir')
@section('breadcrumb', $type == 'penelitian' ? 'Penelitian' : 'Pengabdian Masyarakat')
@section('breadcrumbs_sub_page', 'Kode: '.$check_code->submission_code)

@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('reviewer.laporan-akhir.index', ['type' => $type]) }}" class="btn btn-info text-white"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
                        <a href="{{ route('reviewer.laporan-akhir.tracking', ['type' => $type, 'id' => $check_code->id]) }}" class="btn btn-primary">Lihat traking</a>
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
                        @if( $check_code->status_laporan_akhir == 'Pending by Reviewer' || $check_code->status_laporan_akhir == 'Returned to Reviewer' )
                            @if ( $select->nama_fakultas || $select->nama_fakultas == null )
                                <h6 class="card-title my-0">3. Berikan Penilaian :</h6>
                                @php
                                    $fti = ['FTI', 'FAKULTAS TEKNIK DAN INFORMATIKA', 'FAKULTAS TEKNIK DAN INFORMATIKA (FTI)'];
                                    $fbis = ['FBIS', 'FAKULTAS BISNIS DAN ILMU SOSIAL', 'FAKULTAS BISNIS DAN ILMU SOSIAL (FBIS)'];
                                @endphp
                                @if( in_array(strtoupper($select->nama_fakultas), $fti) )
                                    <div>
                                        @include('pages.reviewer.submission.laporan-akhir.fti')
                                    </div>
                                @elseif( in_array(strtoupper($select->nama_fakultas), $fbis) )
                                    <div>
                                        @include('pages.reviewer.submission.laporan-akhir.fbis')
                                    </div>
                                @endif
                            @endif
                        @else
                            <h6 class="card-title my-0">3. Penilaian :</h6>
                            <a target="__blank" href="{{ route('penilaian.submission', $check_code->id) }}" class="btn btn-primary btn-sm w-100">Lihat penilaian laporan akhir</a>
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
    </script>

@endpush
