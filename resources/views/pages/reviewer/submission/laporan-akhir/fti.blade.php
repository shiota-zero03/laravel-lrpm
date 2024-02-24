@if( $check_code->status_laporan_akhir == 'Returned to Reviewer' )
    <div class="alert alert-warning fw-bold fst-italic text-center">Penilaian dikembalikan oleh admin</div>
    <span>
        Alasan dikembalikan : <strong>{{ $check_code->alasan_laporan_akhir_ditolak }}</strong>
    </span>
    <br /><br />
@endif
@if( $check_code->status_laporan_akhir == 'Returned to Reviewer' )
@php
    $penilaian = \App\Models\FtiEvaluation::where('id_submission', $check_code->id)->where('tipe', 'Laporan Akhir')->first();
@endphp
<form action="{{ route('reviewer.laporan-akhir.action', ['type' => $type, 'id' => $check_code->id, 'aksi' => 'fti']) }}" id="form-fti" method="post">
    @csrf
    <div class="table-responsive">
        <table class="table table-bordered border-dark">
            <thead>
                <tr class="text-center">
                    <th>KOMENTAR REVIEWER</th>
                    <th width="15%">NILAI</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>A. Abstrak</th>
                    <td rowspan="2" class="align-middle">
                        <input value="{{ $penilaian->q1 }}" oninput="inputValue(1)" required type="number" min="0" max="100" name="q1" class="form-control border border-dark value-fti">
                    </td>
                </tr>
                <tr>
                    <th>
                        <textarea name="k1" id="k1" rows="3" class="form-control border border-dark" placeholder="isi komentar disini">{{ $penilaian->k1 }}</textarea>
                    </th>
                </tr>
                <tr>
                    <th>B. Pendahuluan</th>
                    <td rowspan="2" class="align-middle">
                        <input value="{{ $penilaian->q2 ? $penilaian->q2 : 0 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="q2" class="form-control border border-dark value-fti">
                    </td>
                </tr>
                <tr>
                    <th>
                        <textarea name="k2" id="k2" rows="3" class="form-control border border-dark" placeholder="isi komentar disini">{{ $penilaian->k2 }}</textarea>
                    </th>
                </tr>
                <tr>
                    <th>C. Kajian Pustaka</th>
                    <td rowspan="2" class="align-middle">
                        <input value="{{ $penilaian->q3 ? $penilaian->q3 : 0 }}" oninput="inputValue(3)" required type="number" min="0" max="100" name="q3" class="form-control border border-dark value-fti">
                    </td>
                </tr>
                <tr>
                    <th>
                        <textarea name="k3" id="k3" rows="3" class="form-control border border-dark" placeholder="isi komentar disini">{{ $penilaian->k3 }}</textarea>
                    </th>
                </tr>
                <tr>
                    <th>D. Metodologi Penelitian</th>
                    <td rowspan="2" class="align-middle">
                        <input value="{{ $penilaian->q4 ? $penilaian->q4 : 0 }}" oninput="inputValue(4)" required type="number" min="0" max="100" name="q4" class="form-control border border-dark value-fti">
                    </td>
                </tr>
                <tr>
                    <th>
                        <textarea name="k4" id="k4" rows="3" class="form-control border border-dark" placeholder="isi komentar disini">{{ $penilaian->k4 }}</textarea>
                    </th>
                </tr>
                <tr>
                    <th>E. Hasil</th>
                    <td rowspan="2" class="align-middle">
                        <input value="{{ $penilaian->q5 ? $penilaian->q5 : 0 }}" oninput="inputValue(5)" required type="number" min="0" max="100" name="q5" class="form-control border border-dark value-fti">
                    </td>
                </tr>
                <tr>
                    <th>
                        <textarea name="k5" id="k5" rows="3" class="form-control border border-dark" placeholder="isi komentar disini">{{ $penilaian->k5 }}</textarea>
                    </th>
                </tr>
                <tr>
                    <th>F. Pembahasan</th>
                    <td rowspan="2" class="align-middle">
                        <input value="{{ $penilaian->q6 ? $penilaian->q6 : 0 }}" oninput="inputValue(6)" required type="number" min="0" max="100" name="q6" class="form-control border border-dark value-fti">
                    </td>
                </tr>
                <tr>
                    <th>
                        <textarea name="k6" id="k6" rows="3" class="form-control border border-dark" placeholder="isi komentar disini">{{ $penilaian->k6 }}</textarea>
                    </th>
                </tr>
                <tr>
                    <th>G. Daftar Pustaka</th>
                    <td rowspan="2" class="align-middle">
                        <input value="{{ $penilaian->q7 ? $penilaian->q7 : 0 }}" oninput="inputValue(7)" required type="number" min="0" max="100" name="q7" class="form-control border border-dark value-fti">
                    </td>
                </tr>
                <tr>
                    <th>
                        <textarea name="k7" id="k7" rows="3" class="form-control border border-dark" placeholder="isi komentar disini">{{ $penilaian->k7 }}</textarea>
                    </th>
                </tr>

                <tr>
                    <th>Total Nilai (A s/d G)</th>
                    <th><input value="0" readonly required type="text" min="0" name="total" id="total-fti" class="form-control border border-dark"></th>
                </tr>
                <tr>
                    <th>Nilai Rata - Rata (A s/d G / 7)</th>
                    <th><input value="0" readonly required type="text" min="0" name="average" id="average-fti" class="form-control border border-dark"></th>
                </tr>
                <tr>
                    <th>Keterangan</th>
                    <th>
                        <textarea readonly required name="grade_value" id="grade-value-fti" class="form-control border border-dark" cols="10" rows="3"></textarea>
                    </th>
                </tr>

            </tbody>
        </table>
    </div>
    <style>
        label.check-on-value {
            cursor: pointer;
        }
        input.input-on-value:checked + label.check-on-value {
            background-color: #D4D4D4;
        }
    </style>
    <div class="table-responsive">
        <table class="table table-bordered table-hovered border-dark">
            <tbody>
                <tr>
                    <th colspan="5" class="text-center text-uppercase">Orisinalitas @error('orisinalitas') <small class="text-danger fst-italic">( {{ $message }} )</small>@enderror</th>
                </tr>
                <tr>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Baik Sekali" name="orisinalitas" id="obs1" @if( $penilaian->orisinalitas == 'Baik Sekali' ) checked @endif>
                        <label for="obs1" class="check-on-value w-100 p-2 text-center">Baik Sekali</label>
                    </td>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Baik" name="orisinalitas" id="ob1" @if( $penilaian->orisinalitas == 'Baik' ) checked @endif>
                        <label for="ob1" class="check-on-value w-100 p-2 text-center">Baik</label>
                    </td>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Cukup" name="orisinalitas" id="oc1" @if( $penilaian->orisinalitas == 'Cukup' ) checked @endif>
                        <label for="oc1" class="check-on-value w-100 p-2 text-center">Cukup</label>
                    </td>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Tidak Baik" name="orisinalitas" id="otb1" @if( $penilaian->orisinalitas == 'Tidak Baik' ) checked @endif>
                        <label for="otb1" class="check-on-value w-100 p-2 text-center">Tidak Baik</label>
                    </td>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Sangat Tidak Baik" name="orisinalitas" id="ostb1" @if( $penilaian->orisinalitas == 'Sangat Tidak Baik' ) checked @endif>
                        <label for="ostb1" class="check-on-value w-100 p-2 text-center">Sangat Tidak Baik</label>
                    </td>
                </tr>
                <tr>
                    <th colspan="5" class="text-center text-uppercase">Kualitas Teknikal @error('kualitas_teknikal') <small class="text-danger fst-italic">( {{ $message }} )</small>@enderror</th>
                </tr>
                <tr>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Baik Sekali" name="kualitas_teknikal" id="ktbs1" @if($penilaian->kualitas_teknikal == 'Baik Sekali') checked @endif>
                        <label for="ktbs1" class="check-on-value w-100 p-2 text-center">Baik Sekali</label>
                    </td>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Baik" name="kualitas_teknikal" id="ktb1" @if($penilaian->kualitas_teknikal == 'Baik') checked @endif>
                        <label for="ktb1" class="check-on-value w-100 p-2 text-center">Baik</label>
                    </td>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Cukup" name="kualitas_teknikal" id="ktc1" @if($penilaian->kualitas_teknikal == 'Cukup') checked @endif>
                        <label for="ktc1" class="check-on-value w-100 p-2 text-center">Cukup</label>
                    </td>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Tidak Baik" name="kualitas_teknikal" id="kttb1" @if($penilaian->kualitas_teknikal == 'Tidak Baik') checked @endif>
                        <label for="kttb1" class="check-on-value w-100 p-2 text-center">Tidak Baik</label>
                    </td>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Sangat Tidak Baik" name="kualitas_teknikal" id="ktstb1" @if($penilaian->kualitas_teknikal == 'Sangat Tidak Baik') checked @endif>
                        <label for="ktstb1" class="check-on-value w-100 p-2 text-center">Sangat Tidak Baik</label>
                    </td>
                </tr>
                <tr>
                    <th colspan="5" class="text-center text-uppercase">Metodologi @error('metodologi') <small class="text-danger fst-italic">( {{ $message }} )</small>@enderror</th>
                </tr>
                <tr>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Baik Sekali" name="metodologi" id="mbs1" @if( $penilaian->metodologi == 'Baik Sekali' ) checked @endif>
                        <label for="mbs1" class="check-on-value w-100 p-2 text-center">Baik Sekali</label>
                    </td>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Baik" name="metodologi" id="mb1" @if( $penilaian->metodologi == 'Baik' ) checked @endif>
                        <label for="mb1" class="check-on-value w-100 p-2 text-center">Baik</label>
                    </td>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Cukup" name="metodologi" id="mc1" @if( $penilaian->metodologi == 'Cukup' ) checked @endif>
                        <label for="mc1" class="check-on-value w-100 p-2 text-center">Cukup</label>
                    </td>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Tidak Baik" name="metodologi" id="mtb1" @if( $penilaian->metodologi == 'Tidak Baik' ) checked @endif>
                        <label for="mtb1" class="check-on-value w-100 p-2 text-center">Tidak Baik</label>
                    </td>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Sangat Tidak Baik" name="metodologi" id="mstb1" @if( $penilaian->metodologi == 'Sangat Tidak Baik' ) checked @endif>
                        <label for="mstb1" class="check-on-value w-100 p-2 text-center">Sangat Tidak Baik</label>
                    </td>
                </tr>
                <tr>
                    <th colspan="5" class="text-center text-uppercase">Kejelasan Kalimat @error('kejelasan_kalimat') <small class="text-danger fst-italic">( {{ $message }} )</small>@enderror</th>
                </tr>
                <tr>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Baik Sekali" name="kejelasan_kalimat" id="kkbs1" @if( $penilaian->kejelasan_kalimat == 'Baik Sekali') checked @endif>
                        <label for="kkbs1" class="check-on-value w-100 p-2 text-center">Baik Sekali</label>
                    </td>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Baik" name="kejelasan_kalimat" id="kkb1" @if( $penilaian->kejelasan_kalimat == 'Baik') checked @endif>
                        <label for="kkb1" class="check-on-value w-100 p-2 text-center">Baik</label>
                    </td>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Cukup" name="kejelasan_kalimat" id="kkc1" @if( $penilaian->kejelasan_kalimat == 'Cukup') checked @endif>
                        <label for="kkc1" class="check-on-value w-100 p-2 text-center">Cukup</label>
                    </td>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Tidak Baik" name="kejelasan_kalimat" id="kktb1" @if( $penilaian->kejelasan_kalimat == 'Tidak Baik') checked @endif>
                        <label for="kktb1" class="check-on-value w-100 p-2 text-center">Tidak Baik</label>
                    </td>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Sangat Tidak Baik" name="kejelasan_kalimat" id="kkstb1" @if( $penilaian->kejelasan_kalimat == 'Sangat Tidak Baik') checked @endif>
                        <label for="kkstb1" class="check-on-value w-100 p-2 text-center">Sangat Tidak Baik</label>
                    </td>
                </tr>
                <tr>
                    <th colspan="5" class="text-center text-uppercase">Urgensi @error('urgensi') <small class="text-danger fst-italic">( {{ $message }} )</small>@enderror</th>
                </tr>
                <tr>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Baik Sekali" name="urgensi" id="ubs1" @if( $penilaian->urgensi == 'Baik Sekali' ) checked @endif>
                        <label for="ubs1" class="check-on-value w-100 p-2 text-center">Baik Sekali</label>
                    </td>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Baik" name="urgensi" id="ub1" @if( $penilaian->urgensi == 'Baik' ) checked @endif>
                        <label for="ub1" class="check-on-value w-100 p-2 text-center">Baik</label>
                    </td>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Cukup" name="urgensi" id="uc1" @if( $penilaian->urgensi == 'Cukup' ) checked @endif>
                        <label for="uc1" class="check-on-value w-100 p-2 text-center">Cukup</label>
                    </td>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Tidak Baik" name="urgensi" id="utb1" @if( $penilaian->urgensi == 'Tidak Baik' ) checked @endif>
                        <label for="utb1" class="check-on-value w-100 p-2 text-center">Tidak Baik</label>
                    </td>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Sangat Tidak Baik" name="urgensi" id="ustb1" @if( $penilaian->urgensi == 'Sangat Tidak Baik' ) checked @endif>
                        <label for="ustb1" class="check-on-value w-100 p-2 text-center">Sangat Tidak Baik</label>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <h6 class="text-primary fw-bold">Komentar Reviewer (Keseluruhan)</h6>
    <textarea name="last_comment" id="last_comment" class="form-control border border-dark" rows="5">{{ $penilaian->last_comment }}</textarea>
    <button type="submit" name="update" class="btn btn-primary btn-sm p-2 w-100 mt-3">Kirim Nilai</button>
</form>
@else
<form action="{{ route('reviewer.laporan-akhir.action', ['type' => $type, 'id' => $check_code->id, 'aksi' => 'fti']) }}" id="form-fti" method="post">
    @csrf
    <div class="table-responsive">
        <table class="table table-bordered border-dark">
            <thead>
                <tr class="text-center">
                    <th>KOMENTAR REVIEWER</th>
                    <th width="15%">NILAI</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>A. Abstrak</th>
                    <td rowspan="2" class="align-middle">
                        <input value="{{ old('q1') ? old('q1') : 0 }}" oninput="inputValue(1)" required type="number" min="0" max="100" name="q1" class="form-control border border-dark value-fti">
                    </td>
                </tr>
                <tr>
                    <th>
                        <textarea name="k1" id="k1" rows="3" class="form-control border border-dark" placeholder="isi komentar disini">{{ old('k1') }}</textarea>
                    </th>
                </tr>
                <tr>
                    <th>B. Pendahuluan</th>
                    <td rowspan="2" class="align-middle">
                        <input value="{{ old('q2') ? old('q2') : 0 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="q2" class="form-control border border-dark value-fti">
                    </td>
                </tr>
                <tr>
                    <th>
                        <textarea name="k2" id="k2" rows="3" class="form-control border border-dark" placeholder="isi komentar disini">{{ old('k2') }}</textarea>
                    </th>
                </tr>
                <tr>
                    <th>C. Kajian Pustaka</th>
                    <td rowspan="2" class="align-middle">
                        <input value="{{ old('q3') ? old('q3') : 0 }}" oninput="inputValue(3)" required type="number" min="0" max="100" name="q3" class="form-control border border-dark value-fti">
                    </td>
                </tr>
                <tr>
                    <th>
                        <textarea name="k3" id="k3" rows="3" class="form-control border border-dark" placeholder="isi komentar disini">{{ old('k3') }}</textarea>
                    </th>
                </tr>
                <tr>
                    <th>D. Metodologi Penelitian</th>
                    <td rowspan="2" class="align-middle">
                        <input value="{{ old('q4') ? old('q4') : 0 }}" oninput="inputValue(4)" required type="number" min="0" max="100" name="q4" class="form-control border border-dark value-fti">
                    </td>
                </tr>
                <tr>
                    <th>
                        <textarea name="k4" id="k4" rows="3" class="form-control border border-dark" placeholder="isi komentar disini">{{ old('k4') }}</textarea>
                    </th>
                </tr>
                <tr>
                    <th>E. Hasil</th>
                    <td rowspan="2" class="align-middle">
                        <input value="{{ old('q5') ? old('q5') : 0 }}" oninput="inputValue(5)" required type="number" min="0" max="100" name="q5" class="form-control border border-dark value-fti">
                    </td>
                </tr>
                <tr>
                    <th>
                        <textarea name="k5" id="k5" rows="3" class="form-control border border-dark" placeholder="isi komentar disini">{{ old('k5') }}</textarea>
                    </th>
                </tr>
                <tr>
                    <th>F. Pembahasan</th>
                    <td rowspan="2" class="align-middle">
                        <input value="{{ old('q6') ? old('q6') : 0 }}" oninput="inputValue(6)" required type="number" min="0" max="100" name="q6" class="form-control border border-dark value-fti">
                    </td>
                </tr>
                <tr>
                    <th>
                        <textarea name="k6" id="k6" rows="3" class="form-control border border-dark" placeholder="isi komentar disini">{{ old('k6') }}</textarea>
                    </th>
                </tr>
                <tr>
                    <th>G. Daftar Pustaka</th>
                    <td rowspan="2" class="align-middle">
                        <input value="{{ old('q7') ? old('q7') : 0 }}" oninput="inputValue(7)" required type="number" min="0" max="100" name="q7" class="form-control border border-dark value-fti">
                    </td>
                </tr>
                <tr>
                    <th>
                        <textarea name="k7" id="k7" rows="3" class="form-control border border-dark" placeholder="isi komentar disini">{{ old('k7') }}</textarea>
                    </th>
                </tr>

                <tr>
                    <th>Total Nilai (A s/d G)</th>
                    <th><input value="0" readonly required type="text" min="0" name="total" id="total-fti" class="form-control border border-dark"></th>
                </tr>
                <tr>
                    <th>Nilai Rata - Rata (A s/d G / 7)</th>
                    <th><input value="0" readonly required type="text" min="0" name="average" id="average-fti" class="form-control border border-dark"></th>
                </tr>
                <tr>
                    <th>Keterangan</th>
                    <th>
                        <textarea readonly required name="grade_value" id="grade-value-fti" class="form-control border border-dark" cols="10" rows="3"></textarea>
                    </th>
                </tr>

            </tbody>
        </table>
    </div>
    <style>
        label.check-on-value {
            cursor: pointer;
        }
        input.input-on-value:checked + label.check-on-value {
            background-color: #D4D4D4;
        }
    </style>
    <div class="table-responsive">
        <table class="table table-bordered table-hovered border-dark">
            <tbody>
                <tr>
                    <th colspan="5" class="text-center text-uppercase">Orisinalitas @error('orisinalitas') <small class="text-danger fst-italic">( {{ $message }} )</small>@enderror</th>
                </tr>
                <tr>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Baik Sekali" name="orisinalitas" id="obs1">
                        <label for="obs1" class="check-on-value w-100 p-2 text-center">Baik Sekali</label>
                    </td>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Baik" name="orisinalitas" id="ob1">
                        <label for="ob1" class="check-on-value w-100 p-2 text-center">Baik</label>
                    </td>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Cukup" name="orisinalitas" id="oc1">
                        <label for="oc1" class="check-on-value w-100 p-2 text-center">Cukup</label>
                    </td>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Tidak Baik" name="orisinalitas" id="otb1">
                        <label for="otb1" class="check-on-value w-100 p-2 text-center">Tidak Baik</label>
                    </td>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Sangat Tidak Baik" name="orisinalitas" id="ostb1">
                        <label for="ostb1" class="check-on-value w-100 p-2 text-center">Sangat Tidak Baik</label>
                    </td>
                </tr>
                <tr>
                    <th colspan="5" class="text-center text-uppercase">Kualitas Teknikal @error('kualitas_teknikal') <small class="text-danger fst-italic">( {{ $message }} )</small>@enderror</th>
                </tr>
                <tr>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Baik Sekali" name="kualitas_teknikal" id="ktbs1">
                        <label for="ktbs1" class="check-on-value w-100 p-2 text-center">Baik Sekali</label>
                    </td>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Baik" name="kualitas_teknikal" id="ktb1">
                        <label for="ktb1" class="check-on-value w-100 p-2 text-center">Baik</label>
                    </td>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Cukup" name="kualitas_teknikal" id="ktc1">
                        <label for="ktc1" class="check-on-value w-100 p-2 text-center">Cukup</label>
                    </td>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Tidak Baik" name="kualitas_teknikal" id="kttb1">
                        <label for="kttb1" class="check-on-value w-100 p-2 text-center">Tidak Baik</label>
                    </td>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Sangat Tidak Baik" name="kualitas_teknikal" id="ktstb1">
                        <label for="ktstb1" class="check-on-value w-100 p-2 text-center">Sangat Tidak Baik</label>
                    </td>
                </tr>
                <tr>
                    <th colspan="5" class="text-center text-uppercase">Metodologi @error('metodologi') <small class="text-danger fst-italic">( {{ $message }} )</small>@enderror</th>
                </tr>
                <tr>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Baik Sekali" name="metodologi" id="mbs1">
                        <label for="mbs1" class="check-on-value w-100 p-2 text-center">Baik Sekali</label>
                    </td>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Baik" name="metodologi" id="mb1">
                        <label for="mb1" class="check-on-value w-100 p-2 text-center">Baik</label>
                    </td>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Cukup" name="metodologi" id="mc1">
                        <label for="mc1" class="check-on-value w-100 p-2 text-center">Cukup</label>
                    </td>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Tidak Baik" name="metodologi" id="mtb1">
                        <label for="mtb1" class="check-on-value w-100 p-2 text-center">Tidak Baik</label>
                    </td>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Sangat Tidak Baik" name="metodologi" id="mstb1">
                        <label for="mstb1" class="check-on-value w-100 p-2 text-center">Sangat Tidak Baik</label>
                    </td>
                </tr>
                <tr>
                    <th colspan="5" class="text-center text-uppercase">Kejelasan Kalimat @error('kejelasan_kalimat') <small class="text-danger fst-italic">( {{ $message }} )</small>@enderror</th>
                </tr>
                <tr>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Baik Sekali" name="kejelasan_kalimat" id="kkbs1">
                        <label for="kkbs1" class="check-on-value w-100 p-2 text-center">Baik Sekali</label>
                    </td>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Baik" name="kejelasan_kalimat" id="kkb1">
                        <label for="kkb1" class="check-on-value w-100 p-2 text-center">Baik</label>
                    </td>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Cukup" name="kejelasan_kalimat" id="kkc1">
                        <label for="kkc1" class="check-on-value w-100 p-2 text-center">Cukup</label>
                    </td>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Tidak Baik" name="kejelasan_kalimat" id="kktb1">
                        <label for="kktb1" class="check-on-value w-100 p-2 text-center">Tidak Baik</label>
                    </td>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Sangat Tidak Baik" name="kejelasan_kalimat" id="kkstb1">
                        <label for="kkstb1" class="check-on-value w-100 p-2 text-center">Sangat Tidak Baik</label>
                    </td>
                </tr>
                <tr>
                    <th colspan="5" class="text-center text-uppercase">Urgensi @error('urgensi') <small class="text-danger fst-italic">( {{ $message }} )</small>@enderror</th>
                </tr>
                <tr>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Baik Sekali" name="urgensi" id="ubs1">
                        <label for="ubs1" class="check-on-value w-100 p-2 text-center">Baik Sekali</label>
                    </td>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Baik" name="urgensi" id="ub1">
                        <label for="ub1" class="check-on-value w-100 p-2 text-center">Baik</label>
                    </td>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Cukup" name="urgensi" id="uc1">
                        <label for="uc1" class="check-on-value w-100 p-2 text-center">Cukup</label>
                    </td>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Tidak Baik" name="urgensi" id="utb1">
                        <label for="utb1" class="check-on-value w-100 p-2 text-center">Tidak Baik</label>
                    </td>
                    <td class="p-0">
                        <input class="input-on-value d-none" type="radio" value="Sangat Tidak Baik" name="urgensi" id="ustb1">
                        <label for="ustb1" class="check-on-value w-100 p-2 text-center">Sangat Tidak Baik</label>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <h6 class="text-primary fw-bold">Komentar Reviewer (Keseluruhan)</h6>
    <textarea name="last_comment" id="last_comment" class="form-control border border-dark" rows="5">{{ old('last_comment') }}</textarea>
    <button name="store" type="submit" class="btn btn-primary btn-sm p-2 w-100 mt-3">Kirim Nilai</button>
</form>
@endif

<script>
    function updateValue()
    {
        var value = document.getElementsByClassName('value-fti');
        var total = 0;

        for (var i = 1; i <= value.length; i++) {
            var inputName = 'q' + i;
            var inputValue = parseInt(document.getElementsByName(inputName)[0].value) || 0;
            total += inputValue;
        }

        var average = (total/value.length).toFixed(2)
        document.getElementById('total-fti').value = total;
        document.getElementById('average-fti').value = average;

        if( parseFloat(average) >= 0 && parseFloat(average) <= 54 ) document.getElementById('grade-value-fti').value = 'Ditolak';
        else if( parseFloat(average) > 54 && parseFloat(average) <= 69 ) document.getElementById('grade-value-fti').value = 'Diterima revisi mayor';
        else if( parseFloat(average) > 69 && parseFloat(average) <= 85 ) document.getElementById('grade-value-fti').value = 'Diterima revisi minor';
        else if( parseFloat(average) > 84 && parseFloat(average) <= 100 ) document.getElementById('grade-value-fti').value = 'Diterima';
    }
    updateValue()
    function inputValue(number)
    {
        var inputName = 'q' + number;
        var inputValue = document.getElementsByName(inputName)[0].value;

        if(inputValue > 100) {
            document.getElementsByName(inputName)[0].value = 100;
        } else if(inputValue < 0) {
            document.getElementsByName(inputName)[0].value = '';
        }
        updateValue()


    }
</script>
