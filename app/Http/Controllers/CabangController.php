<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CabangController extends Controller
{
    public function index()
    {
        $cabang = DB::table('cabang')->orderBy('kode_cabang')->get();
        return view('cabang.index', compact('cabang'));
    }

    public function store(Request $request)
    {
        $kode_cabang = $request->kode_cabang;
        $nama_cabang = $request->nama_cabang;
        $lokasi_cabang = $request->lokasi_cabang;
        $radius_cabang = $request->radius_cabang;

        try {
            $data = [
                'kode_cabang' => $kode_cabang,
                'nama_cabang' => $nama_cabang,
                'lokasi_cabang' => $lokasi_cabang,
                'radius_cabang' => $radius_cabang
            ];
            DB::table('cabang')->insert($data);
            return redirect()->back()->with('success', 'Data Cabang Berhasil Diinput');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memproses data cabang. Silakan coba lagi.');
        }
    }

    public function edit(Request $request)
    {
        $kode_cabang = $request->kode_cabang;
        $cabang = DB::table('cabang')->where('kode_cabang', $kode_cabang)->first();
        return view('cabang.edit', compact('cabang'));
    }

    public function update(Request $request,$kode_cabang)
    {
        $nama_cabang = $request->nama_cabang;
        $lokasi_cabang = $request->lokasi_cabang;
        $radius_cabang = $request->radius_cabang;

        try {
            $data = [
                'nama_cabang' => $nama_cabang,
                'lokasi_cabang' => $lokasi_cabang,
                'radius_cabang' => $radius_cabang
            ];
            DB::table('cabang')
            ->where('kode_cabang', $kode_cabang)
            ->update($data);
            return redirect()->back()->with('success', 'Data Cabang Berhasil Di Update');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memproses data cabang. Silakan coba lagi.');
        }
    }

    public function delete($kode_cabang)
    {
        $hapus = DB::table('cabang')->where('kode_cabang', $kode_cabang)->delete();
        if($hapus){
            return redirect()->back()->with('success', 'Data Berhasil Dihapus');
        } else {
            return redirect()->back()->with('error', 'Data Gagal Dihapus');
        }
    }
}
