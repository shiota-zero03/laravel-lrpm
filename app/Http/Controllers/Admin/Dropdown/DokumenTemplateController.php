<?php

namespace App\Http\Controllers\Admin\Dropdown;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\TemplateDocument;
use DataTables;

class DokumenTemplateController extends Controller
{
    public function index()
    {
        return view('pages.admin.dropdown.template');
    }
    public function json(Request $request)
    {
        if ($request->ajax()) {
            $data = TemplateDocument::orderByDesc('id')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('dokumen', function($row){
                    if(!$row['dokumen_template'] || $row['dokumen_template'] == null) return '<small class="text-danger"><em>Belum ada template dokumen</em></small>';
                    else return '<a class="text-success" href="'.asset('assets/storage/files/dokumen-template/'.$row['dokumen_template']).'" target="__blank"><i class="bi bi-file-earmark-fill me-2"></i> '.$row['dokumen_template'].'</a>';
                })
                ->addColumn('action', function($row){
                    return '
                        <a href="#" onclick="openModal('.$row['id'].')" class="btn btn-warning mb-1 me-1 btn-sm text-white"><strong><i class="bi bi-pencil-fill"></i></strong></a>
                        <a href="#" onclick="deleteData('.$row['id'].')" class="btn btn-danger mb-1 me-1 btn-sm"><strong><i class="bi bi-trash"></i></strong></a>
                    ';
                })
                ->rawColumns(['dokumen','action'])
                ->make(true);
        }
    }
    public function store(Request $request)
    {
        $this->__rules($request);
        if( !isset($request->dokumen) || !$request->file('dokumen') ){
            $dokumen = null;
        } else {
            $upload = $this->__uploadDokumen($request->file('dokumen'));
            $dokumen = $upload;
        }
        $data = [
            'nama_template' => $request->nama,
            'dokumen_template' => $dokumen,
            'cant_delete' => false
        ];
        $create = TemplateDocument::create($data);
        if($create) return response()->json(['message' =>'Data berhasil ditambahkan'], 200);
        return response()->json(['message' => 'server error'], 500);
    }
    public function show(Request $request)
    {
        $data = TemplateDocument::find($request->id);
        if($data) return response()->json(['message' =>'Data berhasil didapatkan', 'data' => $data], 200);
        return response()->json(['message' => 'server error'], 500);
    }
    public function update(Request $request)
    {
        $this->__rules($request);
        if( !isset($request->dokumen) || !$request->file('dokumen') ){
            $dokumen = null;
        } else {
            $upload = $this->__uploadDokumen($request->file('dokumen'));
            $dokumen = $upload;
        }
        $data = [
            'nama_template' => $request->nama,
            'dokumen_template' => $dokumen,
        ];
        $update = TemplateDocument::find($request->id)->update($data);
        if($update) return response()->json(['message' =>'Data berhasil diubah'], 200);
        return response()->json(['message' => 'server error'], 500);
    }
    public function destroy(Request $request)
    {
        $check_delete = TemplateDocument::find($request->id);
        if($check_delete->cant_delete == true) return response()->json(['message' => 'Template ini tidak dapat dihapus'], 403);
        else {
            $delete = TemplateDocument::find($request->id)->delete();
            if($delete) return response()->json(['message' =>'Data berhasil dihapus'], 200);
            return response()->json(['message' => 'server error'], 500);
        }
    }
    public function __rules(Request $request)
    {
        return $request->validate([
            'nama' => 'required',
        ],[
            'nama.required' => 'Nama template tidak boleh kosong',
        ]);
    }

    public function __uploadDokumen($file)
    {
        $namafile = time().'_'.$file->getClientOriginalName();
        $file->move(public_path().'assets/storage/files/dokumen-template/', $namafile);
        return $namafile;
    }
}
