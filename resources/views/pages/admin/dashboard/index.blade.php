@extends('theme.layout')

@section('page', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')
@php
    $fakultas = \App\Models\Faculty::all();
@endphp

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body py-3">
                    <h6 class="card-title">Jumlah Pengguna</h6>
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="alert alert-warning">
                                <div class="d-flex align-items-center">
                                    <i style="font-size: 2.5rem" class="bi bi-person-lines-fill me-3"></i>
                                    <div>
                                        <h5 class="my-0 fw-bold"> DOSEN </h5>
                                        <h3 class="my-0">{{ $data['dosen'] }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="alert alert-success">
                                <div class="d-flex align-items-center">
                                    <i style="font-size: 2.5rem" class="bi bi-person-lines-fill me-3"></i>
                                    <div>
                                        <h5 class="my-0 fw-bold"> REVIEWER </h5>
                                        <h3 class="my-0">{{ $data['reviewer'] }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="alert alert-info">
                                <div class="d-flex align-items-center">
                                    <i style="font-size: 2.5rem" class="bi bi-buildings me-3"></i>
                                    <div>
                                        <h5 class="my-0 fw-bold"> FAKULTAS </h5>
                                        <h3 class="my-0">{{ $data['fakultas'] }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="alert alert-primary">
                                <div class="d-flex align-items-center">
                                    <i style="font-size: 2.5rem" class="bi bi-buildings me-3"></i>
                                    <div>
                                        <h5 class="my-0 fw-bold"> PRODI </h5>
                                        <h3 class="my-0">{{ $data['prodi'] }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-md-flex justify-content-between align-items-center">
                        <h6 class="card-title">Data Pengajuan</h6>
                        <div></div>
                        <div id="date-range" class="col-md-4">
                            <label for="daterange" class="fw-bold">Pilih Rentang Tanggal:</label>
                            <input type="text" id="daterange" name="daterange" value="" class="form-control border border-dark" style="cursor: pointer" />
                        </div>
                    </div>
                    <div>
                        <a onclick="exportExcel()" class="btn btn-success text-white fw-bold"><i class="bi bi-file-earmark-excel-fill me-2"></i> Export ke Excel</a>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6 col-12">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr class="text-center table-primary">
                                        <th colspan="3">Kemajuan Penelitian Universitas</th>
                                    </tr>
                                    <tr>
                                        <th>Penelitian</th>
                                        <th>Submit Usulan</th>
                                        <th>Submit Laporan Final</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>UNDIRA</td>
                                        <td id="psuu">{{ $data['psuu'] }}</td>
                                        <td id="pslfu">{{ $data['pslfu'] }} ({{ $data['psuu'] > 0 ? (($data['pslfu']/$data['psuu'])*100) : 0 }}%)</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6 col-12">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr class="text-center table-primary">
                                        <th colspan="3">Kemajuan Penelitian Fakultas</th>
                                    </tr>
                                    <tr>
                                        <th>Nama Fakultas</th>
                                        <th>Submit Usulan</th>
                                        <th>Submit Laporan Final</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $fakultas as $index => $fak )
                                        <tr>
                                            <td>{{ $fak->nama_fakultas }}</td>
                                            <td id="psuf-{{ $index }}">{{ $faculty[$index][$fak['id']]['psuf'] }}</td>
                                            <td id="pslff-{{ $index }}">{{ $faculty[$index][$fak['id']]['psuf'] > 0 ? ((intval($faculty[$index][$fak['id']]['pslff'])/intval($faculty[$index][$fak['id']]['psuf'])) *100) : 0 }}%</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @foreach ( $fakultas as $infak => $fak )
                            <div class="col-md-6">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="text-center table-primary">
                                            <th colspan="3">Kemajuan Penelitian {{ $fak->nama_fakultas }}</th>
                                        </tr>
                                        <tr>
                                            <th>Nama Prodi</th>
                                            <th>Submit Usulan</th>
                                            <th>Submit Laporan Final</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $prodi = \App\Models\Department::where('id_fakultas', $fak->id)->get();
                                        @endphp
                                        @foreach ( $prodi as $inprod => $prod )
                                            <tr>
                                                <td>{{ $prod['nama_prodi'] }}</td>
                                                <td id="psup-{{ $infak }}-{{ $inprod }}">{{ $faculty[$infak][$fak['id']]['prodi'][$inprod][0]['psup'] }}</td>
                                                <td id="pslfp-{{ $infak }}-{{ $inprod }}">{{ $faculty[$infak][$fak['id']]['prodi'][$inprod][0]['psup'] > 0 ? (($faculty[$infak][$fak['id']]['prodi'][$inprod][0]['pslfp']/$faculty[$infak][$fak['id']]['prodi'][$inprod][0]['psup'])*100) : 0 }}%</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                        <div class="col-12">
                            <hr class="my-3">
                        </div>
                        <div class="col-md-6 col-12">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr class="text-center table-primary">
                                        <th colspan="3">Kemajuan PKM Universitas</th>
                                    </tr>
                                    <tr>
                                        <th>PKM</th>
                                        <th>Submit Usulan</th>
                                        <th>Submit Laporan Final</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>UNDIRA</td>
                                        <td id="pmsuu">{{ $data['pmsuu'] }}</td>
                                        <td id="pmslfu">{{ $data['pmslfu'] }} ({{ $data['pmsuu'] > 0 ? (($data['pmslfu']/$data['pmsuu'])*100) : 0 }}%)</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6 col-12">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr class="text-center table-primary">
                                        <th colspan="3">Kemajuan PKM Fakultas</th>
                                    </tr>
                                    <tr>
                                        <th>Nama Fakultas</th>
                                        <th>Submit Usulan</th>
                                        <th>Submit Laporan Final</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $fakultas as $index => $fak )
                                        <tr>
                                            <td>{{ $fak->nama_fakultas }}</td>
                                            <td id="pmsuf-{{ $index }}">{{ $faculty[$index][$fak['id']]['pmsuf'] }}</td>
                                            <td id="pmslff-{{ $index }}">{{ $faculty[$index][$fak['id']]['pmsuf'] > 0 ? ((intval($faculty[$index][$fak['id']]['pmslff'])/intval($faculty[$index][$fak['id']]['pmsuf'])) *100) : 0 }}%</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @foreach ( $fakultas as $infak => $fak )
                            <div class="col-md-6">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="text-center table-primary">
                                            <th colspan="3">Kemajuan PKM {{ $fak->nama_fakultas }}</th>
                                        </tr>
                                        <tr>
                                            <th>Nama Prodi</th>
                                            <th>Submit Usulan</th>
                                            <th>Submit Laporan Final</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $prodi = \App\Models\Department::where('id_fakultas', $fak->id)->get();
                                        @endphp
                                        @foreach ( $prodi as $inprod => $prod )
                                            <tr>
                                                <td>{{ $prod['nama_prodi'] }}</td>
                                                <td id="pmsup-{{ $infak }}-{{ $inprod }}">{{ $faculty[$infak][$fak['id']]['prodi'][$inprod][0]['pmsup'] }}</td>
                                                <td id="pmslfp-{{ $infak }}-{{ $inprod }}">{{ $faculty[$infak][$fak['id']]['prodi'][$inprod][0]['pmsup'] > 0 ? (($faculty[$infak][$fak['id']]['prodi'][$inprod][0]['pmslfp']/$faculty[$infak][$fak['id']]['prodi'][$inprod][0]['pmsup'])*100) : 0 }}%</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                        <div class="col-md-6 col-12">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr class="text-center table-primary">
                                        <th>Proses Laporan Penelitian</th>
                                        <th>Universitas</th>
                                        <th>FBIS</th>
                                        <th>FTI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>Submit Usulan</th>
                                        <td class="text-center">{{ $process['universitas_penelitian']['submit_laporan'] }}</td>
                                        <td class="text-center">{{ $process['fbis_penelitian']['submit_laporan'] }}</td>
                                        <td class="text-center">{{ $process['fti_penelitian']['submit_laporan'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>Usulan Diterima</th>
                                        <td class="text-center">{{ $process['universitas_penelitian']['laporan_diterima'] }}</td>
                                        <td class="text-center">{{ $process['fbis_penelitian']['laporan_diterima'] }}</td>
                                        <td class="text-center">{{ $process['fti_penelitian']['laporan_diterima'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>Usulan Ditolak</th>
                                        <td class="text-center">{{ $process['universitas_penelitian']['laporan_ditolak'] }}</td>
                                        <td class="text-center">{{ $process['fbis_penelitian']['laporan_ditolak'] }}</td>
                                        <td class="text-center">{{ $process['fti_penelitian']['laporan_ditolak'] }}</td>
                                    </tr>

                                    <tr>
                                        <th>Upload Proposal</th>
                                        <td class="text-center">{{ $process['universitas_penelitian']['upload_proposal'] }}</td>
                                        <td class="text-center">{{ $process['fbis_penelitian']['upload_proposal'] }}</td>
                                        <td class="text-center">{{ $process['fti_penelitian']['upload_proposal'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>Proposal Diterima</th>
                                        <td class="text-center">{{ $process['universitas_penelitian']['proposal_diterima'] }}</td>
                                        <td class="text-center">{{ $process['fbis_penelitian']['proposal_diterima'] }}</td>
                                        <td class="text-center">{{ $process['fti_penelitian']['proposal_diterima'] }}</td>
                                    </tr>

                                    <tr>
                                        <th>Upload Laporan Akhir</th>
                                        <td class="text-center">{{ $process['universitas_penelitian']['upload_laporan_akhir'] }}</td>
                                        <td class="text-center">{{ $process['fbis_penelitian']['upload_laporan_akhir'] }}</td>
                                        <td class="text-center">{{ $process['fti_penelitian']['upload_laporan_akhir'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>Laporan Akhir Diterima</th>
                                        <td class="text-center">{{ $process['universitas_penelitian']['laporan_akhir_diterima'] }}</td>
                                        <td class="text-center">{{ $process['fbis_penelitian']['laporan_akhir_diterima'] }}</td>
                                        <td class="text-center">{{ $process['fti_penelitian']['laporan_akhir_diterima'] }}</td>
                                    </tr>

                                    <tr>
                                        <th>Persiapan Monev</th>
                                        <td class="text-center">{{ $process['universitas_penelitian']['persiapan_monev'] }}</td>
                                        <td class="text-center">{{ $process['fbis_penelitian']['persiapan_monev'] }}</td>
                                        <td class="text-center">{{ $process['fti_penelitian']['persiapan_monev'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>Review Monev</th>
                                        <td class="text-center">{{ $process['universitas_penelitian']['review_monev'] }}</td>
                                        <td class="text-center">{{ $process['fbis_penelitian']['review_monev'] }}</td>
                                        <td class="text-center">{{ $process['fti_penelitian']['review_monev'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>Revisi Monev</th>
                                        <td class="text-center">{{ $process['universitas_penelitian']['revisi_monev'] }}</td>
                                        <td class="text-center">{{ $process['fbis_penelitian']['revisi_monev'] }}</td>
                                        <td class="text-center">{{ $process['fti_penelitian']['revisi_monev'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>Monev Diterima</th>
                                        <td class="text-center">{{ $process['universitas_penelitian']['monev_diterima'] }}</td>
                                        <td class="text-center">{{ $process['fbis_penelitian']['monev_diterima'] }}</td>
                                        <td class="text-center">{{ $process['fti_penelitian']['monev_diterima'] }}</td>
                                    </tr>

                                    <tr>
                                        <th>Upload Laporan Final</th>
                                        <td class="text-center">{{ $process['universitas_penelitian']['upload_laporan_final'] }}</td>
                                        <td class="text-center">{{ $process['fbis_penelitian']['upload_laporan_final'] }}</td>
                                        <td class="text-center">{{ $process['fti_penelitian']['upload_laporan_final'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>Laporan Final Diterima</th>
                                        <td class="text-center">{{ $process['universitas_penelitian']['laporan_final_diterima'] }}</td>
                                        <td class="text-center">{{ $process['fbis_penelitian']['laporan_final_diterima'] }}</td>
                                        <td class="text-center">{{ $process['fti_penelitian']['laporan_final_diterima'] }}</td>
                                    </tr>

                                    <tr>
                                        <th>Proses Selesai</th>
                                        <td class="text-center">{{ $process['universitas_penelitian']['proses_selesai'] }}</td>
                                        <td class="text-center">{{ $process['fbis_penelitian']['proses_selesai'] }}</td>
                                        <td class="text-center">{{ $process['fti_penelitian']['proses_selesai'] }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6 col-12">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr class="text-center table-primary">
                                        <th>Proses Laporan PKM</th>
                                        <th>Universitas</th>
                                        <th>FBIS</th>
                                        <th>FTI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>Submit Usulan</th>
                                        <td class="text-center">{{ $process['universitas_pkm']['submit_laporan'] }}</td>
                                        <td class="text-center">{{ $process['fbis_pkm']['submit_laporan'] }}</td>
                                        <td class="text-center">{{ $process['fti_pkm']['submit_laporan'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>Usulan Diterima</th>
                                        <td class="text-center">{{ $process['universitas_pkm']['laporan_diterima'] }}</td>
                                        <td class="text-center">{{ $process['fbis_pkm']['laporan_diterima'] }}</td>
                                        <td class="text-center">{{ $process['fti_pkm']['laporan_diterima'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>Usulan Ditolak</th>
                                        <td class="text-center">{{ $process['universitas_pkm']['laporan_ditolak'] }}</td>
                                        <td class="text-center">{{ $process['fbis_pkm']['laporan_ditolak'] }}</td>
                                        <td class="text-center">{{ $process['fti_pkm']['laporan_ditolak'] }}</td>
                                    </tr>

                                    <tr>
                                        <th>Upload Proposal</th>
                                        <td class="text-center">{{ $process['universitas_pkm']['upload_proposal'] }}</td>
                                        <td class="text-center">{{ $process['fbis_pkm']['upload_proposal'] }}</td>
                                        <td class="text-center">{{ $process['fti_pkm']['upload_proposal'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>Proposal Diterima</th>
                                        <td class="text-center">{{ $process['universitas_pkm']['proposal_diterima'] }}</td>
                                        <td class="text-center">{{ $process['fbis_pkm']['proposal_diterima'] }}</td>
                                        <td class="text-center">{{ $process['fti_pkm']['proposal_diterima'] }}</td>
                                    </tr>

                                    <tr>
                                        <th>Upload Laporan Akhir</th>
                                        <td class="text-center">{{ $process['universitas_pkm']['upload_laporan_akhir'] }}</td>
                                        <td class="text-center">{{ $process['fbis_pkm']['upload_laporan_akhir'] }}</td>
                                        <td class="text-center">{{ $process['fti_pkm']['upload_laporan_akhir'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>Laporan Akhir Diterima</th>
                                        <td class="text-center">{{ $process['universitas_pkm']['laporan_akhir_diterima'] }}</td>
                                        <td class="text-center">{{ $process['fbis_pkm']['laporan_akhir_diterima'] }}</td>
                                        <td class="text-center">{{ $process['fti_pkm']['laporan_akhir_diterima'] }}</td>
                                    </tr>

                                    <tr>
                                        <th>Persiapan Monev</th>
                                        <td class="text-center">{{ $process['universitas_pkm']['persiapan_monev'] }}</td>
                                        <td class="text-center">{{ $process['fbis_pkm']['persiapan_monev'] }}</td>
                                        <td class="text-center">{{ $process['fti_pkm']['persiapan_monev'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>Review Monev</th>
                                        <td class="text-center">{{ $process['universitas_pkm']['review_monev'] }}</td>
                                        <td class="text-center">{{ $process['fbis_pkm']['review_monev'] }}</td>
                                        <td class="text-center">{{ $process['fti_pkm']['review_monev'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>Revisi Monev</th>
                                        <td class="text-center">{{ $process['universitas_pkm']['revisi_monev'] }}</td>
                                        <td class="text-center">{{ $process['fbis_pkm']['revisi_monev'] }}</td>
                                        <td class="text-center">{{ $process['fti_pkm']['revisi_monev'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>Monev Diterima</th>
                                        <td class="text-center">{{ $process['universitas_pkm']['monev_diterima'] }}</td>
                                        <td class="text-center">{{ $process['fbis_pkm']['monev_diterima'] }}</td>
                                        <td class="text-center">{{ $process['fti_pkm']['monev_diterima'] }}</td>
                                    </tr>

                                    <tr>
                                        <th>Upload Laporan Final</th>
                                        <td class="text-center">{{ $process['universitas_pkm']['upload_laporan_final'] }}</td>
                                        <td class="text-center">{{ $process['fbis_pkm']['upload_laporan_final'] }}</td>
                                        <td class="text-center">{{ $process['fti_pkm']['upload_laporan_final'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>Laporan Final Diterima</th>
                                        <td class="text-center">{{ $process['universitas_pkm']['laporan_final_diterima'] }}</td>
                                        <td class="text-center">{{ $process['fbis_pkm']['laporan_final_diterima'] }}</td>
                                        <td class="text-center">{{ $process['fti_pkm']['laporan_final_diterima'] }}</td>
                                    </tr>

                                    <tr>
                                        <th>Proses Selesai</th>
                                        <td class="text-center">{{ $process['universitas_pkm']['proses_selesai'] }}</td>
                                        <td class="text-center">{{ $process['fbis_pkm']['proses_selesai'] }}</td>
                                        <td class="text-center">{{ $process['fti_pkm']['proses_selesai'] }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('custom_script')
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script>
    $('#dashboard-menu').removeClass('collapsed');
</script>

<input type="hidden" value="" id="start">
<input type="hidden" value="" id="end">

<script>
    $(function() {
        $('input[name="daterange"]').daterangepicker({
            opens: 'left'
        }, function(start, end, label) {
            getData(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'))
            $('#start').val(start.format('YYYY-MM-DD'));
            $('#end').val(end.format('YYYY-MM-DD'));
        });
    });
    function getDate (start, end){
        return [start, end];
    }
    function getData (start, end) {
        $.ajax({
            url: "{{ route('admin.dashboard.index') }}?from="+start+"&to="+end,
            method: "GET",
            success: function(response){
                var data = response.data;

                $('#psuu').html(data.universitas.submit_usulan_penelitian)
                $('#pslfu').html(data.universitas.submit_laporan_penelitian)
                $('#pmsuu').html(data.universitas.submit_usulan_pkm)
                $('#pmslfu').html(data.universitas.submit_laporan_pkm)

                $.each(data.fakultas, function( index, value ) {
                    $('#psuf-'+index).html(value[0]['psuf'])
                    $('#pslff-'+index).html(value[0]['pslff'])
                    $('#pmsuf-'+index).html(value[0]['pmsuf'])
                    $('#pmslff-'+index).html(value[0]['pmslff'])

                    $.each(value[0]['prodi'], function( indprod, valprod ) {
                        $('#psup-'+index+'-'+indprod).html(valprod[0]['psup'])
                        $('#pslfp-'+index+'-'+indprod).html(valprod[0]['pslfp'])

                        $('#pmsup-'+index+'-'+indprod).html(valprod[0]['pmsup'])
                        $('#pmslfp-'+index+'-'+indprod).html(valprod[0]['pmslfp'])
                    })
                })
                // console.log(response.data.fakultas)
            },
            error: function(error){
                console.error(error)
            }
        })
    }
    function exportExcel()
    {
        var start = $('#start').val();
        var end = $('#end').val();
        document.location.href='/admin/export?from='+start+"&to="+end;
    }
</script>
@endpush
