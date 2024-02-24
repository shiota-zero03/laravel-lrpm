<?php

namespace App\Http\Controllers\Prodi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Notification;

class NotificationController extends Controller
{
    public function read_all_notification (Request $request){
        return Notification::where('to_role', 3)->where('to_id', auth()->user()->prodi)->update(['read_status' => 'read']);
    }
    public function read_notification (Request $request)
    {
        $getById = Notification::find($request->id);
        if(!$getById) abort(404);
        if($getById->to_role != 3) abort(404);
        if($getById->to_id != auth()->user()->prodi) abort(404);

        $jenis = $getById->jenis_notifikasi;
        $getById->update(['read_status' => 'read']);
        if ($jenis == 'Submission') {
            $sub = \App\Models\Submission::find($getById->id_jenis);
            return redirect()->to(route('prodi.usulan-baru.show', ['type' => $sub->tipe_submission, 'submission_code' => $sub->submission_code]));
        }
    }
}
