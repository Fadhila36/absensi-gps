<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IzinController extends Controller
{
    public function create()
    {
        return view('izin.create');
    }

    public function storeIzin(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_izin_dari = $request->tgl_izin_dari;
        $tgl_izin_sampai = $request->tgl_izin_sampai;
        $status = "i";
        $keterangan = $request->keterangan;

        $bulan = date("m", strtotime($tgl_izin_dari));
        $tahun = date("Y" ,strtotime($tgl_izin_dari));
        $thn = substr($tahun,2,2);
        $last_izin = DB::table('pengajuan_izin')
        ->whereRaw('MONTH(tgl_izin_dari)="' . $bulan . '"')
        ->whereRaw('YEAR(tgl_izin_dari)="' . $tahun . '"')
        ->orderBy('kode_izin', 'desc')
        ->first();

        $last_kode_izin = $last_izin != null ? $last_izin->kode_izin : "";
        $format = "IZ".$bulan.$thn;
        $kode_izin = buatkode($last_kode_izin, $format, 3);

        $data = [
            'kode_izin' => $kode_izin,
            'nik' => $nik,
            'tgl_izin_dari' => $tgl_izin_dari,
            'tgl_izin_sampai' => $tgl_izin_sampai,
            'status' => $status,
            'keterangan' => $keterangan
        ];

        $simpan = DB::table('pengajuan_izin')->insert($data);

        if ($simpan) {
            return redirect('/presensi/izin')->with('success', 'Data Berhasil Diinput');
        } else {
            return redirect('/presensi/izin')->with('error', 'Data Gagal Diinput');
        }
    }
}
