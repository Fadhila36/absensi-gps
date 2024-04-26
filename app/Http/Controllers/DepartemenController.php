<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class DepartemenController extends Controller
{
    public function index(Request $request)
    {
        $nama_dept = $request->nama_dept;
        $query = Departemen::query();
        $query->select('*');
        if(!empty($nama_dept)){
            $query->where('nama_dept', 'like', '%'.$nama_dept.'%');
        }
        $departemen = $query->get();
        // $departemen = DB::table('departement')->orderBy('kode_dept')->get();
        return view('departemen.index', compact('departemen'));
    }

    public function store(Request $request)
    {
        $kode_dept = $request->kode_dept;
        $nama_dept = $request->nama_dept;
        $data = [
            'kode_dept' => $kode_dept,
            'nama_dept' => $nama_dept
        ];

        $cek = DB::table('departement')->where('kode_dept', $kode_dept)->count();
        if($cek > 0){
            return Redirect::back()->with('error', 'Data Departemen Sudah Ada');
        }
        $simpan = DB::table('departement')->insert($data);
        if ($simpan) {
            return Redirect::back()->with('success', 'Data Berhasil Diinput');
        } else {
            return Redirect::back()->with('error', 'Data Gagal Diinput');
        }
    }
    
    public function edit(Request $request)
    {
        $kode_dept = $request->kode_dept;
        $departemen = DB::table('departement')->where('kode_dept', $kode_dept)->first();
        return view('departemen.edit', compact('departemen'));
    }

    public function update($kode_dept, Request $request)
    {
        $nama_dept = $request->nama_dept;
        $data = [
            'nama_dept' => $nama_dept
        ];

        $update = DB::table('departement')->where('kode_dept', $kode_dept)->update($data);
        if ($update) {
            return Redirect::back()->with('success', 'Data Berhasil Diupdate');
        } else {
            return Redirect::back()->with('error', 'Data Gagal Diupdate');
        }
    }

    public function delete($kode_dept)
    {
        $hapus = DB::table('departement')->where('kode_dept', $kode_dept)->delete();
        if($hapus){
            return Redirect::back()->with('success', 'Data Berhasil Dihapus');
        } else {
            return Redirect::back()->with('error', 'Data Gagal Dihapus');
        }
    }
}
