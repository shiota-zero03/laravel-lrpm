@php
    $dataarray = ['Lengkap', 'Belum Lengkap', 'Tidak Lengkap'];
@endphp
@if( $check_code->status_laporan_akhir == 'Returned to Reviewer' )
    <div class="alert alert-warning fw-bold fst-italic text-center">Penilaian dikembalikan oleh admin</div>
    <span>
        Alasan dikembalikan : <strong>{{ $check_code->alasan_laporan_akhir_ditolak }}</strong>
    </span>
    <br /><br />
@endif
@if( $check_code->status_laporan_akhir == 'Returned to Reviewer' )
@php
    $penilaian = \App\Models\FbisEvaluation::where('id_submission', $check_code->id)->where('tipe', 'Laporan Akhir')->first();
@endphp
<form action="{{ route('reviewer.laporan-akhir.action', ['type' => $type, 'id' => $check_code->id, 'aksi' => 'fbis']) }}" id="form-fbis" method="post">
    @csrf
    <div class="table-responsive">
        <table class="table table-bordered border-dark">
            <tbody id="A">
                <tr class="text-center">
                    <th width="5%">A</th>
                    <th>Objek Evaluasi</th>
                    <th>Ya/Belum/Tidak Lengkap</th>
                    <th width="15%">NILAI</th>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        1. Apakah abstrak menjelaskan tujuan yang ingin dicapai dalam penelitian?
                    </td>
                    <td>
                        <select name="sa1" id="sa1" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if($penilaian->sa1 == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('a1')" value="{{ $penilaian->qa1 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qa1" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        2. Apakah abstrak menginformasikan metodologi penelitian, pengumpulan data, strategi penelitian, Teknik pengambilan sampel, operasionalisasi variable?
                    </td>
                    <td>
                        <select name="sa2" id="sa2" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if($penilaian->sa2 == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('a2')" value="{{ $penilaian->qa2 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qa2" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        3. Apakah abstrak menjelaskan temuan dari hasil penelitian?
                    </td>
                    <td>
                        <select name="sa3" id="sa3" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if($penilaian->sa3 == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('a3')" value="{{ $penilaian->qa3 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qa3" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        4. Apakah abstrak memiliki keunikan atau kebaruan dari penelitian?
                    </td>
                    <td>
                        <select name="sa4" id="sa4" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if($penilaian->sa4 == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('a4')" value="{{ $penilaian->qa4 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qa4" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
            </tbody>
            <tbody id="B">
                <tr class="text-center">
                    <th width="5%">B</th>
                    <th>Pendahuluan</th>
                    <th>Ya/Belum/Tidak Lengkap</th>
                    <th width="15%">NILAI</th>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        1. Apakah latar belakang menjelaskan permasalahan yang akan dilakukan dalam penelitian / fenomena atau gejala?
                    </td>
                    <td>
                        <select name="sb1" id="sb1" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if($penilaian->sb1 == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('b1')" value="{{ $penilaian->qb1 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qb1" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        2. Apakah latar belakang memberikan informasi tujuan dan manfaat dilakukannya penelitian?
                    </td>
                    <td>
                        <select name="sb2" id="sb2" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if($penilaian->sb2 == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('b2')" value="{{ $penilaian->qb2 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qb2" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        3. Apakah latar belakang memberikan informasi urgensi dilakukannya penelitian?
                    </td>
                    <td>
                        <select name="sb3" id="sb3" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if($penilaian->sb3 == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('b3')" value="{{ $penilaian->qb3 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qb3" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
            </tbody>
            <tbody id="C">
                <tr class="text-center">
                    <th width="5%">C</th>
                    <th>Kajian Pustaka</th>
                    <th>Ya/Belum/Tidak Lengkap</th>
                    <th width="15%">NILAI</th>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        1. Apakah kajian pustaka menjelaskan variabel yang diteliti dalam penelitian?
                    </td>
                    <td>
                        <select name="sc1" id="sc1" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if($penilaian->sc1 == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('c1')" value="{{ $penilaian->qc1 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qc1" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        2. Apakah kajian pustaka menjelaskan hubungan antar variabel dalam penelitian?
                    </td>
                    <td>
                        <select name="sc2" id="sc2" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if($penilaian->sc2 == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('c2')" value="{{ $penilaian->qc2 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qc2" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        3. Apakah kajian pustaka memberikan informasi mengenai state of the art / penelitian terdahulu yang relevan?
                    </td>
                    <td>
                        <select name="sc3" id="sc3" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if($penilaian->sc3 == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('c3')" value="{{ $penilaian->qc3 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qc3" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        4. Apakah kajian pustaka menyajikan conceptual framework dalam penelitian?
                    </td>
                    <td>
                        <select name="sc4" id="sc4" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if($penilaian->sc4 == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('c4')" value="{{ $penilaian->qc4 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qc4" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
            </tbody>
            <tbody id="D">
                <tr class="text-center">
                    <th width="5%">D</th>
                    <th>Metodologi Penelitian</th>
                    <th>Ya/Belum/Tidak Lengkap</th>
                    <th width="15%">NILAI</th>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        1. Apakah metodologi penelitian yang digunakan dengan jelas ?
                    </td>
                    <td>
                        <select name="sd1" id="sd1" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if($penilaian->sd1 == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('d1')" value="{{ $penilaian->qd1 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qd1" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        2. Apakah metodologi penelitian menjelaskan metode pengumpulan data yang digunakan?
                    </td>
                    <td>
                        <select name="sd2" id="sd2" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if($penilaian->sd2 == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('d2')" value="{{ $penilaian->qd2 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qd2" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        3. Apakah metodologi penelitian menjelaskan rencana umum tentang bagaimana peneliti akan menjawab pertanyaan penelitian ?
                    </td>
                    <td>
                        <select name="sd3" id="sd3" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if($penilaian->sd3 == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('d3')" value="{{ $penilaian->qd3 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qd3" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        4. Apakah metodologi penelitian menjelaskan strategi pengambilan sampel dalam penelitian?
                    </td>
                    <td>
                        <select name="sd4" id="sd4" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if($penilaian->sd4 == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('d4')" value="{{ $penilaian->qd4 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qd4" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        5. Apakah metodologi penelitian mendefinisikan dan menghubungkan variable pada literature review sebagai acuan pengukuran dan pengambilan data?
                    </td>
                    <td>
                        <select name="sd5" id="sd5" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if($penilaian->sd5 == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('d5')" value="{{ $penilaian->qd5 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qd5" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
            </tbody>
            <tbody id="E">
                <tr class="text-center">
                    <th width="5%">E</th>
                    <th>Hasil dan Pembahasan</th>
                    <th>Ya/Belum/Tidak Lengkap</th>
                    <th width="15%">NILAI</th>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        1. Apakah hasil penelitian menjawab hipotesis atau pertanyaan penelitian sesuai dengan analisis data?
                    </td>
                    <td>
                        <select name="se1" id="se1" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if($penilaian->se1 == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('e1')" value="{{ $penilaian->qe1 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qe1" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        2. Apakah temuan hasil penelitian dijelaskan secara akurat?
                    </td>
                    <td>
                        <select name="se2" id="se2" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if($penilaian->se2 == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('e2')" value="{{ $penilaian->qe2 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qe2" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
            </tbody>
            <tbody id="F">
                <tr class="text-center">
                    <th width="5%">F</th>
                    <th>Kesimpulan dan Saran</th>
                    <th>Ya/Belum/Tidak Lengkap</th>
                    <th width="15%">NILAI</th>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        1. Apakah kesimpulan telah menyajikan kontribusi dalam penelitian ?
                    </td>
                    <td>
                        <select name="sf1" id="sf1" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if($penilaian->sf1 == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('f1')" value="{{ $penilaian->qf1 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qf1" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        2. Apakah menyajikan saran untuk penelitian selanjutnya berdasarkan temuan penelitian?
                    </td>
                    <td>
                        <select name="sf2" id="sf2" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if($penilaian->sf2 == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('f2')" value="{{ $penilaian->qf2 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qf2" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
            </tbody>
            <tbody id="G">
                <tr class="text-center">
                    <th width="5%">G</th>
                    <th>Roadmap Penelitian</th>
                    <th>Ya/Belum/Tidak Lengkap</th>
                    <th width="15%">NILAI</th>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        1. Apakah roadmap dalam penelitian yang direncanakan oleh peneliti secara keberlanjutan sudah jelas?
                    </td>
                    <td>
                        <select name="sg1" id="sg1" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if($penilaian->sg1 == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('g1')" value="{{ $penilaian->qg1 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qg1" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
            </tbody>
            <tbody id="H">
                <tr class="text-center">
                    <th width="5%">H</th>
                    <th>Capaian Target Luaran</th>
                    <th>Ya/Belum/Tidak Lengkap</th>
                    <th width="15%">NILAI</th>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        1. Apakah telah melampirkan draft artikel penelitian [jika belum publish]?
                    </td>
                    <td>
                        <select name="sh1" id="sh1" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if($penilaian->sh1 == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('h1')" value="{{ $penilaian->qh1 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qh1" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        2. Status target luaran
                    </td>
                    <td>
                        <select name="sh2" id="sh2" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if($penilaian->sh2 == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('h2')" value="{{ $penilaian->qh2 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qh2" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        3. Luaran jurnal publikasi
                    </td>
                    <td>
                        <select name="sh3" id="sh3" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if($penilaian->sh3 == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('h3')" value="{{ $penilaian->qh3 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qh3" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        4. Target luaran tambahan [jika ada]
                    </td>
                    <td>
                        <select name="sh4" id="sh4" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if($penilaian->sh4 == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('h4')" value="{{ $penilaian->qh4 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qh4" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
            </tbody>
            <tbody>
                <tr>
                    <th colspan="3">Total Nilai (A s/d H)</th>
                    <th><input value="0" readonly required type="text" min="0" name="total" id="total-fbis" class="form-control border border-dark"></th>
                </tr>
                <tr>
                    <th colspan="3">Nilai Rata - Rata (A s/d H / 25)</th>
                    <th><input value="0" readonly required type="text" min="0" name="average" id="average-fbis" class="form-control border border-dark"></th>
                </tr>
                <tr>
                    <th colspan="3">Keterangan</th>
                    <th>
                        <textarea readonly required name="grade_value" id="grade-value-fbis" class="form-control border border-dark" cols="10" rows="3"></textarea>
                    </th>
                </tr>
            </tbody>
        </table>
    </div>
    <h6 class="text-primary fw-bold">Komentar Reviewer (Keseluruhan)</h6>
    <textarea name="last_comment" id="last_comment" class="form-control border border-dark" rows="5">{{ $penilaian->last_comment }}</textarea>
    <button type="submit" name="update" class="btn btn-primary btn-sm p-2 w-100 mt-3">Kirim Nilai</button>
</form>
@else
<form action="{{ route('reviewer.laporan-akhir.action', ['type' => $type, 'id' => $check_code->id, 'aksi' => 'fbis']) }}" id="form-fbis" method="post">
    @csrf
    <div class="table-responsive">
        <table class="table table-bordered border-dark">
            <tbody id="A">
                <tr class="text-center">
                    <th width="5%">A</th>
                    <th>Objek Evaluasi</th>
                    <th>Ya/Belum/Tidak Lengkap</th>
                    <th width="15%">NILAI</th>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        1. Apakah abstrak menjelaskan tujuan yang ingin dicapai dalam penelitian?
                    </td>
                    <td>
                        <select name="sa1" id="sa1" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if(old('sa1') == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('a1')" value="{{ old('qa1') ? old('qa1') : 0 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qa1" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        2. Apakah abstrak menginformasikan metodologi penelitian, pengumpulan data, strategi penelitian, Teknik pengambilan sampel, operasionalisasi variable?
                    </td>
                    <td>
                        <select name="sa2" id="sa2" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if(old('sa2') == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('a2')" value="{{ old('qa2') ? old('qa2') : 0 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qa2" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        3. Apakah abstrak menjelaskan temuan dari hasil penelitian?
                    </td>
                    <td>
                        <select name="sa3" id="sa3" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if(old('sa3') == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('a3')" value="{{ old('qa3') ? old('qa3') : 0 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qa3" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        4. Apakah abstrak memiliki keunikan atau kebaruan dari penelitian?
                    </td>
                    <td>
                        <select name="sa4" id="sa4" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if(old('sa4') == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('a4')" value="{{ old('qa4') ? old('qa4') : 0 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qa4" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
            </tbody>
            <tbody id="B">
                <tr class="text-center">
                    <th width="5%">B</th>
                    <th>Pendahuluan</th>
                    <th>Ya/Belum/Tidak Lengkap</th>
                    <th width="15%">NILAI</th>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        1. Apakah latar belakang menjelaskan permasalahan yang akan dilakukan dalam penelitian / fenomena atau gejala?
                    </td>
                    <td>
                        <select name="sb1" id="sb1" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if(old('sb1') == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('b1')" value="{{ old('qb1') ? old('qb1') : 0 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qb1" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        2. Apakah latar belakang memberikan informasi tujuan dan manfaat dilakukannya penelitian?
                    </td>
                    <td>
                        <select name="sb2" id="sb2" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if(old('sb2') == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('b2')" value="{{ old('qb2') ? old('qb2') : 0 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qb2" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        3. Apakah latar belakang memberikan informasi urgensi dilakukannya penelitian?
                    </td>
                    <td>
                        <select name="sb3" id="sb3" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if(old('sb3') == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('b3')" value="{{ old('qb3') ? old('qb3') : 0 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qb3" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
            </tbody>
            <tbody id="C">
                <tr class="text-center">
                    <th width="5%">C</th>
                    <th>Kajian Pustaka</th>
                    <th>Ya/Belum/Tidak Lengkap</th>
                    <th width="15%">NILAI</th>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        1. Apakah kajian pustaka menjelaskan variabel yang diteliti dalam penelitian?
                    </td>
                    <td>
                        <select name="sc1" id="sc1" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if(old('sc1') == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('c1')" value="{{ old('qc1') ? old('qc1') : 0 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qc1" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        2. Apakah kajian pustaka menjelaskan hubungan antar variabel dalam penelitian?
                    </td>
                    <td>
                        <select name="sc2" id="sc2" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if(old('sc2') == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('c2')" value="{{ old('qc2') ? old('qc2') : 0 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qc2" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        3. Apakah kajian pustaka memberikan informasi mengenai state of the art / penelitian terdahulu yang relevan?
                    </td>
                    <td>
                        <select name="sc3" id="sc3" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if(old('sc3') == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('c3')" value="{{ old('qc3') ? old('qc3') : 0 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qc3" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        4. Apakah kajian pustaka menyajikan conceptual framework dalam penelitian?
                    </td>
                    <td>
                        <select name="sc4" id="sc4" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if(old('sc4') == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('c4')" value="{{ old('qc4') ? old('qc4') : 0 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qc4" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
            </tbody>
            <tbody id="D">
                <tr class="text-center">
                    <th width="5%">D</th>
                    <th>Metodologi Penelitian</th>
                    <th>Ya/Belum/Tidak Lengkap</th>
                    <th width="15%">NILAI</th>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        1. Apakah metodologi penelitian yang digunakan dengan jelas ?
                    </td>
                    <td>
                        <select name="sd1" id="sd1" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if(old('sd1') == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('d1')" value="{{ old('qd1') ? old('qd1') : 0 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qd1" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        2. Apakah metodologi penelitian menjelaskan metode pengumpulan data yang digunakan?
                    </td>
                    <td>
                        <select name="sd2" id="sd2" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if(old('sd2') == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('d2')" value="{{ old('qd2') ? old('qd2') : 0 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qd2" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        3. Apakah metodologi penelitian menjelaskan rencana umum tentang bagaimana peneliti akan menjawab pertanyaan penelitian ?
                    </td>
                    <td>
                        <select name="sd3" id="sd3" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if(old('sd3') == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('d3')" value="{{ old('qd3') ? old('qd3') : 0 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qd3" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        4. Apakah metodologi penelitian menjelaskan strategi pengambilan sampel dalam penelitian?
                    </td>
                    <td>
                        <select name="sd4" id="sd4" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if(old('sd4') == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('d4')" value="{{ old('qd4') ? old('qd4') : 0 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qd4" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        5. Apakah metodologi penelitian mendefinisikan dan menghubungkan variable pada literature review sebagai acuan pengukuran dan pengambilan data?
                    </td>
                    <td>
                        <select name="sd5" id="sd5" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if(old('sd5') == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('d5')" value="{{ old('qd5') ? old('qd5') : 0 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qd5" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
            </tbody>
            <tbody id="E">
                <tr class="text-center">
                    <th width="5%">E</th>
                    <th>Hasil dan Pembahasan</th>
                    <th>Ya/Belum/Tidak Lengkap</th>
                    <th width="15%">NILAI</th>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        1. Apakah hasil penelitian menjawab hipotesis atau pertanyaan penelitian sesuai dengan analisis data?
                    </td>
                    <td>
                        <select name="se1" id="se1" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if(old('se1') == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('e1')" value="{{ old('qe1') ? old('qe1') : 0 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qe1" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        2. Apakah temuan hasil penelitian dijelaskan secara akurat?
                    </td>
                    <td>
                        <select name="se2" id="se2" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if(old('se2') == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('e2')" value="{{ old('qe2') ? old('qe2') : 0 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qe2" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
            </tbody>
            <tbody id="F">
                <tr class="text-center">
                    <th width="5%">F</th>
                    <th>Kesimpulan dan Saran</th>
                    <th>Ya/Belum/Tidak Lengkap</th>
                    <th width="15%">NILAI</th>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        1. Apakah kesimpulan telah menyajikan kontribusi dalam penelitian ?
                    </td>
                    <td>
                        <select name="sf1" id="sf1" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if(old('sf1') == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('f1')" value="{{ old('qf1') ? old('qf1') : 0 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qf1" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        2. Apakah menyajikan saran untuk penelitian selanjutnya berdasarkan temuan penelitian?
                    </td>
                    <td>
                        <select name="sf2" id="sf2" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if(old('sf2') == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('f2')" value="{{ old('qf2') ? old('qf2') : 0 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qf2" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
            </tbody>
            <tbody id="G">
                <tr class="text-center">
                    <th width="5%">G</th>
                    <th>Roadmap Penelitian</th>
                    <th>Ya/Belum/Tidak Lengkap</th>
                    <th width="15%">NILAI</th>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        1. Apakah roadmap dalam penelitian yang direncanakan oleh peneliti secara keberlanjutan sudah jelas?
                    </td>
                    <td>
                        <select name="sg1" id="sg1" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if(old('sg1') == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('g1')" value="{{ old('qg1') ? old('qg1') : 0 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qg1" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
            </tbody>
            <tbody id="H">
                <tr class="text-center">
                    <th width="5%">H</th>
                    <th>Capaian Target Luaran</th>
                    <th>Ya/Belum/Tidak Lengkap</th>
                    <th width="15%">NILAI</th>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        1. Apakah telah melampirkan draft artikel penelitian [jika belum publish]?
                    </td>
                    <td>
                        <select name="sh1" id="sh1" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if(old('sh1') == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('h1')" value="{{ old('qh1') ? old('qh1') : 0 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qh1" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        2. Status target luaran
                    </td>
                    <td>
                        <select name="sh2" id="sh2" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if(old('sh2') == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('h2')" value="{{ old('qh2') ? old('qh2') : 0 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qh2" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        3. Luaran jurnal publikasi
                    </td>
                    <td>
                        <select name="sh3" id="sh3" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if(old('sh3') == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('h3')" value="{{ old('qh3') ? old('qh3') : 0 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qh3" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        4. Target luaran tambahan [jika ada]
                    </td>
                    <td>
                        <select name="sh4" id="sh4" class="form-control border border-dark">
                            @foreach ( $dataarray as $arr )
                                <option @if(old('sh4') == $arr) selected @endif value="{{ $arr }}">{{ $arr }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input oninput="inputValue('h4')" value="{{ old('qh4') ? old('qh4') : 0 }}" oninput="inputValue(2)" required type="number" min="0" max="100" name="qh4" class="form-control border border-dark value-fbis">
                    </td>
                </tr>
            </tbody>
            <tbody>
                <tr>
                    <th colspan="3">Total Nilai (A s/d H)</th>
                    <th><input value="0" readonly required type="text" min="0" name="total" id="total-fbis" class="form-control border border-dark"></th>
                </tr>
                <tr>
                    <th colspan="3">Nilai Rata - Rata (A s/d H / 25)</th>
                    <th><input value="0" readonly required type="text" min="0" name="average" id="average-fbis" class="form-control border border-dark"></th>
                </tr>
                <tr>
                    <th colspan="3">Keterangan</th>
                    <th>
                        <textarea readonly required name="grade_value" id="grade-value-fbis" class="form-control border border-dark" cols="10" rows="3"></textarea>
                    </th>
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
        var value = document.getElementsByClassName('value-fbis');
        var total = 0;

        for (var i = 0; i < value.length; i++) {
            var inputName = 'q' + i;
            var inputValue = parseInt(document.getElementsByClassName('value-fbis')[i].value) || 0;
            total += inputValue;
        }

        var average = (total/value.length).toFixed(2)
        document.getElementById('total-fbis').value = total;
        document.getElementById('average-fbis').value = average;

        if( parseFloat(average) >= 0 && parseFloat(average) <= 54 ) document.getElementById('grade-value-fbis').value = 'Ditolak';
        else if( parseFloat(average) > 54 && parseFloat(average) <= 69 ) document.getElementById('grade-value-fbis').value = 'Diterima revisi mayor';
        else if( parseFloat(average) > 69 && parseFloat(average) <= 85 ) document.getElementById('grade-value-fbis').value = 'Diterima revisi minor';
        else if( parseFloat(average) > 84 && parseFloat(average) <= 100 ) document.getElementById('grade-value-fbis').value = 'Diterima';
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
