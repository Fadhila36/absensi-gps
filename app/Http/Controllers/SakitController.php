<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SakitController extends Controller
{
    public function create()
    {
        return view('sakit.create');
    }

    public function storeSakit(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_izin_dari = $request->tgl_izin_dari;
        $tgl_izin_sampai = $request->tgl_izin_sampai;
        $status = "s";
        $keterangan = $request->keterangan;

        $kode_izin = rand();
        if ($request->hasFile('sid')) {
            $sid = $kode_izin . "." . $request->file('sid')->getClientOriginalExtension();
        } else {
            $sid = null;
        }
        $data = [
            'nik' => $nik,
            'tgl_izin_dari' => $tgl_izin_dari,
            'tgl_izin_sampai' => $tgl_izin_sampai,
            'status' => $status,
            'keterangan' => $keterangan,
            'doc_sid' => $sid
        ];

        $simpan = DB::table('pengajuan_izin')->insert($data);

        if ($simpan) {
            if ($request->hasFile('sid')) {
                $sid = $kode_izin . "." . $request->file('sid')->getClientOriginalExtension();
                $folderPath = "public/uploads/sid/";
                $request->file('sid')->storeAs($folderPath, $sid);
            }   
            return redirect('/presensi/izin')->with('success', 'Data Berhasil Diinput');
        } else {
            return redirect('/presensi/izin')->with('error', 'Data Gagal Diinput');
        }
    }
}
