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
        <tbody>
            <tr class="text-center">
                <th style="width: 90%">KOMENTAR REVIEWER</th>
                <th class="no-dosen" style="width: 10%">NILAI</th>
            </tr>
            <tr>
                <th class="text-left">A. Abstrak</th>
                <th class="no-dosen text-center" rowspan="2">{{ $nilai->q1 }}</th>
            </tr>
            <tr>
                <td class="text-left"><b>Komentar : </b>{{ $nilai->k1 }}</td>
            </tr>
            <tr>
                <th class="text-left">B. Pendahuluan</th>
                <th class="no-dosen text-center" rowspan="2">{{ $nilai->q2 }}</th>
            </tr>
            <tr>
                <td class="text-left"><b>Komentar : </b>{{ $nilai->k2 }}</td>
            </tr>
            <tr>
                <th class="text-left">C. Kajian Pustaka</th>
                <th class="no-dosen text-center" rowspan="2">{{ $nilai->q3 }}</th>
            </tr>
            <tr>
                <td class="text-left"><b>Komentar : </b>{{ $nilai->k3 }}</td>
            </tr>
            <tr>
                <th class="text-left">D. Metodologi Penelitian</th>
                <th class="no-dosen text-center" rowspan="2">{{ $nilai->q4 }}</th>
            </tr>
            <tr>
                <td class="text-left"><b>Komentar : </b>{{ $nilai->k4 }}</td>
            </tr>
            <tr>
                <th class="text-left">E. Hasil</th>
                <th class="no-dosen text-center" rowspan="2">{{ $nilai->q5 }}</th>
            </tr>
            <tr>
                <td class="text-left"><b>Komentar : </b>{{ $nilai->k1 }}</td>
            </tr>
            <tr>
                <th class="text-left">F. Pembahasan</th>
                <th class="no-dosen text-center" rowspan="2">{{ $nilai->q6 }}</th>
            </tr>
            <tr>
                <td class="text-left"><b>Komentar : </b>{{ $nilai->k5 }}</td>
            </tr>
            <tr>
                <th class="text-left">G. Daftar Pustaka</th>
                <th class="no-dosen text-center" rowspan="2">{{ $nilai->q7 }}</th>
            </tr>
            <tr>
                <td class="text-left"><b>Komentar : </b>{{ $nilai->k1 }}</td>
            </tr>

            <tr>
                <th class="no-dosen text-left">Total Nilai (A s/d G)</th>
                <th class="no-dosen text-center" >{{ $nilai->total }}</th>
            </tr>
            <tr>
                <th class="no-dosen text-left">Nilai Rata - Rata (A s/d G / 7)</th>
                <th class="no-dosen text-center" >{{ $nilai->average }}</th>
            </tr>
            <tr>
                <th
                    @if((auth()->user()->role == 5))
                        @if($nilai->grade_value !== 'Diterima') colspan="2" @endif
                    @else
                        colspan="2"
                    @endif>
                    Keterangan :<br />
                    <h2 style="text-transform: uppercase"><span><b>{{ $nilai->grade_value }}</b></span></h2>
                </th>
            </tr>
            <tr>
                <td class="text-center"
                    @if((auth()->user()->role == 5))
                        @if($nilai->grade_value !== 'Diterima') colspan="2" @endif
                    @else
                        colspan="2"
                    @endif>
                    <b>Komentar Keseluruhan :<br /></b>
                    <p class="text-left"><span>{{ $nilai->last_comment }}</span></p>
                </td>
            </tr>

        </tbody>
    </table>
    <br>
    <table class="table" cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
                <th colspan="5" class="text-center text-uppercase">Orisinalitas @error('orisinalitas') <small class="text-danger fst-italic">( {{ $message }} )</small>@enderror</th>
            </tr>
            <tr>
                <td class="text-center">
                    <label class="check-on-value text-center" style="width: 100%; @if($nilai->orisinalitas == 'Baik Sekali') font-weight: 800; @endif">Baik Sekali</label>
                </td>
                <td class="text-center">
                    <label class="check-on-value text-center" style="width: 100%; @if($nilai->orisinalitas == 'Baik') font-weight: 800; @endif">Baik</label>
                </td>
                <td class="text-center">
                    <label class="check-on-value text-center" style="width: 100%; @if($nilai->orisinalitas == 'Cukup') font-weight: 800; @endif">Cukup</label>
                </td>
                <td class="text-center">
                    <label class="check-on-value text-center" style="width: 100%; @if($nilai->orisinalitas == 'Tidak Baik') font-weight: 800; @endif">Tidak Baik</label>
                </td>
                <td class="text-center">
                    <label class="check-on-value text-center" style="width: 100%; @if($nilai->orisinalitas == 'Sangat Tidak Baik') font-weight: 800; @endif">Sangat Tidak Baik</label>
                </td>
            </tr>
            <tr>
                <th colspan="5" class="text-center text-uppercase">Kualitas Teknikal @error('kualitas_teknikal') <small class="text-danger fst-italic">( {{ $message }} )</small>@enderror</th>
            </tr>
            <tr>
                <td class="text-center">
                    <label class="check-on-value text-center" style="width: 100%; @if($nilai->kualitas_teknikal == 'Baik Sekali') font-weight: 800; @endif">Baik Sekali</label>
                </td>
                <td class="text-center">
                    <label class="check-on-value text-center" style="width: 100%; @if($nilai->kualitas_teknikal == 'Baik') font-weight: 800; @endif">Baik</label>
                </td>
                <td class="text-center">
                    <label class="check-on-value text-center" style="width: 100%; @if($nilai->kualitas_teknikal == 'Cukup') font-weight: 800; @endif">Cukup</label>
                </td>
                <td class="text-center">
                    <label class="check-on-value text-center" style="width: 100%; @if($nilai->kualitas_teknikal == 'Tidak Baik') font-weight: 800; @endif">Tidak Baik</label>
                </td>
                <td class="text-center">
                    <label class="check-on-value text-center" style="width: 100%; @if($nilai->kualitas_teknikal == 'Sangat Tidak Baik') font-weight: 800; @endif">Sangat Tidak Baik</label>
                </td>
            </tr>
            <tr>
                <th colspan="5" class="text-center text-uppercase">Metodologi @error('metodologi') <small class="text-danger fst-italic">( {{ $message }} )</small>@enderror</th>
            </tr>
            <tr>
                <td class="text-center">
                    <label class="check-on-value text-center" style="width: 100%; @if($nilai->metodologi == 'Baik Sekali') font-weight: 800; @endif">Baik Sekali</label>
                </td>
                <td class="text-center">
                    <label class="check-on-value text-center" style="width: 100%; @if($nilai->metodologi == 'Baik') font-weight: 800; @endif">Baik</label>
                </td>
                <td class="text-center">
                    <label class="check-on-value text-center" style="width: 100%; @if($nilai->metodologi == 'Cukup') font-weight: 800; @endif">Cukup</label>
                </td>
                <td class="text-center">
                    <label class="check-on-value text-center" style="width: 100%; @if($nilai->metodologi == 'Tidak Baik') font-weight: 800; @endif">Tidak Baik</label>
                </td>
                <td class="text-center">
                    <label class="check-on-value text-center" style="width: 100%; @if($nilai->metodologi == 'Sangat Tidak Baik') font-weight: 800; @endif">Sangat Tidak Baik</label>
                </td>
            </tr>
            <tr>
                <th colspan="5" class="text-center text-uppercase">Kejelasan Kalimat @error('kejelasan_kalimat') <small class="text-danger fst-italic">( {{ $message }} )</small>@enderror</th>
            </tr>
            <tr>
                <td class="text-center">
                    <label class="check-on-value text-center" style="width: 100%; @if($nilai->kejelasan_kalimat == 'Baik Sekali') font-weight: 800; @endif">Baik Sekali</label>
                </td>
                <td class="text-center">
                    <label class="check-on-value text-center" style="width: 100%; @if($nilai->kejelasan_kalimat == 'Baik') font-weight: 800; @endif">Baik</label>
                </td>
                <td class="text-center">
                    <label class="check-on-value text-center" style="width: 100%; @if($nilai->kejelasan_kalimat == 'Cukup') font-weight: 800; @endif">Cukup</label>
                </td>
                <td class="text-center">
                    <label class="check-on-value text-center" style="width: 100%; @if($nilai->kejelasan_kalimat == 'Tidak Baik') font-weight: 800; @endif">Tidak Baik</label>
                </td>
                <td class="text-center">
                    <label class="check-on-value text-center" style="width: 100%; @if($nilai->kejelasan_kalimat == 'Sangat Tidak Baik') font-weight: 800; @endif">Sangat Tidak Baik</label>
                </td>
            </tr>
            <tr>
                <th colspan="5" class="text-center text-uppercase">Urgensi @error('urgensi') <small class="text-danger fst-italic">( {{ $message }} )</small>@enderror</th>
            </tr>
            <tr>
                <td class="text-center">
                    <label class="check-on-value text-center" style="width: 100%; @if($nilai->urgensi == 'Baik Sekali') font-weight: 800; @endif">Baik Sekali</label>
                </td>
                <td class="text-center">
                    <label class="check-on-value text-center" style="width: 100%; @if($nilai->urgensi == 'Baik') font-weight: 800; @endif">Baik</label>
                </td>
                <td class="text-center">
                    <label class="check-on-value text-center" style="width: 100%; @if($nilai->urgensi == 'Cukup') font-weight: 800; @endif">Cukup</label>
                </td>
                <td class="text-center">
                    <label class="check-on-value text-center" style="width: 100%; @if($nilai->urgensi == 'Tidak Baik') font-weight: 800; @endif">Tidak Baik</label>
                </td>
                <td class="text-center">
                    <label class="check-on-value text-center" style="width: 100%; @if($nilai->urgensi == 'Sangat Tidak Baik') font-weight: 800; @endif">Sangat Tidak Baik</label>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>
