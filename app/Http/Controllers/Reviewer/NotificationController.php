<?php

namespace App\Http\Controllers\Reviewer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Notification;

class NotificationController extends Controller
{
    public function read_all_notification (Request $request){
        return 0;
    }
    public function read_notification (Request $request)
    {
        $getById = Notification::find($request->id);
        if(!$getById) abort(404);
        if($getById->to_role != 2) abort(404);

        $jenis = $getById->jenis_notifikasi;
        $getById->update(['read_status' => 'read']);
        if ($jenis == 'Proposal') {
            $sub = \App\Models\Submission::find($getById->id_jenis);
            return redirect()->to(route('reviewer.proposal.show', ['type' => $sub->tipe_submission, 'submission_code' => $sub->submission_code]));
        } elseif ($jenis == 'Laporan') {
            $sub = \App\Models\Submission::find($getById->id_jenis);
            return redirect()->to(route('reviewer.laporan-akhir.show', ['type' => $sub->tipe_submission, 'submission_code' => $sub->submission_code]));
        } elseif ($jenis == 'Monev') {
            $sub = \App\Models\Submission::find($getById->id_jenis);
            return redirect()->to(route('reviewer.monev.show', ['type' => $sub->tipe_submission, 'submission_code' => $sub->submission_code]));
        } elseif ($jenis == 'Final') {
            $sub = \App\Models\Submission::find($getById->id_jenis);
            return redirect()->to(route('reviewer.laporan-final.show', ['type' => $sub->tipe_submission, 'submission_code' => $sub->submission_code]));
        }
    }
}
