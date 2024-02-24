<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Auth, Hash;

class AuthController extends Controller
{
    public function login_process(Request $request)
    {
        $this->__loginRules($request);

        $credentials = $request->only('email', 'password');
        if(Auth::attempt($credentials)){
            if(!auth()->user()->email_verified_at) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->with('error', 'Akun anda belum aktif');
            }
            if(auth()->user()->role == 1) return redirect()->intended(route('admin.beranda.index')); 
            elseif(auth()->user()->role == 2) return redirect()->intended(route('reviewer.beranda.index')); 
            elseif(auth()->user()->role == 3) return redirect()->intended(route('prodi.beranda.index')); 
            elseif(auth()->user()->role == 4) return redirect()->intended(route('fakultas.beranda.index')); 
            elseif(auth()->user()->role == 5) return redirect()->intended(route('dosen.beranda.index')); 
        } else return back()->with('error', 'Email atau password tidak sesuai');
    }

    public function getprodi(Request $request)
    {
        $data = \App\Models\Department::where('id_fakultas', $request->id_fakultas)->get();
        return response()->json(['message' => 'Program studi berhasil didapatkan', 'data' => $data], 200);
    }

    public function register_process(Request $request)
    {
        $this->__registerRules($request);
        $data = [
            'name' => $request->name,
            'nidn' => $request->nidn,
            'jabatan' => $request->jabatan,
            'unit' => $request->unit,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_hp' => $request->no_hp,
            'role' => 5,
            'institusi' => $request->institusi,
            'id_sinta' => $request->id_sinta,
            'id_google_scholar' => $request->id_google_scholar,
            'id_scopus' => $request->id_scopus,
            'fakultas' => $request->fakultas,
            'prodi' => $request->prodi,
        ];
        $create = User::create($data);
        if($create) {
            \App\Models\Notification::create([
                'id_jenis' => $create->id,
                'jenis_notifikasi' => 'Registrasi',
                'judul_notifikasi' => 'Informasi registrasi akun baru',
                'text_notifikasi' => 'Akun dengan email '.$request->email.' atas nama '.$request->name.' telah melakukan registrasi dan sedang menunggu untuk diverifikasi',
                'to_role' => 1,
                'read_status' => 'unread',
            ]);
            return redirect()->route('login')->with('success', 'Akun anda berhasil diregistrasikan, silahkan menghubungi admin untuk mengaktifkan akun anda');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda berhasil logout');
    }

    public function __loginRules(Request $request)
    {
        return $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ],[
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak vaid',
            'password.required' => 'Password tidak boleh kosong'
        ]);
    }
    public function __registerRules(Request $request)
    {
        return $request->validate([
            'name' => 'required',
            'nidn' => 'required|unique:users',
            'jabatan' => 'required',
            'password' => 'required',
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
            'password.required' => 'Password tidak boleh kosong',
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
