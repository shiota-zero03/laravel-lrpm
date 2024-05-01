<?php

namespace App\Http\Controllers\Dosen;

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
        if($getById->to_role != 5) abort(404);
        if($getById->to_id != auth()->user()->id) abort(404);

        $jenis = $getById->jenis_notifikasi;
        $getById->update(['read_status' => 'read']);
        if ($jenis == 'Submission') {
            $sub = \App\Models\Submission::find($getById->id_jenis);
            return redirect()->to(route('dosen.usulan-baru.detail', ['type' => $sub->tipe_submission, 'id' => $sub->id]));
        } elseif ($jenis == 'Proposal') {
            $sub = \App\Models\Submission::find($getById->id_jenis);
            return redirect()->to(route('dosen.proposal.detail', ['type' => $sub->tipe_submission, 'id' => $sub->id]));
        } elseif ($jenis == 'SPK') {
            $sub = \App\Models\Submission::find($getById->id_jenis);
            return redirect()->to(route('dosen.spk.detail', ['type' => $sub->tipe_submission, 'id' => $sub->id]));
        } elseif ($jenis == 'Laporan') {
            $sub = \App\Models\Submission::find($getById->id_jenis);
            return redirect()->to(route('dosen.laporan-akhir.detail', ['type' => $sub->tipe_submission, 'id' => $sub->id]));
        } elseif ($jenis == 'Monev') {
            $sub = \App\Models\Submission::find($getById->id_jenis);
            return redirect()->to(route('dosen.monev.detail', ['type' => $sub->tipe_submission, 'id' => $sub->id]));
        } elseif ($jenis == 'Final') {
            $sub = \App\Models\Submission::find($getById->id_jenis);
            return redirect()->to(route('dosen.laporan-final.detail', ['type' => $sub->tipe_submission, 'id' => $sub->id]));
        } elseif ($jenis == 'Publikasi') {
            $sub = \App\Models\Submission::find($getById->id_jenis);
            return redirect()->to(route('dosen.publikasi.detail', ['type' => $sub->tipe_submission, 'id' => $sub->id]));
        }
    }
}
