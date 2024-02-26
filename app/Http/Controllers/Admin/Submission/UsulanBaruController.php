<?php

namespace App\Http\Controllers\Admin\Submission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Submission;
use App\Models\User;

class UsulanBaruController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->type;
        $data = Submission::where('tipe_submission', $type)
                            ->whereNot('status_akhir', null)
                            ->orderByDesc('id')
                            ->get();

        return view('pages.admin.submission.usulan-baru.index', compact(['type', 'data']));
    }
    public function tracking(Request $request){
        $type = $request->type;
        $data = Submission::find($request->id);
        if($data->status_akhir == null) abort(404);
        if($data->tipe_submission != $type) abort(404);
        $timeline = \App\Models\TimelineProgress::where('id_submission', $data->id)->orderByDesc('created_at')->get();
        return view('pages.admin.submission.usulan-baru.tracking', compact(['type', 'data', 'timeline']));
    }
    public function show(Request $request)
    {
        $type = $request->type;
        $check_code = Submission::where('submission_code', $request->submission_code)->first();
        $user = User::find($check_code->id_pengaju);
        if($check_code->status_akhir == null) abort(404);
        return view('pages.admin.submission.usulan-baru.show', compact(['type', 'check_code', 'user']));
    }
    public function action(Request $request)
    {
        $check_code = Submission::find($request->id);
        if($request->file('dokumen_tambahan_usulan')){
            $file = $request->file('dokumen_tambahan_usulan');
            $namafile = time().'_'.$file->getClientOriginalName();
            $file->move(public_path().'/assets/storage/files/dokumen-submission/', $namafile);
        } else {
            $namafile = null;
        }
        $user = User::find($check_code->id_pengaju);
        if($request->aksi == 'Rejected') {
            \App\Models\Notification::create([
                'id_jenis' => $check_code->id,
                'jenis_notifikasi' => 'Submission',
                'judul_notifikasi' => 'Informasi penolakan usulan',
                'text_notifikasi' => 'Usulan baru dengan nomor pengajuan '.$check_code->submission_code.' telah ditolak',
                'to_role' => 5,
                'to_id' => $check_code->id_pengaju,
                'read_status' => 'unread',
            ]);
            \App\Models\TimelineProgress::create([
                'id_submission' => $check_code->id,
                'judul_progress' => 'Usulan ditolak oleh admin',
                'text_progress' => $request->alasan,
                'status_progress' => 'rejected'
            ]);
            $update = $check_code->update([
                'dokumen_tambahan_usulan' => $namafile,
                'status_usulan' => 'Rejected by Admin',
                'alasan_usulan_ditolak' => $request->alasan,
                'status_akhir' => 'Rejected',
            ]);
            if($update) return response()->json(['message' =>'Data berhasil ditolak'], 200);
            return response()->json(['message' => 'server error'], 500);
        } elseif($request->aksi == 'Revised') {
            \App\Models\Notification::create([
                'id_jenis' => $check_code->id,
                'jenis_notifikasi' => 'Submission',
                'judul_notifikasi' => 'Informasi pengembalian usulan',
                'text_notifikasi' => 'Usulan baru dengan nomor pengajuan '.$check_code->submission_code.' telah dikembalikan',
                'to_role' => 5,
                'to_id' => $check_code->id_pengaju,
                'read_status' => 'unread',
            ]);
            \App\Models\TimelineProgress::create([
                'id_submission' => $check_code->id,
                'judul_progress' => 'Usulan dikembalikan oleh admin',
                'text_progress' => $request->alasan,
                'status_progress' => 'revised'
            ]);
            $update = $check_code->update([
                'dokumen_tambahan_usulan' => $namafile,
                'status_usulan' => 'Returned by Admin',
                'alasan_usulan_ditolak' => $request->alasan,
            ]);
            if($update) return response()->json(['message' =>'Data berhasil dikembalikan'], 200);
            return response()->json(['message' => 'server error'], 500);
        } elseif($request->aksi == 'Approved') {
            \App\Models\Notification::create([
                'id_jenis' => $check_code->id,
                'jenis_notifikasi' => 'Submission',
                'judul_notifikasi' => 'Informasi penerimaan usulan',
                'text_notifikasi' => 'Usulan baru dengan nomor pengajuan '.$check_code->submission_code.' telah dilanjutkan ke bagian program studi',
                'to_role' => 5,
                'to_id' => $check_code->id_pengaju,
                'read_status' => 'unread',
            ]);
            \App\Models\Notification::create([
                'id_jenis' => $check_code->id,
                'jenis_notifikasi' => 'Submission',
                'judul_notifikasi' => 'Informasi penerimaan usulan',
                'text_notifikasi' => 'Usulan baru dengan nomor pengajuan '.$check_code->submission_code.' telah dilanjutkan ke bagian program studi',
                'to_role' => 3,
                'to_id' => $user->prodi,
                'read_status' => 'unread',
            ]);
            \App\Models\TimelineProgress::create([
                'id_submission' => $check_code->id,
                'judul_progress' => 'Usulan diterima oleh admin',
                'text_progress' => 'Usulan dilanjutkan ke bagian program studi',
                'status_progress' => 'success'
            ]);
            $update = $check_code->update([
                'dokumen_tambahan_usulan' => $namafile,
                'status_usulan' => 'Pending by Prodi',
            ]);
            if($update) return response()->json(['message' =>'Data berhasil disetujui'], 200);
            return response()->json(['message' => 'server error'], 500);
        } elseif($request->aksi == 'Validation') {
            \App\Models\Notification::create([
                'id_jenis' => $check_code->id,
                'jenis_notifikasi' => 'Submission',
                'judul_notifikasi' => 'Informasi validasi '.($check_code->second_status == 'Rejected' ? 'penolakan' : ( $check_code->second_status == 'Revised' ? 'pengembalian' : 'persetujuan' )),
                'text_notifikasi' => 'Usulan baru dengan nomor pengajuan '.$check_code->submission_code.' telah '.($check_code->second_status == 'Rejected' ? 'ditolak' : ( $check_code->second_status == 'Revised' ? 'dikembalikan' : 'disetujui' )),
                'to_role' => 5,
                'to_id' => $check_code->id_pengaju,
                'read_status' => 'unread',
            ]);
            \App\Models\TimelineProgress::create([
                'id_submission' => $check_code->id,
                'judul_progress' => $check_code->second_status == 'Rejected' ? 'Penolakan' : ( $check_code->second_status == 'Returned' ? 'Pengembalian' : 'Persetujuan' ).' divalidasi oleh admin',
                'text_progress' => $check_code->second_status == 'Rejected' ? 'Penolakan' : ( $check_code->second_status == 'Returned' ? 'Pengembalian' : 'Persetujuan' ).' oleh prodi berhasil divalidasi',
                'status_progress' => 'success'
            ]);
            if($check_code->second_status == 'Approved'){
                $update = $check_code->update([
                    'status_usulan' => 'Approved',
                    'second_status' => null,
                    'waktu_proposal' => now(),
                    'status_proposal' => 'Pending by Dosen',
                ]);
            } else {
                $update = $check_code->update([
                    'status_usulan' => $check_code->second_status == 'Rejected' ? 'Rejected by Prodi' : 'Returned by Prodi',
                    'second_status' => null,
                    'status_akhir' => $check_code->second_status == 'Rejected' ? 'Rejected' : 'Pending',
                ]);
            }
            if($update) return response()->json(['message' =>'Data berhasil divalidasi'], 200);
            return response()->json(['message' => 'server error'], 500);
        }
    }
}
