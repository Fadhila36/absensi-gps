<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CutiController extends Controller
{
    public function index()
    {
        $cuti = DB::table('master_cuti')->orderBy('kode_cuti', 'asc')->get();
        return view('cuti.index', compact('cuti'));
    }


    public function store(Request $request)
    {
        $kode_cuti = $request->kode_cuti;
        $nama_cuti = $request->nama_cuti;
        $jml_hari = $request->jml_hari;

        $cek_cuti = DB::table('master_cuti')->where('kode_cuti', $kode_cuti)->count();
        if ($cek_cuti > 0) {
            return redirect()->back()->with('error', 'Data Kode Cuti Sudah Ada');
        }
        try {
            DB::table('master_cuti')->insert([
                'kode_cuti' => $kode_cuti,
                'nama_cuti' => $nama_cuti,
                'jml_hari' => $jml_hari
            ]);
            return redirect()->back()->with('success', 'Data Cuti Berhasil Di Simpan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data Cuti Gagal Di Simpan');
        }
    }

    public function edit(Request $request)
    {
        $kode_cuti = $request->kode_cuti;
        $cuti = DB::table('master_cuti')->where('kode_cuti', $kode_cuti)->first();
        return view('cuti.edit', compact('cuti'));
    }

    public function update(Request $request, $kode_cuti)
    {
        $nama_cuti = $request->nama_cuti;
        $jml_hari = $request->jml_hari;

        try {
            DB::table('master_cuti')->where('kode_cuti', $kode_cuti)->update([
                'nama_cuti' => $nama_cuti,
                'jml_hari' => $jml_hari
            ]);
            return redirect()->back()->with('success', 'Data Cuti Berhasil Di Update');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data Cuti Gagal Di Update');
        }
    }

    public function delete($kode_cuti)
    {
        try {
            DB::table('master_cuti')->where('kode_cuti', $kode_cuti)->delete();
            return redirect()->back()->with('success', 'Data Cuti Berhasil Di Hapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data Cuti Gagal Di Hapus');
        }
    }
}
