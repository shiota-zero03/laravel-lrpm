<?php

namespace App\Http\Controllers\Reviewer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
class ProfileController extends Controller
{
    public function index()
    {
        $jabatan = \App\Models\Position::where('role_jabatan', auth()->user()->role)->get();
        $fakultas = \App\Models\Faculty::all();
        $prodi = \App\Models\Department::where('id_fakultas', auth()->user()->fakultas)->get();
        return view('pages.public.profile.index', compact(['jabatan', 'fakultas', 'prodi']));
    }
    public function getProdi(Request $request)
    {
        $data = \App\Models\Department::where('id_fakultas', $request->id_fakultas)->get();
        return response()->json(['message' => 'Program studi berhasil didapatkan', 'data' => $data], 200);
    }
    public function update(Request $request)
    {
        $this->__rules($request);
        if($request->email != auth()->user()->email) $request->validate(['email' => 'unique:users'],['email.unique' => 'email sudah pernah digunakan']);
        if($request->nidn != auth()->user()->nidn) $request->validate(['nidn' => 'unique:users'],['nidn.unique' => 'nidn sudah pernah digunakan']);
        if($request->no_hp != auth()->user()->no_hp) $request->validate(['no_hp' => 'unique:users'],['no_hp.unique' => 'no hp sudah pernah digunakan']);

        $data = [
            'name' => $request->name,
            'nidn' => $request->nidn,
            'jabatan' => $request->jabatan,
            'unit' => $request->unit,
            'email' => $request->email,
            'password' => auth()->user()->password == $request->password ? $request->password : Hash::make($request->password),
            'no_hp' => $request->no_hp,
            'institusi' => $request->institusi,
            'id_sinta' => $request->id_sinta,
            'id_google_scholar' => $request->id_google_scholar,
            'id_scopus' => $request->id_scopus,
            'fakultas' => $request->fakultas,
            'prodi' => $request->prodi,
        ];
        $update = \App\Models\User::find(auth()->user()->id)->update($data);
        if($update) return back()->with('success', 'Data berhasil diupdate');
    }
    public function __rules(Request $request)
    {
        if(auth()->user()->role == 1){
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
        } elseif(auth()->user()->role == 2){
            return $request->validate([
                'name' => 'required',
                'unit' => 'required',
            ],[
                'name.required' => 'Nama tidak boleh kosong',
                'nidn.required' => 'NIDN tidak boleh kosong',
                'unit.required' => 'Institusi tidak boleh kosong',
                'email.required' => 'Email tidak boleh kosong',
                'no_hp.required' => 'Nomor hp tidak boleh kosong',
                'email.email' => 'Email tidak valid',
            ]);
        } elseif(auth()->user()->role == 3){
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
        } elseif(auth()->user()->role == 4){
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
}
