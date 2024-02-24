<?php

namespace App\Http\Controllers\Admin\Dropdown;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Theme;
use DataTables;

class TemaController extends Controller
{
    public function index()
    {
        return view('pages.admin.dropdown.tema');
    }
    public function json(Request $request)
    {
        if ($request->ajax()) {
            $data = Theme::orderByDesc('id')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('riset', function($row){
                    $riset = \App\Models\SuperiorResearch::find($row['id_riset']);
                    return $riset->nama_riset;
                })
                ->addColumn('action', function($row){
                    return '
                        <a href="#" onclick="openModal('.$row['id'].')" class="btn btn-warning mb-1 me-1 btn-sm text-white"><strong><i class="bi bi-pencil-fill"></i></strong></a>
                        <a href="#" onclick="deleteData('.$row['id'].')" class="btn btn-danger mb-1 me-1 btn-sm"><strong><i class="bi bi-trash"></i></strong></a>
                    ';
                })
                ->rawColumns(['riset', 'action'])
                ->make(true);
        }
    }
    public function store(Request $request)
    {
        $this->__rules($request);
        $data = [
            'nama_tema' => $request->nama_tema,
            'id_riset' => $request->id_riset
        ];
        $create = Theme::create($data);
        if($create) return response()->json(['message' =>'Data berhasil ditambahkan'], 200);
        return response()->json(['message' => 'server error'], 500);
    }
    public function show(Request $request)
    {
        $data = Theme::find($request->id);
        if($data) return response()->json(['message' =>'Data berhasil didapatkan', 'data' => $data], 200);
        return response()->json(['message' => 'server error'], 500);
    }
    public function update(Request $request)
    {
        $this->__rules($request);
        $data = [
            'nama_tema' => $request->nama_tema,
            'id_riset' => $request->id_riset
        ];
        $update = Theme::find($request->id)->update($data);
        if($update) return response()->json(['message' =>'Data berhasil diubah'], 200);
        return response()->json(['message' => 'server error'], 500);
    }
    public function destroy(Request $request)
    {
        $delete = Theme::find($request->id)->delete();
        if($delete) return response()->json(['message' =>'Data berhasil dihapus'], 200);
        return response()->json(['message' => 'server error'], 500);
    }
    public function __rules(Request $request)
    {
        return $request->validate([
            'nama_tema' => 'required',
            'id_riset' => 'required'
        ],[
            'nama_tema.required' => 'Nama tema tidak boleh kosong',
            'id_riset.required' => 'Pilih salah satu riset',
        ]);
    }
    public function getByIdRisetJson(Request $request)
    {
        if($request->ajax()){
            $data = Theme::where('id_riset', $request->id)->get();
            if($data) return response()->json(['message' =>'Data berhasil didapatkan', 'data' => $data], 200);
            return response()->json(['message' => 'server error'], 500);
        } else abort(404);
    }
    public function getTopicByIdTemaJson(Request $request)
    {
        if($request->ajax()){
            $data = \App\Models\Topic::where('id_tema', $request->id)->get();
            if($data) return response()->json(['message' =>'Data berhasil didapatkan', 'data' => $data], 200);
            return response()->json(['message' => 'server error'], 500);
        } else abort(404);
    }
}
