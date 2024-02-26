<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Submission;
use App\Models\TimelineProgress;
use App\Models\User;

class SPKController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->type;
        $data = Submission::where('tipe_submission', $type)
                            ->where('id_pengaju', auth()->user()->id)
                            ->whereNot('status_spk', null)
                            ->orderByDesc('id')
                            ->get();
        return view('pages.dosen.spk.index', compact(['type', 'data']));
    }
    public function spk(Request $request)
    {
        $check_code = Submission::where('submission_code', $request->submission_code)->first();
        if(!$check_code) abort(404);

        if($check_code->id_pengaju !== auth()->user()->id) abort(404);

        $type = $request->type;

        if($request->page == 1 || !isset($request->page)) return view('pages.dosen.spk.buat-spk.fase-1', compact(['type', 'check_code']));
        elseif($request->page == 2) return view('pages.dosen.spk.buat-spk.fase-2', compact(['type', 'check_code']));
        elseif($request->page == 3){
            if( !$check_code->spk_upload ) return redirect()->to(route('dosen.spk.update', ['type' => $request->type, 'submission_code' => $request->submission_code.'?page=2']))->with('error', 'Harap lengkapi form terlebih dahulu');
            return view('pages.dosen.spk.buat-spk.fase-3', compact(['type', 'check_code']));
        }
        abort(404);
    }
    public function updatespk (Request $request)
    {
        $check_code = Submission::where('submission_code', $request->submission_code)->first();
        $spk = $check_code->spk_upload;
        if($request->file('spk')){
            $spk = time().'_'.$request->file('spk')->getClientOriginalName();
            $request->file('spk')->move(public_path().'/assets/storage/files/spk-upload/', $spk);
        }
        $data = [
            'spk_upload' =>  $spk
        ];
        $update = Submission::find($check_code->id)->update($data);
        if($update) return redirect()->to(route('dosen.spk.update', ['type' => $check_code->tipe_submission, 'submission_code' => $check_code->submission_code.'?page=3']))->with('success', 'Dokumen berhasil di upload');
    }
    public function submitspk (Request $request)
    {
        $check_code = Submission::where('submission_code', $request->submission_code)->first();
        if($check_code->status_proposal == 'Returned by Admin'){
            \App\Models\Notification::create([
                'id_jenis' => $check_code->id,
                'jenis_notifikasi' => 'SPK',
                'judul_notifikasi' => 'Informasi pengembalian spk',
                'text_notifikasi' => 'SPK dengan nomor pengajuan '.$check_code->submission_code.' telah dikirim kembali menunggu untuk dikonfirmasi',
                'to_role' => 1,
                'read_status' => 'unread',
            ]);
            \App\Models\TimelineProgress::create([
                'id_submission' => $check_code->id,
                'judul_progress' => 'SPK diperbaiki',
                'text_progress' => 'Diperbaiki oleh '.auth()->user()->name,
                'status_progress' => 'success'
            ]);
        }  elseif($check_code->status_proposal == 'Pending by Dosen'){
            \App\Models\Notification::create([
                'id_jenis' => $check_code->id,
                'jenis_notifikasi' => 'SPK',
                'judul_notifikasi' => 'Informasi pengajuan spk',
                'text_notifikasi' => 'SPK dengan nomor pengajuan '.$check_code->submission_code.' telah diajukan, menunggu untuk dikonfirmasi',
                'to_role' => 1,
                'read_status' => 'unread',
            ]);
            \App\Models\TimelineProgress::create([
                'id_submission' => $check_code->id,
                'judul_progress' => 'SPK diajukan',
                'text_progress' => 'Diajukan oleh '.auth()->user()->name,
                'status_progress' => 'success'
            ]);
        }
        if($check_code->status_akhir != 'Rejected' || $check_code->status_akhir != 'Approved'){
            $data = [
                'status_spk' => $check_code->status_spk == 'Pending by Dosen' ? 'Pending by Admin' :
                                    ($check_code->status_spk == 'Returned by Admin' ? 'Pending by Admin' : ''),
                'status_akhir' => 'Pending',
                'alasan_spk_ditolak' => null,
            ];
        }
        $update = Submission::find($check_code->id)->update($data);
        if($update) return redirect()->to(route('dosen.spk.index', $request->type));
    }
    public function show(Request $request){
        $type = $request->type;
        $data = Submission::find($request->id);
        if($data->status_akhir == null) abort(404);
        if($data->tipe_submission != $type) abort(404);
        $timeline = TimelineProgress::where('id_submission', $data->id)->orderByDesc('created_at')->get();
        return view('pages.dosen.spk.show', compact(['type', 'data', 'timeline']));
    }
    public function detail(Request $request)
    {
        $type = $request->type;
        $check_code = Submission::find($request->id);
        $user = User::find($check_code->id_pengaju);
        if($check_code->status_akhir == null) abort(404);
        if($check_code->tipe_submission != $type) abort(404);
        return view('pages.dosen.spk.detail', compact(['type', 'check_code', 'user']));
    }
}
