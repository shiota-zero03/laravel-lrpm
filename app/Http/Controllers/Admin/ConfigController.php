<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Config;

class ConfigController extends Controller
{
    public function index(){
        $data = [
            'usulan_baru' => Config::where('type', 'usulan_baru')->first()
        ];
        return view('pages.admin.config.index', compact(['data']));
    }
    public function store(Request $request){
        $request->validate([
            'usulan_baru' => 'required'
        ], [
            'usulan_baru.required' => 'pilih salah satu'
        ]);

        $usulan_baru = Config::where('type', 'usulan_baru')->first();
        if( $usulan_baru ) {
            $createUsulanBaru = Config::find($usulan_baru->id)->update(['status' => intval($request->usulan_baru)]);
        } else {
            $createUsulanBaru = Config::create(['type' => 'usulan_baru', 'status' => intval($request->usulan_baru)]);
        }

        if($createUsulanBaru) return back()->with('success', 'Data berhasil diperbarui');
    }
}
