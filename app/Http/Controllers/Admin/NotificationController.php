<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Notification;

class NotificationController extends Controller
{
    public function read_all_notification (Request $request){
        return Notification::where('to_role', 1)->update(['read_status' => 'read']);
    }
    public function read_notification (Request $request)
    {
        $getById = Notification::find($request->id);
        if(!$getById) abort(404);
        if($getById->to_role != 1) abort(404);

        $jenis = $getById->jenis_notifikasi;
        $getById->update(['read_status' => 'read']);
        if($jenis == 'Registrasi') {
            return redirect()->to(route('admin.user.index', ['role' => 'dosen']));
        } elseif ($jenis == 'Submission') {
            $sub = \App\Models\Submission::find($getById->id_jenis);
            return redirect()->to(route('admin.usulan-baru.show', ['type' => $sub->tipe_submission, 'submission_code' => $sub->submission_code]));
        } elseif ($jenis == 'Proposal') {
            $sub = \App\Models\Submission::find($getById->id_jenis);
            return redirect()->to(route('admin.proposal.show', ['type' => $sub->tipe_submission, 'submission_code' => $sub->submission_code]));
        } elseif ($jenis == 'Laporan') {
            $sub = \App\Models\Submission::find($getById->id_jenis);
            return redirect()->to(route('admin.laporan-akhir.show', ['type' => $sub->tipe_submission, 'submission_code' => $sub->submission_code]));
        } elseif ($jenis == 'Publikasi') {
            $sub = \App\Models\Submission::find($getById->id_jenis);
            return redirect()->to(route('admin.publikasi.show', ['type' => $sub->tipe_submission, 'submission_code' => $sub->submission_code]));
        }
    }
}
