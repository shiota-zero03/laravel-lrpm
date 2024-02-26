@extends('theme.layout')

@section('page', 'Usulan Baru')
@section('breadcrumb', $type == 'penelitian' ? 'Penelitian' : 'Pengabdian Masyarakat')

@section('content')
<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Daftar Usulan Baru {{ $type == 'penelitian' ? 'Penelitian' : 'Pengabdian Masyarakat' }}</h5>
                    @if (
                        \App\Models\Config::where('type', 'usulan_baru')->first()->status == 1
                    )
                        <a href="{{ route('dosen.usulan-baru.create', $type) }}" class="btn btn-primary rounded mb-3">
                            <i class="bi bi-plus"></i> Ajukan Usulan Baru
                        </a>
                    @else
                        <div class="mb-4 alert alert-danger"><em>Tidak dapat mengajukan {{ $type }} untuk saat ini</em></div>
                    @endif
                    <div style="overflow-x: scroll; white-space: nowrap" class="pb-5">
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
                                            @if(!$usulan->dokumen_usulan)
                                                <a class="btn border-danger w-100" id="download-usulan">
                                                    <small><em>Belum ada dokumen usulan</em></small>
                                                </a>
                                            @else
                                                <a href="{{ asset('assets/storage/files/dokumen-usulan/'.$usulan->dokumen_usulan) }}" class="btn border-success w-100" id="download-usulan">
                                                    <small><i class="bi bi-cloud-arrow-down-fill me-2 text-success"></i> {{ $usulan->dokumen_usulan }}</small>
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            @if( $usulan->status_usulan == 'Draft' ) <small class="btn border-2 border-secondary py-1 px-4 fw-bold fst-italic">{{ $usulan->status_usulan }}</small>
                                            @elseif( $usulan->status_usulan == 'Rejected by Admin' || $usulan->status_usulan == 'Rejected by Prodi' )
                                                <small class="btn border-2 border-danger py-1 px-4 fw-bold fst-italic">{{ $usulan->status_usulan }}</small> <br />
                                                <small>
                                                    Alasan ditolak: <b>{{ $usulan->alasan_usulan_ditolak }}</b>
                                                </small><br />
                                                @if ( $usulan->dokumen_tambahan_usulan )
                                                    <small>
                                                        Dokumen tambahan penolakan : <b><a href="{{ asset('assets/storage/files/dokumen-submission/'.$usulan->dokumen_tambahan_usulan) }}" target="__blank">Lihat dokumen</a></b>
                                                    </small>
                                                @endif
                                            @elseif( $usulan->status_usulan == 'Approved' ) <small class="btn border-2 border-success py-1 px-4 fw-bold fst-italic">{{ $usulan->status_usulan }}</small>
                                            @else
                                                <small class="btn border-2 border-warning py-1 px-4 fw-bold fst-italic">{{ $usulan->status_usulan }}</small> <br />
                                                @if( $usulan->status_usulan == 'Returned by Admin' || $usulan->status_usulan == 'Returned by Prodi' )
                                                    <small>
                                                        Alasan dikembalikan: <b>{{ $usulan->alasan_usulan_ditolak }}</b>
                                                    </small><br />
                                                    @if ( $usulan->dokumen_tambahan_usulan )
                                                        <small>
                                                            Dokumen tambahan pengembalian : <b><a href="{{ asset('assets/storage/files/dokumen-submission/'.$usulan->dokumen_tambahan_usulan) }}" target="__blank">Lihat dokumen</a></b>
                                                        </small>
                                                    @endif
                                                @endif
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            @if( $usulan->status_usulan == 'Draft' || $usulan->status_usulan == 'Returned by Admin' || $usulan->status_usulan == 'Returned by Prodi' )
                                                <a href="{{ route('dosen.usulan-baru.identitas-usulan', ['type' => $type, 'submission_code' => $usulan->submission_code]) }}" class="btn btn-warning mb-1 me-1 btn-sm"><strong><i class="bi bi-pencil-fill text-white"></i></strong></a>
                                            @endif
                                            @if( $usulan->status_usulan !== 'Approved' )
                                                <a href="#" onclick="deleteData({{ $usulan->id }})" class="btn btn-danger mb-1 me-1 btn-sm" data-bs-toggle="tooltip" title="Delete"><strong><i class="bi bi-trash"></i></strong></a>
                                            @endif
                                            <a href="{{ route('dosen.usulan-baru.detail', ['type' => $type, 'id' => $usulan->id]) }}" data-bs-toggle="tooltip" title="Detail" class="btn btn-primary mb-1 me-1 btn-sm"><strong><i class="bi bi-eye"></i></strong></a>
                                            <a href="{{ route('dosen.usulan-baru.show', ['type' => $type, 'id' => $usulan->id]) }}" data-bs-toggle="tooltip" title="Traking" class="btn btn-info text-white mb-1 me-1 btn-sm"><strong><i class="bi bi-search"></i></strong></a>
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
    function deleteData(id){
        Swal.fire({
            text: 'Anda yakin ingin menghapus data ini ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: "Ya",
            cancelButtonText: "tidak"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: 'DELETE',
                    url: "{{ $type }}/delete/"+id,
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response){
                        Swal.fire({
                            title: response.message,
                            icon: 'success',
                        }).then((res) => {
                            location.reload()
                        })
                    },
                    error: function(error){
                        console.error(error);
                    }
                })
            }
        });
    }
</script>

@endpush
