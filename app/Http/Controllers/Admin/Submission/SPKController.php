<?php

namespace App\Http\Controllers\Admin\Submission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Submission;
use App\Models\User;

class SPKController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->type;
        $data = Submission::where('tipe_submission', $type)
                            ->whereNot('status_akhir', null)
                            ->whereNot('status_spk', null)
                            ->orderByDesc('id')
                            ->get();
        return view('pages.admin.submission.spk.index', compact(['type', 'data']));
    }
    public function tracking(Request $request)
    {
        $type = $request->type;
        $data = Submission::find($request->id);
        if($data->status_akhir == null) abort(404);
        if($data->tipe_submission != $type) abort(404);
        $timeline = \App\Models\TimelineProgress::where('id_submission', $data->id)->orderByDesc('created_at')->get();
        return view('pages.admin.submission.spk.tracking', compact(['type', 'data', 'timeline']));
    }
    public function show(Request $request)
    {
        $reviewer = User::where('role', 2)->get();
        $type = $request->type;
        $check_code = Submission::where('submission_code', $request->submission_code)->first();
        $user = User::find($check_code->id_pengaju);
        if($check_code->status_akhir == null) abort(404);
        return view('pages.admin.submission.spk.show', compact(['type', 'check_code', 'user'], 'reviewer'));
    }
    public function action(Request $request)
    {
        $check_code = Submission::find($request->id);
        if($request->aksi == 'Revised') {
            \App\Models\Notification::create([
                'id_jenis' => $check_code->id,
                'jenis_notifikasi' => 'SPK',
                'judul_notifikasi' => 'Informasi pengembalian spk',
                'text_notifikasi' => 'SPK dengan nomor pengajuan '.$check_code->submission_code.' telah dikembalikan',
                'to_role' => 5,
                'to_id' => $check_code->id_pengaju,
                'read_status' => 'unread',
            ]);
            \App\Models\TimelineProgress::create([
                'id_submission' => $check_code->id,
                'judul_progress' => 'SPK dikembalikan oleh admin',
                'text_progress' => $request->alasan,
                'status_progress' => 'revised'
            ]);
            $update = $check_code->update([
                'status_spk' => 'Returned by Admin',
                'alasan_spk_ditolak' => $request->alasan,
            ]);
            if($update) return response()->json(['message' =>'Data berhasil dikembalikan'], 200);
            return response()->json(['message' => 'server error'], 500);
        } elseif($request->aksi == 'Approved') {
            $user = User::find($check_code->id_pengaju);
            \App\Models\Notification::create([
                'id_jenis' => $check_code->id,
                'jenis_notifikasi' => 'SPK',
                'judul_notifikasi' => 'Informasi penerimaan SPK',
                'text_notifikasi' => 'SPK dengan nomor pengajuan '.$check_code->submission_code.' telah ditandatangani',
                'to_role' => 5,
                'to_id' => $check_code->id_pengaju,
                'read_status' => 'unread',
            ]);
            \App\Models\TimelineProgress::create([
                'id_submission' => $check_code->id,
                'judul_progress' => 'SPK diterima oleh admin',
                'text_progress' => 'SPK telah ditandatangani',
                'status_progress' => 'success'
            ]);

            $namafile = time().'_'.$request->file('file_upload')->getClientOriginalName();
            $request->file('file_upload')->move(public_path().'assets/storage/files/spk-upload/', $namafile);

            $update = $check_code->update([
                'status_spk' => 'Approved',
                'spk_upload' => $namafile,
                'waktu_laporan_akhir' => now(),
                'status_laporan_akhir' => 'Pending by Dosen',
            ]);
            if($update) return redirect()->to(route('admin.spk.index', $check_code->tipe_submission));
            return response()->json(['message' => 'server error'], 500);
        }
    }
    public function spkUpload(Request $request)
    {
        $check_code = Submission::where('submission_code', $request->submission_code)->first();
        $namafile = time().'_'.$request->file('spk')->getClientOriginalName();
        $request->file('spk')->move('assets/storage/files/spk-download/', $namafile);
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
