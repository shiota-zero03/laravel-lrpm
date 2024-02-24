<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Submission;
use App\Models\TimelineProgress;
use App\Models\User;

class PublikasiController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->type;
        $data = Submission::where('tipe_submission', $type)
                            ->where('id_pengaju', auth()->user()->id)
                            ->whereNot('status_publikasi', null)
                            ->orderByDesc('id')
                            ->get();
        return view('pages.dosen.publikasi.index', compact(['type', 'data']));
    }
    public function proposal(Request $request)
    {
        $check_code = Submission::where('submission_code', $request->submission_code)->first();
        if(!$check_code) abort(404);

        if($check_code->id_pengaju !== auth()->user()->id) abort(404);

        $type = $request->type;

        if($request->page == 1 || !isset($request->page)) return view('pages.dosen.publikasi.buat-proposal.fase-1', compact(['type', 'check_code']));
        elseif($request->page == 2) return view('pages.dosen.publikasi.buat-proposal.fase-2', compact(['type', 'check_code']));
        elseif($request->page == 3){
            if( $check_code->luaran_publikasi && $check_code->judul_publikasi && $check_code->nama_jurnal && $check_code->link_jurnal && $check_code->dokumen_submit && $check_code->tanggal_submit){
                if( ($check_code->dokumen_accepted && $check_code->tanggal_accepted) ){
                    if($check_code->dokumen_publish && $check_code->tanggal_publish) {
                        return view('pages.dosen.publikasi.buat-proposal.fase-3', compact(['type', 'check_code']));
                    }
                } elseif($check_code->dokumen_rejected && $check_code->tanggal_rejected) {
                    return view('pages.dosen.publikasi.buat-proposal.fase-3', compact(['type', 'check_code']));
                }
            }
            return redirect()->to(route('dosen.publikasi.update', ['type' => $request->type, 'submission_code' => $request->submission_code.'?page=2']))->with('error', 'Harap lengkapi form terlebih dahulu');
        }
        abort(404);
    }
    public function updateLaporan (Request $request)
    {
        $check_code = Submission::where('submission_code', $request->submission_code)->first();

        $data = [
            'luaran_publikasi' => $request->luaran_publikasi,
            'judul_publikasi' => $request->judul_publikasi,
            'nama_jurnal' => $request->nama_jurnal,
            'link_jurnal' => $request->link_jurnal,
            'tanggal_submit' => $request->tanggal_submit,
            'tanggal_revision' => $request->tanggal_revision,
            'tanggal_accepted' => $request->tanggal_accepted,
            'tanggal_publish' => $request->tanggal_publish,
            'tanggal_rejected' => $request->tanggal_rejected,
        ];
        if($request->file('dokumen_submit')){
            $submit = time().'_'.$request->file('dokumen_submit')->getClientOriginalName();
            $request->file('dokumen_submit')->move(public_path().'assets/storage/files/publikasi/submit/', $submit);
            $data = array_merge($data, ['dokumen_submit' => $submit]);
        }
        if($request->file('dokumen_revision')){
            $submit = time().'_'.$request->file('dokumen_revision')->getClientOriginalName();
            $request->file('dokumen_revision')->move(public_path().'assets/storage/files/publikasi/revision/', $submit);
            $data = array_merge($data, ['dokumen_revision' => $submit]);
        }
        if($request->file('dokumen_accepted')){
            $submit = time().'_'.$request->file('dokumen_accepted')->getClientOriginalName();
            $request->file('dokumen_accepted')->move(public_path().'assets/storage/files/publikasi/accepted/', $submit);
            $data = array_merge($data, ['dokumen_accepted' => $submit]);
        }
        if($request->file('dokumen_publish')){
            $submit = time().'_'.$request->file('dokumen_publish')->getClientOriginalName();
            $request->file('dokumen_publish')->move(public_path().'assets/storage/files/publikasi/publish/', $submit);
            $data = array_merge($data, ['dokumen_publish' => $submit]);
        }
        if($request->file('dokumen_rejected')){
            $submit = time().'_'.$request->file('dokumen_rejected')->getClientOriginalName();
            $request->file('dokumen_rejected')->move(public_path().'assets/storage/files/publikasi/rejected/', $submit);
            $data = array_merge($data, ['dokumen_rejected' => $submit]);
        }

        $update = Submission::find($check_code->id)->update($data);
        if($update) return back();
    }
    public function submitLaporan (Request $request)
    {
        $check_code = Submission::where('submission_code', $request->submission_code)->first();
        if($check_code->status_publikasi == 'Returned by Admin'){
            \App\Models\Notification::create([
                'id_jenis' => $check_code->id,
                'jenis_notifikasi' => 'Publikasi',
                'judul_notifikasi' => 'Informasi pengembalian publikasi',
                'text_notifikasi' => 'Publikasi dengan nomor pengajuan '.$check_code->submission_code.' telah dikirim kembali menunggu untuk dikonfirmasi',
                'to_role' => 1,
                'read_status' => 'unread',
            ]);
            \App\Models\TimelineProgress::create([
                'id_submission' => $check_code->id,
                'judul_progress' => 'Publikasi diperbaiki',
                'text_progress' => 'Diperbaiki oleh '.auth()->user()->name,
                'status_progress' => 'success'
            ]);
        } elseif($check_code->status_publikasi == 'Pending'){
            \App\Models\Notification::create([
                'id_jenis' => $check_code->id,
                'jenis_notifikasi' => 'Publikasi',
                'judul_notifikasi' => 'Informasi pengajuan Publikasi',
                'text_notifikasi' => 'Publikasi dengan nomor pengajuan '.$check_code->submission_code.' telah diajukan, menunggu untuk dikonfirmasi',
                'to_role' => 1,
                'read_status' => 'unread',
            ]);
            \App\Models\TimelineProgress::create([
                'id_submission' => $check_code->id,
                'judul_progress' => 'Publikasi diajukan',
                'text_progress' => 'Diajukan oleh '.auth()->user()->name,
                'status_progress' => 'success'
            ]);
        }
        if($check_code->status_akhir != 'Rejected' || $check_code->status_akhir != 'Approved'){
            $data = [
                'status_publikasi' => $check_code->status_publikasi == 'Pending by Dosen' ? 'Pending by Admin' :
                                    ($check_code->status_publikasi == 'Returned by Admin' ? 'Pending by Admin' : ''),
                'status_akhir' => 'Pending',
                'alasan_publikasi_ditolak' => null,
            ];
        }
        $update = Submission::find($check_code->id)->update($data);
        if($update) return redirect()->to(route('dosen.publikasi.index', $request->type));
    }
    public function show(Request $request){
        $type = $request->type;
        $data = Submission::find($request->id);
        if($data->status_akhir == null) abort(404);
        if($data->tipe_submission != $type) abort(404);
        $timeline = TimelineProgress::where('id_submission', $data->id)->orderByDesc('created_at')->get();
        return view('pages.dosen.publikasi.show', compact(['type', 'data', 'timeline']));
    }
    public function detail(Request $request)
    {
        $type = $request->type;
        $check_code = Submission::find($request->id);
        $user = User::find($check_code->id_pengaju);
        if($check_code->status_akhir == null) abort(404);
        if($check_code->tipe_submission != $type) abort(404);
        return view('pages.dosen.publikasi.detail', compact(['type', 'check_code', 'user']));
    }
}
