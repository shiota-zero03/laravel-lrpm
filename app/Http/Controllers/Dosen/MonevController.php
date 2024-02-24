<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Submission;
use App\Models\TimelineProgress;
use App\Models\User;

class MonevController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->type;
        $data = Submission::where('tipe_submission', $type)
                            ->where('id_pengaju', auth()->user()->id)
                            ->whereNot('status_monev', null)
                            ->orderByDesc('id')
                            ->get();
        return view('pages.dosen.monev.index', compact(['type', 'data']));
    }
    public function proposal(Request $request)
    {
        $check_code = Submission::where('submission_code', $request->submission_code)->first();
        if(!$check_code) abort(404);

        if($check_code->id_pengaju !== auth()->user()->id) abort(404);

        $type = $request->type;

        if($request->page == 1 || !isset($request->page)) return view('pages.dosen.monev.buat-proposal.fase-1', compact(['type', 'check_code']));
        elseif($request->page == 2) return view('pages.dosen.monev.buat-proposal.fase-2', compact(['type', 'check_code']));
        elseif($request->page == 3){
            if( !$check_code->ppt_laporan ) return redirect()->to(route('dosen.monev.update', ['type' => $request->type, 'submission_code' => $request->submission_code.'?page=2']))->with('error', 'Harap lengkapi form terlebih dahulu');
            return view('pages.dosen.monev.buat-proposal.fase-3', compact(['type', 'check_code']));
        }
        abort(404);
    }
    public function updateMonev (Request $request)
    {
        $check_code = Submission::where('submission_code', $request->submission_code)->first();
        $laporanAkhir = $check_code->ppt_laporan;
        if($request->file('ppt_monev')){
            $laporanAkhir = time().'_'.$request->file('ppt_monev')->getClientOriginalName();
            $request->file('ppt_monev')->move(public_path().'assets/storage/files/ppt-monev/', $laporanAkhir);
        }
        $data = [
            'ppt_laporan' => $laporanAkhir,
        ];
        $update = Submission::find($check_code->id)->update($data);
        if($update) return redirect()->to(route('dosen.monev.update', ['type' => $check_code->tipe_submission, 'submission_code' => $check_code->submission_code.'?page=3']));
    }
    public function submitMonev (Request $request)
    {
        $check_code = Submission::where('submission_code', $request->submission_code)->first();
        if($check_code->status_monev == 'Returned by Admin'){
            \App\Models\Notification::create([
                'id_jenis' => $check_code->id,
                'jenis_notifikasi' => 'Monev',
                'judul_notifikasi' => 'Informasi pengembalian monev',
                'text_notifikasi' => 'Monev dengan nomor pengajuan '.$check_code->submission_code.' telah dikirim kembali menunggu untuk dikonfirmasi',
                'to_role' => 1,
                'read_status' => 'unread',
            ]);
            \App\Models\TimelineProgress::create([
                'id_submission' => $check_code->id,
                'judul_progress' => 'Monev diperbaiki',
                'text_progress' => 'Diperbaiki oleh '.auth()->user()->name,
                'status_progress' => 'success'
            ]);
        } elseif($check_code->status_monev == 'Returned by Reviewer'){
            \App\Models\Notification::create([
                'id_jenis' => $check_code->id,
                'jenis_notifikasi' => 'Monev',
                'judul_notifikasi' => 'Informasi pengembalian Monev',
                'text_notifikasi' => 'Monev dengan nomor pengajuan '.$check_code->submission_code.' telah dikirim kembali menunggu untuk dikonfirmasi',
                'to_role' => 1,
                'read_status' => 'unread',
            ]);
            \App\Models\TimelineProgress::create([
                'id_submission' => $check_code->id,
                'judul_progress' => 'Monev diperbaiki',
                'text_progress' => 'Diperbaiki oleh '.auth()->user()->name,
                'status_progress' => 'success'
            ]);
        } elseif($check_code->status_monev == 'Pending by Dosen'){
            \App\Models\Notification::create([
                'id_jenis' => $check_code->id,
                'jenis_notifikasi' => 'Monev',
                'judul_notifikasi' => 'Informasi pengajuan monev',
                'text_notifikasi' => 'Monev dengan nomor pengajuan '.$check_code->submission_code.' telah diajukan, menunggu untuk dikonfirmasi',
                'to_role' => 1,
                'read_status' => 'unread',
            ]);
            \App\Models\TimelineProgress::create([
                'id_submission' => $check_code->id,
                'judul_progress' => 'Monev diajukan',
                'text_progress' => 'Diajukan oleh '.auth()->user()->name,
                'status_progress' => 'success'
            ]);
        }
        if($check_code->status_akhir != 'Rejected' || $check_code->status_akhir != 'Approved'){
            $data = [
                'status_monev' => $check_code->status_monev == 'Pending by Dosen' ? 'Pending by Admin' :
                                    ($check_code->status_monev == 'Returned by Admin' ? 'Pending by Admin' :
                                        ($check_code->status_monev == 'Returned by Reviewer' ? 'Pending by Admin' : 'Pending by Admin')
                                    ),
                'status_akhir' => 'Pending',
                'alasan_monev_ditolak' => null,
            ];
        }
        $update = Submission::find($check_code->id)->update($data);
        if($update) return redirect()->to(route('dosen.monev.index', $request->type));
    }
    public function show(Request $request){
        $type = $request->type;
        $data = Submission::find($request->id);
        if($data->status_akhir == null) abort(404);
        if($data->tipe_submission != $type) abort(404);
        $timeline = TimelineProgress::where('id_submission', $data->id)->orderByDesc('created_at')->get();
        return view('pages.dosen.monev.show', compact(['type', 'data', 'timeline']));
    }
    public function detail(Request $request)
    {
        $type = $request->type;
        $check_code = Submission::find($request->id);
        $user = User::find($check_code->id_pengaju);
        if($check_code->status_akhir == null) abort(404);
        if($check_code->tipe_submission != $type) abort(404);
        return view('pages.dosen.monev.detail', compact(['type', 'check_code', 'user']));
    }
}
