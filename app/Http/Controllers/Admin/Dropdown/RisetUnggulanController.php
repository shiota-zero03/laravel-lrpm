<?php

namespace App\Http\Controllers\Admin\Dropdown;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SuperiorResearch;
use DataTables;

class RisetUnggulanController extends Controller
{
    public function index()
    {
        return view('pages.admin.dropdown.riset-unggulan');
    }
    public function json(Request $request)
    {
        if ($request->ajax()) {
            $data = SuperiorResearch::orderByDesc('id')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '
                        <a href="#" onclick="openModal('.$row['id'].')" class="btn btn-warning mb-1 me-1 btn-sm text-white"><strong><i class="bi bi-pencil-fill"></i></strong></a>
                        <a href="#" onclick="deleteData('.$row['id'].')" class="btn btn-danger mb-1 me-1 btn-sm"><strong><i class="bi bi-trash"></i></strong></a>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    public function store(Request $request)
    {
        $this->__rules($request);
        $data = [
            'nama_riset' => $request->nama_riset,
        ];
        $create = SuperiorResearch::create($data);
        if($create) return response()->json(['message' =>'Data berhasil ditambahkan'], 200);
        return response()->json(['message' => 'server error'], 500);
    }
    public function show(Request $request)
    {
        $data = SuperiorResearch::find($request->id);
        if($data) return response()->json(['message' =>'Data berhasil didapatkan', 'data' => $data], 200);
        return response()->json(['message' => 'server error'], 500);
    }
    public function update(Request $request)
    {
        $this->__rules($request);
        $data = [
            'nama_riset' => $request->nama_riset,
        ];
        $update = SuperiorResearch::find($request->id)->update($data);
        if($update) return response()->json(['message' =>'Data berhasil diubah'], 200);
        return response()->json(['message' => 'server error'], 500);
    }
    public function destroy(Request $request)
    {
        $delete = SuperiorResearch::find($request->id)->delete();
        if($delete) return response()->json(['message' =>'Data berhasil dihapus'], 200);
        return response()->json(['message' => 'server error'], 500);
    }
    public function __rules(Request $request)
    {
        return $request->validate([
            'nama_riset' => 'required',
        ],[
            'nama_riset.required' => 'Nama riset tidak boleh kosong',
        ]);
    }
}
