<?php

namespace App\Http\Controllers\Admin\Submission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Submission;
use App\Models\User;

class ProposalController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->type;
        $data = Submission::where('tipe_submission', $type)
                            ->whereNot('status_akhir', null)
                            ->whereNot('status_proposal', null)
                            ->orderByDesc('id')
                            ->get();
        return view('pages.admin.submission.proposal.index', compact(['type', 'data']));
    }
    public function tracking(Request $request)
    {
        $type = $request->type;
        $data = Submission::find($request->id);
        if($data->status_akhir == null) abort(404);
        if($data->tipe_submission != $type) abort(404);
        $timeline = \App\Models\TimelineProgress::where('id_submission', $data->id)->orderByDesc('created_at')->get();
        return view('pages.admin.submission.proposal.tracking', compact(['type', 'data', 'timeline']));
    }
    public function show(Request $request)
    {
        $reviewer = User::where('role', 2)->get();
        $type = $request->type;
        $check_code = Submission::where('submission_code', $request->submission_code)->first();
        $user = User::find($check_code->id_pengaju);
        if($check_code->status_akhir == null) abort(404);
        return view('pages.admin.submission.proposal.show', compact(['type', 'check_code', 'user'], 'reviewer'));
    }
    public function action(Request $request)
    {
        $check_code = Submission::find($request->id);
        if($request->aksi == 'Rejected') {
            \App\Models\Notification::create([
                'id_jenis' => $check_code->id,
                'jenis_notifikasi' => 'Proposal',
                'judul_notifikasi' => 'Informasi penolakan proposal',
                'text_notifikasi' => 'Proposal dengan nomor pengajuan '.$check_code->submission_code.' telah ditolak',
                'to_role' => 5,
                'to_id' => $check_code->id_pengaju,
                'read_status' => 'unread',
            ]);
            \App\Models\TimelineProgress::create([
                'id_submission' => $check_code->id,
                'judul_progress' => 'Proposal ditolak oleh admin',
                'text_progress' => $request->alasan,
                'status_progress' => 'rejected'
            ]);
            $update = $check_code->update([
                'status_proposal' => 'Rejected by Admin',
                'alasan_proposal_ditolak' => $request->alasan,
                'status_akhir' => 'Rejected',
            ]);
            if($update) return response()->json(['message' =>'Data berhasil ditolak'], 200);
            return response()->json(['message' => 'server error'], 500);
        } elseif($request->aksi == 'Revised') {
            \App\Models\Notification::create([
                'id_jenis' => $check_code->id,
                'jenis_notifikasi' => 'Proposal',
                'judul_notifikasi' => 'Informasi pengembalian proposal',
                'text_notifikasi' => 'Proposal dengan nomor pengajuan '.$check_code->submission_code.' telah dikembalikan',
                'to_role' => 5,
                'to_id' => $check_code->id_pengaju,
                'read_status' => 'unread',
            ]);
            \App\Models\TimelineProgress::create([
                'id_submission' => $check_code->id,
                'judul_progress' => 'Proposal dikembalikan oleh admin',
                'text_progress' => $request->alasan,
                'status_progress' => 'revised'
            ]);
            $update = $check_code->update([
                'status_proposal' => 'Returned by Admin',
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
                'text_notifikasi' => 'Proposal dengan nomor pengajuan '.$check_code->submission_code.' telah dilanjutkan ke bagian reviewer',
                'to_role' => 5,
                'to_id' => $check_code->id_pengaju,
                'read_status' => 'unread',
            ]);
            \App\Models\Notification::create([
                'id_jenis' => $check_code->id,
                'jenis_notifikasi' => 'Proposal',
                'judul_notifikasi' => 'Informasi penerimaan proposal',
                'text_notifikasi' => 'Proposal dengan nomor pengajuan '.$check_code->submission_code.' telah dilanjutkan ke bagian reviewer',
                'to_role' => 2,
                'to_id' => $request->reviewer,
                'read_status' => 'unread',
            ]);
            \App\Models\TimelineProgress::create([
                'id_submission' => $check_code->id,
                'judul_progress' => 'Proposal diterima oleh admin',
                'text_progress' => 'Proposal dilanjutkan ke bagian reviewer',
                'status_progress' => 'success'
            ]);
            $update = $check_code->update([
                'status_proposal' => 'Pending by Reviewer',
                'review_proposal_by' => $request->reviewer,
                'review_laporan_akhir_by' => $request->reviewer,
            ]);
            if($update) return response()->json(['message' =>'Data berhasil disetujui'], 200);
            return response()->json(['message' => 'server error'], 500);
        } elseif($request->aksi == 'Validation') {
            \App\Models\Notification::create([
                'id_jenis' => $check_code->id,
                'jenis_notifikasi' => 'Proposal',
                'judul_notifikasi' => 'Informasi validasi '.($check_code->second_status == 'Rejected' ? 'penolakan' : ( $check_code->second_status == 'Revised' ? 'pengembalian' : 'persetujuan' )),
                'text_notifikasi' => 'Proposal baru dengan nomor pengajuan '.$check_code->submission_code.' telah '.($check_code->second_status == 'Rejected' ? 'ditolak' : ( $check_code->second_status == 'Revised' ? 'dikembalikan' : 'disetujui' )),
                'to_role' => 5,
                'to_id' => $check_code->id_pengaju,
                'read_status' => 'unread',
            ]);
            \App\Models\TimelineProgress::create([
                'id_submission' => $check_code->id,
                'judul_progress' => $check_code->second_status == 'Rejected' ? 'Penolakan' : ( $check_code->second_status == 'Returned' ? 'Pengembalian' : 'Persetujuan' ).' divalidasi oleh admin',
                'text_progress' => $check_code->second_status == 'Rejected' ? 'Penolakan' : ( $check_code->second_status == 'Returned' ? 'Pengembalian' : 'Persetujuan' ).' oleh reviewer berhasil divalidasi',
                'status_progress' => 'success'
            ]);
            if($check_code->second_status == 'Approved'){
                $update = $check_code->update([
                    'status_proposal' => 'Approved',
                    'second_status' => null,
                    'waktu_spk' => now(),
                    'status_spk' => 'Pending by Dosen',
                ]);
            } else {
                $update = $check_code->update([
                    'status_proposal' => $check_code->second_status == 'Rejected' ? 'Rejected by Reviewer' : 'Returned by Reviewer',
                    'second_status' => null,
                    'status_akhir' => $check_code->second_status == 'Rejected' ? 'Rejected' : 'Pending',
                ]);
            }
            if($update) return response()->json(['message' =>'Data berhasil divalidasi'], 200);
            return response()->json(['message' => 'server error'], 500);
        }
    }
    public function spkUpload(Request $request)
    {
        $check_code = Submission::where('submission_code', $request->submission_code)->first();
        $namafile = time().'_'.$request->file('spk')->getClientOriginalName();
        $request->file('spk')->move(public_path().'/assets/storage/files/spk-download/', $namafile);
        \App\Models\Notification::create([
            'id_jenis' => $check_code->id,
            'jenis_notifikasi' => 'Proposal',
            'judul_notifikasi' => 'Informasi penerimaan proposal',
            'text_notifikasi' => 'Proposal dengan nomor pengajuan '.$check_code->submission_code.' telah diterima, silahkan lanjutkan untuk mengajukan laporan akhir',
            'to_role' => 5,
            'to_id' => $check_code->id_pengaju,
            'read_status' => 'unread',
        ]);
        \App\Models\TimelineProgress::create([
            'id_submission' => $check_code->id,
            'judul_progress' => 'Proposal telah diterima',
            'text_progress' => 'Silahkan download SPK di link yang telah disediakan untuk diunggah di laporan akhir',
            'status_progress' => 'success'
        ]);
        $update = $check_code->update([
            'alasan_proposal_ditolak' => null,
            'spk_download' => $namafile,
            'status_proposal' => 'Approved',
            'status_spk' => 'Pending by Dosen',
            'waktu_spk' => now(),
        ]);
        if($update) return redirect()->to(route('admin.proposal.index', $check_code->tipe_submission))->with('success', 'Proposal berhasil disetujui');
        return response()->json(['message' => 'server error'], 500);
    }
}
