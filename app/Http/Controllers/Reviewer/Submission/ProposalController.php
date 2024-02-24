<?php

namespace App\Http\Controllers\Reviewer\Submission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Submission;
Use App\Models\User;

class ProposalController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->type;
        $data = Submission::where('tipe_submission', $type)
                            ->whereNot('status_akhir', null)
                            ->whereNot('status_proposal', null)
                            ->where('review_proposal_by', auth()->user()->id)
                            ->orderByDesc('id')
                            ->get();
        return view('pages.reviewer.submission.proposal.index', compact(['type', 'data']));
    }
    public function tracking(Request $request)
    {
        $type = $request->type;
        $data = Submission::find($request->id);
        if($data->status_akhir == null) abort(404);
        if($data->tipe_submission != $type) abort(404);
        $timeline = \App\Models\TimelineProgress::where('id_submission', $data->id)->orderByDesc('created_at')->get();
        return view('pages.reviewer.submission.proposal.tracking', compact(['type', 'data', 'timeline']));
    }
    public function show(Request $request)
    {
        $type = $request->type;
        $check_code = Submission::where('submission_code', $request->submission_code)->first();
        $user = User::find($check_code->id_pengaju);
        if($check_code->status_akhir == null) abort(404);
        return view('pages.reviewer.submission.proposal.show', compact(['type', 'check_code', 'user']));
    }
    public function action(Request $request)
    {
        $check_code = Submission::find($request->id);
        if($request->file('dokumen_tambahan_usulan')){
            $file = $request->file('dokumen_tambahan_usulan');
            $namafile = time().'_'.$file->getClientOriginalName();
            $file->move(public_path().'assets/storage/files/dokumen-submission/', $namafile);
        } else {
            $namafile = null;
        }
        if($request->aksi == 'Rejected') {
            \App\Models\Notification::create([
                'id_jenis' => $check_code->id,
                'jenis_notifikasi' => 'Proposal',
                'judul_notifikasi' => 'Informasi penolakan usulan',
                'text_notifikasi' => 'Menunggu validasi admin (ditolak oleh prodi)',
                'to_role' => 5,
                'to_id' => $check_code->id_pengaju,
                'read_status' => 'unread',
            ]);
            \App\Models\Notification::create([
                'id_jenis' => $check_code->id,
                'jenis_notifikasi' => 'Proposal',
                'judul_notifikasi' => 'Informasi penolakan usulan',
                'text_notifikasi' => 'Menunggu validasi admin (ditolak oleh prodi)',
                'to_role' => 1,
                'read_status' => 'unread',
            ]);
            \App\Models\TimelineProgress::create([
                'id_submission' => $check_code->id,
                'judul_progress' => 'Menunggu validasi admin (ditolak oleh reviewer)',
                'text_progress' => $request->alasan,
                'status_progress' => 'rejected'
            ]);

            $update = $check_code->update([
                'dokumen_tambahan_proposal' => $namafile,
                'second_status' => 'Rejected',
                'status_proposal' => 'Waiting for Validation',
                'alasan_proposal_ditolak' => $request->alasan,
            ]);
            if($update) return response()->json(['message' =>'Data berhasil ditolak'], 200);
            return response()->json(['message' => 'server error'], 500);
        } elseif($request->aksi == 'Revised') {
            \App\Models\Notification::create([
                'id_jenis' => $check_code->id,
                'jenis_notifikasi' => 'Proposal',
                'judul_notifikasi' => 'Informasi pengembalian proposal',
                'text_notifikasi' => 'Menunggu validasi admin (dikembalikan oleh reviewer)',
                'to_role' => 5,
                'to_id' => $check_code->id_pengaju,
                'read_status' => 'unread',
            ]);
            \App\Models\Notification::create([
                'id_jenis' => $check_code->id,
                'jenis_notifikasi' => 'Proposal',
                'judul_notifikasi' => 'Informasi pengembalian proposal',
                'text_notifikasi' => 'Menunggu validasi admin (dikembalikan oleh reviewer)',
                'to_role' => 1,
                'read_status' => 'unread',
            ]);
            \App\Models\TimelineProgress::create([
                'id_submission' => $check_code->id,
                'judul_progress' => 'Menunggu validasi admin (dikembalikan oleh reviewer)',
                'text_progress' => $request->alasan,
                'status_progress' => 'revised'
            ]);
            $update = $check_code->update([
                'dokumen_tambahan_proposal' => $namafile,
                'second_status' => 'Returned',
                'status_proposal' => 'Waiting for Validation',
                'alasan_proposal_ditolak' => $request->alasan,
            ]);
            if($update) return response()->json(['message' =>'Data berhasil dikembalikan'], 200);
            return response()->json(['message' => 'server error'], 500);
        } elseif($request->aksi == 'Approved') {
            $user = User::find($check_code->id_pengaju);
            \App\Models\Notification::create([
                'id_jenis' => $check_code->id,
                'jenis_notifikasi' => 'Proposal',
                'judul_notifikasi' => 'Informasi penerimaan proposal',
                'text_notifikasi' => 'Proposal dengan nomor pengajuan '.$check_code->submission_code.' telah dilanjutkan ke bagian program studi menunggu untuk mengupload SPK',
                'to_role' => 5,
                'to_id' => $check_code->id_pengaju,
                'read_status' => 'unread',
            ]);
            \App\Models\Notification::create([
                'id_jenis' => $check_code->id,
                'jenis_notifikasi' => 'Proposal',
                'judul_notifikasi' => 'Informasi penerimaan proposal',
                'text_notifikasi' => 'Proposal dengan nomor pengajuan '.$check_code->submission_code.' telah dilanjutkan, ke bagian admin menunggu untuk mengupload SPK',
                'to_role' => 1,
                'read_status' => 'unread',
            ]);
            \App\Models\TimelineProgress::create([
                'id_submission' => $check_code->id,
                'judul_progress' => 'Proposal diterima oleh reviewer',
                'text_progress' => 'Menunggu admin mengupload SPK',
                'status_progress' => 'success'
            ]);
            $update = $check_code->update([
                'dokumen_tambahan_proposal' => $namafile,
                'status_proposal' => 'Waiting for SPK',
            ]);
            if($update) return response()->json(['message' =>'Data berhasil disetujui'], 200);
            return response()->json(['message' => 'server error'], 500);
        }
    }
}
