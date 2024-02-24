<?php

namespace App\Http\Controllers\Admin\Submission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Submission;
use App\Models\User;

class PublikasiController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->type;
        $data = Submission::where('tipe_submission', $type)
                            ->whereNot('status_akhir', null)
                            ->whereNot('status_publikasi', null)
                            ->orderByDesc('id')
                            ->get();
        return view('pages.admin.submission.publikasi.index', compact(['type', 'data']));
    }
    public function tracking(Request $request)
    {
        $type = $request->type;
        $data = Submission::find($request->id);
        if($data->status_akhir == null) abort(404);
        if($data->tipe_submission != $type) abort(404);
        $timeline = \App\Models\TimelineProgress::where('id_submission', $data->id)->orderByDesc('created_at')->get();
        return view('pages.admin.submission.publikasi.tracking', compact(['type', 'data', 'timeline']));
    }
    public function show(Request $request)
    {
        $type = $request->type;
        $check_code = Submission::where('submission_code', $request->submission_code)->first();
        $user = User::find($check_code->id_pengaju);
        if($check_code->status_akhir == null) abort(404);
        return view('pages.admin.submission.publikasi.show', compact(['type', 'check_code', 'user']));
    }
    public function action(Request $request)
    {
        $check_code = Submission::find($request->id);
        if($request->aksi == 'Rejected') {
            \App\Models\Notification::create([
                'id_jenis' => $check_code->id,
                'jenis_notifikasi' => 'Publikasi',
                'judul_notifikasi' => 'Informasi penolakan publikasi',
                'text_notifikasi' => 'Publikasi dengan nomor pengajuan '.$check_code->submission_code.' telah ditolak',
                'to_role' => 5,
                'to_id' => $check_code->id_pengaju,
                'read_status' => 'unread',
            ]);
            \App\Models\TimelineProgress::create([
                'id_submission' => $check_code->id,
                'judul_progress' => 'Publikasi ditolak oleh admin',
                'text_progress' => $request->alasan,
                'status_progress' => 'rejected'
            ]);
            $update = $check_code->update([
                'status_publikasi' => 'Rejected by Admin',
                'alasan_publikasi_ditolak' => $request->alasan,
                'status_akhir' => 'Rejected',
            ]);
            if($update) return response()->json(['message' =>'Data berhasil ditolak'], 200);
            return response()->json(['message' => 'server error'], 500);
        } elseif($request->aksi == 'Revised') {
            \App\Models\Notification::create([
                'id_jenis' => $check_code->id,
                'jenis_notifikasi' => 'Publikasi',
                'judul_notifikasi' => 'Informasi pengembalian publikasi',
                'text_notifikasi' => 'Publikasi dengan nomor pengajuan '.$check_code->submission_code.' telah dikembalikan',
                'to_role' => 5,
                'to_id' => $check_code->id_pengaju,
                'read_status' => 'unread',
            ]);
            \App\Models\TimelineProgress::create([
                'id_submission' => $check_code->id,
                'judul_progress' => 'Publikasi dikembalikan oleh admin',
                'text_progress' => $request->alasan,
                'status_progress' => 'revised'
            ]);
            $update = $check_code->update([
                'status_publikasi' => 'Returned by Admin',
                'alasan_publikasi_ditolak' => $request->alasan,
            ]);
            if($update) return response()->json(['message' =>'Data berhasil dikembalikan'], 200);
            return response()->json(['message' => 'server error'], 500);
        } elseif($request->aksi == 'Approved') {
            $user = User::find($check_code->id_pengaju);
            \App\Models\Notification::create([
                'id_jenis' => $check_code->id,
                'jenis_notifikasi' => 'Publikasi',
                'judul_notifikasi' => 'Informasi penerimaan publikasi',
                'text_notifikasi' => 'Publikasi dengan nomor pengajuan '.$check_code->submission_code.' telah disetujui',
                'to_role' => 5,
                'to_id' => $check_code->id_pengaju,
                'read_status' => 'unread',
            ]);
            \App\Models\TimelineProgress::create([
                'id_submission' => $check_code->id,
                'judul_progress' => 'Publikasi diterima oleh admin',
                'text_progress' => 'Publikasi telah disetujui silahkan tunggu info selanjutnya melalui sosial media admin',
                'status_progress' => 'success'
            ]);
            $update = $check_code->update([
                'status_publikasi' => 'Approved',
                'status_akhir' => 'Approved'
            ]);
            if($update) return response()->json(['message' =>'Data berhasil disetujui'], 200);
            return response()->json(['message' => 'server error'], 500);
        }
    }
}
