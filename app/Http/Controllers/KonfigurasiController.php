<?php

namespace App\Http\Controllers;

use App\Models\SetJamKerja;
use App\Models\SetJamKerjaDept;
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

    public function jamKantor()
    {
        $jam_kerja = DB::table('jam_kerja')->orderBy('kode_jam_kerja')->get();
        return view('konfigurasi.jam-kantor', compact('jam_kerja'));
    }

    public function storeJamKantor(Request $request)
    {
        $kode_jam_kerja = $request->kode_jam_kerja;
        $nama_jam_kerja = $request->nama_jam_kerja;
        $awal_jam_masuk = $request->awal_jam_masuk;
        $jam_masuk = $request->jam_masuk;
        $akhir_jam_masuk = $request->akhir_jam_masuk;
        $jam_pulang = $request->jam_pulang;

        $data = [
            'kode_jam_kerja' => $kode_jam_kerja,
            'nama_jam_kerja' => $nama_jam_kerja,
            'awal_jam_masuk' => $awal_jam_masuk,
            'jam_masuk' => $jam_masuk,
            'akhir_jam_masuk' => $akhir_jam_masuk,
            'jam_pulang' => $jam_pulang
        ];
        try {
            DB::table('jam_kerja')->insert($data);
            return redirect()->back()->with('success', 'Jam kerja baru berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memproses data. Silakan coba lagi.');
        }
    }


    public function editJamKantor(Request $request)
    {
        $kode_jam_kerja = $request->kode_jam_kerja;
        $jam_kerja = DB::table('jam_kerja')->where('kode_jam_kerja', $kode_jam_kerja)->first();
        return view('konfigurasi.edit-jam-kantor', compact('jam_kerja'));
    }

    public function updateJamKantor($kode_jam_kerja, Request $request)
    {
        $nama_jam_kerja = $request->nama_jam_kerja;
        $awal_jam_masuk = $request->awal_jam_masuk;
        $jam_masuk = $request->jam_masuk;
        $akhir_jam_masuk = $request->akhir_jam_masuk;
        $jam_pulang = $request->jam_pulang;

        $data = [
            'nama_jam_kerja' => $nama_jam_kerja,
            'awal_jam_masuk' => $awal_jam_masuk,
            'jam_masuk' => $jam_masuk,
            'akhir_jam_masuk' => $akhir_jam_masuk,
            'jam_pulang' => $jam_pulang
        ];
        try {
            DB::table('jam_kerja')->where('kode_jam_kerja', $kode_jam_kerja)->update($data);
            return redirect()->back()->with('success', 'Jam kerja baru berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memproses data. Silakan coba lagi.');
        }
    }

    public function deleteJamKantor($kode_jam_kerja)
    {
        $hapus = DB::table('jam_kerja')->where('kode_jam_kerja', $kode_jam_kerja)->delete();
        if ($hapus) {
            return redirect()->back()->with('success', 'Data Berhasil Dihapus');
        } else {
            return redirect()->back()->with('error', 'Data Gagal Dihapus');
        }
    }

    public function setJamKerja($nik)
    {
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        $jam_kerja = DB::table('jam_kerja')->orderBy('nama_jam_kerja')->get();
        $cek_jam_kerja = DB::table('konfigurasi_jam_kerja')->where('nik', $nik)->count();
        if ($cek_jam_kerja > 0) {
            $set_jam_kerja = DB::table('konfigurasi_jam_kerja')->where('nik', $nik)->get();
            return view('konfigurasi.edit-jam-kerja', compact('karyawan', 'jam_kerja', 'set_jam_kerja'));
        } else {
            return view('konfigurasi.set-jam-kerja', compact('karyawan', 'jam_kerja'));
        }
    }

    public function storeSetJamKerja(Request $request)
    {
        $nik = $request->nik;
        $hari = $request->hari;
        $kode_jam_kerja = $request->kode_jam_kerja;

        for ($i = 0; $i < count($hari); $i++) {
            $data[] = [
                'nik' => $nik,
                'hari' => $hari[$i],
                'kode_jam_kerja' => $kode_jam_kerja[$i]
            ];
        }

        try {
            SetJamKerja::insert($data);
            return redirect('/karyawan')->with('success', 'Jam kerja baru berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect('/karyawan')->with('error', 'Gagal memproses data. Silakan coba lagi.');
        }
    }

    public function updateSetJamKerja(Request $request)
    {
        $nik = $request->nik;
        $hari = $request->hari;
        $kode_jam_kerja = $request->kode_jam_kerja;

        for ($i = 0; $i < count($hari); $i++) {
            $data[] = [
                'nik' => $nik,
                'hari' => $hari[$i],
                'kode_jam_kerja' => $kode_jam_kerja[$i]
            ];
        }

        DB::beginTransaction();
        try {
            SetJamKerja::where('nik', $nik)->delete();
            SetJamKerja::insert($data);
            DB::commit();
            return redirect('/karyawan')->with('success', 'Jam kerja baru berhasil di Update!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/karyawan')->with('error', 'Gagal memproses data. Silakan coba lagi.');
        }
    }

    public function jamDepartemen()
    {
        $jam_kerja_dept = DB::table('konfigurasi_jk_dept')
            ->join('cabang', 'konfigurasi_jk_dept.kode_cabang', '=', 'cabang.kode_cabang')
            ->join('departement', 'konfigurasi_jk_dept.kode_dept', '=', 'departement.kode_dept')
            ->get();
        return view('konfigurasi.jam-departemen.index', compact('jam_kerja_dept'));
    }

    public function createJamDepartemen()
    {
        $jam_kerja = DB::table('jam_kerja')->orderBy('nama_jam_kerja')->get();
        $cabang = DB::table('cabang')->get();
        $departemen = DB::table('departement')->get();
        return view('konfigurasi.jam-departemen.create', compact('jam_kerja', 'cabang', 'departemen'));
    }

    public function storeJamDepartemen(Request $request)
    {
        $kode_cabang = $request->kode_cabang;
        $kode_dept = $request->kode_dept;
        $hari = $request->hari;
        $kode_jam_kerja = $request->kode_jam_kerja;
        $kode_jk_dept = "J" . $kode_cabang . $kode_dept;

        DB::beginTransaction();
        try {
            // Menyimpan data ke konfigurasi_jk_dept
            DB::table('konfigurasi_jk_dept')->insert([
                'kode_jk_dept' => $kode_jk_dept,
                'kode_cabang' => $kode_cabang,
                'kode_dept' => $kode_dept
            ]);

            for ($i = 0; $i < count($hari); $i++) {
                $data[] = [
                    'kode_jk_dept' => $kode_jk_dept,
                    'hari' => $hari[$i],
                    'kode_jam_kerja' => $kode_jam_kerja[$i]
                ];
            }

            SetJamKerjaDept::insert($data);
            DB::commit();
            return redirect('/setting/jam-departemen')->with('success', 'Jam kerja Departemen baru berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/setting/jam-departemen')->with('error', 'Gagal memproses data. Silakan coba lagi.');
        }
    }

    public function editJamDepartemen($kode_jk_dept)
    {
        $jam_kerja = DB::table('jam_kerja')->orderBy('nama_jam_kerja')->get();
        $cabang = DB::table('cabang')->get();
        $departemen = DB::table('departement')->get();
        $jam_kerja_dept = DB::table('konfigurasi_jk_dept')->where('kode_jk_dept', $kode_jk_dept)->first();
        $jam_kerja_dept_detail = DB::table('konfigurasi_jk_dept_detail')->where('kode_jk_dept', $kode_jk_dept)->get();
        return view('konfigurasi.jam-departemen.edit', compact('jam_kerja', 'cabang', 'departemen', 'kode_jk_dept', 'jam_kerja_dept', 'jam_kerja_dept_detail'));
    }

    public function updateJamDepartemen(Request $request, $kode_jk_dept)
    {
        $hari = $request->hari;
        $kode_jam_kerja = $request->kode_jam_kerja;

        DB::beginTransaction();
        try {

            // Hapus data jam kerja sebelumnya
            DB::table('konfigurasi_jk_dept_detail')->where('kode_jk_dept', $kode_jk_dept)->delete();

            for ($i = 0; $i < count($hari); $i++) {
                $data[] = [
                    'kode_jk_dept' => $kode_jk_dept,
                    'hari' => $hari[$i],
                    'kode_jam_kerja' => $kode_jam_kerja[$i]
                ];
            }

            SetJamKerjaDept::insert($data);
            DB::commit();
            return redirect('/setting/jam-departemen')->with('success', 'Jam kerja Departemen baru berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/setting/jam-departemen')->with('error', 'Gagal memproses data. Silakan coba lagi.');
        }
    }

    public function showJamDepartemen($kode_jk_dept)
    {
        $jam_kerja = DB::table('jam_kerja')->orderBy('nama_jam_kerja')->get();
        $cabang = DB::table('cabang')->get();
        $departemen = DB::table('departement')->get();
        $jam_kerja_dept = DB::table('konfigurasi_jk_dept')->where('kode_jk_dept', $kode_jk_dept)->first();
        $jam_kerja_dept_detail = DB::table('konfigurasi_jk_dept_detail')
            ->join('jam_kerja', 'konfigurasi_jk_dept_detail.kode_jam_kerja', '=', 'jam_kerja.kode_jam_kerja')
            ->where('kode_jk_dept', $kode_jk_dept)
            ->get();
        return view('konfigurasi.jam-departemen.show', compact('jam_kerja', 'cabang', 'departemen', 'kode_jk_dept', 'jam_kerja_dept', 'jam_kerja_dept_detail'));
    }

    public function deleteJamDepartemen($kode_jk_dept)
    {
        try {
            DB::table('konfigurasi_jk_dept')->where('kode_jk_dept', $kode_jk_dept)->delete();
            return redirect()->back()->with('success', 'Data Berhasil Dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data Gagal Dihapus');
        }
    }
}
