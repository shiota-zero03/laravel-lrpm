<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Position;
use App\Models\Department;
use App\Models\Faculty;

use DataTables, Hash;
class UserController extends Controller
{
    public function index(Request $request)
    {

        $pengguna = ucwords(str_replace('-', ' ', $request->role));
        $role = $request->role;
        if($role == 'admin') $rl = 1;
        elseif($role == 'reviewer') $rl = 2;
        elseif($role == 'program-studi') $rl = 3;
        elseif($role == 'fakultas') $rl = 4;
        elseif($role == 'dosen') $rl = 5;

        $jabatan = Position::where('role_jabatan', $rl)->get();
        $fakultas = Faculty::all();

        return view('pages.admin.user.index', compact(['pengguna', 'role', 'jabatan', 'fakultas']));
    }
    public function json(Request $request)
    {
        if($request->role == 'admin') $role = 1;
        elseif($request->role == 'reviewer') $role = 2;
        elseif($request->role == 'program-studi') $role = 3;
        elseif($request->role == 'fakultas') $role = 4;
        elseif($request->role == 'dosen') $role = 5;

        if ($request->ajax()) {
            $data = User::whereNot('id', 1)
                        ->where('role', $role)
                        ->orderByDesc('created_at')
                        ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('rl', function($row){
                    ($row['role'] == 1 ? $rl ='Admin' :
                        ($row['role'] == 2 ? $rl ='Reviewer' :
                            ($row['role'] == 3 ? $rl ='Program Studi' :
                                ($row['role'] == 4 ? $rl ='Fakultas' : $rl = 'Dosen')
                            )
                        )
                    );
                    return $rl;
                })
                ->addColumn('jur', function($row){
                    $dept = Department::find($row['prodi']);
                    if(!$dept) return '<em>Belum memilih jurusan</em>';
                    else return $dept->nama_prodi;
                })
                ->addColumn('fak', function($row){
                    $dept = Faculty::find($row['fakultas']);
                    if(!$dept) return '<em>Belum memilih fakultas</em>';
                    else return $dept->nama_fakultas;
                })
                ->addColumn('jabatan', function($row){
                    $jabatan = \App\Models\Position::find($row['jabatan']);
                    if(!$jabatan) return '<em>Belum memilih fakultas</em>';
                    else return $jabatan->nama_jabatan;
                })
                ->addColumn('status', function($row){
                    return $row['email_verified_at'] ? '<small class="text-white bg-success py-1 px-3 rounded-pill">Aktif</small>' :
                        '
                            <small class="text-white bg-warning py-1 px-3 rounded-pill fst-italic">Tidak Aktif</small><br>
                            <button onclick="verifikasi('.$row['id'].')" class="bg-primary mt-1 text-white rounded border-0"><small><i class="bi bi-patch-check-fill me-2"></i>Verifikasi User</small></button>
                        ';
                })
                ->addColumn('action', function($row){
                    return '
                        <a href="#" onclick="openModal('.$row['id'].')" class="btn btn-warning mb-1 me-1 btn-sm text-white"><strong><i class="bi bi-pencil-fill"></i></strong></a>
                        <a href="#" onclick="deleteData('.$row['id'].')" class="btn btn-danger mb-1 me-1 btn-sm"><strong><i class="bi bi-trash"></i></strong></a>
                    ';
                })
                ->rawColumns(['rl', 'jur', 'fak', 'jabatan', 'status', 'action'])
                ->make(true);
        }
    }
    public function store(Request $request)
    {
        $role = $request->role;
        if($role == 'admin') $rl = 1;
        elseif($role == 'reviewer') $rl = 2;
        elseif($role == 'program-studi') $rl = 3;
        elseif($role == 'fakultas') $rl = 4;
        elseif($role == 'dosen') $rl = 5;

        $this->__rulesStore($request);

        if(!$request->nidn || !isset($request->nidn)){
            $nidnNumber = User::pluck('nidn')->toArray();
            do {
                $rand = mt_rand(1000000000, 9999999999);
                $newNIDNNumber = $rand;
            } while (in_array($rand, $nidnNumber));
            $nidn = $newNIDNNumber;
        } else {
            $nidn = $request->nidn;
        }

        $data = [
            'name' => $request->name,
            'nidn' => $nidn,
            'jabatan' => $request->jabatan,
            'unit' => $request->unit,
            'email' => $request->email,
            'email_verified_at' => now(),
            'password' => Hash::make($request->password),
            'no_hp' => $request->no_hp,
            'role' => $rl,
            'institusi' => $request->institusi,
            'id_sinta' => $request->id_sinta,
            'id_google_scholar' => $request->id_google_scholar,
            'id_scopus' => $request->id_scopus,
            'fakultas' => $request->fakultas,
            'prodi' => $request->prodi,
        ];
        $create = User::create($data);
        if($create) return response()->json(['message' =>'Data berhasil ditambahkan'], 200);
        return response()->json(['message' => 'server error'], 500);
    }
    public function show(Request $request)
    {
        $data = User::find($request->id);
        if($data) return response()->json(['message' =>'Data berhasil didapatkan', 'data' => $data], 200);
        return response()->json(['message' => 'server error'], 500);
    }
    public function update(Request $request)
    {
        $role = $request->role;
        if($role == 'admin') $rl = 1;
        elseif($role == 'reviewer') $rl = 2;
        elseif($role == 'program-studi') $rl = 3;
        elseif($role == 'fakultas') $rl = 4;
        elseif($role == 'dosen') $rl = 5;

        $this->__rulesUpdate($request);

        $userFind = User::find($request->id);

        if($request->email != $userFind->email) $request->validate(['email' => 'unique:users'],['email.unique' => 'email sudah pernah digunakan']);
        if($request->nidn != $userFind->nidn) $request->validate(['nidn' => 'unique:users'],['nidn.unique' => 'nidn sudah pernah digunakan']);
        if($request->no_hp != $userFind->no_hp) $request->validate(['no_hp' => 'unique:users'],['no_hp.unique' => 'no hp sudah pernah digunakan']);

        if(!$request->nidn){
            $data = [
                'name' => $request->name,
                'jabatan' => $request->jabatan,
                'unit' => $request->unit,
                'email' => $request->email,
                'password' => $userFind->password == $request->password ? $request->password : Hash::make($request->password),
                'no_hp' => $request->no_hp,
                'institusi' => $request->institusi,
                'id_sinta' => $request->id_sinta,
                'id_google_scholar' => $request->id_google_scholar,
                'id_scopus' => $request->id_scopus,
                'fakultas' => $request->fakultas,
                'prodi' => $request->prodi,
            ];
        } else {
            $data = [
                'name' => $request->name,
                'nidn' => $request->nidn,
                'jabatan' => $request->jabatan,
                'unit' => $request->unit,
                'email' => $request->email,
                'password' => $userFind->password == $request->password ? $request->password : Hash::make($request->password),
                'no_hp' => $request->no_hp,
                'institusi' => $request->institusi,
                'id_sinta' => $request->id_sinta,
                'id_google_scholar' => $request->id_google_scholar,
                'id_scopus' => $request->id_scopus,
                'fakultas' => $request->fakultas,
                'prodi' => $request->prodi,
            ];
        }

        $update = User::find($request->id)->update($data);
        if($update) return response()->json(['message' =>'Data berhasil diupdate'], 200);
        return response()->json(['message' => 'server error'], 500);
    }

    public function destroy(Request $request)
    {
        $delete = User::find($request->id)->delete();
        if($delete) return response()->json(['message' =>'Data berhasil dihapus'], 200);
        return response()->json(['message' => 'server error'], 500);
    }

    public function __rulesStore(Request $request)
    {
        if($request->role == 'admin'){
            return $request->validate([
                'name' => 'required',
                'unit' => 'required',
                'jabatan' => 'required',
                'email' => 'required|email|unique:users',
                'no_hp' => 'required|unique:users'
            ],[
                'name.required' => 'Nama tidak boleh kosong',
                'unit.required' => 'Unit tidak boleh kosong',
                'jabatan.required' => 'Jabatan tidak boleh kosong',
                'email.required' => 'Email tidak boleh kosong',
                'no_hp.required' => 'Nomor hp tidak boleh kosong',
                'email.email' => 'Email tidak valid',
                'email.unique' => 'Email sudah digunakan',
                'no_hp.unique' => 'Nomor hp sudah digunakan',
            ]);
        } elseif($request->role == 'reviewer'){
            return $request->validate([
                'name' => 'required',
                'nidn' => 'required|unique:users',
                'jabatan.required' => 'Jabatan tidak boleh kosong',
                'unit' => 'required',
                'email' => 'required|email|unique:users',
                'no_hp' => 'required|unique:users'
            ],[
                'name.required' => 'Nama tidak boleh kosong',
                'nidn.required' => 'NIDN tidak boleh kosong',
                'unit.required' => 'Institusi tidak boleh kosong',
                'jabatan.required' => 'Jabatan tidak boleh kosong',
                'email.required' => 'Email tidak boleh kosong',
                'no_hp.required' => 'Nomor hp tidak boleh kosong',
                'email.email' => 'Email tidak valid',
                'nidn.unique' => 'NIDN sudah digunakan',
                'email.unique' => 'Email sudah digunakan',
                'no_hp.unique' => 'Nomor hp sudah digunakan',
            ]);
        } elseif($request->role == 'program-studi'){
            return $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'no_hp' => 'required|unique:users',
                'fakultas' => 'required',
                'prodi' => 'required',
            ],[
                'name.required' => 'Nama tidak boleh kosong',
                'email.required' => 'Email tidak boleh kosong',
                'no_hp.required' => 'Nomor hp tidak boleh kosong',
                'fakultas.required' => 'Fakultas tidak boleh kosong',
                'prodi.required' => 'Program studi tidak boleh kosong',
                'email.email' => 'Email tidak valid',
                'email.unique' => 'Email sudah digunakan',
                'no_hp.unique' => 'Nomor hp sudah digunakan',
            ]);
        } elseif($request->role == 'fakultas'){
            return $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'no_hp' => 'required|unique:users',
                'fakultas' => 'required'
            ],[
                'name.required' => 'Nama tidak boleh kosong',
                'email.required' => 'Email tidak boleh kosong',
                'no_hp.required' => 'Nomor hp tidak boleh kosong',
                'fakultas.required' => 'Fakultas tidak boleh kosong',
                'email.email' => 'Email tidak valid',
                'email.unique' => 'Email sudah digunakan',
                'no_hp.unique' => 'Nomor hp sudah digunakan',
            ]);
        } else{
            return $request->validate([
                'name' => 'required',
                'nidn' => 'required|unique:users',
                'jabatan' => 'required',
                'email' => 'required|email|unique:users',
                'no_hp' => 'required|unique:users',
                'fakultas' => 'required',
                'prodi' => 'required',
                'id_sinta' => 'required',
                'id_google_scholar' => 'required',
                'id_scopus' => 'required',
            ],[
                'name.required' => 'Nama tidak boleh kosong',
                'nidn.required' => 'NIDN tidak boleh kosong',
                'jabatan.required' => 'Jabatan tidak boleh kosong',
                'email.required' => 'Email tidak boleh kosong',
                'no_hp.required' => 'Nomor hp tidak boleh kosong',
                'fakultas.required' => 'Fakultas tidak boleh kosong',
                'prodi.required' => 'Program studi tidak boleh kosong',
                'id_sinta.required' => 'ID sinta harus diisi',
                'id_google_scholar.required' => 'ID google scholar harus diisi',
                'id_scopus.required' => 'ID scopus harus diisi',
                'email.email' => 'Email tidak valid',
                'nidn.unique' => 'NIDN sudah digunakan',
                'email.unique' => 'Email sudah digunakan',
                'no_hp.unique' => 'Nomor hp sudah digunakan',
            ]);
        }
    }

    public function __rulesUpdate(Request $request)
    {
        if($request->role == 'admin'){
            return $request->validate([
                'name' => 'required',
                'unit' => 'required',
                'jabatan' => 'required',
            ],[
                'name.required' => 'Nama tidak boleh kosong',
                'unit.required' => 'Unit tidak boleh kosong',
                'jabatan.required' => 'Jabatan tidak boleh kosong',
                'email.required' => 'Email tidak boleh kosong',
                'no_hp.required' => 'Nomor hp tidak boleh kosong',
                'email.email' => 'Email tidak valid',
            ]);
        } elseif($request->role == 'reviewer'){
            return $request->validate([
                'name' => 'required',
                'unit' => 'required',
                'jabatan' => 'required',
            ],[
                'name.required' => 'Nama tidak boleh kosong',
                'nidn.required' => 'NIDN tidak boleh kosong',
                'jabatan.required' => 'Jabatan tidak boleh kosong',
                'unit.required' => 'Institusi tidak boleh kosong',
                'email.required' => 'Email tidak boleh kosong',
                'no_hp.required' => 'Nomor hp tidak boleh kosong',
                'email.email' => 'Email tidak valid',
            ]);
        } elseif($request->role == 'program-studi'){
            return $request->validate([
                'name' => 'required',
                'fakultas' => 'required',
                'prodi' => 'required',
            ],[
                'name.required' => 'Nama tidak boleh kosong',
                'email.required' => 'Email tidak boleh kosong',
                'no_hp.required' => 'Nomor hp tidak boleh kosong',
                'fakultas.required' => 'Fakultas tidak boleh kosong',
                'prodi.required' => 'Program studi tidak boleh kosong',
                'email.email' => 'Email tidak valid',
            ]);
        } elseif($request->role == 'fakultas'){
            return $request->validate([
                'name' => 'required',
                'fakultas' => 'required'
            ],[
                'name.required' => 'Nama tidak boleh kosong',
                'email.required' => 'Email tidak boleh kosong',
                'no_hp.required' => 'Nomor hp tidak boleh kosong',
                'fakultas.required' => 'Fakultas tidak boleh kosong',
                'email.email' => 'Email tidak valid',
            ]);
        } else{
            return $request->validate([
                'name' => 'required',
                'jabatan' => 'required',
                'fakultas' => 'required',
                'prodi' => 'required',
                'id_sinta' => 'required',
                'id_google_scholar' => 'required',
                'id_scopus' => 'required',
            ],[
                'name.required' => 'Nama tidak boleh kosong',
                'nidn.required' => 'NIDN tidak boleh kosong',
                'jabatan.required' => 'Jabatan tidak boleh kosong',
                'email.required' => 'Email tidak boleh kosong',
                'no_hp.required' => 'Nomor hp tidak boleh kosong',
                'fakultas.required' => 'Fakultas tidak boleh kosong',
                'prodi.required' => 'Program studi tidak boleh kosong',
                'id_sinta.required' => 'ID sinta harus diisi',
                'id_google_scholar.required' => 'ID google scholar harus diisi',
                'id_scopus.required' => 'ID scopus harus diisi',
                'email.email' => 'Email tidak valid',
            ]);
        }
    }

    public function getProdi(Request $request)
    {
        $data = Department::where('id_fakultas', $request->fakultas_id)->get();
        return response()->json(['message' => 'Program studi berhasil didapatkan', 'data' => $data], 200);
    }
    public function verifikasi(Request $request)
    {
        $data = [
            'email_verified_at' => now()
        ];
        $update = User::find($request->id)->update($data);
        if($update) return response()->json(['message' =>'Akun berhasil diaktifkan'], 200);
        return response()->json(['message' => 'server error'], 500);
    }
}
