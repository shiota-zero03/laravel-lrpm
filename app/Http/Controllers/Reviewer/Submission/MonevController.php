<?php

namespace App\Http\Controllers\Reviewer\Submission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Submission;
Use App\Models\User;

class MonevController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->type;
        $data = Submission::where('tipe_submission', $type)
                            ->whereNot('status_akhir', null)
                            ->whereNot('status_monev', null)
                            ->where('review_laporan_akhir_by', auth()->user()->id)
                            ->orderByDesc('id')
                            ->get();
        return view('pages.reviewer.submission.monev.index', compact(['type', 'data']));
    }
    public function tracking(Request $request)
    {
        $type = $request->type;
        $data = Submission::find($request->id);
        if($data->status_akhir == null) abort(404);
        if($data->tipe_submission != $type) abort(404);
        $timeline = \App\Models\TimelineProgress::where('id_submission', $data->id)->orderByDesc('created_at')->get();
        return view('pages.reviewer.submission.laporan-akhir.tracking', compact(['type', 'data', 'timeline']));
    }
    public function show(Request $request)
    {
        $type = $request->type;
        $check_code = Submission::where('submission_code', $request->submission_code)->first();
        $user = User::find($check_code->id_pengaju);
        if($check_code->status_akhir == null) abort(404);
        return view('pages.reviewer.submission.monev.show', compact(['type', 'check_code', 'user']));
    }
    public function action(Request $request)
    {
        $check_code = Submission::where('submission_code', $request->submission_code)->first();
        if(now() < $check_code->waktu_sidang) return back()->with('error', 'Sidang belum dimulai');

        $laporanAkhir = time().'_'.$request->file('penilaian')->getClientOriginalName();
        $request->file('penilaian')->move(public_path().'/assets/storage/files/form-penilaian/', $laporanAkhir);

        $data = [
            'status_monev' => 'Waiting for Validation',
            'dokumen_tambahan_monev' => $laporanAkhir,
            'komentar_reviewer' => $request->komentar
        ];
        \App\Models\Notification::create([
            'id_jenis' => $check_code->id,
            'jenis_notifikasi' => 'Monev',
            'judul_notifikasi' => 'Informasi penerimaan Monev',
            'text_notifikasi' => 'Monev dengan nomor pengajuan '.$check_code->submission_code.' telah dinilai, menunggu verifikasi oleh admin',
            'to_role' => 1,
            'read_status' => 'unread',
        ]);
        \App\Models\TimelineProgress::create([
            'id_submission' => $check_code->id,
            'judul_progress' => 'Laporan dinilai oleh reviewer',
            'text_progress' => 'Menunggu admin memverifikasi data',
            'status_progress' => 'success'
        ]);
        $update = Submission::find($check_code->id)->update($data);
        if($update) return redirect()->to(route('reviewer.monev.index', $check_code->tipe_submission))->with('success', 'Data monev berhasil disetujui');
    }
}
