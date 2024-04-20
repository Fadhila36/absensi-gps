<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $hari_ini = date('Y-m-d');
        $bulan_ini = date('m') * 1;
        $tahun_ini = date('Y');
        $nik = Auth::guard('karyawan')->user()->nik;
        $presensi_hari_ini = DB::table('presensi')->where('nik', $nik)->where('tgl_presensi', $hari_ini)->first();
        $histori_bulan = DB::table('presensi')
            ->where('nik', $nik)
            ->whereRaw('MONTH(tgl_presensi)="' . $bulan_ini . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahun_ini . '"')
            ->orderBy('tgl_presensi')
            ->get();
        $rekapPresensi = DB::table('presensi')
            ->selectRaw('COUNT(nik) as jmlHadir, SUM(IF(jam_in > "07:00",1,0)) as jmlTerlambat')
            ->where('nik', $nik)
            ->whereRaw('MONTH(tgl_presensi)="' . $bulan_ini . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahun_ini . '"')
            ->first();

        $leaderboard = DB::table('presensi')
            ->join('karyawan', 'presensi.nik', '=', 'karyawan.nik')
            ->where('tgl_presensi', $hari_ini)
            ->orderBy('jam_in')
            ->get();
        $namaBulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $dataIzin = DB::table('pengajuan_izin')
            ->selectRaw('SUM((IF(status="i",1,0))) as jmlIzin')
            ->selectRaw('SUM((IF(status="s",1,0))) as jmlSakit')
            ->where('nik', $nik)
            ->whereRaw('MONTH(tgl_izin)="' . $bulan_ini . '"')
            ->whereRaw('YEAR(tgl_izin)="' . $tahun_ini . '"')
            ->where('status_approved', 1)
            ->first();
        return view('dashboard.dashboard', compact('presensi_hari_ini', 'histori_bulan', 'namaBulan', 'bulan_ini', 'tahun_ini', 'rekapPresensi', 'leaderboard', 'dataIzin'));
    }

    public function dashboardAdmin()
    {
        $hariIni = date('Y-m-d');
        $rekapPresensi = DB::table('presensi')
            ->selectRaw('COUNT(nik) as jmlHadir, SUM(IF(jam_in > "07:00",1,0)) as jmlTerlambat')
            ->where('tgl_presensi', $hariIni)
            ->first();

        $dataIzin = DB::table('pengajuan_izin')
            ->selectRaw('SUM((IF(status="i",1,0))) as jmlIzin')
            ->selectRaw('SUM((IF(status="s",1,0))) as jmlSakit')
            ->where('tgl_izin', $hariIni)
            ->where('status_approved', 1)
            ->first();
        return view('dashboard.dashboard-admin', compact('rekapPresensi', 'dataIzin'));
    }
}
