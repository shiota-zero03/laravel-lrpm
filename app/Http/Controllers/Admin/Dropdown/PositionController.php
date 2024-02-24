<?php

namespace App\Http\Controllers\Admin\Dropdown;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Position;
use DataTables;

class PositionController extends Controller
{
    public function index()
    {
        return view('pages.admin.dropdown.jabatan');
    }
    public function json(Request $request)
    {
        if ($request->ajax()) {
            $data = Position::orderByDesc('id')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('rl', function($row){
                    ($row['role_jabatan'] == 1 ? $rl ='Admin' : 
                        ($row['role_jabatan'] == 2 ? $rl = 'Reviewer' : 
                            ($row['role_jabatan'] == 3 ? $rl = 'Program Studi' : 
                                ($row['role_jabatan'] == 4 ? $rl = 'Fakultas' : $rl = 'Dosen')
                            )
                        )
                    );
                    return $rl;        
                })
                ->addColumn('action', function($row){
                    return '
                        <a href="#" onclick="openModal('.$row['id'].')" class="btn btn-warning mb-1 me-1 btn-sm text-white"><strong><i class="bi bi-pencil-fill"></i></strong></a>
                        <a href="#" onclick="deleteData('.$row['id'].')" class="btn btn-danger mb-1 me-1 btn-sm"><strong><i class="bi bi-trash"></i></strong></a>
                    ';
                })
                ->rawColumns(['rl', 'action'])
                ->make(true);
        }
    }
    public function store(Request $request)
    {
        $this->__rules($request);
        $data = [
            'nama_jabatan' => $request->nama_jabatan,
            'role_jabatan' => $request->role_jabatan,
        ];
        $create = Position::create($data);
        if($create) return response()->json(['message' =>'Data berhasil ditambahkan'], 200);
        return response()->json(['message' => 'server error'], 500);
    }
    public function show(Request $request)
    {
        $data = Position::find($request->id);
        if($data) return response()->json(['message' =>'Data berhasil didapatkan', 'data' => $data], 200);
        return response()->json(['message' => 'server error'], 500);
    }
    public function update(Request $request)
    {
        $this->__rules($request);
        $data = [
            'nama_jabatan' => $request->nama_jabatan,
            'role_jabatan' => $request->role_jabatan,
        ];
        $update = Position::find($request->id)->update($data);
        if($update) return response()->json(['message' =>'Data berhasil diubah'], 200);
        return response()->json(['message' => 'server error'], 500);
    }
    public function destroy(Request $request)
    {
        $delete = Position::find($request->id)->delete();
        if($delete) return response()->json(['message' =>'Data berhasil dihapus'], 200);
        return response()->json(['message' => 'server error'], 500);
    }
    public function __rules(Request $request)
    {
        return $request->validate([
            'nama_jabatan' => 'required',
            'role_jabatan' => 'required'
        ],[
            'nama_jabatan.required' => 'Nama jabatan tidak boleh kosong',
            'role_jabatan.required' => 'Role jabatan harus dipilih'
        ]);
    }
}
