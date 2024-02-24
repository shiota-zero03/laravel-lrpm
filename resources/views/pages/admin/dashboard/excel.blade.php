<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .text-center{
            text-align: center
        }
    </style>
</head>
<body>
    @php
        $fakultas = \App\Models\Faculty::all();
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=data_lrpm.xls");
    @endphp
    <table style="border: 1px solid black; padding: 2px 10px; ">
        <thead>
            <tr>
                <th class="text-center" colspan="3"> DATA LRPM </th>
            </tr>
            <tr class="text-center table-primary">
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; " colspan="3">Kemajuan Penelitian Universitas</th>
            </tr>
            <tr>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Penelitian</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Submit Usulan</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Submit Laporan Final</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">UNDIRA</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; " id="psuu">{{ $data['universitas']['submit_usulan_penelitian'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; " id="pslfu">{{ $data['universitas']['submit_usulan_penelitian'] }} </td>
            </tr>
        </tbody>
        <tr>
            <td></td>
        </tr>
        <thead>
            <tr>
                <th colspan="3" class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Kemajuan Penelitian Fakultas</th>
            </tr>
            <tr>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Nama Fakultas</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Submit Usulan</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Submit Laporan Final</th>
            </tr>
        </thead>
        <tbody>
            @foreach ( $fakultas as $index => $fak )
                <tr>
                    <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $fak->nama_fakultas }}</td>
                    <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $data['fakultas'][$index][0]['psuf'] }}</td>
                    <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $data['fakultas'][$index][0]['pslff'] }} ({{ $data['fakultas'][$index][0]['psuf'] > 0 ? ((intval($data['fakultas'][$index][0]['pslff'])/intval($data['fakultas'][$index][0]['psuf'])) *100) : 0 }}%)</td>
                </tr>
            @endforeach
        </tbody>
        <tr>
            <td></td>
        </tr>
        @foreach ( $fakultas as $infak => $fak )
            <thead>
                <tr class="text-center table-primary">
                    <th class="text-center" style="border: 1px solid black; padding: 2px 10px; " colspan="3">Kemajuan Penelitian {{ $fak->nama_fakultas }}</th>
                </tr>
                <tr>
                    <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Nama Prodi</th>
                    <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Submit Usulan</th>
                    <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Submit Laporan Final</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $prodi = \App\Models\Department::where('id_fakultas', $fak->id)->get();
                @endphp
                @foreach ( $prodi as $inprod => $prod )
                    <tr>
                        <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $prod['nama_prodi'] }}</td>
                        <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $data['fakultas'][$infak][0]['prodi'][$inprod][0]['psup'] }}</td>
                        <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $data['fakultas'][$infak][0]['prodi'][$inprod][0]['pslfp'] }} ({{ $data['fakultas'][$infak][0]['prodi'][$inprod][0]['psup'] > 0 ? (($data['fakultas'][$infak][0]['prodi'][$inprod][0]['pslfp']/$data['fakultas'][$infak][0]['prodi'][$inprod][0]['psup'])*100) : 0 }}%)</td>
                    </tr>
                @endforeach
            </tbody>
            <tr>
                <td></td>
            </tr>
        @endforeach
    </table>
    <table>
        <tr><td></td></tr>
    </table>
    <table style="border: 1px solid black; padding: 2px 10px; ">
        <thead>
            <tr>
                <th class="text-center" colspan="3"> DATA LRPM </th>
            </tr>
            <tr class="text-center table-primary">
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; " colspan="3">Kemajuan PKM Universitas</th>
            </tr>
            <tr>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">PKM</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Submit Usulan</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Submit Laporan Final</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">UNDIRA</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $data['universitas']['submit_usulan_pkm'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $data['universitas']['submit_usulan_pkm'] }} </td>
            </tr>
        </tbody>
        <tr>
            <td></td>
        </tr>
        <thead>
            <tr>
                <th colspan="3" class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Kemajuan PKM Fakultas</th>
            </tr>
            <tr>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Nama Fakultas</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Submit Usulan</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Submit Laporan Final</th>
            </tr>
        </thead>
        <tbody>
            @foreach ( $fakultas as $index => $fak )
                <tr>
                    <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $fak->nama_fakultas }}</td>
                    <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $data['fakultas'][$index][0]['pmsuf'] }}</td>
                    <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $data['fakultas'][$index][0]['pmslff'] }} ({{ $data['fakultas'][$index][0]['pmsuf'] > 0 ? ((intval($data['fakultas'][$index][0]['pmslff'])/intval($data['fakultas'][$index][0]['pmsuf'])) *100) : 0 }}%)</td>
                </tr>
            @endforeach
        </tbody>
        <tr>
            <td></td>
        </tr>
        @foreach ( $fakultas as $infak => $fak )
            <thead>
                <tr class="text-center table-primary">
                    <th class="text-center" style="border: 1px solid black; padding: 2px 10px; " colspan="3">Kemajuan PKM {{ $fak->nama_fakultas }}</th>
                </tr>
                <tr>
                    <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Nama Prodi</th>
                    <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Submit Usulan</th>
                    <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Submit Laporan Final</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $prodi = \App\Models\Department::where('id_fakultas', $fak->id)->get();
                @endphp
                @foreach ( $prodi as $inprod => $prod )
                    <tr>
                        <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $prod['nama_prodi'] }}</td>
                        <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $data['fakultas'][$infak][0]['prodi'][$inprod][0]['pmsup'] }}</td>
                        <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $data['fakultas'][$infak][0]['prodi'][$inprod][0]['pmslfp'] }} ({{ $data['fakultas'][$infak][0]['prodi'][$inprod][0]['pmsup'] > 0 ? (($data['fakultas'][$infak][0]['prodi'][$inprod][0]['pmslfp']/$data['fakultas'][$infak][0]['prodi'][$inprod][0]['pmsup'])*100) : 0 }}%)</td>
                    </tr>
                @endforeach
            </tbody>
            <tr>
                <td></td>
            </tr>
        @endforeach
    </table>
    <table>
        <tr>
            <td style="padding: 20px;"></td>
        </tr>
    </table>
    <table style="border: 1px solid black; padding: 2px 10px; ">
        <thead>
            <tr class="text-center table-primary">
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Proses Laporan Penelitian</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Universitas</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">FBIS</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">FTI</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Submit Usulan</th>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['universitas_penelitian']['submit_laporan'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fbis_penelitian']['submit_laporan'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fti_penelitian']['submit_laporan'] }}</td>
            </tr>
            <tr>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Usulan Diterima</th>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['universitas_penelitian']['laporan_diterima'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fbis_penelitian']['laporan_diterima'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fti_penelitian']['laporan_diterima'] }}</td>
            </tr>
            <tr>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Usulan Ditolak</th>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['universitas_penelitian']['laporan_ditolak'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fbis_penelitian']['laporan_ditolak'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fti_penelitian']['laporan_ditolak'] }}</td>
            </tr>

            <tr>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Upload Proposal</th>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['universitas_penelitian']['upload_proposal'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fbis_penelitian']['upload_proposal'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fti_penelitian']['upload_proposal'] }}</td>
            </tr>
            <tr>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Proposal Diterima</th>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['universitas_penelitian']['proposal_diterima'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fbis_penelitian']['proposal_diterima'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fti_penelitian']['proposal_diterima'] }}</td>
            </tr>

            <tr>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Upload Laporan Akhir</th>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['universitas_penelitian']['upload_laporan_akhir'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fbis_penelitian']['upload_laporan_akhir'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fti_penelitian']['upload_laporan_akhir'] }}</td>
            </tr>
            <tr>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Laporan Akhir Diterima</th>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['universitas_penelitian']['laporan_akhir_diterima'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fbis_penelitian']['laporan_akhir_diterima'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fti_penelitian']['laporan_akhir_diterima'] }}</td>
            </tr>

            <tr>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Persiapan Monev</th>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['universitas_penelitian']['persiapan_monev'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fbis_penelitian']['persiapan_monev'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fti_penelitian']['persiapan_monev'] }}</td>
            </tr>
            <tr>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Review Monev</th>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['universitas_penelitian']['review_monev'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fbis_penelitian']['review_monev'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fti_penelitian']['review_monev'] }}</td>
            </tr>
            <tr>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Revisi Monev</th>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['universitas_penelitian']['revisi_monev'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fbis_penelitian']['revisi_monev'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fti_penelitian']['revisi_monev'] }}</td>
            </tr>
            <tr>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Monev Diterima</th>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['universitas_penelitian']['monev_diterima'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fbis_penelitian']['monev_diterima'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fti_penelitian']['monev_diterima'] }}</td>
            </tr>

            <tr>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Upload Laporan Final</th>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['universitas_penelitian']['upload_laporan_final'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fbis_penelitian']['upload_laporan_final'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fti_penelitian']['upload_laporan_final'] }}</td>
            </tr>
            <tr>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Laporan Final Diterima</th>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['universitas_penelitian']['laporan_final_diterima'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fbis_penelitian']['laporan_final_diterima'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fti_penelitian']['laporan_final_diterima'] }}</td>
            </tr>

            <tr>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Proses Selesai</th>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['universitas_penelitian']['proses_selesai'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fbis_penelitian']['proses_selesai'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fti_penelitian']['proses_selesai'] }}</td>
            </tr>
        </tbody>
        <tr>
            <td></td>
        </tr>
        <thead>
            <tr class="text-center table-primary">
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Proses Laporan PKM</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Universitas</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">FBIS</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">FTI</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Submit Usulan</th>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['universitas_pkm']['submit_laporan'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fbis_pkm']['submit_laporan'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fti_pkm']['submit_laporan'] }}</td>
            </tr>
            <tr>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Usulan Diterima</th>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['universitas_pkm']['laporan_diterima'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fbis_pkm']['laporan_diterima'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fti_pkm']['laporan_diterima'] }}</td>
            </tr>
            <tr>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Usulan Ditolak</th>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['universitas_pkm']['laporan_ditolak'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fbis_pkm']['laporan_ditolak'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fti_pkm']['laporan_ditolak'] }}</td>
            </tr>

            <tr>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Upload Proposal</th>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['universitas_pkm']['upload_proposal'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fbis_pkm']['upload_proposal'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fti_pkm']['upload_proposal'] }}</td>
            </tr>
            <tr>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Proposal Diterima</th>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['universitas_pkm']['proposal_diterima'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fbis_pkm']['proposal_diterima'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fti_pkm']['proposal_diterima'] }}</td>
            </tr>

            <tr>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Upload Laporan Akhir</th>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['universitas_pkm']['upload_laporan_akhir'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fbis_pkm']['upload_laporan_akhir'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fti_pkm']['upload_laporan_akhir'] }}</td>
            </tr>
            <tr>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Laporan Akhir Diterima</th>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['universitas_pkm']['laporan_akhir_diterima'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fbis_pkm']['laporan_akhir_diterima'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fti_pkm']['laporan_akhir_diterima'] }}</td>
            </tr>

            <tr>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Persiapan Monev</th>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['universitas_pkm']['persiapan_monev'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fbis_pkm']['persiapan_monev'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fti_pkm']['persiapan_monev'] }}</td>
            </tr>
            <tr>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Review Monev</th>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['universitas_pkm']['review_monev'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fbis_pkm']['review_monev'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fti_pkm']['review_monev'] }}</td>
            </tr>
            <tr>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Revisi Monev</th>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['universitas_pkm']['revisi_monev'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fbis_pkm']['revisi_monev'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fti_pkm']['revisi_monev'] }}</td>
            </tr>
            <tr>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Monev Diterima</th>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['universitas_pkm']['monev_diterima'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fbis_pkm']['monev_diterima'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fti_pkm']['monev_diterima'] }}</td>
            </tr>

            <tr>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Upload Laporan Final</th>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['universitas_pkm']['upload_laporan_final'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fbis_pkm']['upload_laporan_final'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fti_pkm']['upload_laporan_final'] }}</td>
            </tr>
            <tr>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Laporan Final Diterima</th>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['universitas_pkm']['laporan_final_diterima'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fbis_pkm']['laporan_final_diterima'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fti_pkm']['laporan_final_diterima'] }}</td>
            </tr>

            <tr>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Proses Selesai</th>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['universitas_pkm']['proses_selesai'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fbis_pkm']['proses_selesai'] }}</td>
                <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $process['fti_pkm']['proses_selesai'] }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
