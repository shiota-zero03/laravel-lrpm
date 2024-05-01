<?php

namespace App\Http\Controllers\Fakultas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Submission;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.public.beranda.index');
    }
    public function dashboard(Request $request)
    {
        if($request->ajax()){
            $data = $this->ajaxData($request);
            return response()->json(['data' => $data]);
        }

        $data = [
            'fakultas' => User::where('role', 4)->where('fakultas', auth()->user()->fakultas)->get()->count(),
            'prodi' => User::where('role', 3)->where('fakultas', auth()->user()->fakultas)->get()->count(),

            'psuu' => Submission::whereNot('status_usulan', 'Draft')->whereNot('status_akhir', null)->where('tipe_submission', 'penelitian')->get()->count(),
            'pslfu' => Submission::whereNot('status_laporan_final', null)->whereNot('status_akhir', null)->where('tipe_submission', 'penelitian')->get()->count(),
            'pmsuu' => Submission::whereNot('status_usulan', 'Draft')->whereNot('status_akhir', null)->where('tipe_submission', 'pengabdian-masyarakat')->get()->count(),
            'pmslfu' => Submission::whereNot('status_laporan_final', null)->whereNot('status_akhir', null)->where('tipe_submission', 'pengabdian-masyarakat')->get()->count(),
        ];

        $faculty = [];

        $fakultas = \App\Models\Faculty::get();

        foreach($fakultas as $fac){
            $psuf = Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')
                                    ->join('faculties', 'users.fakultas', '=', 'faculties.id')
                                    ->where('faculties.id', $fac['id'])
                                    ->whereNot('submissions.status_usulan', 'Draft')
                                    ->whereNot('submissions.status_akhir', null)
                                    ->where('submissions.tipe_submission', 'penelitian')
                                    ->get();
            $pslff = Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')
                                    ->join('faculties', 'users.fakultas', '=', 'faculties.id')
                                    ->where('faculties.id', $fac['id'])
                                    ->whereNot('submissions.status_laporan_final', null)
                                    ->whereNot('submissions.status_akhir', null)
                                    ->where('submissions.tipe_submission', 'penelitian')
                                    ->get();
            $pmsuf = Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')
                                    ->join('faculties', 'users.fakultas', '=', 'faculties.id')
                                    ->where('faculties.id', $fac['id'])
                                    ->whereNot('submissions.status_usulan', 'Draft')
                                    ->whereNot('submissions.status_akhir', null)
                                    ->where('submissions.tipe_submission', 'pengabdian-masyarakat')
                                    ->get();
            $pmslff = Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')
                                    ->join('faculties', 'users.fakultas', '=', 'faculties.id')
                                    ->where('faculties.id', $fac['id'])
                                    ->whereNot('submissions.status_laporan_final', null)
                                    ->whereNot('submissions.status_akhir', null)
                                    ->where('submissions.tipe_submission', 'pengabdian-masyarakat')
                                    ->get();


            $prodi = [];
            $getProdi = \App\Models\Department::where('id_fakultas', $fac['id'])->get();
            foreach ($getProdi as $prod) {
                $psup = Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')
                                    ->join('departments', 'users.prodi', '=', 'departments.id')
                                    ->where('departments.id', $prod['id'])
                                    ->whereNot('submissions.status_usulan', 'Draft')
                                    ->whereNot('submissions.status_akhir', null)
                                    ->where('submissions.tipe_submission', 'penelitian')
                                    ->get();
                $pslfp = Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')
                                    ->join('departments', 'users.prodi', '=', 'departments.id')
                                    ->where('departments.id', $prod['id'])
                                    ->whereNot('submissions.status_laporan_final', null)
                                    ->whereNot('submissions.status_akhir', null)
                                    ->where('submissions.tipe_submission', 'penelitian')
                                    ->get();
                $pmsup = Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')
                                    ->join('departments', 'users.prodi', '=', 'departments.id')
                                    ->where('departments.id', $prod['id'])
                                    ->whereNot('submissions.status_usulan', 'Draft')
                                    ->whereNot('submissions.status_akhir', null)
                                    ->where('submissions.tipe_submission', 'pengabdian-masyarakat')
                                    ->get();
                $pmslfp = Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')
                                    ->join('departments', 'users.prodi', '=', 'departments.id')
                                    ->where('departments.id', $prod['id'])
                                    ->whereNot('submissions.status_laporan_final', null)
                                    ->whereNot('submissions.status_akhir', null)
                                    ->where('submissions.tipe_submission', 'pengabdian-masyarakat')
                                    ->get();

                $prodi[] = [
                    [
                        'psup' => $psup->count(),
                        'pslfp' => $pslfp->count(),
                        'pmsup' => $pmsup->count(),
                        'pmslfp' => $pmslfp->count()
                    ]
                ];
            }
            $faculty[] = [
                $fac['id'] => [
                    'psuf' => $psuf->count(),
                    'pslff' => $pslff->count(),
                    'pmsuf' => $pmsuf->count(),
                    'pmslff' => $pmslff->count(),
                    'prodi' => $prodi
                ]
            ];
        }


        return view('pages.fakultas.dashboard.index', compact(['data', 'faculty']));
    }
    public function ajaxData (Request $request)
    {
        $from = $request->from ? $request->from : date('Y-m-d');
        $to = $request->to ? $request->to : date('Y-m-d');
        $universitas = [
            'submit_usulan_penelitian' => Submission::whereBetween('waktu_usulan', [$from.' 00:00:00', $to.' 23:59:59'])->where('tipe_submission', 'penelitian')->get()->count(),
            'submit_laporan_penelitian' => Submission::whereBetween('waktu_laporan_final', [$from.' 00:00:00', $to.' 23:59:59'])->where('tipe_submission', 'penelitian')->get()->count(),

            'submit_usulan_pkm' => Submission::whereBetween('waktu_usulan', [$from.' 00:00:00', $to.' 23:59:59'])->where('tipe_submission', 'pengabdian-masyarakat')->get()->count(),
            'submit_laporan_pkm' => Submission::whereBetween('waktu_laporan_final', [$from.' 00:00:00', $to.' 23:59:59'])->where('tipe_submission', 'pengabdian-masyarakat')->get()->count()
        ];

        $faculty = [];

        $fakultas = \App\Models\Faculty::get();

        foreach($fakultas as $fac){
            $psuf = Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')
                                    ->join('faculties', 'users.fakultas', '=', 'faculties.id')
                                    ->where('faculties.id', $fac['id'])
                                    ->whereNot('submissions.status_usulan', 'Draft')
                                    ->whereNot('submissions.status_akhir', null)
                                    ->where('submissions.tipe_submission', 'penelitian')
                                    ->whereBetween('submissions.waktu_usulan', [$from.' 00:00:00', $to.' 23:59:59'])
                                    ->get();
            $pslff = Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')
                                    ->join('faculties', 'users.fakultas', '=', 'faculties.id')
                                    ->where('faculties.id', $fac['id'])
                                    ->whereNot('submissions.status_laporan_final', null)
                                    ->whereNot('submissions.status_akhir', null)
                                    ->where('submissions.tipe_submission', 'penelitian')
                                    ->whereBetween('submissions.waktu_laporan_final', [$from.' 00:00:00', $to.' 23:59:59'])
                                    ->get();
            $pmsuf = Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')
                                    ->join('faculties', 'users.fakultas', '=', 'faculties.id')
                                    ->where('faculties.id', $fac['id'])
                                    ->whereNot('submissions.status_usulan', 'Draft')
                                    ->whereNot('submissions.status_akhir', null)
                                    ->where('submissions.tipe_submission', 'pengabdian-masyarakat')
                                    ->whereBetween('submissions.waktu_usulan', [$from.' 00:00:00', $to.' 23:59:59'])
                                    ->get();
            $pmslff = Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')
                                    ->join('faculties', 'users.fakultas', '=', 'faculties.id')
                                    ->where('faculties.id', $fac['id'])
                                    ->whereNot('submissions.status_laporan_final', null)
                                    ->whereNot('submissions.status_akhir', null)
                                    ->where('submissions.tipe_submission', 'pengabdian-masyarakat')
                                    ->whereBetween('submissions.waktu_laporan_final', [$from.' 00:00:00', $to.' 23:59:59'])
                                    ->get();
            $prodi = [];
            $getProdi = \App\Models\Department::where('id_fakultas', $fac['id'])->get();
            foreach ($getProdi as $prod) {
                $psup = Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')
                                    ->join('departments', 'users.prodi', '=', 'departments.id')
                                    ->where('departments.id', $prod['id'])
                                    ->whereNot('submissions.status_usulan', 'Draft')
                                    ->whereNot('submissions.status_akhir', null)
                                    ->whereBetween('submissions.waktu_usulan', [$from.' 00:00:00', $to.' 23:59:59'])
                                    ->where('submissions.tipe_submission', 'penelitian')
                                    ->get();
                $pslfp = Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')
                                    ->join('departments', 'users.prodi', '=', 'departments.id')
                                    ->where('departments.id', $prod['id'])
                                    ->whereNot('submissions.status_laporan_final', null)
                                    ->whereNot('submissions.status_akhir', null)
                                    ->whereBetween('submissions.waktu_laporan_final', [$from.' 00:00:00', $to.' 23:59:59'])
                                    ->where('submissions.tipe_submission', 'penelitian')
                                    ->get();
                $pmsup = Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')
                                    ->join('departments', 'users.prodi', '=', 'departments.id')
                                    ->where('departments.id', $prod['id'])
                                    ->whereNot('submissions.status_usulan', 'Draft')
                                    ->whereNot('submissions.status_akhir', null)
                                    ->whereBetween('submissions.waktu_usulan', [$from.' 00:00:00', $to.' 23:59:59'])
                                    ->where('submissions.tipe_submission', 'pengabdian-masyarakat')
                                    ->get();
                $pmslfp = Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')
                                    ->join('departments', 'users.prodi', '=', 'departments.id')
                                    ->where('departments.id', $prod['id'])
                                    ->whereNot('submissions.status_laporan_final', null)
                                    ->whereNot('submissions.status_akhir', null)
                                    ->whereBetween('submissions.waktu_laporan_final', [$from.' 00:00:00', $to.' 23:59:59'])
                                    ->where('submissions.tipe_submission', 'pengabdian-masyarakat')
                                    ->get();

                $prodi[] = [
                    [
                        'psup' => $psup->count(),
                        'pslfp' => $pslfp->count(),
                        'pmsup' => $pmsup->count(),
                        'pmslfp' => $pmslfp->count()
                    ]
                ];
            }
            $faculty[] = [
                [
                    'psuf' => $psuf->count(),
                    'pslff' => $pslff->count(),
                    'pmsuf' => $pmsuf->count(),
                    'pmslff' => $pmslff->count(),
                    'prodi' => $prodi
                ]
            ];
        }
        $data = [
            'from' => $from,
            'to' => $to,
            'universitas' => $universitas,
            'fakultas' => $faculty
        ];
        return $data;
    }
    public function exportDatabase (Request $request)
    {
        $from = $request->from ? $request->from : date('Y-m-d');
        $to = $request->to ? $request->to : date('Y-m-d');

        if($request->from && $request->to){
            $submission = Submission::whereBetween('status_usulan', [$from.' 00:00:00', $to.' 23:59:59'])->whereNot('status_akhir', null)->get();
        } else {
            $submission = Submission::whereNot('status_usulan', 'Draft')->whereNot('status_akhir', null)->get();
        }
        return view('pages.public.export-database', compact(['submission']));
    }
}
