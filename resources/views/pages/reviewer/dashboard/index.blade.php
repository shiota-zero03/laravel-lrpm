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
                    <h6 class="card-title">Jumlah Pengguna dan Data Pengajuan</h6>
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-success">
                                <div class="d-flex align-items-center">
                                    <i style="font-size: 2.5rem" class="bi bi-person-lines-fill me-3"></i>
                                    <div>
                                        <h5 class="my-0 fw-bold">REVIEWER </h5>
                                        <h3 class="my-0">{{ $data['reviewer'] }}</h3>
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

<script>
    $(function() {
        $('input[name="daterange"]').daterangepicker({
            opens: 'left'
        }, function(start, end, label) {
            getData(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'))
        });
    });
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
                        console.log(indprod)
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
</script>
@endpush
