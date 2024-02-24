<?php

namespace App\Http\Controllers\Fakultas\Submission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Submission;
use App\Models\User;

class LaporanFinalController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->type;
        $data = Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')
                            ->where('users.fakultas', auth()->user()->fakultas)
                            ->where('submissions.tipe_submission', $type)
                            ->whereNot('submissions.status_usulan', null)
                            ->whereNot('submissions.status_usulan', 'Draft')
                            ->whereNot('submissions.status_usulan', 'Pending by Admin')
                            ->whereNot('submissions.status_usulan', 'Returned by Admin')
                            ->whereNot('submissions.status_usulan', 'Rejected by Admin')
                            ->whereNot('submissions.status_akhir', null)
                            ->whereNot('submissions.status_laporan_final', null)
                            ->select('submissions.*', 'users.fakultas')
                            ->orderByDesc('submissions.id')
                            ->get();
        return view('pages.fakultas.submission.laporan-final.index', compact(['type', 'data']));
    }
    public function tracking(Request $request)
    {
        $type = $request->type;
        $data = Submission::find($request->id);
        if($data->status_akhir == null) abort(404);
        if($data->tipe_submission != $type) abort(404);
        $timeline = \App\Models\TimelineProgress::where('id_submission', $data->id)->orderByDesc('created_at')->get();
        return view('pages.fakultas.submission.laporan-final.tracking', compact(['type', 'data', 'timeline']));
    }
    public function show(Request $request)
    {
        $type = $request->type;
        $check_code = Submission::where('submission_code', $request->submission_code)->first();

        $user = User::find($check_code->id_pengaju);
        $fakultas = \App\Models\Faculty::find($user->fakultas);

        $fti = ['FTI', 'FAKULTAS TEKNIK DAN INFORMATIKA', 'FAKULTAS TEKNIK DAN INFORMATIKA (FTI)'];
        $fbis = ['FBIS', 'FAKULTAS BISNIS DAN ILMU SOSIAL', 'FAKULTAS BISNIS DAN ILMU SOSIAL (FBIS)'];

        if( in_array(strtoupper($fakultas->nama_fakultas), $fti) ) {
            $nilai = \App\Models\FtiEvaluation::where('id_submission', $check_code->id)->where('tipe', 'Laporan Final')->get()->count();
        } elseif( in_array(strtoupper($fakultas->nama_fakultas), $fbis) ) {
            $nilai = \App\Models\FbisEvaluation::where('id_submission', $check_code->id)->where('tipe', 'Laporan Final')->get()->count();
        }
        if($check_code->status_akhir == null) abort(404);
        return view('pages.fakultas.submission.laporan-final.show', compact(['type', 'check_code', 'user', 'nilai']));
    }
    public function action(Request $request)
    {
        $check_code = Submission::find($request->id);
        if($request->aksi == 'Revised') {
            \App\Models\Notification::create([
                'id_jenis' => $check_code->id,
                'jenis_notifikasi' => 'Laporan',
                'judul_notifikasi' => 'Informasi pengembalian laporan Final',
                'text_notifikasi' => 'Laporan Final dengan nomor pengajuan '.$check_code->submission_code.' telah dikembalikan',
                'to_role' => 5,
                'to_id' => $check_code->id_pengaju,
                'read_status' => 'unread',
            ]);
            \App\Models\TimelineProgress::create([
                'id_submission' => $check_code->id,
                'judul_progress' => 'Laporan Final dikembalikan oleh admin',
                'text_progress' => $request->alasan,
                'status_progress' => 'revised'
            ]);
            $update = $check_code->update([
                'status_laporan_final' => 'Returned by Admin',
                'alasan_laporan_final_ditolak' => $request->alasan,
            ]);
            if($update) return response()->json(['message' =>'Data berhasil dikembalikan'], 200);
            return response()->json(['message' => 'server error'], 500);
        } elseif($request->aksi == 'Approved') {
            $user = User::find($check_code->id_pengaju);
            \App\Models\Notification::create([
                'id_jenis' => $check_code->id,
                'jenis_notifikasi' => 'Laporan',
                'judul_notifikasi' => 'Informasi penerimaan laporan Final',
                'text_notifikasi' => 'Laporan Final dengan nomor pengajuan '.$check_code->submission_code.' telah dilanjutkan ke bagian reviewer',
                'to_role' => 5,
                'to_id' => $check_code->id_pengaju,
                'read_status' => 'unread',
            ]);
            \App\Models\Notification::create([
                'id_jenis' => $check_code->id,
                'jenis_notifikasi' => 'Laporan',
                'judul_notifikasi' => 'Informasi penerimaan laporan Final',
                'text_notifikasi' => 'Laporan Final dengan nomor pengajuan '.$check_code->submission_code.' telah dilanjutkan ke bagian reviewer',
                'to_role' => 2,
                'to_id' => $check_code->review_laporan_akhir_by,
                'read_status' => 'unread',
            ]);
            \App\Models\TimelineProgress::create([
                'id_submission' => $check_code->id,
                'judul_progress' => 'Laporan Final diterima oleh admin',
                'text_progress' => 'Laporan Final dilanjutkan ke bagian reviewer',
                'status_progress' => 'success'
            ]);
            $update = $check_code->update([
                'status_laporan_final' => 'Pending by Reviewer',
            ]);
            if($update) return response()->json(['message' =>'Data berhasil disetujui'], 200);
            return response()->json(['message' => 'server error'], 500);
        } elseif($request->aksi == 'ToReviewer') {
            $user = User::find($check_code->id_pengaju);
            \App\Models\Notification::create([
                'id_jenis' => $check_code->id,
                'jenis_notifikasi' => 'Laporan',
                'judul_notifikasi' => 'Informasi penerimaan laporan Final',
                'text_notifikasi' => 'Laporan Final dengan nomor pengajuan '.$check_code->submission_code.' dikembalikan oleh admin ke reviewer',
                'to_role' => 2,
                'to_id' => $check_code->review_laporan_akhir_by,
                'read_status' => 'unread',
            ]);
            \App\Models\TimelineProgress::create([
                'id_submission' => $check_code->id,
                'judul_progress' => 'Laporan Final dikembalikan ke reviewer',
                'text_progress' => 'Laporan Final dikembalikan ke bagian reviewer',
                'status_progress' => 'revised'
            ]);
            $update = $check_code->update([
                'status_laporan_final' => 'Returned to Reviewer',
                'alasan_laporan_final_ditolak' => $request->alasan,
            ]);
            if($update) return response()->json(['message' =>'Data berhasil dikembalikan'], 200);
            return response()->json(['message' => 'server error'], 500);
        } elseif($request->aksi == 'Disetujui') {
            $user = \App\Models\User::find($check_code->id_pengaju);
            $fakultas = \App\Models\Faculty::find($user->fakultas);

            $fti = ['FTI', 'FAKULTAS TEKNIK DAN INFORMATIKA', 'FAKULTAS TEKNIK DAN INFORMATIKA (FTI)'];
            $fbis = ['FBIS', 'FAKULTAS BISNIS DAN ILMU SOSIAL', 'FAKULTAS BISNIS DAN ILMU SOSIAL (FBIS)'];

            if( in_array(strtoupper($fakultas->nama_fakultas), $fti) ) {
                $nilai = \App\Models\FtiEvaluation::where('id_submission', $check_code->id)->where('tipe', 'Laporan Final')->first();
            } elseif( in_array(strtoupper($fakultas->nama_fakultas), $fbis) ) {
                $nilai = \App\Models\FbisEvaluation::where('id_submission', $check_code->id)->where('tipe', 'Laporan Final')->first();
            }
            if($nilai->grade_value == 'Ditolak') {
                \App\Models\Notification::create([
                    'id_jenis' => $check_code->id,
                    'jenis_notifikasi' => 'Laporan',
                    'judul_notifikasi' => 'Informasi penolakan laporan Final oleh reviewer',
                    'text_notifikasi' => 'Laporan Final ditolak oleh reviewer',
                    'to_role' => 5,
                    'to_id' => $check_code->id_pengaju,
                    'read_status' => 'unread',
                ]);
                \App\Models\TimelineProgress::create([
                    'id_submission' => $check_code->id,
                    'judul_progress' => 'Laporan Final ditolak oleh reviewer',
                    'text_progress' => 'Laporan Final ditolak oleh reviewer',
                    'status_progress' => 'rejected'
                ]);
                $update = $check_code->update([
                    'status_laporan_final' => 'Rejected by Reviewer',
                ]);
            } elseif($nilai->grade_value == 'Diterima') {
                \App\Models\Notification::create([
                    'id_jenis' => $check_code->id,
                    'jenis_notifikasi' => 'Laporan',
                    'judul_notifikasi' => 'Informasi penerimaan laporan Final oleh reviewer',
                    'text_notifikasi' => 'Laporan Final diterima oleh reviewer',
                    'to_role' => 5,
                    'to_id' => $check_code->id_pengaju,
                    'read_status' => 'unread',
                ]);
                \App\Models\TimelineProgress::create([
                    'id_submission' => $check_code->id,
                    'judul_progress' => 'Laporan Final diterima oleh reviewer',
                    'text_progress' => 'Laporan Final diterima oleh reviewer',
                    'status_progress' => 'success'
                ]);
                $update = $check_code->update([
                    'status_laporan_final' => 'Approved',
                    'waktu_publikasi' => now(),
                    'status_publikasi' => 'Pending by Dosen'
                ]);
            } else {
                \App\Models\Notification::create([
                    'id_jenis' => $check_code->id,
                    'jenis_notifikasi' => 'Laporan',
                    'judul_notifikasi' => 'Informasi penerimaan laporan Final oleh reviewer',
                    'text_notifikasi' => 'Laporan Final diterima oleh reviewer',
                    'to_role' => 5,
                    'to_id' => $check_code->id_pengaju,
                    'read_status' => 'unread',
                ]);
                \App\Models\TimelineProgress::create([
                    'id_submission' => $check_code->id,
                    'judul_progress' => 'Laporan Final diterima oleh reviewer ('.$nilai->grade_value.')',
                    'text_progress' => 'Laporan Final diterima oleh reviewer ('.$nilai->grade_value.')',
                    'status_progress' => 'success'
                ]);
                $update = $check_code->update([
                    'status_laporan_final' => 'Returned by Reviewer',
                    'alasan_laporan_final_ditolak' => $nilai->grade_value
                ]);
            }

            if($update) return response()->json(['message' =>'Data berhasil disetujui'], 200);
            return response()->json(['message' => 'server error'], 500);
        }
    }
}
