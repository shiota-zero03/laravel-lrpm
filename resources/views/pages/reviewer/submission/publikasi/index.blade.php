@extends('theme.layout')

@section('page', 'Publikasi')
@section('breadcrumb', $type == 'penelitian' ? 'Penelitian' : 'Pengabdian Masyarakat')

@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Daftar Publikasi {{ $type == 'penelitian' ? 'Penelitian' : 'Pengabdian Masyarakat' }}</h5>
                    <div class="table-responsive">
                        <table class="table" id="pengajuan-datatable">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama Pengusul</th>
                                    <th scope="col">Judul Usulan</th>
                                    <th scope="col">Link Jurnal</th>
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
                                        <td>{{ $usulan->link_jurnal }}</td>
                                        <td>
                                            @if( $usulan->status_publikasi == 'Draft' ) <small class="btn border-2 border-secondary py-1 px-4 fw-bold fst-italic">{{ $usulan->status_publikasi }}</small> 
                                            @elseif( $usulan->status_publikasi == 'Rejected by Admin' )
                                                <small class="btn border-2 border-danger py-1 px-4 fw-bold fst-italic">{{ $usulan->status_publikasi }}</small> <br />
                                                <small>
                                                    Alasan ditolak: <b>{{ $usulan->alasan_usulan_ditolak }}</b>
                                                </small>
                                            @elseif( $usulan->status_publikasi == 'Approved' ) <small class="btn border-2 border-success py-1 px-4 fw-bold fst-italic">{{ $usulan->status_publikasi }}</small> 
                                            @else 
                                                <small class="btn border-2 border-warning py-1 px-4 fw-bold fst-italic">{{ $usulan->status_publikasi }}</small> <br />
                                                @if( $usulan->status_publikasi == 'Returned by Admin' )
                                                    <small>
                                                        Alasan dikembalikan: <b>{{ $usulan->alasan_usulan_ditolak }}</b>
                                                    </small>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{route('reviewer.publikasi.show', ['type' => $usulan->tipe_submission, 'submission_code' => $usulan->submission_code])}}" class="btn btn-primary mb-1 me-1 btn-sm"><strong><i class="bi bi-eye"></i></strong></a>
                                            <a href="{{route('reviewer.publikasi.tracking', ['type' => $usulan->tipe_submission, 'id' => $usulan->id])}}" class="btn btn-secondary">Tracking</a>
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