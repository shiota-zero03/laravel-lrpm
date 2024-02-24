@extends('theme.layout')

@section('page', 'Proposal')
@section('breadcrumb', $type == 'penelitian' ? 'Penelitian' : 'Pengabdian Masyarakat')

@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Daftar Proposal {{ $type == 'penelitian' ? 'Penelitian' : 'Pengabdian Masyarakat' }}</h5>
                    <div class="table-responsive">
                        <table class="table" id="pengajuan-datatable">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Kode Pengajuan</th>
                                    <th scope="col">Judul Usulan</th>
                                    <th scope="col">Dokumen Usulan</th>
                                    <th scope="col">Status Usulan</th>
                                    <th scope="col">Aksi</th>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach( $data as $usulan )
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $usulan->submission_code }}</td>
                                        <td>{{ $usulan->judul_usulan }}</td>
                                        <td>
                                            @if(!$usulan->proposal_usulan)
                                                <a class="btn border-danger w-100" id="download-usulan">
                                                    <small><em>Belum ada proposal usulan</em></small>
                                                </a>
                                            @else
                                                <a href="{{ asset('assets/storage/files/dokumen-usulan/'.$usulan->proposal_usulan) }}" class="btn border-success w-100" id="download-usulan">
                                                    <small><i class="bi bi-cloud-arrow-down-fill me-2 text-success"></i> {{ $usulan->proposal_usulan }}</small>
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            @if( $usulan->status_proposal == 'Draft' ) <small class="btn border-2 border-secondary py-1 px-4 fw-bold fst-italic">{{ $usulan->status_proposal }}</small>
                                            @elseif( $usulan->status_proposal == 'Rejected by Admin' || $usulan->status_proposal == 'Rejected by Reviewer' )
                                                <small class="btn border-2 border-danger py-1 px-4 fw-bold fst-italic">{{ $usulan->status_proposal }}</small> <br />
                                                <small>
                                                    Alasan ditolak: <b>{{ $usulan->alasan_proposal_ditolak }}</b>
                                                </small>
                                            @elseif( $usulan->status_proposal == 'Approved' ) <small class="btn border-2 border-success py-1 px-4 fw-bold fst-italic">{{ $usulan->status_proposal }}</small>
                                            @else
                                                <small class="btn border-2 border-warning py-1 px-4 fw-bold fst-italic">{{ $usulan->status_proposal }}</small> <br />
                                                @if( $usulan->status_proposal == 'Returned by Admin' || $usulan->status_proposal == 'Returned by Reviewer' )
                                                    <small>
                                                        Alasan dikembalikan: <b>{{ $usulan->alasan_proposal_ditolak }}</b>
                                                    </small>
                                                @endif
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            @if( $usulan->status_proposal == 'Pending by Dosen' || $usulan->status_proposal == 'Returned by Admin' || $usulan->status_proposal == 'Returned by Reviewer' )
                                                <a href="{{ route('dosen.proposal.update', ['type' => $type, 'submission_code' => $usulan->submission_code]) }}" class="btn btn-warning mb-1 me-1 btn-sm"><strong><i class="bi bi-pencil-fill text-white"></i></strong></a>
                                            @endif
                                            <a href="{{ route('dosen.proposal.detail', ['type' => $type, 'id' => $usulan->id]) }}" class="btn btn-primary mb-1 me-1 btn-sm"><strong><i class="bi bi-eye"></i></strong></a>
                                            <a href="{{ route('dosen.proposal.show', ['type' => $type, 'id' => $usulan->id]) }}" class="btn btn-info text-white mb-1 me-1 btn-sm"><strong><i class="bi bi-search"></i></strong></a>
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
    $('#pengajuan-datatable').DataTable();
</script>

@endpush
