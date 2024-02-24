<?php

namespace App\Http\Controllers\Admin\Dropdown;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Topic;
use DataTables;

class TopikController extends Controller
{
    public function index()
    {
        return view('pages.admin.dropdown.topik');
    }
    public function json(Request $request)
    {
        if ($request->ajax()) {
            $data = Topic::orderByDesc('id')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('tema', function($row){
                    $tema = \App\Models\Theme::find($row->id_tema);
                    return $tema->nama_tema;
                })
                ->addColumn('riset', function($row){
                    $tema = \App\Models\Theme::find($row->id_tema);
                    $riset = \App\Models\SuperiorResearch::find($tema->id_riset);
                    return $riset->nama_riset;
                })
                ->addColumn('action', function($row){
                    return '
                        <a href="#" onclick="openModal('.$row['id'].')" class="btn btn-warning mb-1 me-1 btn-sm text-white"><strong><i class="bi bi-pencil-fill"></i></strong></a>
                        <a href="#" onclick="deleteData('.$row['id'].')" class="btn btn-danger mb-1 me-1 btn-sm"><strong><i class="bi bi-trash"></i></strong></a>
                    ';
                })
                ->rawColumns(['tema', 'riset','action'])
                ->make(true);
        }
    }
    public function store(Request $request)
    {
        $this->__rules($request);
        $data = [
            'nama_topik' => $request->nama_topik,
            'id_tema' => $request->id_tema
        ];
        $create = Topic::create($data);
        if($create) return response()->json(['message' =>'Data berhasil ditambahkan'], 200);
        return response()->json(['message' => 'server error'], 500);
    }
    public function show(Request $request)
    {
        $data = Topic::join('themes', 'themes.id', '=', 'topics.id_tema')
                        ->join('superior_research', 'superior_research.id', '=', 'themes.id_riset')
                        ->select('superior_research.id as riset_id', 'themes.id as tema_id', 'topics.*')
                        ->where('topics.id', $request->id)->first();
        if($data) return response()->json(['message' =>'Data berhasil didapatkan', 'data' => $data], 200);
        return response()->json(['message' => 'server error'], 500);
    }
    public function update(Request $request)
    {
        $this->__rules($request);
        $data = [
            'nama_topik' => $request->nama_topik,
            'id_tema' => $request->id_tema
        ];
        $update = Topic::find($request->id)->update($data);
        if($update) return response()->json(['message' =>'Data berhasil diubah'], 200);
        return response()->json(['message' => 'server error'], 500);
    }
    public function destroy(Request $request)
    {
        $delete = Topic::find($request->id)->delete();
        if($delete) return response()->json(['message' =>'Data berhasil dihapus'], 200);
        return response()->json(['message' => 'server error'], 500);
    }
    public function __rules(Request $request)
    {
        return $request->validate([
            'nama_topik' => 'required',
            'id_tema' => 'required',
            'id_riset' => 'required',
        ],[
            'nama_topik.required' => 'Nama topik tidak boleh kosong',
            'id_tema.required' => 'Pilih salah satu tema',
            'id_riset.required' => 'Pilih salah satu riset',
        ]);
    }
}
