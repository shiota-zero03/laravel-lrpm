<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Penilaian Internal UNDIRA FTI</title>
    <style>
        .table{
            width: 100%;
        }
        .table tr th, .table tr td{
            border: 1px solid  black;
            padding: 10px 5px;
            margin: 0;
        }
        .text-left{
            text-align: left
        }
        .text-right{
            text-align: right
        }
        .text-center{
            text-align: center
        }
    </style>
    @if($tipe == 'final' && auth()->user()->role == 5)
    <style>
        .no-dosen{
            display: none;
        }
    </style>
    @endif
    @if($tipe == 'akhir' && auth()->user()->role == 5 && $nilai->grade_value == 'Diterima')
    <style>
        .no-dosen{
            display: none;
        }
    </style>
    @endif
</head>
<body>
    {{-- <img src="/assets/img/logo-undira.jpg" alt=""> --}}
    <h3 class="text-center">
        FORMULIR PENILAIAN MONEV INTERNAL<br />
        UNIVERSITAS DIAN NUSANTARA<br />
        FAKULTAS TEKNIK DAN INFORMATIKA
    </h3>
    <br>
    <table>
        <tr>
            <th class="text-left">Nama Pengusul</th>
            <td class="text-right" width="50px"> : </td>
            <td>&nbsp;{{ $user->name }}</td>
        </tr>
        <tr>
            <th class="text-left">NIDN</th>
            <td class="text-right" width="50px"> : </td>
            <td>&nbsp;{{ $user->nidn }}</td>
        </tr>
        <tr>
            <th class="text-left">Judul</th>
            <td class="text-right" width="50px"> : </td>
            <td>&nbsp;{{ $submission->judul_usulan }}</td>
        </tr>
        <tr>
            <th class="text-left">Tanggal Monev</th>
            <td class="text-right" width="50px"> : </td>
            <td>&nbsp;{{ date('d-m-Y', strtotime($submission->waktu_laporan_akhir)) }}</td>
        </tr>
    </table>
    <br>
    <table class="table" cellpadding="0" cellspacing="0">
        <tbody id="A">
            <tr class="text-center">
                <th width="5%">A</th>
                <th width="80%">Objek Evaluasi</th>
                <th width="10%">Ya/Belum/Tidak Lengkap</th>
                <th class="no-dosen" width="5%">NILAI</th>
            </tr>
            <tr>
                <td></td>
                <td>
                    1. Apakah abstrak menjelaskan tujuan yang ingin dicapai dalam penelitian?
                </td>
                <td>
                    {{ $nilai->sa1 }}
                </td>
                <td class="text-center no-dosen">
                    {{ $nilai->qa1 }}
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    2. Apakah abstrak menginformasikan metodologi penelitian, pengumpulan data, strategi penelitian, Teknik pengambilan sampel, operasionalisasi variable?
                </td>
                <td>
                    {{ $nilai->sa2 }}
                </td>
                <td class="text-center no-dosen">
                    {{ $nilai->qa2 }}
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    3. Apakah abstrak menjelaskan temuan dari hasil penelitian?
                </td>
                <td>
                    {{ $nilai->sa3 }}
                </td>
                <td class="text-center no-dosen">
                    {{ $nilai->qa3 }}
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    4. Apakah abstrak memiliki keunikan atau kebaruan dari penelitian?
                </td>
                <td>
                    {{ $nilai->sa4 }}
                </td>
                <td class="text-center no-dosen">
                    {{ $nilai->qa4 }}
                </td>
            </tr>
        </tbody>
        <tbody id="B">
            <tr class="text-center">
                <th width="5%">B</th>
                <th>Pendahuluan</th>
                <th>Ya/Belum/Tidak Lengkap</th>
                <th class="no-dosen" width="15%">NILAI</th>
            </tr>
            <tr>
                <td></td>
                <td>
                    1. Apakah latar belakang menjelaskan permasalahan yang akan dilakukan dalam penelitian / fenomena atau gejala?
                </td>
                <td>
                    {{ $nilai->sb1 }}
                </td>
                <td class="text-center no-dosen">
                    {{ $nilai->qb1 }}
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    2. Apakah latar belakang memberikan informasi tujuan dan manfaat dilakukannya penelitian?
                </td>
                <td>
                    {{ $nilai->sb2 }}
                </td>
                <td class="text-center no-dosen">
                    {{ $nilai->qb2 }}
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    3. Apakah latar belakang memberikan informasi urgensi dilakukannya penelitian?
                </td>
                <td>
                    {{ $nilai->sb3 }}
                </td>
                <td class="text-center no-dosen">
                    {{ $nilai->qb3 }}
                </td>
            </tr>
        </tbody>
        <tbody id="C">
            <tr class="text-center">
                <th width="5%">C</th>
                <th>Kajian Pustaka</th>
                <th>Ya/Belum/Tidak Lengkap</th>
                <th class="no-dosen" width="15%">NILAI</th>
            </tr>
            <tr>
                <td></td>
                <td>
                    1. Apakah kajian pustaka menjelaskan variabel yang diteliti dalam penelitian?
                </td>
                <td>
                    {{ $nilai->sc1 }}
                </td>
                <td class="text-center no-dosen">
                    {{ $nilai->qc1 }}
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    2. Apakah kajian pustaka menjelaskan hubungan antar variabel dalam penelitian?
                </td>
                <td>
                    {{ $nilai->sc2 }}
                </td>
                <td class="text-center no-dosen">
                    {{ $nilai->qc2 }}
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    3. Apakah kajian pustaka memberikan informasi mengenai state of the art / penelitian terdahulu yang relevan?
                </td>
                <td>
                    {{ $nilai->sc3 }}
                </td>
                <td class="text-center no-dosen">
                    {{ $nilai->qc3 }}
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    4. Apakah kajian pustaka menyajikan conceptual framework dalam penelitian?
                </td>
                <td>
                    {{ $nilai->sc4 }}
                </td>
                <td class="text-center no-dosen">
                    {{ $nilai->qc4 }}
                </td>
            </tr>
        </tbody>
        <tbody id="D">
            <tr class="text-center">
                <th width="5%">D</th>
                <th>Metodologi Penelitian</th>
                <th>Ya/Belum/Tidak Lengkap</th>
                <th class="no-dosen" width="15%">NILAI</th>
            </tr>
            <tr>
                <td></td>
                <td>
                    1. Apakah metodologi penelitian yang digunakan dengan jelas ?
                </td>
                <td>
                    {{ $nilai->sd1 }}
                </td>
                <td class="text-center no-dosen">
                    {{ $nilai->qd1 }}
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    2. Apakah metodologi penelitian menjelaskan metode pengumpulan data yang digunakan?
                </td>
                <td>
                    {{ $nilai->sd2 }}
                </td>
                <td class="text-center no-dosen">
                    {{ $nilai->qd2 }}
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    3. Apakah metodologi penelitian menjelaskan rencana umum tentang bagaimana peneliti akan menjawab pertanyaan penelitian ?
                </td>
                <td>
                    {{ $nilai->sd3 }}
                </td>
                <td class="text-center no-dosen">
                    {{ $nilai->qd3 }}
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    4. Apakah metodologi penelitian menjelaskan strategi pengambilan sampel dalam penelitian?
                </td>
                <td>
                    {{ $nilai->sd4 }}
                </td>
                <td class="text-center no-dosen">
                    {{ $nilai->qd4 }}
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    5. Apakah metodologi penelitian mendefinisikan dan menghubungkan variable pada literature review sebagai acuan pengukuran dan pengambilan data?
                </td>
                <td>
                    {{ $nilai->sd5 }}
                </td>
                <td class="text-center no-dosen">
                    {{ $nilai->qd5 }}
                </td>
            </tr>
        </tbody>
        <tbody id="E">
            <tr class="text-center">
                <th width="5%">E</th>
                <th>Hasil dan Pembahasan</th>
                <th>Ya/Belum/Tidak Lengkap</th>
                <th class="no-dosen" width="15%">NILAI</th>
            </tr>
            <tr>
                <td></td>
                <td>
                    1. Apakah hasil penelitian menjawab hipotesis atau pertanyaan penelitian sesuai dengan analisis data?
                </td>
                <td>
                    {{ $nilai->se1 }}
                </td>
                <td class="text-center no-dosen">
                    {{ $nilai->qe1 }}
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    2. Apakah temuan hasil penelitian dijelaskan secara akurat?
                </td>
                <td>
                    {{ $nilai->se2 }}
                </td>
                <td class="text-center no-dosen">
                    {{ $nilai->qe2 }}
                </td>
            </tr>
        </tbody>
        <tbody id="F">
            <tr class="text-center">
                <th width="5%">F</th>
                <th>Kesimpulan dan Saran</th>
                <th>Ya/Belum/Tidak Lengkap</th>
                <th class="no-dosen" width="15%">NILAI</th>
            </tr>
            <tr>
                <td></td>
                <td>
                    1. Apakah kesimpulan telah menyajikan kontribusi dalam penelitian ?
                </td>
                <td>
                    {{ $nilai->sf1 }}
                </td>
                <td class="text-center no-dosen">
                    {{ $nilai->qf1 }}
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    2. Apakah menyajikan saran untuk penelitian selanjutnya berdasarkan temuan penelitian?
                </td>
                <td>
                    {{ $nilai->sf2 }}
                </td>
                <td class="text-center no-dosen">
                    {{ $nilai->qf2 }}
                </td>
            </tr>
        </tbody>
        <tbody id="G">
            <tr class="text-center">
                <th width="5%">G</th>
                <th>Roadmap Penelitian</th>
                <th>Ya/Belum/Tidak Lengkap</th>
                <th class="no-dosen" width="15%">NILAI</th>
            </tr>
            <tr>
                <td></td>
                <td>
                    1. Apakah roadmap dalam penelitian yang direncanakan oleh peneliti secara keberlanjutan sudah jelas?
                </td>
                <td>
                    {{ $nilai->sg1 }}
                </td>
                <td class="text-center no-dosen">
                    {{ $nilai->qg1 }}
                </td>
            </tr>
        </tbody>
        <tbody id="H">
            <tr class="text-center">
                <th width="5%">H</th>
                <th>Capaian Target Luaran</th>
                <th>Ya/Belum/Tidak Lengkap</th>
                <th class="no-dosen" width="15%">NILAI</th>
            </tr>
            <tr>
                <td></td>
                <td>
                    1. Apakah telah melampirkan draft artikel penelitian [jika belum publish]?
                </td>
                <td>
                    {{ $nilai->sh1 }}
                </td>
                <td class="text-center no-dosen">
                    {{ $nilai->qh1 }}
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    2. Status target luaran
                </td>
                <td>
                    {{ $nilai->sh2 }}
                </td>
                <td class="text-center no-dosen">
                    {{ $nilai->qh2 }}
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    3. Luaran jurnal publikasi
                </td>
                <td>
                    {{ $nilai->sh3 }}
                </td>
                <td class="text-center no-dosen">
                    {{ $nilai->qh3 }}
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    4. Target luaran tambahan [jika ada]
                </td>
                <td>
                    {{ $nilai->sh4 }}
                </td>
                <td class="text-center no-dosen">
                    {{ $nilai->qh4 }}
                </td>
            </tr>
        </tbody>
        <tbody>
            <tr>
                <th class="no-dosen text-left" colspan="3">Total Nilai (A s/d H)</th>
                <th class="no-dosen">{{ $nilai->total }}</th>
            </tr>
            <tr>
                <th class="no-dosen text-left" colspan="3">Nilai Rata - Rata (A s/d H / 25)</th>
                <th class="no-dosen">{{ $nilai->average }}</th>
            </tr>
            @if(auth()->user()->role !== 5)
                <tr>
                    <th class="text-left" colspan="3">Keterangan</th>
                    <th>{{ $nilai->grade_value }}</th>
                </tr>
            @else
                @if($tipe == 'akhir' && $nilai->grade_value !== 'Diterima')
                    <tr>
                        <th class="text-left" colspan="3">Keterangan</th>
                        <th>{{ $nilai->grade_value }}</th>
                    </tr>
                @else
                    <tr>
                        <th class="text-center" colspan="3">Keterangan</th>
                    </tr>
                    <tr>
                        <th class="text-center" colspan="3">{{ $nilai->grade_value }}</th>
                    </tr>
                @endif
            @endif
            <tr>
                <td
                    @if(auth()->user()->role !== 5)
                        colspan="4"
                    @else
                        @if($tipe == 'akhir' && $nilai->grade_value !== 'Diterima')
                            colspan="4"
                        @else
                            colspan="3"
                        @endif
                    @endif style="padding: 20px 0"></td>
            </tr>
            <tr class="text-center">
                <th
                    @if(auth()->user()->role !== 5)
                        colspan="4"
                    @else
                        @if($tipe == 'akhir' && $nilai->grade_value !== 'Diterima')
                            colspan="4"
                        @else
                            colspan="3"
                        @endif
                    @endif>Komentar Reviewer</th>
            </tr>
            <tr>
                <td
                    @if(auth()->user()->role !== 5)
                        colspan="4"
                    @else
                        @if($tipe == 'akhir' && $nilai->grade_value !== 'Diterima')
                            colspan="4"
                        @else
                            colspan="3"
                        @endif
                    @endif>{{ $nilai->last_comment }}</td>
            </tr>
        </tbody>
    </table>
</body>
