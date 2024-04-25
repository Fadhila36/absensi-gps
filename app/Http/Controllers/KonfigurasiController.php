<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class KonfigurasiController extends Controller
{
    public function lokasiKantor()
    {
        $lokasi = DB::table('config_lokasi')->where('id', 1)->first();
        return view('konfigurasi.lokasi-kantor', compact('lokasi'));
    }

    public function updateLokasi(Request $request)
    {
        $lokasi_kantor = $request->lokasi_kantor;
        $radius = $request->radius;

        $update = DB::table('config_lokasi')->where('id', 1)->update([
            'lokasi_kantor' => $lokasi_kantor,
            'radius' => $radius
        ]);

        if ($update) {
            return Redirect::back()->with('success', 'Lokasi kantor dan radius lokasi berhasil diupdate!');
        } else {
            return Redirect::back()->with('error', 'Lokasi kantor dan radius lokasi gagal diupdate!');
        }
    }
}
