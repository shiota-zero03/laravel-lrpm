<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FtiEvaluation;
use App\Models\FbisEvaluation;
use App\Models\Submission;
use PDF;

class PenilaianController extends Controller
{
    public function showPenilaian(Request $request)
    {
        $check_submission = Submission::find($request->id);
        if(!$check_submission) abort(404);

        if(auth()->user()->role == 5) {
            if(auth()->user()->id != $check_submission->id_pengaju) abort(404);
        }

        $user = \App\Models\User::find($check_submission->id_pengaju);
        $fakultas = \App\Models\Faculty::find($user->fakultas);

        $fti = ['FTI', 'FAKULTAS TEKNIK DAN INFORMATIKA', 'FAKULTAS TEKNIK DAN INFORMATIKA (FTI)'];
        $fbis = ['FBIS', 'FAKULTAS BISNIS DAN ILMU SOSIAL', 'FAKULTAS BISNIS DAN ILMU SOSIAL (FBIS)'];

        if( in_array(strtoupper($fakultas->nama_fakultas), $fti) ) {
            $nilai = FtiEvaluation::where('id_submission', $check_submission->id)->where('tipe', 'Laporan Akhir')->first();
            if(!$nilai) abort(404);

            $data = [
                'tipe' => 'akhir',
                'submission' => $check_submission,
                'user' => $user,
                'nilai' => $nilai
            ];

            $pdf = PDF::loadView('pages.public.penilaian.fti', $data);
            return $pdf->stream('laporan-penilaian-akhir.pdf');
        } elseif( in_array(strtoupper($fakultas->nama_fakultas), $fbis) ) {
            $nilai = FbisEvaluation::where('id_submission', $check_submission->id)->where('tipe', 'Laporan Akhir')->first();
            if(!$nilai) abort(404);

            $data = [
                'tipe' => 'akhir',
                'submission' => $check_submission,
                'user' => $user,
                'nilai' => $nilai
            ];

            $pdf = PDF::loadView('pages.public.penilaian.fbis', $data);
            return $pdf->stream('laporan-penilaian-akhir.pdf');
        }
    }
    public function showFinalPenilaian(Request $request)
    {
        $check_submission = Submission::find($request->id);
        if(!$check_submission) abort(404);

        if(auth()->user()->role == 5) {
            if(auth()->user()->id != $check_submission->id_pengaju) abort(404);
        }

        $user = \App\Models\User::find($check_submission->id_pengaju);
        $fakultas = \App\Models\Faculty::find($user->fakultas);

        $fti = ['FTI', 'FAKULTAS TEKNIK DAN INFORMATIKA', 'FAKULTAS TEKNIK DAN INFORMATIKA (FTI)'];
        $fbis = ['FBIS', 'FAKULTAS BISNIS DAN ILMU SOSIAL', 'FAKULTAS BISNIS DAN ILMU SOSIAL (FBIS)'];

        if( in_array(strtoupper($fakultas->nama_fakultas), $fti) ) {
            $nilai = FtiEvaluation::where('id_submission', $check_submission->id)->where('tipe', 'Laporan Final')->first();
            if(!$nilai) abort(404);

            $data = [
                'tipe' => 'final',
                'submission' => $check_submission,
                'user' => $user,
                'nilai' => $nilai
            ];

            $pdf = PDF::loadView('pages.public.penilaian.fti', $data);
            return $pdf->stream('laporan-penilaian-final.pdf');
        } elseif( in_array(strtoupper($fakultas->nama_fakultas), $fbis) ) {
            $nilai = FbisEvaluation::where('id_submission', $check_submission->id)->where('tipe', 'Laporan Final')->first();
            if(!$nilai) abort(404);

            $data = [
                'tipe' => 'final',
                'submission' => $check_submission,
                'user' => $user,
                'nilai' => $nilai
            ];

            $pdf = PDF::loadView('pages.public.penilaian.fbis', $data);
            return $pdf->stream('laporan-penilaian-final.pdf');
        }
    }
}
