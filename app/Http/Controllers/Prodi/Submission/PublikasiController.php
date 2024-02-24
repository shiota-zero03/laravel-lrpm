<?php

namespace App\Http\Controllers\Prodi\Submission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Submission;
use App\Models\User;

class PublikasiController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->type;
        $data = Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')
                            ->where('users.prodi', auth()->user()->prodi)
                            ->where('submissions.tipe_submission', $type)
                            ->whereNot('submissions.status_usulan', null)
                            ->whereNot('submissions.status_usulan', 'Draft')
                            ->whereNot('submissions.status_usulan', 'Pending by Admin')
                            ->whereNot('submissions.status_usulan', 'Returned by Admin')
                            ->whereNot('submissions.status_usulan', 'Rejected by Admin')
                            ->whereNot('submissions.status_akhir', null)
                            ->whereNot('submissions.status_publikasi', null)
                            ->select('submissions.*', 'users.prodi')
                            ->orderByDesc('submissions.id')
                            ->get();
        return view('pages.prodi.submission.publikasi.index', compact(['type', 'data']));
    }
    public function tracking(Request $request){
        $type = $request->type;
        $data = Submission::find($request->id);
        if($data->status_akhir == null) abort(404);
        if($data->tipe_submission != $type) abort(404);
        $timeline = \App\Models\TimelineProgress::where('id_submission', $data->id)->orderByDesc('created_at')->get();
        return view('pages.prodi.submission.publikasi.tracking', compact(['type', 'data', 'timeline']));
    }
    public function show(Request $request)
    {
        $type = $request->type;
        $check_code = Submission::where('submission_code', $request->submission_code)->first();
        $user = User::find($check_code->id_pengaju);
        if($check_code->status_akhir == null) abort(404);
        return view('pages.prodi.submission.publikasi.show', compact(['type', 'check_code', 'user']));
    }
}
