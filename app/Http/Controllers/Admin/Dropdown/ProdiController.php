<?php

namespace App\Http\Controllers\Admin\Dropdown;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Department;
use App\Models\Faculty;
use DataTables;

class ProdiController extends Controller
{
    public function index()
    {
        $fakultas = Faculty::all();
        return view('pages.admin.dropdown.prodi', compact(['fakultas']));
    }
    public function json(Request $request)
    {
        if ($request->ajax()) {
            $data = Department::orderByDesc('id')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('fakultas', function($row){
                    $faculty = Faculty::find($row['id_fakultas']);
                    return $faculty->nama_fakultas;
                })
                ->addColumn('action', function($row){
                    return '
                        <a href="#" onclick="openModal('.$row['id'].')" class="btn btn-warning mb-1 me-1 btn-sm text-white"><strong><i class="bi bi-pencil-fill"></i></strong></a>
                        <a href="#" onclick="deleteData('.$row['id'].')" class="btn btn-danger mb-1 me-1 btn-sm"><strong><i class="bi bi-trash"></i></strong></a>
                    ';
                })
                ->rawColumns(['fakultas', 'action'])
                ->make(true);
        }
    }
    public function store(Request $request)
    {
        $this->__rules($request);
        $data = [
            'nama_prodi' => $request->nama_prodi,
            'id_fakultas' => $request->id_fakultas,
        ];
        $create = Department::create($data);
        if($create) return response()->json(['message' =>'Data berhasil ditambahkan'], 200);
        return response()->json(['message' => 'server error'], 500);
    }
    public function show(Request $request)
    {
        $data = Department::find($request->id);
        if($data) return response()->json(['message' =>'Data berhasil didapatkan', 'data' => $data], 200);
        return response()->json(['message' => 'server error'], 500);
    }
    public function update(Request $request)
    {
        $this->__rules($request);
        $data = [
            'nama_prodi' => $request->nama_prodi,
            'id_fakultas' => $request->id_fakultas,
        ];
        $update = Department::find($request->id)->update($data);
        if($update) return response()->json(['message' =>'Data berhasil diubah'], 200);
        return response()->json(['message' => 'server error'], 500);
    }
    public function destroy(Request $request)
    {
        $delete = Department::find($request->id)->delete();
        if($delete) return response()->json(['message' =>'Data berhasil dihapus'], 200);
        return response()->json(['message' => 'server error'], 500);
    }
    public function __rules(Request $request)
    {
        return $request->validate([
            'nama_prodi' => 'required',
            'id_fakultas' => 'required'
        ],[
            'nama_prodi.required' => 'Nama program studi tidak boleh kosong',
            'id_fakultas.required' => 'Fakultas harus dipilih'
        ]);
    }
}
