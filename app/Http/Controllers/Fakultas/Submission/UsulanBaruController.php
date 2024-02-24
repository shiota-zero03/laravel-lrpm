<?php

namespace App\Http\Controllers\Fakultas\Submission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Submission;
use App\Models\User;

class UsulanBaruController extends Controller
{
    public function index(Request $request)
    {
        $not = [ 'Draft', 'Pending by Admin', 'Returned by Admin', 'Rejected by Admin' ];
        $type = $request->type;
        $data = Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')
                            ->where('users.fakultas', auth()->user()->fakultas)
                            ->where('submissions.tipe_submission', $type)
                            ->whereNotNull('submissions.status_usulan')
                            ->whereNotIn('submissions.status_usulan', $not)
                            ->select('submissions.*', 'users.fakultas')
                            ->orderByDesc('submissions.id')
                            ->get();
        return view('pages.fakultas.submission.usulan-baru.index', compact(['type', 'data']));
    }
    public function tracking(Request $request){
        $type = $request->type;
        $data = Submission::find($request->id);
        if($data->status_akhir == null) abort(404);
        if($data->tipe_submission != $type) abort(404);
        $timeline = \App\Models\TimelineProgress::where('id_submission', $data->id)->orderByDesc('created_at')->get();
        return view('pages.fakultas.submission.usulan-baru.tracking', compact(['type', 'data', 'timeline']));
    }
    public function show(Request $request)
    {
        $type = $request->type;
        $check_code = Submission::where('submission_code', $request->submission_code)->first();
        $user = User::find($check_code->id_pengaju);
        if($check_code->status_akhir == null) abort(404);
        return view('pages.fakultas.submission.usulan-baru.show', compact(['type', 'check_code', 'user']));
    }
    public function action(Request $request)
    {
        $check_code = Submission::find($request->id);
        if($request->file('dokumen_tambahan_usulan')){
            $file = $request->file('dokumen_tambahan_usulan');
            $namafile = time().'_'.$file->getClientOriginalName();
            $file->move('assets/storage/files/dokumen-submission/', $namafile);
        } else {
            $namafile = null;
        }
        if($request->aksi == 'Rejected') {
            \App\Models\Notification::create([
                'id_jenis' => $check_code->id,
                'jenis_notifikasi' => 'Submission',
                'judul_notifikasi' => 'Informasi penolakan usulan',
                'text_notifikasi' => 'Menunggu validasi admin (ditolak oleh prodi)',
                'to_role' => 5,
                'to_id' => $check_code->id_pengaju,
                'read_status' => 'unread',
            ]);
            \App\Models\Notification::create([
                'id_jenis' => $check_code->id,
                'jenis_notifikasi' => 'Submission',
                'judul_notifikasi' => 'Informasi penolakan usulan',
                'text_notifikasi' => 'Menunggu validasi admin (ditolak oleh prodi)',
                'to_role' => 1,
                'read_status' => 'unread',
            ]);
            \App\Models\TimelineProgress::create([
                'id_submission' => $check_code->id,
                'judul_progress' => 'Menunggu validasi admin (ditolak oleh prodi)',
                'text_progress' => $request->alasan,
                'status_progress' => 'rejected'
            ]);
            $update = $check_code->update([
                'dokumen_tambahan_usulan' => $namafile,
                'second_status' => 'Rejected',
                'status_usulan' => 'Waiting for Validation',
                'alasan_usulan_ditolak' => $request->alasan,
            ]);
            if($update) return response()->json(['message' =>'Data berhasil ditolak'], 200);
            return response()->json(['message' => 'server error'], 500);
        } elseif($request->aksi == 'Revised') {
            \App\Models\Notification::create([
                'id_jenis' => $check_code->id,
                'jenis_notifikasi' => 'Submission',
                'judul_notifikasi' => 'Informasi pengembalian usulan',
                'text_notifikasi' => 'Menunggu validasi admin (dikembalikan oleh prodi)',
                'to_role' => 5,
                'to_id' => $check_code->id_pengaju,
                'read_status' => 'unread',
            ]);
            \App\Models\Notification::create([
                'id_jenis' => $check_code->id,
                'jenis_notifikasi' => 'Submission',
                'judul_notifikasi' => 'Informasi pengembalian usulan',
                'text_notifikasi' => 'Menunggu validasi admin (dikembalikan oleh prodi)',
                'to_role' => 1,
                'read_status' => 'unread',
            ]);
            \App\Models\TimelineProgress::create([
                'id_submission' => $check_code->id,
                'judul_progress' => 'Menunggu validasi admin (dikembalikan oleh prodi)',
                'text_progress' => $request->alasan,
                'status_progress' => 'revised'
            ]);
            $update = $check_code->update([
                'dokumen_tambahan_usulan' => $namafile,
                'second_status' => 'Returned',
                'status_usulan' => 'Waiting for Validation',
                'alasan_usulan_ditolak' => $request->alasan,
            ]);
            if($update) return response()->json(['message' =>'Data berhasil dikembalikan'], 200);
            return response()->json(['message' => 'server error'], 500);
        } elseif($request->aksi == 'Approved') {
            \App\Models\Notification::create([
                'id_jenis' => $check_code->id,
                'jenis_notifikasi' => 'Submission',
                'judul_notifikasi' => 'Informasi penerimaan usulan',
                'text_notifikasi' => 'Menunggu validasi admin (diterima oleh prodi)',
                'to_role' => 5,
                'to_id' => $check_code->id_pengaju,
                'read_status' => 'unread',
            ]);
            \App\Models\Notification::create([
                'id_jenis' => $check_code->id,
                'jenis_notifikasi' => 'Submission',
                'judul_notifikasi' => 'Informasi penerimaan usulan',
                'text_notifikasi' => 'Menunggu validasi admin (diterima oleh prodi)',
                'to_role' => 1,
                'read_status' => 'unread',
            ]);
            \App\Models\TimelineProgress::create([
                'id_submission' => $check_code->id,
                'judul_progress' => 'Menunggu validasi admin (diterima oleh prodi)',
                'text_progress' => 'Usulan diterima, sedang menunggu validasi admin',
                'status_progress' => 'success'
            ]);

            $update = $check_code->update([
                'dokumen_tambahan_usulan' => $namafile,
                'second_status' => 'Approved',
                'status_usulan' => 'Waiting for Validation',
            ]);
            if($update) return response()->json(['message' =>'Data berhasil disetujui'], 200);
            return response()->json(['message' => 'server error'], 500);
        }
    }
}
