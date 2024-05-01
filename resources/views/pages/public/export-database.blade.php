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
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=data_submission.xls");
    @endphp
    <table style="border: 1px solid black; padding: 2px 10px; ">
        <thead>
            <tr>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; " colspan="38"> DATA Pengajuan Usulan </th>
            </tr>
            <tr>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">No</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Jenis Usulan</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Kode Pengajuan</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Nama Ketua</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">NIDN</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Jabatan Fungsional</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Alamat Email</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">No. Handphone</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Program Studi</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Fakultas</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">ID Scopus</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">ID SINTA</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">ID Google Scholar</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Anggota (Dosen 1)</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Anggota (Dosen 2)</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Mahasiswa / NIM 1</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Mahasiswa / NIM 2</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Skema Usulan</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Judul Usulan (Sebelumnya)</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Riset Unggulan Usulan</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Tema</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Topik</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Target Luaran (Awal)</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Target Luaran Tambahan (Opsional)</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; "> Mitra (Jika ada)</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Institusi Mitra (Jika ada)</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Pendanaan dari Mitra (Jika ada)</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Link Usulan Baru</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Link Proposal</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Link SPK</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Link Laporan Akhir</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Link Laporan Final</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; "> Jurnal</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Link Jurnal</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Status Jurnal</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Judul Publikasi</th>
                <th class="text-center" style="border: 1px solid black; padding: 2px 10px; ">Target Luaran (Akhir)</th>

            </tr>
        </thead>
        <tbody>
            @if($submission->count() > 0)
            @foreach($submission as $index => $sub)
                @php
                    $leader = \App\Models\User::find($sub->id_pengaju);
                    $dosen = \App\Models\Participant::where('id_submission', $sub->id)->where('role', 'Dosen')->get();
                    $mahasiswa = \App\Models\Participant::where('id_submission', $sub->id)->where('role', 'Mahasiswa')->get();
                @endphp
                <tr>
                    <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $index + 1 }}</td>
                    <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $sub->tipe_submission == 'penelitian' ? 'Penelitian' : 'Pengabdian Masyarakat' }}</td>
                    <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $sub->submission_code }}</td>

                    <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $leader->name }}</td>
                    <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $leader->nidn }}</td>
                    <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ \App\Models\Position::find($leader->jabatan) ? \App\Models\Position::find($leader->jabatan)->nama_jabatan : '' }}</td>
                    <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $leader->email }}</td>
                    <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $leader->no_hp }}</td>
                    <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ \App\Models\Department::find($leader->prodi) ? \App\Models\Department::find($leader->prodi)->nama_prodi : '' }}</td>
                    <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ \App\Models\Faculty::find($leader->fakultas) ? \App\Models\Faculty::find($leader->fakultas)->nama_fakultas : '' }}</td>
                    <td class="text-center" style="border: 1px solid black; padding: 2px 10px; "><a href="{{ $leader->id_scopus }}">{{ $leader->id_scopus }}</a></td>
                    <td class="text-center" style="border: 1px solid black; padding: 2px 10px; "><a href="{{ $leader->id_sinta }}">{{ $leader->id_sinta }}</a></td>
                    <td class="text-center" style="border: 1px solid black; padding: 2px 10px; "><a href="{{ $leader->id_google_scholar }}">{{ $leader->id_google_scholar }}</a></td>

                    @if($dosen->count() > 0)
                        <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $dosen[0]->nama }}</td>
                        @if($dosen->count() > 1)
                            <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $dosen[1]->nama }}</td>
                        @else
                        <td class="text-center" style="border: 1px solid black; padding: 2px 10px; "></td>
                        @endif
                    @else
                        <td class="text-center" style="border: 1px solid black; padding: 2px 10px; "></td>
                        <td class="text-center" style="border: 1px solid black; padding: 2px 10px; "></td>
                    @endif

                    @if($mahasiswa->count() > 0)
                        <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $mahasiswa[0]->nama }}</td>
                        @if($mahasiswa->count() > 1)
                            <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $mahasiswa[1]->nama }}</td>
                        @else
                        <td class="text-center" style="border: 1px solid black; padding: 2px 10px; "></td>
                        @endif
                    @else
                        <td class="text-center" style="border: 1px solid black; padding: 2px 10px; "></td>
                        <td class="text-center" style="border: 1px solid black; padding: 2px 10px; "></td>
                    @endif

                    <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ \App\Models\Schema::find($sub->skema) ? \App\Models\Schema::find($sub->skema)->nama_skema : '' }}</td>
                    <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $sub->judul_usulan }}</td>
                    <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ \App\Models\SuperiorResearch::find($sub->riset_unggulan) ? \App\Models\SuperiorResearch::find($sub->riset_unggulan)->nama_riset : '' }}</td>
                    <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ \App\Models\Theme::find($sub->tema) ? \App\Models\Theme::find($sub->tema)->nama_tema : '' }}</td>
                    <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ \App\Models\Topic::find($sub->topik) ? \App\Models\Topic::find($sub->topik)->nama_topik : '' }}</td>
                    <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ \App\Models\Outer::find($sub->target_luaran) ? \App\Models\Outer::find($sub->target_luaran)->nama_luaran : '' }}</td>
                    <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $sub->target_luaran_tambahan }}</td>
                    <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $sub->nama_mitra }}</td>
                    <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $sub->institusi_mitra }}</td>
                    <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ \App\Models\MitraFunding::find($sub->id_pendanaan_mitra) ? \App\Models\MitraFunding::find($sub->id_pendanaan_mitra)->nama_pendanaan : '' }}</td>
                    <td class="text-center" style="border: 1px solid black; padding: 2px 10px; "><a href="{{ $sub->dokumen_usulan ? asset('assets/storage/files/dokumen-usulan/'.$sub->dokumen_usulan) : '#' }}">{{ $sub->dokumen_usulan ? asset('assets/storage/files/dokumen-usulan/'.$sub->dokumen_usulan) : '' }}</a></td>
                    <td class="text-center" style="border: 1px solid black; padding: 2px 10px; "><a href="{{ $sub->proposal_usulan ? asset('assets/storage/files/dokumen-proposal/'.$sub->proposal_usulan) : '#' }}">{{ $sub->proposal_usulan ? asset('assets/storage/files/dokumen-proposal/'.$sub->proposal_usulan) : '' }}</a></td>
                    <td class="text-center" style="border: 1px solid black; padding: 2px 10px; "><a href="{{ $sub->spk_upload ? asset('assets/storage/files/spk-upload/'.$sub->spk_upload) : '#' }}">{{ $sub->spk_upload ? asset('assets/storage/files/spk-upload/'.$sub->spk_upload) : '' }}</a></td>
                    <td class="text-center" style="border: 1px solid black; padding: 2px 10px; "><a href="{{ $sub->laporan_akhir ? asset('assets/storage/files/laporan-akhir/'.$sub->laporan_akhir) : '#' }}">{{ $sub->laporan_akhir ? asset('assets/storage/files/laporan-akhir/'.$sub->laporan_akhir) : '' }}</a></td>
                    <td class="text-center" style="border: 1px solid black; padding: 2px 10px; "><a href="{{ $sub->laporan_final ? asset('assets/storage/files/laporan-final/'.$sub->laporan_final) : '#' }}">{{ $sub->laporan_final ? asset('assets/storage/files/laporan-final/'.$sub->laporan_final) : '' }}</a></td>
                    <td class="text-center" style="border: 1px solid black; padding: 2px 10px; "><a href="{{ $sub->draft_artikel ? asset('assets/storage/files/publikasi/draft-artikel/'.$sub->draft_artikel) : '#' }}">{{ $sub->draft_artikel ? asset('assets/storage/files/publikasi/draft-artikel/'.$sub->draft_artikel) : '' }}</a></td>
                    <td class="text-center" style="border: 1px solid black; padding: 2px 10px; "><a href="{{ $sub->link_jurnal }}">{{ $sub->link_jurnal }}</a></td>
                    <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">
                        @php
                            if ($sub->dokumen_publish) {
                                echo 'Published';
                            } else {
                                if($sub->dokumen_accepted){
                                    echo 'Accepted';
                                } else {
                                    if($sub->dokumen_revision) {
                                        echo 'Revised';
                                    } else {
                                        if($sub->dokumen_rejected) {
                                            echo 'Rejected';
                                        } else {
                                            if($sub->dokumen_submit) {
                                                echo 'Submitted';
                                            }
                                        }
                                    }
                                }
                            }
                        @endphp
                    </td>
                    <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ $sub->judul_publikasi }}</td>
                    <td class="text-center" style="border: 1px solid black; padding: 2px 10px; ">{{ \App\Models\Outer::find($sub->luaran_publikasi) ? \App\Models\Outer::find($sub->luaran_publikasi)->nama_luaran : '' }}</td>
                </tr>
            @endforeach
            @else
                <tr>
                    <th class="text-center" style="border: 1px solid black; padding: 2px 10px; " colspan="38"> Tidak Ada Data Usulan </th>
                </tr>
            @endif
        </tbody>
    </table>
</body>
</html>
