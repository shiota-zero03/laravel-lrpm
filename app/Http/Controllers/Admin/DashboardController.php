<?php

namespace App\Http\Controllers\Admin;

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
            'dosen' => User::where('role', 5)->get()->count(),
            'fakultas' => User::where('role', 4)->get()->count(),
            'prodi' => User::where('role', 3)->get()->count(),
            'reviewer' => User::where('role', 2)->get()->count(),

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

        $univPenelitian = [
            'submit_laporan' => Submission::where('tipe_submission', 'penelitian')->whereNot('status_usulan', 'Draft')->whereNot('status_akhir', null)->get()->count(),
            'laporan_diterima' => Submission::where('tipe_submission', 'penelitian')->where('status_usulan', 'Approved')->whereNot('status_akhir', null)->get()->count(),
            'laporan_ditolak' => Submission::where('tipe_submission', 'penelitian')->where('status_akhir', 'Rejected')->get()->count(),

            'upload_proposal' => Submission::where('tipe_submission', 'penelitian')->whereNot('status_proposal', null)->whereNot('status_proposal', 'Pending by Dosen')->whereNot('status_akhir', null)->get()->count(),
            'proposal_diterima' => Submission::where('tipe_submission', 'penelitian')->where('status_proposal', 'Approved')->whereNot('status_akhir', null)->get()->count(),

            'upload_laporan_akhir' => Submission::where('tipe_submission', 'penelitian')->whereNot('status_laporan_akhir', null)->whereNot('status_laporan_akhir', 'Pending by Dosen')->whereNot('status_akhir', null)->get()->count(),
            'laporan_akhir_diterima' => Submission::where('tipe_submission', 'penelitian')->where('status_laporan_akhir', 'Approved')->whereNot('status_akhir', null)->get()->count(),

            'persiapan_monev' => Submission::where('tipe_submission', 'penelitian')->whereNot('status_monev', null)->whereNot('status_akhir', null)->get()->count(),
            'review_monev' => Submission::where('tipe_submission', 'penelitian')->whereNot('status_monev', 'Pending by Admin')->whereNot('status_monev', 'Pending by Dosen')->whereNot('status_monev', 'Waiting for Schedule')->whereNot('status_akhir', null)->get()->count(),
            'revisi_monev' => Submission::where('tipe_submission', 'penelitian')->whereNot('status_monev', 'Pending by Admin')->whereNot('status_monev', 'Pending by Dosen')->whereNot('status_monev', 'Waiting for Schedule')->whereNot('status_monev', 'Waiting for Validation')->whereNot('status_akhir', null)->get()->count(),
            'monev_diterima' => Submission::where('tipe_submission', 'penelitian')->where('status_monev', 'Approved')->whereNot('status_akhir', null)->get()->count(),

            'upload_laporan_final' => Submission::where('tipe_submission', 'penelitian')->whereNot('status_laporan_final', null)->whereNot('status_laporan_final', 'Pending by Dosen')->whereNot('status_akhir', null)->get()->count(),
            'laporan_final_diterima' => Submission::where('tipe_submission', 'penelitian')->where('status_laporan_final', 'Approved')->whereNot('status_akhir', null)->get()->count(),

            'proses_selesai' => Submission::where('tipe_submission', 'penelitian')->where('status_akhir', 'Approved')->get()->count()
        ];
        $univPkm = [
            'submit_laporan' => Submission::where('tipe_submission', 'pengabdian-masyarakat')->whereNot('status_usulan', 'Draft')->whereNot('status_akhir', null)->get()->count(),
            'laporan_diterima' => Submission::where('tipe_submission', 'pengabdian-masyarakat')->where('status_usulan', 'Approved')->whereNot('status_akhir', null)->get()->count(),
            'laporan_ditolak' => Submission::where('tipe_submission', 'pengabdian-masyarakat')->where('status_akhir', 'Rejected')->get()->count(),

            'upload_proposal' => Submission::where('tipe_submission', 'pengabdian-masyarakat')->whereNot('status_proposal', null)->whereNot('status_proposal', 'Pending by Dosen')->whereNot('status_akhir', null)->get()->count(),
            'proposal_diterima' => Submission::where('tipe_submission', 'pengabdian-masyarakat')->where('status_proposal', 'Approved')->whereNot('status_akhir', null)->get()->count(),

            'upload_laporan_akhir' => Submission::where('tipe_submission', 'pengabdian-masyarakat')->whereNot('status_laporan_akhir', null)->whereNot('status_laporan_akhir', 'Pending by Dosen')->whereNot('status_akhir', null)->get()->count(),
            'laporan_akhir_diterima' => Submission::where('tipe_submission', 'pengabdian-masyarakat')->where('status_laporan_akhir', 'Approved')->whereNot('status_akhir', null)->get()->count(),

            'persiapan_monev' => Submission::where('tipe_submission', 'pengabdian-masyarakat')->whereNot('status_monev', null)->whereNot('status_akhir', null)->get()->count(),
            'review_monev' => Submission::where('tipe_submission', 'pengabdian-masyarakat')->whereNot('status_monev', 'Pending by Admin')->whereNot('status_monev', 'Pending by Dosen')->whereNot('status_monev', 'Waiting for Schedule')->whereNot('status_akhir', null)->get()->count(),
            'revisi_monev' => Submission::where('tipe_submission', 'pengabdian-masyarakat')->whereNot('status_monev', 'Pending by Admin')->whereNot('status_monev', 'Pending by Dosen')->whereNot('status_monev', 'Waiting for Schedule')->whereNot('status_monev', 'Waiting for Validation')->whereNot('status_akhir', null)->get()->count(),
            'monev_diterima' => Submission::where('tipe_submission', 'pengabdian-masyarakat')->where('status_monev', 'Approved')->whereNot('status_akhir', null)->get()->count(),

            'upload_laporan_final' => Submission::where('tipe_submission', 'pengabdian-masyarakat')->whereNot('status_laporan_final', null)->whereNot('status_laporan_final', 'Pending by Dosen')->whereNot('status_akhir', null)->get()->count(),
            'laporan_final_diterima' => Submission::where('tipe_submission', 'pengabdian-masyarakat')->where('status_laporan_final', 'Approved')->whereNot('status_akhir', null)->get()->count(),

            'proses_selesai' => Submission::where('tipe_submission', 'pengabdian-masyarakat')->where('status_akhir', 'Approved')->get()->count()
        ];

        $fbisPenelitian = [
            'submit_laporan' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->whereNot('submissions.status_usulan', 'Draft')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),
            'laporan_diterima' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->where('submissions.status_usulan', 'Approved')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),
            'laporan_ditolak' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->where('submissions.status_akhir', 'Rejected')->where('submissions.tipe_submission', 'penelitian')->get()->count(),

            'upload_proposal' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->whereNot('submissions.status_proposal', null)->whereNot('submissions.status_proposal', 'Pending by Dosen')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),
            'proposal_diterima' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->where('submissions.status_proposal', 'Approved')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),

            'upload_laporan_akhir' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->whereNot('submissions.status_laporan_akhir', null)->whereNot('submissions.status_laporan_akhir', 'Pending by Dosen')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),
            'laporan_akhir_diterima' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->where('submissions.status_laporan_akhir', 'Approved')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),

            'persiapan_monev' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->whereNot('submissions.status_monev', null)->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),
            'review_monev' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->whereNot('submissions.status_monev', 'Pending by Admin')->whereNot('submissions.status_monev', 'Pending by Dosen')->whereNot('submissions.status_monev', 'Waiting for Schedule')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),
            'revisi_monev' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->whereNot('submissions.status_monev', 'Pending by Admin')->whereNot('submissions.status_monev', 'Pending by Dosen')->whereNot('submissions.status_monev', 'Waiting for Schedule')->whereNot('submissions.status_monev', 'Waiting for Validation')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),
            'monev_diterima' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->where('submissions.status_monev', 'Approved')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),

            'upload_laporan_final' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->whereNot('submissions.status_laporan_final', null)->whereNot('submissions.status_laporan_final', 'Pending by Dosen')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),
            'laporan_final_diterima' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->where('submissions.status_laporan_final', 'Approved')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),

            'proses_selesai' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->where('submissions.status_akhir', 'Approved')->where('submissions.tipe_submission', 'penelitian')->get()->count()
        ];
        $ftiPenelitian = [
            'submit_laporan' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->whereNot('submissions.status_usulan', 'Draft')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),
            'laporan_diterima' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->where('submissions.status_usulan', 'Approved')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),
            'laporan_ditolak' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->where('submissions.status_akhir', 'Rejected')->where('submissions.tipe_submission', 'penelitian')->get()->count(),

            'upload_proposal' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->whereNot('submissions.status_proposal', null)->whereNot('submissions.status_proposal', 'Pending by Dosen')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),
            'proposal_diterima' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->where('submissions.status_proposal', 'Approved')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),

            'upload_laporan_akhir' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->whereNot('submissions.status_laporan_akhir', null)->whereNot('submissions.status_laporan_akhir', 'Pending by Dosen')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),
            'laporan_akhir_diterima' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->where('submissions.status_laporan_akhir', 'Approved')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),

            'persiapan_monev' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->whereNot('submissions.status_monev', null)->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),
            'review_monev' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->whereNot('submissions.status_monev', 'Pending by Admin')->whereNot('submissions.status_monev', 'Pending by Dosen')->whereNot('submissions.status_monev', 'Waiting for Schedule')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),
            'revisi_monev' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->whereNot('submissions.status_monev', 'Pending by Admin')->whereNot('submissions.status_monev', 'Pending by Dosen')->whereNot('submissions.status_monev', 'Waiting for Schedule')->whereNot('submissions.status_monev', 'Waiting for Validation')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),
            'monev_diterima' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->where('submissions.status_monev', 'Approved')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),

            'upload_laporan_final' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->whereNot('submissions.status_laporan_final', null)->whereNot('submissions.status_laporan_final', 'Pending by Dosen')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),
            'laporan_final_diterima' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->where('submissions.status_laporan_final', 'Approved')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),

            'proses_selesai' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->where('submissions.status_akhir', 'Approved')->where('submissions.tipe_submission', 'penelitian')->get()->count()
        ];
        $fbisPkm = [
            'submit_laporan' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->whereNot('submissions.status_usulan', 'Draft')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),
            'laporan_diterima' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->where('submissions.status_usulan', 'Approved')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),
            'laporan_ditolak' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->where('submissions.status_akhir', 'Rejected')->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),

            'upload_proposal' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->whereNot('submissions.status_proposal', null)->whereNot('submissions.status_proposal', 'Pending by Dosen')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),
            'proposal_diterima' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->where('submissions.status_proposal', 'Approved')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),

            'upload_laporan_akhir' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->whereNot('submissions.status_laporan_akhir', null)->whereNot('submissions.status_laporan_akhir', 'Pending by Dosen')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),
            'laporan_akhir_diterima' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->where('submissions.status_laporan_akhir', 'Approved')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),

            'persiapan_monev' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->whereNot('submissions.status_monev', null)->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),
            'review_monev' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->whereNot('submissions.status_monev', 'Pending by Admin')->whereNot('submissions.status_monev', 'Pending by Dosen')->whereNot('submissions.status_monev', 'Waiting for Schedule')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),
            'revisi_monev' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->whereNot('submissions.status_monev', 'Pending by Admin')->whereNot('submissions.status_monev', 'Pending by Dosen')->whereNot('submissions.status_monev', 'Waiting for Schedule')->whereNot('submissions.status_monev', 'Waiting for Validation')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),
            'monev_diterima' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->where('submissions.status_monev', 'Approved')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),

            'upload_laporan_final' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->whereNot('submissions.status_laporan_final', null)->whereNot('submissions.status_laporan_final', 'Pending by Dosen')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),
            'laporan_final_diterima' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->where('submissions.status_laporan_final', 'Approved')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),

            'proses_selesai' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->where('submissions.status_akhir', 'Approved')->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count()
        ];
        $ftiPkm = [
            'submit_laporan' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->whereNot('submissions.status_usulan', 'Draft')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),
            'laporan_diterima' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->where('submissions.status_usulan', 'Approved')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),
            'laporan_ditolak' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->where('submissions.status_akhir', 'Rejected')->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),

            'upload_proposal' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->whereNot('submissions.status_proposal', null)->whereNot('submissions.status_proposal', 'Pending by Dosen')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),
            'proposal_diterima' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->where('submissions.status_proposal', 'Approved')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),

            'upload_laporan_akhir' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->whereNot('submissions.status_laporan_akhir', null)->whereNot('submissions.status_laporan_akhir', 'Pending by Dosen')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),
            'laporan_akhir_diterima' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->where('submissions.status_laporan_akhir', 'Approved')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),

            'persiapan_monev' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->whereNot('submissions.status_monev', null)->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),
            'review_monev' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->whereNot('submissions.status_monev', 'Pending by Admin')->whereNot('submissions.status_monev', 'Pending by Dosen')->whereNot('submissions.status_monev', 'Waiting for Schedule')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),
            'revisi_monev' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->whereNot('submissions.status_monev', 'Pending by Admin')->whereNot('submissions.status_monev', 'Pending by Dosen')->whereNot('submissions.status_monev', 'Waiting for Schedule')->whereNot('submissions.status_monev', 'Waiting for Validation')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),
            'monev_diterima' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->where('submissions.status_monev', 'Approved')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),

            'upload_laporan_final' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->whereNot('submissions.status_laporan_final', null)->whereNot('submissions.status_laporan_final', 'Pending by Dosen')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),
            'laporan_final_diterima' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->where('submissions.status_laporan_final', 'Approved')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),

            'proses_selesai' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->where('submissions.status_akhir', 'Approved')->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count()
        ];

        $process = [
            'universitas_penelitian' => $univPenelitian,
            'universitas_pkm' => $univPkm,
            'fbis_penelitian' => $fbisPenelitian,
            'fti_penelitian' => $ftiPenelitian,
            'fbis_pkm' => $fbisPkm,
            'fti_pkm' => $ftiPkm,
        ];

        return view('pages.admin.dashboard.index', compact(['data', 'faculty', 'process']));
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
    public function export(Request $request)
    {
        $ajax = $this->ajaxData($request);

        $universitas = [
            'submit_usulan_penelitian' => Submission::whereNot('status_usulan', 'Draft')->whereNot('status_akhir', null)->where('tipe_submission', 'penelitian')->get()->count(),
            'submit_laporan_penelitian' => Submission::whereNot('status_laporan_final', null)->whereNot('status_akhir', null)->where('tipe_submission', 'penelitian')->get()->count(),
            'submit_usulan_pkm' => Submission::whereNot('status_usulan', 'Draft')->whereNot('status_akhir', null)->where('tipe_submission', 'pengabdian-masyarakat')->get()->count(),
            'submit_laporan_pkm' => Submission::whereNot('status_laporan_final', null)->whereNot('status_akhir', null)->where('tipe_submission', 'pengabdian-masyarakat')->get()->count(),
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
                [
                    'psuf' => $psuf->count(),
                    'pslff' => $pslff->count(),
                    'pmsuf' => $pmsuf->count(),
                    'pmslff' => $pmslff->count(),
                    'prodi' => $prodi
                ]
            ];
        }

        $all = [
            'universitas' => $universitas,
            'fakultas' => $faculty
        ];
        if($request->from && $request->to){
            $data = $ajax;
        } else {
            $data = $all;
        }
        $univPenelitian = [
            'submit_laporan' => Submission::where('tipe_submission', 'penelitian')->whereNot('status_usulan', 'Draft')->whereNot('status_akhir', null)->get()->count(),
            'laporan_diterima' => Submission::where('tipe_submission', 'penelitian')->where('status_usulan', 'Approved')->whereNot('status_akhir', null)->get()->count(),
            'laporan_ditolak' => Submission::where('tipe_submission', 'penelitian')->where('status_akhir', 'Rejected')->get()->count(),

            'upload_proposal' => Submission::where('tipe_submission', 'penelitian')->whereNot('status_proposal', null)->whereNot('status_proposal', 'Pending by Dosen')->whereNot('status_akhir', null)->get()->count(),
            'proposal_diterima' => Submission::where('tipe_submission', 'penelitian')->where('status_proposal', 'Approved')->whereNot('status_akhir', null)->get()->count(),

            'upload_laporan_akhir' => Submission::where('tipe_submission', 'penelitian')->whereNot('status_laporan_akhir', null)->whereNot('status_laporan_akhir', 'Pending by Dosen')->whereNot('status_akhir', null)->get()->count(),
            'laporan_akhir_diterima' => Submission::where('tipe_submission', 'penelitian')->where('status_laporan_akhir', 'Approved')->whereNot('status_akhir', null)->get()->count(),

            'persiapan_monev' => Submission::where('tipe_submission', 'penelitian')->whereNot('status_monev', null)->whereNot('status_akhir', null)->get()->count(),
            'review_monev' => Submission::where('tipe_submission', 'penelitian')->whereNot('status_monev', 'Pending by Admin')->whereNot('status_monev', 'Pending by Dosen')->whereNot('status_monev', 'Waiting for Schedule')->whereNot('status_akhir', null)->get()->count(),
            'revisi_monev' => Submission::where('tipe_submission', 'penelitian')->whereNot('status_monev', 'Pending by Admin')->whereNot('status_monev', 'Pending by Dosen')->whereNot('status_monev', 'Waiting for Schedule')->whereNot('status_monev', 'Waiting for Validation')->whereNot('status_akhir', null)->get()->count(),
            'monev_diterima' => Submission::where('tipe_submission', 'penelitian')->where('status_monev', 'Approved')->whereNot('status_akhir', null)->get()->count(),

            'upload_laporan_final' => Submission::where('tipe_submission', 'penelitian')->whereNot('status_laporan_final', null)->whereNot('status_laporan_final', 'Pending by Dosen')->whereNot('status_akhir', null)->get()->count(),
            'laporan_final_diterima' => Submission::where('tipe_submission', 'penelitian')->where('status_laporan_final', 'Approved')->whereNot('status_akhir', null)->get()->count(),

            'proses_selesai' => Submission::where('tipe_submission', 'penelitian')->where('status_akhir', 'Approved')->get()->count()
        ];
        $univPkm = [
            'submit_laporan' => Submission::where('tipe_submission', 'pengabdian-masyarakat')->whereNot('status_usulan', 'Draft')->whereNot('status_akhir', null)->get()->count(),
            'laporan_diterima' => Submission::where('tipe_submission', 'pengabdian-masyarakat')->where('status_usulan', 'Approved')->whereNot('status_akhir', null)->get()->count(),
            'laporan_ditolak' => Submission::where('tipe_submission', 'pengabdian-masyarakat')->where('status_akhir', 'Rejected')->get()->count(),

            'upload_proposal' => Submission::where('tipe_submission', 'pengabdian-masyarakat')->whereNot('status_proposal', null)->whereNot('status_proposal', 'Pending by Dosen')->whereNot('status_akhir', null)->get()->count(),
            'proposal_diterima' => Submission::where('tipe_submission', 'pengabdian-masyarakat')->where('status_proposal', 'Approved')->whereNot('status_akhir', null)->get()->count(),

            'upload_laporan_akhir' => Submission::where('tipe_submission', 'pengabdian-masyarakat')->whereNot('status_laporan_akhir', null)->whereNot('status_laporan_akhir', 'Pending by Dosen')->whereNot('status_akhir', null)->get()->count(),
            'laporan_akhir_diterima' => Submission::where('tipe_submission', 'pengabdian-masyarakat')->where('status_laporan_akhir', 'Approved')->whereNot('status_akhir', null)->get()->count(),

            'persiapan_monev' => Submission::where('tipe_submission', 'pengabdian-masyarakat')->whereNot('status_monev', null)->whereNot('status_akhir', null)->get()->count(),
            'review_monev' => Submission::where('tipe_submission', 'pengabdian-masyarakat')->whereNot('status_monev', 'Pending by Admin')->whereNot('status_monev', 'Pending by Dosen')->whereNot('status_monev', 'Waiting for Schedule')->whereNot('status_akhir', null)->get()->count(),
            'revisi_monev' => Submission::where('tipe_submission', 'pengabdian-masyarakat')->whereNot('status_monev', 'Pending by Admin')->whereNot('status_monev', 'Pending by Dosen')->whereNot('status_monev', 'Waiting for Schedule')->whereNot('status_monev', 'Waiting for Validation')->whereNot('status_akhir', null)->get()->count(),
            'monev_diterima' => Submission::where('tipe_submission', 'pengabdian-masyarakat')->where('status_monev', 'Approved')->whereNot('status_akhir', null)->get()->count(),

            'upload_laporan_final' => Submission::where('tipe_submission', 'pengabdian-masyarakat')->whereNot('status_laporan_final', null)->whereNot('status_laporan_final', 'Pending by Dosen')->whereNot('status_akhir', null)->get()->count(),
            'laporan_final_diterima' => Submission::where('tipe_submission', 'pengabdian-masyarakat')->where('status_laporan_final', 'Approved')->whereNot('status_akhir', null)->get()->count(),

            'proses_selesai' => Submission::where('tipe_submission', 'pengabdian-masyarakat')->where('status_akhir', 'Approved')->get()->count()
        ];
        $fbisPenelitian = [
            'submit_laporan' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->whereNot('submissions.status_usulan', 'Draft')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),
            'laporan_diterima' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->where('submissions.status_usulan', 'Approved')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),
            'laporan_ditolak' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->where('submissions.status_akhir', 'Rejected')->where('submissions.tipe_submission', 'penelitian')->get()->count(),

            'upload_proposal' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->whereNot('submissions.status_proposal', null)->whereNot('submissions.status_proposal', 'Pending by Dosen')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),
            'proposal_diterima' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->where('submissions.status_proposal', 'Approved')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),

            'upload_laporan_akhir' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->whereNot('submissions.status_laporan_akhir', null)->whereNot('submissions.status_laporan_akhir', 'Pending by Dosen')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),
            'laporan_akhir_diterima' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->where('submissions.status_laporan_akhir', 'Approved')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),

            'persiapan_monev' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->whereNot('submissions.status_monev', null)->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),
            'review_monev' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->whereNot('submissions.status_monev', 'Pending by Admin')->whereNot('submissions.status_monev', 'Pending by Dosen')->whereNot('submissions.status_monev', 'Waiting for Schedule')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),
            'revisi_monev' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->whereNot('submissions.status_monev', 'Pending by Admin')->whereNot('submissions.status_monev', 'Pending by Dosen')->whereNot('submissions.status_monev', 'Waiting for Schedule')->whereNot('submissions.status_monev', 'Waiting for Validation')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),
            'monev_diterima' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->where('submissions.status_monev', 'Approved')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),

            'upload_laporan_final' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->whereNot('submissions.status_laporan_final', null)->whereNot('submissions.status_laporan_final', 'Pending by Dosen')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),
            'laporan_final_diterima' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->where('submissions.status_laporan_final', 'Approved')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),

            'proses_selesai' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->where('submissions.status_akhir', 'Approved')->where('submissions.tipe_submission', 'penelitian')->get()->count()
        ];
        $ftiPenelitian = [
            'submit_laporan' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->whereNot('submissions.status_usulan', 'Draft')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),
            'laporan_diterima' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->where('submissions.status_usulan', 'Approved')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),
            'laporan_ditolak' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->where('submissions.status_akhir', 'Rejected')->where('submissions.tipe_submission', 'penelitian')->get()->count(),

            'upload_proposal' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->whereNot('submissions.status_proposal', null)->whereNot('submissions.status_proposal', 'Pending by Dosen')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),
            'proposal_diterima' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->where('submissions.status_proposal', 'Approved')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),

            'upload_laporan_akhir' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->whereNot('submissions.status_laporan_akhir', null)->whereNot('submissions.status_laporan_akhir', 'Pending by Dosen')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),
            'laporan_akhir_diterima' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->where('submissions.status_laporan_akhir', 'Approved')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),

            'persiapan_monev' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->whereNot('submissions.status_monev', null)->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),
            'review_monev' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->whereNot('submissions.status_monev', 'Pending by Admin')->whereNot('submissions.status_monev', 'Pending by Dosen')->whereNot('submissions.status_monev', 'Waiting for Schedule')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),
            'revisi_monev' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->whereNot('submissions.status_monev', 'Pending by Admin')->whereNot('submissions.status_monev', 'Pending by Dosen')->whereNot('submissions.status_monev', 'Waiting for Schedule')->whereNot('submissions.status_monev', 'Waiting for Validation')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),
            'monev_diterima' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->where('submissions.status_monev', 'Approved')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),

            'upload_laporan_final' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->whereNot('submissions.status_laporan_final', null)->whereNot('submissions.status_laporan_final', 'Pending by Dosen')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),
            'laporan_final_diterima' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->where('submissions.status_laporan_final', 'Approved')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'penelitian')->get()->count(),

            'proses_selesai' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->where('submissions.status_akhir', 'Approved')->where('submissions.tipe_submission', 'penelitian')->get()->count()
        ];
        $fbisPkm = [
            'submit_laporan' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->whereNot('submissions.status_usulan', 'Draft')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),
            'laporan_diterima' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->where('submissions.status_usulan', 'Approved')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),
            'laporan_ditolak' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->where('submissions.status_akhir', 'Rejected')->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),

            'upload_proposal' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->whereNot('submissions.status_proposal', null)->whereNot('submissions.status_proposal', 'Pending by Dosen')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),
            'proposal_diterima' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->where('submissions.status_proposal', 'Approved')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),

            'upload_laporan_akhir' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->whereNot('submissions.status_laporan_akhir', null)->whereNot('submissions.status_laporan_akhir', 'Pending by Dosen')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),
            'laporan_akhir_diterima' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->where('submissions.status_laporan_akhir', 'Approved')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),

            'persiapan_monev' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->whereNot('submissions.status_monev', null)->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),
            'review_monev' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->whereNot('submissions.status_monev', 'Pending by Admin')->whereNot('submissions.status_monev', 'Pending by Dosen')->whereNot('submissions.status_monev', 'Waiting for Schedule')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),
            'revisi_monev' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->whereNot('submissions.status_monev', 'Pending by Admin')->whereNot('submissions.status_monev', 'Pending by Dosen')->whereNot('submissions.status_monev', 'Waiting for Schedule')->whereNot('submissions.status_monev', 'Waiting for Validation')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),
            'monev_diterima' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->where('submissions.status_monev', 'Approved')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),

            'upload_laporan_final' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->whereNot('submissions.status_laporan_final', null)->whereNot('submissions.status_laporan_final', 'Pending by Dosen')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),
            'laporan_final_diterima' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->where('submissions.status_laporan_final', 'Approved')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),

            'proses_selesai' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 2)->where('submissions.status_akhir', 'Approved')->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count()
        ];
        $ftiPkm = [
            'submit_laporan' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->whereNot('submissions.status_usulan', 'Draft')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),
            'laporan_diterima' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->where('submissions.status_usulan', 'Approved')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),
            'laporan_ditolak' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->where('submissions.status_akhir', 'Rejected')->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),

            'upload_proposal' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->whereNot('submissions.status_proposal', null)->whereNot('submissions.status_proposal', 'Pending by Dosen')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),
            'proposal_diterima' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->where('submissions.status_proposal', 'Approved')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),

            'upload_laporan_akhir' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->whereNot('submissions.status_laporan_akhir', null)->whereNot('submissions.status_laporan_akhir', 'Pending by Dosen')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),
            'laporan_akhir_diterima' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->where('submissions.status_laporan_akhir', 'Approved')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),

            'persiapan_monev' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->whereNot('submissions.status_monev', null)->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),
            'review_monev' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->whereNot('submissions.status_monev', 'Pending by Admin')->whereNot('submissions.status_monev', 'Pending by Dosen')->whereNot('submissions.status_monev', 'Waiting for Schedule')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),
            'revisi_monev' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->whereNot('submissions.status_monev', 'Pending by Admin')->whereNot('submissions.status_monev', 'Pending by Dosen')->whereNot('submissions.status_monev', 'Waiting for Schedule')->whereNot('submissions.status_monev', 'Waiting for Validation')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),
            'monev_diterima' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->where('submissions.status_monev', 'Approved')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),

            'upload_laporan_final' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->whereNot('submissions.status_laporan_final', null)->whereNot('submissions.status_laporan_final', 'Pending by Dosen')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),
            'laporan_final_diterima' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->where('submissions.status_laporan_final', 'Approved')->whereNot('submissions.status_akhir', null)->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count(),

            'proses_selesai' => Submission::join('users', 'users.id', '=', 'submissions.id_pengaju')->join('faculties', 'users.fakultas', '=', 'faculties.id')->where('faculties.id', 1)->where('submissions.status_akhir', 'Approved')->where('submissions.tipe_submission', 'pengabdian-masyarakat')->get()->count()
        ];

        $process = [
            'universitas_penelitian' => $univPenelitian,
            'universitas_pkm' => $univPkm,
            'fbis_penelitian' => $fbisPenelitian,
            'fti_penelitian' => $ftiPenelitian,
            'fbis_pkm' => $fbisPkm,
            'fti_pkm' => $ftiPkm,
        ];
        return view('pages.admin.dashboard.excel', compact(['data', 'process']));
    }
}
