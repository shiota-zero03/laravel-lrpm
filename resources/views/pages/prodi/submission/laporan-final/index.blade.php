@extends('theme.layout')

@section('page', 'Laporan Final')
@section('breadcrumb', $type == 'penelitian' ? 'Penelitian' : 'Pengabdian Masyarakat')

@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Daftar Laporan Final {{ $type == 'penelitian' ? 'Penelitian' : 'Pengabdian Masyarakat' }}</h5>
                    <div class="table-responsive">
                        <table class="table" id="pengajuan-datatable">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama Pengusul</th>
                                    <th scope="col">Judul Usulan</th>
                                    <th scope="col">Dokumen Laporan</th>
                                    <th scope="col">Status Usulan</th>
                                    <th scope="col">Aksi</th>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach( $data as $usulan )
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>
                                            @php
                                                $user = \App\Models\User::find($usulan->id_pengaju)->name;
                                            @endphp
                                            {{$user}}
                                        </td>
                                        <td>{{ $usulan->judul_usulan }}</td>
                                        <td>
                                            @if(!$usulan->laporan_final)
                                                <a class="btn border-danger w-100" id="download-usulan">
                                                    <small><em>Belum ada dokumen usulan</em></small>
                                                </a>
                                            @else
                                                <a href="{{ asset('assets/storage/files/laporan-final/'.$usulan->laporan_final) }}" class="btn border-success w-100" id="download-usulan">
                                                    <small><i class="bi bi-cloud-arrow-down-fill me-2 text-success"></i> {{ $usulan->laporan_final }}</small>
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            @if( $usulan->status_laporan_final == 'Draft' ) <small class="btn border-2 border-secondary py-1 px-4 fw-bold fst-italic">{{ $usulan->status_laporan_final }}</small>
                                            @elseif( $usulan->status_laporan_final == 'Rejected by Admin' || $usulan->status_laporan_final == 'Rejected by Reviewer' )
                                                <small class="btn border-2 border-danger py-1 px-4 fw-bold fst-italic">{{ $usulan->status_laporan_final }}</small> <br />
                                                <small>
                                                    Alasan ditolak: <b>{{ $usulan->alasan_laporan_final_ditolak }}</b>
                                                </small>
                                            @elseif( $usulan->status_laporan_final == 'Approved' ) <small class="btn border-2 border-success py-1 px-4 fw-bold fst-italic">{{ $usulan->status_laporan_final }}</small>
                                            @else
                                                <small class="btn border-2 border-warning py-1 px-4 fw-bold fst-italic">{{ $usulan->status_laporan_final }}</small> <br />
                                                @if( $usulan->status_laporan_final == 'Returned by Admin' || $usulan->status_laporan_final == 'Returned by Reviewer' )
                                                    <small>
                                                        Alasan dikembalikan: <b>{{ $usulan->alasan_laporan_final_ditolak }}</b>
                                                    </small>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{route('prodi.laporan-final.show', ['type' => $usulan->tipe_submission, 'submission_code' => $usulan->submission_code])}}" class="btn text-white btn-primary mb-1 me-1 btn-sm"><strong><i class="bi bi-eye"></i></strong></a>
                                            <a href="{{route('prodi.laporan-final.tracking', ['type' => $usulan->tipe_submission, 'id' => $usulan->id])}}" class="btn btn-info text-white mb-1 me-1 btn-sm"><i class="bi bi-search"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
    $('#pengajuan-datatable').DataTable();
</script>

@endpush
