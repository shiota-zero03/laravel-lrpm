<?php

namespace App\Http\Controllers\Reviewer\Submission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Submission;
Use App\Models\User;

class LaporanFinalController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->type;
        $data = Submission::where('tipe_submission', $type)
                            ->whereNot('status_akhir', null)
                            ->whereNot('status_laporan_final', null)
                            ->where('review_laporan_akhir_by', auth()->user()->id)
                            ->orderByDesc('id')
                            ->get();
        return view('pages.reviewer.submission.laporan-final.index', compact(['type', 'data']));
    }
    public function tracking(Request $request)
    {
        $type = $request->type;
        $data = Submission::find($request->id);
        if($data->status_akhir == null) abort(404);
        if($data->tipe_submission != $type) abort(404);
        $timeline = \App\Models\TimelineProgress::where('id_submission', $data->id)->orderByDesc('created_at')->get();
        return view('pages.reviewer.submission.laporan-final.tracking', compact(['type', 'data', 'timeline']));
    }
    public function show(Request $request)
    {
        $type = $request->type;
        $check_code = Submission::where('submission_code', $request->submission_code)->first();
        $user = User::find($check_code->id_pengaju);
        if($user->fakultas){
            $select = \App\Models\Faculty::find($user->fakultas);
        } else {
            $select = null;
        }
        if($check_code->status_akhir == null) abort(404);
        return view('pages.reviewer.submission.laporan-final.show', compact(['type', 'check_code', 'user', 'select']));
    }
    public function action(Request $request)
    {
        $check_code = Submission::find($request->id);
        if($request->aksi == 'fti') {
            if(isset($_POST['store'])){
                \App\Models\Notification::create([
                    'id_jenis' => $check_code->id,
                    'jenis_notifikasi' => 'Laporan',
                    'judul_notifikasi' => 'Informasi penerimaan laporan',
                    'text_notifikasi' => 'Laporan Final dengan nomor pengajuan '.$check_code->submission_code.' telah dinilai, menunggu verifikasi oleh admin',
                    'to_role' => 5,
                    'to_id' => $check_code->id_pengaju,
                    'read_status' => 'unread',
                ]);
                \App\Models\Notification::create([
                    'id_jenis' => $check_code->id,
                    'jenis_notifikasi' => 'Laporan',
                    'judul_notifikasi' => 'Informasi penerimaan laporan',
                    'text_notifikasi' => 'Laporan Final dengan nomor pengajuan '.$check_code->submission_code.' telah dinilai, menunggu verifikasi oleh admin',
                    'to_role' => 1,
                    'read_status' => 'unread',
                ]);
                \App\Models\TimelineProgress::create([
                    'id_submission' => $check_code->id,
                    'judul_progress' => 'Laporan dinilai oleh reviewer',
                    'text_progress' => 'Menunggu admin memverifikasi data',
                    'status_progress' => 'success'
                ]);
            } elseif(isset($_POST['update'])){
                \App\Models\Notification::create([
                    'id_jenis' => $check_code->id,
                    'jenis_notifikasi' => 'Laporan',
                    'judul_notifikasi' => 'Informasi penerimaan laporan',
                    'text_notifikasi' => 'Laporan Final dengan nomor pengajuan '.$check_code->submission_code.' telah dinilai kembali, menunggu verifikasi oleh admin',
                    'to_role' => 1,
                    'read_status' => 'unread',
                ]);
                \App\Models\TimelineProgress::create([
                    'id_submission' => $check_code->id,
                    'judul_progress' => 'Laporan dinilai kembali oleh reviewer',
                    'text_progress' => 'Menunggu admin memverifikasi data',
                    'status_progress' => 'success'
                ]);
            }
            $request->validate([
                'orisinalitas' => 'required',
                'kualitas_teknikal' => 'required',
                'metodologi' => 'required',
                'kejelasan_kalimat' => 'required',
                'urgensi' => 'required',
            ], [
                'orisinalitas.required' => 'Pilih salah satu',
                'kualitas_teknikal.required' => 'Pilih salah satu',
                'metodologi.required' => 'Pilih salah satu',
                'kejelasan_kalimat.required' => 'Pilih salah satu',
                'urgensi.required' => 'Pilih salah satu',
            ]);

            $data = [
                'id_submission' => $check_code->id,
                'tipe' => 'Laporan Final',
                'q1' => $request->q1,
                'k1' => $request->k1,
                'q2' => $request->q2,
                'k2' => $request->k2,
                'q3' => $request->q3,
                'k3' => $request->k3,
                'q4' => $request->q4,
                'k4' => $request->k4,
                'q5' => $request->q5,
                'k5' => $request->k5,
                'q6' => $request->q6,
                'k6' => $request->k6,
                'q7' => $request->q7,
                'k7' => $request->k7,
                'total' => $request->total,
                'average' => $request->average,
                'orisinalitas' => $request->orisinalitas,
                'kualitas_teknikal' => $request->kualitas_teknikal,
                'metodologi' => $request->metodologi,
                'kejelasan_kalimat' => $request->kejelasan_kalimat,
                'urgensi' => $request->urgensi,
                'last_comment' => $request->last_comment,
                'grade_value' => $request->grade_value,
            ];

            $update = $check_code->update([
                'status_laporan_final' => 'Waiting for Validation',
            ]);

            $check_submission = \App\Models\FtiEvaluation::where('id_submission', $check_code->id)->where('tipe', 'Laporan Final')->get()->count();

            if($check_submission > 0) {
                $get_submission = \App\Models\FtiEvaluation::where('id_submission', $check_code->id)->where('tipe', 'Laporan Final')->first();
                $create = \App\Models\FtiEvaluation::find($get_submission->id)->update($data);
            } else {
                $create = \App\Models\FtiEvaluation::create($data);
            }
            if($create) {
                return redirect()->to(route('reviewer.laporan-final.index', ['type' => $request->type]));
            }
        } elseif($request->aksi == 'fbis') {
            if(isset($_POST['store'])){
                \App\Models\Notification::create([
                    'id_jenis' => $check_code->id,
                    'jenis_notifikasi' => 'Laporan',
                    'judul_notifikasi' => 'Informasi penerimaan laporan',
                    'text_notifikasi' => 'Laporan Final dengan nomor pengajuan '.$check_code->submission_code.' telah dinilai, menunggu verifikasi oleh admin',
                    'to_role' => 5,
                    'to_id' => $check_code->id_pengaju,
                    'read_status' => 'unread',
                ]);
                \App\Models\Notification::create([
                    'id_jenis' => $check_code->id,
                    'jenis_notifikasi' => 'Laporan',
                    'judul_notifikasi' => 'Informasi penerimaan laporan',
                    'text_notifikasi' => 'Laporan Final dengan nomor pengajuan '.$check_code->submission_code.' telah dinilai, menunggu verifikasi oleh admin',
                    'to_role' => 1,
                    'read_status' => 'unread',
                ]);
                \App\Models\TimelineProgress::create([
                    'id_submission' => $check_code->id,
                    'judul_progress' => 'Laporan dinilai oleh reviewer',
                    'text_progress' => 'Menunggu admin memverifikasi data',
                    'status_progress' => 'success'
                ]);
            } elseif(isset($_POST['update'])){
                \App\Models\Notification::create([
                    'id_jenis' => $check_code->id,
                    'jenis_notifikasi' => 'Laporan',
                    'judul_notifikasi' => 'Informasi penerimaan laporan',
                    'text_notifikasi' => 'Laporan Final dengan nomor pengajuan '.$check_code->submission_code.' telah dinilai kembali, menunggu verifikasi oleh admin',
                    'to_role' => 1,
                    'read_status' => 'unread',
                ]);
                \App\Models\TimelineProgress::create([
                    'id_submission' => $check_code->id,
                    'judul_progress' => 'Laporan dinilai kembali oleh reviewer',
                    'text_progress' => 'Menunggu admin memverifikasi data',
                    'status_progress' => 'success'
                ]);
            }

            $data = [
                'id_submission' => $check_code->id,
                'tipe' => 'Laporan Final',
                'qa1' => $request->qa1,
                'sa1' => $request->sa1,
                'qa2' => $request->qa2,
                'sa2' => $request->sa2,
                'qa3' => $request->qa3,
                'sa3' => $request->sa3,
                'qa4' => $request->qa4,
                'sa4' => $request->sa4,
                'qb1' => $request->qb1,
                'sb1' => $request->sb1,
                'qb2' => $request->qb2,
                'sb2' => $request->sb2,
                'qb3' => $request->qb3,
                'sb3' => $request->sb3,
                'qc1' => $request->qc1,
                'sc1' => $request->sc1,
                'qc2' => $request->qc2,
                'sc2' => $request->sc2,
                'qc3' => $request->qc3,
                'sc3' => $request->sc3,
                'qc4' => $request->qc4,
                'sc4' => $request->sc4,
                'qd1' => $request->qd1,
                'sd1' => $request->sd1,
                'qd2' => $request->qd2,
                'sd2' => $request->sd2,
                'qd3' => $request->qd3,
                'sd3' => $request->sd3,
                'qd4' => $request->qd4,
                'sd4' => $request->sd4,
                'qd5' => $request->qd5,
                'sd5' => $request->sd5,
                'qe1' => $request->qe1,
                'se1' => $request->se1,
                'qe2' => $request->qe2,
                'se2' => $request->se2,
                'qf1' => $request->qf1,
                'sf1' => $request->sf1,
                'qf2' => $request->qf2,
                'sf2' => $request->sf2,
                'qg1' => $request->qg1,
                'sg1' => $request->sg1,
                'qh1' => $request->qh1,
                'sh1' => $request->sh1,
                'qh2' => $request->qh2,
                'sh2' => $request->sh2,
                'qh3' => $request->qh3,
                'sh3' => $request->sh3,
                'qh4' => $request->qh4,
                'sh4' => $request->sh4,
                'total' => $request->total,
                'average' => $request->average,
                'last_comment' => $request->last_comment,
                'grade_value' => $request->grade_value,
            ];

            $update = $check_code->update([
                'status_laporan_final' => 'Waiting for Validation',
            ]);

            $check_submission = \App\Models\FbisEvaluation::where('id_submission', $check_code->id)->where('tipe', 'Laporan Final')->get()->count();

            if($check_submission > 0) {
                $get_submission = \App\Models\FbisEvaluation::where('id_submission', $check_code->id)->where('tipe', 'Laporan Final')->first();
                $create = \App\Models\FbisEvaluation::find($get_submission->id)->update($data);
            } else {
                $create = \App\Models\FbisEvaluation::create($data);
            }
            if($create) {
                return redirect()->to(route('reviewer.laporan-final.index', ['type' => $request->type]));
            }
        }
    }
}
