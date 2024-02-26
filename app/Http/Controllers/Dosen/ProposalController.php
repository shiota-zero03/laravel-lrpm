<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Submission;
use App\Models\TimelineProgress;
use App\Models\User;

class ProposalController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->type;
        $data = Submission::where('tipe_submission', $type)
                            ->where('id_pengaju', auth()->user()->id)
                            ->whereNot('status_proposal', null)
                            ->orderByDesc('id')
                            ->get();
        return view('pages.dosen.proposal.index', compact(['type', 'data']));
    }
    public function proposal(Request $request)
    {
        $check_code = Submission::where('submission_code', $request->submission_code)->first();
        if(!$check_code) abort(404);

        if($check_code->id_pengaju !== auth()->user()->id) abort(404);

        $type = $request->type;

        if($request->page == 1 || !isset($request->page)) return view('pages.dosen.proposal.buat-proposal.fase-1', compact(['type', 'check_code']));
        elseif($request->page == 2) return view('pages.dosen.proposal.buat-proposal.fase-2', compact(['type', 'check_code']));
        elseif($request->page == 3){
            if( !$check_code->proposal_usulan ) return redirect()->to(route('dosen.proposal.update', ['type' => $request->type, 'submission_code' => $request->submission_code.'?page=2']))->with('error', 'Harap lengkapi form terlebih dahulu');
            return view('pages.dosen.proposal.buat-proposal.fase-3', compact(['type', 'check_code']));
        }
        abort(404);
    }
    public function updateProposal (Request $request)
    {
        $check_code = Submission::where('submission_code', $request->submission_code)->first();
        $namafile = time().'_'.$request->file('upload_dokumen_template')->getClientOriginalName();
        $request->file('upload_dokumen_template')->move(public_path().'/assets/storage/files/dokumen-proposal/', $namafile);
        $data = [
            'proposal_usulan' => $namafile,
        ];
        $update = Submission::find($check_code->id)->update($data);
        if($update) return back();
    }
    public function submitProposal (Request $request)
    {
        $check_code = Submission::where('submission_code', $request->submission_code)->first();
        if($check_code->status_proposal == 'Returned by Admin'){
            \App\Models\Notification::create([
                'id_jenis' => $check_code->id,
                'jenis_notifikasi' => 'Proposal',
                'judul_notifikasi' => 'Informasi pengembalian proposal',
                'text_notifikasi' => 'Proposal dengan nomor pengajuan '.$check_code->submission_code.' telah dikirim kembali menunggu untuk dikonfirmasi',
                'to_role' => 1,
                'read_status' => 'unread',
            ]);
            \App\Models\TimelineProgress::create([
                'id_submission' => $check_code->id,
                'judul_progress' => 'Proposal diperbaiki',
                'text_progress' => 'Diperbaiki oleh '.auth()->user()->name,
                'status_progress' => 'success'
            ]);
        } elseif($check_code->status_proposal == 'Returned by Reviewer'){
            \App\Models\Notification::create([
                'id_jenis' => $check_code->id,
                'jenis_notifikasi' => 'Proposal',
                'judul_notifikasi' => 'Informasi pengembalian proposal',
                'text_notifikasi' => 'Proposal dengan nomor pengajuan '.$check_code->submission_code.' telah dikirim kembali menunggu untuk dikonfirmasi',
                'to_role' => 2,
                'to_id' => $check_code->review_proposal_by,
                'read_status' => 'unread',
            ]);
            \App\Models\TimelineProgress::create([
                'id_submission' => $check_code->id,
                'judul_progress' => 'Proposal diperbaiki',
                'text_progress' => 'Diperbaiki oleh '.auth()->user()->name,
                'status_progress' => 'success'
            ]);
        } elseif($check_code->status_proposal == 'Pending by Dosen'){
            \App\Models\Notification::create([
                'id_jenis' => $check_code->id,
                'jenis_notifikasi' => 'Proposal',
                'judul_notifikasi' => 'Informasi pengajuan proposal',
                'text_notifikasi' => 'Proposal dengan nomor pengajuan '.$check_code->submission_code.' telah diajukan, menunggu untuk dikonfirmasi',
                'to_role' => 1,
                'read_status' => 'unread',
            ]);
            \App\Models\TimelineProgress::create([
                'id_submission' => $check_code->id,
                'judul_progress' => 'Proposal diajukan',
                'text_progress' => 'Diajukan oleh '.auth()->user()->name,
                'status_progress' => 'success'
            ]);
        }
        if($check_code->status_akhir != 'Rejected' || $check_code->status_akhir != 'Approved'){
            $data = [
                'status_proposal' => $check_code->status_proposal == 'Pending by Dosen' ? 'Pending by Admin' :
                                    ($check_code->status_proposal == 'Returned by Admin' ? 'Pending by Admin' :
                                        ($check_code->status_proposal == 'Returned by Reviewer' ? 'Pending by Reviewer' : '')
                                    ),
                'status_akhir' => 'Pending',
                'alasan_usulan_ditolak' => null,
            ];
        }
        $update = Submission::find($check_code->id)->update($data);
        if($update) return redirect()->to(route('dosen.proposal.index', $request->type));
    }
    public function show(Request $request){
        $type = $request->type;
        $data = Submission::find($request->id);
        if($data->status_akhir == null) abort(404);
        if($data->tipe_submission != $type) abort(404);
        $timeline = TimelineProgress::where('id_submission', $data->id)->orderByDesc('created_at')->get();
        return view('pages.dosen.proposal.show', compact(['type', 'data', 'timeline']));
    }
    public function detail(Request $request)
    {
        $type = $request->type;
        $check_code = Submission::find($request->id);
        $user = User::find($check_code->id_pengaju);
        if($check_code->status_akhir == null) abort(404);
        if($check_code->tipe_submission != $type) abort(404);
        return view('pages.dosen.proposal.detail', compact(['type', 'check_code', 'user']));
    }
}
