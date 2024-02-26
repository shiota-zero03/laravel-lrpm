<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Submission;
use App\Models\Schema;
use App\Models\Participant;
use App\Models\Rab;
use App\Models\RabSubmission;
use App\Models\TimelineProgress;
use App\Models\User;

class UsulanBaruController extends Controller
{

    public function index(Request $request){
        $type = $request->type;
        $data = Submission::where('tipe_submission', $type)
                            ->where('id_pengaju', auth()->user()->id)
                            ->whereNot('status_usulan', null)
                            ->orderByDesc('id')
                            ->get();
        return view('pages.dosen.usulan-baru.index', compact(['type', 'data']));
    }
    public function show(Request $request){
        $type = $request->type;
        $data = Submission::find($request->id);
        if($data->tipe_submission != $type) abort(404);
        $timeline = TimelineProgress::where('id_submission', $data->id)->orderByDesc('created_at')->get();
        return view('pages.dosen.usulan-baru.show', compact(['type', 'data', 'timeline']));
    }
    public function detail(Request $request)
    {
        $type = $request->type;
        $check_code = Submission::find($request->id);
        $user = User::find($check_code->id_pengaju);
        if($check_code->tipe_submission != $type) abort(404);
        return view('pages.dosen.usulan-baru.detail', compact(['type', 'check_code', 'user']));
    }
    public function firstOnCreate(Request $request)
    {
        $submission_code = Submission::generateUniqueNumber();

        $data =  [
        	'submission_code' => $submission_code,
        	'id_pengaju' => auth()->user()->id,
        	'tipe_submission' => $request->type
        ];
        $createData = Submission::create($data);
        if($createData) return redirect()->route('dosen.usulan-baru.identitas-usulan', ['type' => $request->type, 'submission_code' => $createData->submission_code]);
    }
// Pengajuan usulan
    public function identitasPengusul(Request $request)
    {
        $check_code = Submission::where('submission_code', $request->submission_code)->first();
        if(!$check_code) abort(404);

        if($check_code->id_pengaju !== auth()->user()->id) abort(404);

        $type = $request->type;
        if($request->page == 4){
            if($check_code->skema) {
                $check_skema = Schema::find($check_code->skema);
                if($check_skema->nama_skema == 'KDN' || $check_skema->nama_skema == 'KLN'){
                    if(!$check_code->nama_mitra || !$check_code->institusi_mitra || !$check_code->id_pendanaan_mitra    ){
                        return redirect()->to(route('dosen.usulan-baru.identitas-usulan', ['type' => $request->type, 'submission_code' => $request->submission_code]))->with('error', 'Harap lengkapi form terlebih dahulu');
                    }
                }
            }

            if(!$check_code->judul_usulan || !$check_code->skema || !$check_code->riset_unggulan || !$check_code->tema || !$check_code->topik || !$check_code->target_luaran){
                return redirect()->to(route('dosen.usulan-baru.identitas-usulan', ['type' => $request->type, 'submission_code' => $request->submission_code.'?page=2']))->with('error', 'Harap lengkapi form terlebih dahulu');
            }

            $rab = RabSubmission::where('id_submission', $check_code->id)->get();
            if($rab->count() > 0){
                return view('pages.dosen.usulan-baru.buat-usulan.fase-4', compact(['type', 'check_code']));
            } else {
                return redirect()->to(route('dosen.usulan-baru.identitas-usulan', ['type' => $request->type, 'submission_code' => $request->submission_code.'?page=3']))->with('error', 'Harap lengkapi form terlebih dahulu');
            }
        }
        elseif($request->page == 3){
            if($check_code->skema) {
                $check_skema = Schema::find($check_code->skema);
                if($check_skema->nama_skema == 'KDN' || $check_skema->nama_skema == 'KLN'){
                    if(!$check_code->nama_mitra || !$check_code->institusi_mitra || !$check_code->id_pendanaan_mitra    ){
                        return redirect()->to(route('dosen.usulan-baru.identitas-usulan', ['type' => $request->type, 'submission_code' => $request->submission_code]))->with('error', 'Harap lengkapi form terlebih dahulu');
                    }
                }
            }

            if(!$check_code->judul_usulan || !$check_code->skema || !$check_code->riset_unggulan || !$check_code->tema || !$check_code->topik || !$check_code->target_luaran){
                return redirect()->to(route('dosen.usulan-baru.identitas-usulan', ['type' => $request->type, 'submission_code' => $request->submission_code.'?page=2']))->with('error', 'Harap lengkapi form terlebih dahulu');
            } else {
                return view('pages.dosen.usulan-baru.buat-usulan.fase-3', compact(['type', 'check_code']));
            }
        }
        elseif($request->page == 2){
            if($check_code->skema) {
                $check_skema = Schema::find($check_code->skema);
                if($check_skema->nama_skema == 'KDN' || $check_skema->nama_skema == 'KLN'){
                    if(!$check_code->nama_mitra || !$check_code->institusi_mitra || !$check_code->id_pendanaan_mitra    ){
                        return redirect()->to(route('dosen.usulan-baru.identitas-usulan', ['type' => $request->type, 'submission_code' => $request->submission_code]))->with('error', 'Harap lengkapi form terlebih dahulu');
                    }
                }
            }

            return view('pages.dosen.usulan-baru.buat-usulan.fase-2', compact(['type', 'check_code']));
        }
        elseif($request->page == 1 || !isset($request->page)) return view('pages.dosen.usulan-baru.buat-usulan.fase-1', compact(['type', 'check_code']));
        abort(404);
    }
    public function storeUsulan(Request $request)
    {
        $check_code = Submission::where('submission_code', $request->submission_code)->first();
        $cek = [];
        if($request->status == 'store'){
            if($request->fase == 'fase-1'){
                if($check_code->skema) {
                    $check_skema = Schema::find($check_code->skema);
                    if($check_skema->nama_skema == 'KDN' || $check_skema->nama_skema == 'KLN') $this->__rulesFase1($request);
                }
                $data = [
                    'nama_mitra' => $request->nama_mitra,
                    'institusi_mitra' => $request->institusi_mitra,
                    'id_pendanaan_mitra' => $request->id_pendanaan_mitra,
                    'status_usulan' => $check_code->status_usulan ? $check_code->status_usulan : 'Draft'
                ];
                $cek = $data;
            } elseif($request->fase == 'upload-dokumen'){
                $namafile = time().'_'.$request->file('dokumen_usulan')->getClientOriginalName();
                $request->file('dokumen_usulan')->move(public_path().'/assets/storage/files/dokumen-usulan/', $namafile);
                $data = [
                    'dokumen_usulan' => $namafile,
                    'status_usulan' => $check_code->status_usulan ? $check_code->status_usulan : 'Draft'
                ];
                $cek = $data;
            } elseif($request->fase == 'fase-2'){
                if($request->event == 'next'){
                    $this->__rulesFase2($request);
                }

                $check_skema = Schema::find($request->skema);
                $data = [
                    'judul_usulan' => $request->judul_usulan,
                    'skema' => $request->skema,
                    'riset_unggulan' => $request->riset_unggulan,
                    'tema' => $request->tema,
                    'topik' => $request->topik,
                    'target_luaran' => $request->target_luaran,
                    'target_luaran_tambahan' => $request->target_luaran_tambahan,
                    'status_usulan' => $check_code->status_usulan ? $check_code->status_usulan : 'Draft'
                ];
                if(isset($check_skema->nama_skema) && ($check_skema->nama_skema == 'KDN' || $check_skema->nama_skema == 'KLN')){
                    if(!$check_code->nama_mitra || !$check_code->institusi_mitra || !$check_code->id_pendanaan_mitra    ){
                        $cek = ['page' => '1'];
                    }
                }
                $cek = ['page' => '3'];
            } elseif($request->fase == 'fase-4'){
                if($check_code->status_usulan == 'Draft'){
                    \App\Models\Notification::create([
                        'id_jenis' => $check_code->id,
                        'jenis_notifikasi' => 'Submission',
                        'judul_notifikasi' => 'Informasi pengajuan usulan baru',
                        'text_notifikasi' => 'Usulan baru dengan nomor pengajuan '.$check_code->submission_code.' menunggu untuk dikonfirmasi',
                        'to_role' => 1,
                        'read_status' => 'unread',
                    ]);
                    \App\Models\TimelineProgress::create([
                        'id_submission' => $check_code->id,
                        'judul_progress' => 'Usulan diajukan',
                        'text_progress' => 'Diajukan oleh '.auth()->user()->name,
                        'status_progress' => 'success'
                    ]);
                } elseif($check_code->status_usulan == 'Returned by Admin'){
                    \App\Models\Notification::create([
                        'id_jenis' => $check_code->id,
                        'jenis_notifikasi' => 'Submission',
                        'judul_notifikasi' => 'Informasi pengembalian usulan baru',
                        'text_notifikasi' => 'Usulan baru dengan nomor pengajuan '.$check_code->submission_code.' telah dikirim kembali menunggu untuk dikonfirmasi',
                        'to_role' => 1,
                        'read_status' => 'unread',
                    ]);
                    \App\Models\TimelineProgress::create([
                        'id_submission' => $check_code->id,
                        'judul_progress' => 'Usulan diperbaiki',
                        'text_progress' => 'Diperbaiki oleh '.auth()->user()->name,
                        'status_progress' => 'success'
                    ]);
                } elseif($check_code->status_usulan == 'Returned by Prodi'){
                    \App\Models\Notification::create([
                        'id_jenis' => $check_code->id,
                        'jenis_notifikasi' => 'Submission',
                        'judul_notifikasi' => 'Informasi pengembalian usulan baru',
                        'text_notifikasi' => 'Usulan baru dengan nomor pengajuan '.$check_code->submission_code.' telah dikirim kembali menunggu untuk dikonfirmasi',
                        'to_role' => 3,
                        'to_id' => auth()->user()->prodi,
                        'read_status' => 'unread',
                    ]);
                    \App\Models\TimelineProgress::create([
                        'id_submission' => $check_code->id,
                        'judul_progress' => 'Usulan diperbaiki',
                        'text_progress' => 'Diperbaiki oleh '.auth()->user()->name,
                        'status_progress' => 'success'
                    ]);
                }
                if($check_code->status_akhir != 'Rejected' || $check_code->status_akhir != 'Approved'){
                    $data = [
                        'status_usulan' => $check_code->status_usulan == 'Draft' ? 'Pending by Admin' :
                                            ($check_code->status_usulan == 'Returned by Admin' ? 'Pending by Admin' :
                                                ($check_code->status_usulan == 'Returned by Prodi' ? 'Pending by Prodi' : '')
                                            ),
                        'status_akhir' => 'Pending',
                        'dokumen_tambahan_usulan' => null,
                        'waktu_usulan' => (( $check_code->waktu_usulan == null || !$check_code->waktu_usulan ) ? now() : $check_code->waktu_usulan),
                        'alasan_usulan_ditolak' => null,
                    ];
                }
                $update = Submission::find($check_code->id)->update($data);
                if($update) return redirect()->to(route('dosen.usulan-baru.index', $request->type));
            }
            if(!isset($data)) abort(404);
            $update = Submission::find($check_code->id)->update($data);
            if($update) return response()->json(['message' =>'Data berhasil ditambahkan', 'data' => $cek], 200);
            return response()->json(['message' => 'server error'], 500);
        }
    }
    public function delete(Request $request)
    {
        $delete = Submission::find($request->id)->delete();
        if($delete) return response()->json(['message' => 'Data berhasil dihapus'], 200);
        return response()->json(['message' => 'server error'], 500);
    }
    public function __rulesFase1(Request $request)
    {
        return $request->validate([
            'nama_mitra' => 'required',
            'institusi_mitra' => 'required',
            'id_pendanaan_mitra' => 'required'
        ],[
            'nama_mitra.required' => 'Nama mitra tidak boleh kosong',
            'institusi_mitra.required' => 'Institusi mitra tidak boleh kosong',
            'id_pendanaan_mitra.required' => 'Pendanaan mitra tidak boleh kosong'
        ]);
    }
    public function __rulesFase2(Request $request)
    {
        return $request->validate([
            'dokumen_usulan' => 'required',
            'judul_usulan' => 'required',
            'skema' => 'required',
            'riset_unggulan' => 'required',
            'tema' => 'required',
            'topik' => 'required',
            'target_luaran' => 'required',
        ],[
            'dokumen_usulan.required' => 'Dokumen usulan tidak boleh kosong',
            'judul_usulan.required' => 'Judul usulan tidak boleh kosong',
            'skema.required' => 'Skema tidak boleh kosong',
            'riset_unggulan.required' => 'Riset unggulan tidak boleh kosong',
            'tema.required' => 'Tema tidak boleh kosong',
            'topik.required' => 'Topik tidak boleh kosong',
            'target_luaran.required' => 'Target luaran tidak boleh kosong',
        ]);
    }
// End Pengajuan

// Participant
    public function checkParticipant(Request $request)
    {
        $check_code = Submission::where('submission_code', $request->submission_code)->first();
        if($request->role == 'dosen'){
            if($request->type == 'penelitian'){
                $part = Participant::where('id_submission', $check_code->id)->where('role', 'Dosen')->get();
                if($part->count() >= 1) return response()->json(['message' => 'Hanya dapat menambahkan satu dosen dalam pengajuan penelitian'], 403);
            } else {
                $part = Participant::where('id_submission', $check_code->id)->where('role', 'Dosen')->get();
                if($part->count() >= 2) return response()->json(['message' => 'Hanya dapat menambahkan dua dosen dalam pengajuan pengabdian masyarakat'], 403);
            }
        }
        if($request->role == 'mahasiswa'){
            $part = Participant::where('id_submission', $check_code->id)->where('role', 'Mahasiswa')->get();
            if($part->count() >= 2) return response()->json(['message' => 'Hanya dapat menambahkan dua mahasiswa dalam pengajuan'], 403);
        }

        return response()->json(200);
    }
    public function getParticipant(Request $request)
    {
        $check_code = Submission::where('submission_code', $request->submission_code)->first();
        if($request->role == 'dosen'){
            $data = Participant::where('id_submission', $check_code->id)->where('role', 'Dosen')->get();
        } else {
            $data = Participant::where('id_submission', $check_code->id)->where('role', 'Mahasiswa')->get();
        }

        return response()->json(['message' =>'Data berhasil didapatkan', 'data' => $data], 200);
    }
    public function tambahParticipant(Request $request)
    {
        $this->__participantRules($request);
        $check_code = Submission::where('submission_code', $request->submission_code)->first();
        if($request->role == 'dosen'){
            $data = [
                'id_submission' => $check_code->id,
                'nama' => $request->nama_dosen,
                'pendidikan' => $request->pendidikan_dosen,
                'nidn' => $request->nidn_dosen,
                'instansi' => $request->instansi_dosen,
                'jabatan' => $request->jabatan_dosen,
                'fakultas' => $request->fakultas_dosen,
                'program_studi' => $request->program_studi_dosen,
                'id_sinta' => $request->id_sinta,
                'tugas' => $request->tugas_dosen,
                'role' => $request->role == 'dosen' ? 'Dosen' : 'Mahasiswa',
            ];
        } elseif($request->role == 'mahasiswa'){
            $data = [
                'id_submission' => $check_code->id,
                'nama' => $request->nama_mahasiswa,
                'nidn' => $request->nidn_mahasiswa,
                'fakultas' => $request->fakultas_mahasiswa,
                'program_studi' => $request->program_studi_mahasiswa,
                'tugas' => $request->tugas_mahasiswa,
                'role' => $request->role == 'dosen' ? 'Dosen' : 'Mahasiswa',
            ];
        } else {
            return response()->json(['message' => 'server error'], 500);
        }

        if($request->role == 'dosen'){
            if($request->type == 'penelitian'){
                $part = Participant::where('id_submission', $check_code->id)->where('role', 'Dosen')->get();
                if($part->count() >= 1) return response()->json(['message' => 'Hanya dapat menambahkan satu dosen dalam pengajuan penelitian'], 403);
            }
        }
        if($request->role == 'mahasiswa'){
            if($request->type == 'penelitian'){
                $part = Participant::where('id_submission', $check_code->id)->where('role', 'Mahasiswa')->get();
                if($part->count() >= 2) return response()->json(['message' => 'Hanya dapat menambahkan dua mahasiswa dalam pengajuan penelitian'], 403);
            }
        }

        $create = Participant::create($data);
        if($create) return response()->json(['message' =>'Data berhasil ditambahkan'], 200);
        return response()->json(['message' => 'server error'], 500);
    }
    public function showParticipant(Request $request)
    {
        $data = Participant::find($request->id);
        if($data) return response()->json(['message' =>'Data berhasil didapatkan', 'data' => $data], 200);
        return response()->json(['message' => 'server error'], 500);
    }
    public function updateParticipant(Request $request)
    {
        $this->__participantRules($request);
        if($request->role == 'dosen'){
            $data = [
                'nama' => $request->nama_dosen,
                'pendidikan' => $request->pendidikan_dosen,
                'nidn' => $request->nidn_dosen,
                'instansi' => $request->instansi_dosen,
                'jabatan' => $request->jabatan_dosen,
                'fakultas' => $request->fakultas_dosen,
                'program_studi' => $request->program_studi_dosen,
                'id_sinta' => $request->id_sinta,
                'tugas' => $request->tugas_dosen,
                'role' => $request->role == 'dosen' ? 'Dosen' : 'Mahasiswa',
            ];
        } elseif($request->role == 'mahasiswa'){
            $data = [
                'nama' => $request->nama_mahasiswa,
                'nidn' => $request->nidn_mahasiswa,
                'fakultas' => $request->fakultas_mahasiswa,
                'program_studi' => $request->program_studi_mahasiswa,
                'tugas' => $request->tugas_mahasiswa,
                'role' => $request->role == 'dosen' ? 'Dosen' : 'Mahasiswa',
            ];
        } else {
            return response()->json(['message' => 'server error'], 500);
        }

        $update = Participant::find($request->id)->update($data);
        if($update) return response()->json(['message' =>'Data berhasil diupdate'], 200);
        return response()->json(['message' => 'server error'], 500);
    }
    public function deleteParticipant(Request $request)
    {
        $delete = Participant::find($request->id)->delete();
        if($delete) return response()->json(['message' =>'Data berhasil dihapus'], 200);
        return response()->json(['message' => 'server error'], 500);
    }
    public function __participantRules(Request $request)
    {
        if($request->role == 'dosen'){
            return $request->validate([
                'nama_dosen' => 'required',
                'pendidikan_dosen' => 'required',
                'nidn_dosen' => 'required',
                'instansi_dosen' => 'required',
                'jabatan_dosen' => 'required',
                'fakultas_dosen' => 'required',
                'program_studi_dosen' => 'required',
                'id_sinta' => 'required',
                'tugas_dosen' => 'required',
            ],[
                'nama_dosen.required'  => 'Nama dosen tidak boleh kosong',
                'pendidikan_dosen.required'  => 'Pendidikan dosen tidak boleh kosong',
                'nidn_dosen.required'  => 'NIDN dosen tidak boleh kosong',
                'instansi_dosen.required'  => 'Instansi tidak boleh kosong',
                'jabatan_dosen.required'  => 'Jabatan dosen tidak boleh kosong',
                'fakultas_dosen.required'  => 'Fakultas dosen tidak boleh kosong',
                'program_studi_dosen.required'  => 'Program studi dosen tidak boleh kosong',
                'id_sinta.required'  => 'ID sinta dosen tidak boleh kosong',
                'tugas_dosen.required'  => 'Tugas dosen tidak boleh kosong',
            ]);
        } elseif($request->role == 'mahasiswa'){
            return $request->validate([
                'nama_mahasiswa' => 'required',
                'nidn_mahasiswa' => 'required',
                'fakultas_mahasiswa' => 'required',
                'program_studi_mahasiswa' => 'required',
                'tugas_mahasiswa' => 'required',
            ],[
                'nama_mahasiswa.required'  => 'Nama mahasiswa tidak boleh kosong',
                'nidn_mahasiswa.required'  => 'NIDN mahasiswa tidak boleh kosong',
                'fakultas_mahasiswa.required'  => 'Fakultas mahasiswa tidak boleh kosong',
                'program_studi_mahasiswa.required'  => 'Program studi mahasiswa tidak boleh kosong',
                'tugas_mahasiswa.required'  => 'Tugas mahasiswa tidak boleh kosong',
            ]);
        }
    }
// End participant

// RAB
    public function getRAB(Request $request)
    {
        $check_code = Submission::where('submission_code', $request->submission_code)->first();
        $data = RabSubmission::where('id_submission', $check_code->id)->get();
        return response()->json(['message' =>'Data berhasil didapatkan', 'data' => $data], 200);
    }
    public function tambahRAB(Request $request)
    {
        $this->__rabRules($request);
        $check_code = Submission::where('submission_code', $request->submission_code)->first();
        $rab = Rab::find($request->nama_item);
        if(!$rab) $nama_item = $request->nama_item;
        else $nama_item = $rab->nama_item;

        $data = [
            'id_submission' => $check_code->id,
            'nama_item' => $nama_item,
            'harga' => $request->harga,
            'volume' => $request->volume,
            'total' => $request->total
        ];

        $create = RabSubmission::create($data);
        if($create) return response()->json(['message' =>'Data berhasil ditambahkan'], 200);
        return response()->json(['message' => 'server error'], 500);
    }
    public function deleteRAB(Request $request)
    {
        $delete = RabSubmission::find($request->id)->delete();
        if($delete) return response()->json(['message' =>'Data berhasil dihapus'], 200);
        return response()->json(['message' => 'server error'], 500);
    }
    public function __rabRules(Request $request)
    {
        return $request->validate([
            'nama_item' => 'required',
            'harga' => 'required',
            'volume' => 'required',
        ],[
            'nama_item.required' => 'Nama item tidak boleh kosong',
            'harga.required' => 'Harga item tidak boleh kosong',
            'volume.required' => 'Volume item tidak boleh kosong'
        ]);
    }
// End RAB
}
