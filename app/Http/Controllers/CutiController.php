<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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


    // USER

    public function createCuti()
    {
        $master_cuti = DB::table('master_cuti')->orderBy('kode_cuti')->get();
        return view('cuti.user.create', compact('master_cuti'));
    }

    public function storeCuti(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_izin_dari = $request->tgl_izin_dari;
        $tgl_izin_sampai = $request->tgl_izin_sampai;
        $kode_cuti = $request->kode_cuti;
        $status = "c";
        $keterangan = $request->keterangan;

        $bulan = date("m", strtotime($tgl_izin_dari));
        $tahun = date("Y", strtotime($tgl_izin_dari));
        $thn = substr($tahun, 2, 2);
        $last_izin = DB::table('pengajuan_izin')
        ->whereRaw('MONTH(tgl_izin_dari)="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_izin_dari)="' . $tahun . '"')
            ->orderBy('kode_izin', 'desc')
            ->first();

        $last_kode_izin = $last_izin != null ? $last_izin->kode_izin : "";
        $format = "IZ" . $bulan . $thn;
        $kode_izin = buatkode($last_kode_izin, $format, 3);

        $data = [
            'kode_izin' => $kode_izin,
            'nik' => $nik,
            'tgl_izin_dari' => $tgl_izin_dari,
            'tgl_izin_sampai' => $tgl_izin_sampai,
            'kode_cuti' => $kode_cuti,
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
