<?php

namespace App\Http\Controllers\Reviewer\Submission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Submission;
use App\Models\User;

class PublikasiController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->type;
        $data = Submission::where('tipe_submission', $type)
                            ->whereNot('status_publikasi', null)
                            ->orderByDesc('id')
                            ->get();
        return view('pages.reviewer.submission.publikasi.index', compact(['type', 'data']));
    }
    public function tracking(Request $request){
        $type = $request->type;
        $data = Submission::find($request->id);
        if($data->status_akhir == null) abort(404);
        if($data->tipe_submission != $type) abort(404);
        $timeline = \App\Models\TimelineProgress::where('id_submission', $data->id)->orderByDesc('created_at')->get();
        return view('pages.reviewer.submission.publikasi.tracking', compact(['type', 'data', 'timeline']));
    }
    public function show(Request $request)
    {
        $type = $request->type;
        $check_code = Submission::where('submission_code', $request->submission_code)->first();
        $user = User::find($check_code->id_pengaju);
        if($check_code->status_akhir == null) abort(404);
        return view('pages.reviewer.submission.publikasi.show', compact(['type', 'check_code', 'user']));
    }
}
