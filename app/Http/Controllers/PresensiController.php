<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class PresensiController extends Controller
{
    public function create()
    {
        $hari_ini = date('Y-m-d');
        $nik = auth()->guard('karyawan')->user()->nik;
        $cek = DB::table('presensi')
            ->where('tgl_presensi', $hari_ini)
            ->where('nik', $nik)
            ->count();

        return view('presensi.create', compact('cek'));
    }

    public function store(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_presensi = date('Y-m-d');
        $jam = date('H:i:s');
        $latitudeKantor = -6.3650752481413315;
        $longitudeKantor = 107.34753819793875;
        $lokasi = $request->lokasi;
        $lokasiUser = explode(',', $lokasi);
        $latitudeUser = $lokasiUser[0];
        $longitudeUser = $lokasiUser[1];

        $jarak = $this->distance($latitudeKantor, $longitudeKantor, $latitudeUser, $longitudeUser);
        $radius = round($jarak["meters"]);


        $image = $request->image;
        $folderPath = "public/upload/absensi/";
        $formatName = $nik . "-" . $tgl_presensi;
        $image_parts = explode(";base64,", $image);

        // Validasi gambar
        if (count($image_parts) !== 2 || !preg_match('/^data:image\/(\w+);base64,/', $image)) {
            return response()->json(['message' => 'Invalid image format.'], 400);
        }

        $image_base64 = base64_decode($image_parts[1]);
        $fileNameIn = $formatName . "_in.png"; // Nama file foto_in
        $fileNameOut = $formatName . "_out.png"; // Nama file foto_out
        $fileIn = $folderPath . $fileNameIn;
        $fileOut = $folderPath . $fileNameOut;

        $cek = DB::table('presensi')
            ->where('tgl_presensi', $tgl_presensi)
            ->where('nik', $nik)
            ->count();
        if ($radius > 30) {
            echo "error|Maaf Anda Diluar Jangkauan, Jarak Anda " . $radius . " Meter Dari Kantor|radius";
        } else {


            if ($cek > 0) {
                $data_pulang = [
                    'jam_out' => $jam,
                    'foto_out' => $fileNameOut, // Menggunakan nama foto_out
                    'lokasi_out' => $lokasi
                ];
                $update = DB::table('presensi')
                    ->where('tgl_presensi', $tgl_presensi)
                    ->where('nik', $nik)
                    ->update($data_pulang);

                if ($update) {
                    // Berhasil mengupdate data
                    echo "success|Terima Kasih, Hati Hati dijalan|out";
                    Storage::put($fileOut, $image_base64); // Menggunakan nama file foto_out
                } else {
                    // Gagal mengupdate data
                    echo "error|Maaf Gagal Absen, Silahkan Hubungi Tim IT|out";
                }
            } else {
                $data = [
                    'nik' => $nik,
                    'tgl_presensi' => $tgl_presensi,
                    'jam_in' => $jam,
                    'foto_in' => $fileNameIn, // Menggunakan nama foto_in
                    'lokasi_in' => $lokasi
                ];
                $simpan = DB::table('presensi')->insert($data);

                if ($simpan) {
                    // Berhasil menyimpan data baru
                    echo "success|Terima Kasih, Selamat Bekerja|in";
                    Storage::put($fileIn, $image_base64); // Menggunakan nama file foto_in
                } else {
                    // Gagal menyimpan data baru
                    echo "error|Maaf Gagal Absen, Silahkan Hubungi Tim IT|in";
                }
            }
        }
    }

    //Menghitung Jarak
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }

    public function editProfile()
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        return view('presensi.editProfile', compact('karyawan'));
    }

    public function updateProfile(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $nama_lengkap = $request->nama_lengkap;
        $no_hp = $request->no_hp;
        $password = Hash::make($request->password);
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        if ($request->hasFile('foto')) {
            $foto = $nik . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = $karyawan->foto;
        }
        if (empty($request->password)) {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'foto' => $foto
            ];
        } else {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'password' => $password,
                'foto' => $foto
            ];
        }

        $update = DB::table('karyawan')->where('nik', $nik)->update($data);
        if ($update) {
            if ($request->hasFile('foto')) {
                $folderPath = "public/upload/karyawan/";
                $request->file('foto')->storeAs($folderPath, $foto);
            }
            return Redirect::back()->with('success', 'Data Berhasil Diupdate');
        } else {
            return Redirect::back()->with('error', 'Data Gagal Diupdate');
        }
    }

    public function histori()
    {
        $namaBulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view('presensi.histori', compact('namaBulan'));
    }

    public function getHistori(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $nik = Auth::guard('karyawan')->user()->nik;

        $histori = DB::table('presensi')
            ->whereRaw('MONTH(tgl_presensi)="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahun . '"')
            ->where('nik', $nik)
            ->orderBy('tgl_presensi')
            ->get();

        return view('presensi.gethistori', compact('histori'));
    }

    public function izin()
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $dataIzin = DB::table('pengajuan_izin')->where('nik', $nik)->get();
        return view('presensi.izin', compact('dataIzin'));
    }

    public function createIzin()
    {

        return view('presensi.pengajuanIzin');
    }

    public function storeIzin(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_izin = $request->tgl_izin;
        $status = $request->status;
        $keterangan = $request->keterangan;

        $data = [
            'nik' => $nik,
            'tgl_izin' => $tgl_izin,
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

    public function monitoring()
    {
        return view('presensi.monitoring');
    }

    public function getPresensi(Request $request)
    {
        $tanggal = $request->tanggal;
        $presensi = DB::table('presensi')
        ->select('presensi.*', 'nama_lengkap', 'nama_dept')
        ->join('karyawan', 'presensi.nik', '=', 'karyawan.nik')
        ->join('departement', 'karyawan.kode_dept', '=', 'departement.kode_dept')
        ->where('tgl_presensi', $tanggal)
        ->get();

        return view('presensi.getpresensi', compact('presensi'));
    }

    public function showMap(Request $request)
    {
        $id = $request->id;
        $presensi = DB::table('presensi')->where('id', $id)
        ->join('karyawan', 'presensi.nik', '=', 'karyawan.nik')
        ->first();
        return view('presensi.showmap', compact('presensi'));
    }

    public function laporan()
    {
        $namaBulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $karyawan = DB::table('karyawan')->orderBy('nama_lengkap')->get();
        return view('presensi.laporan', compact('namaBulan', 'karyawan'));
    }

    public function cetakLaporan(Request $request)
    {
        $nik = $request->nik;
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $namaBulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $karyawan = DB::table('karyawan')->where('nik', $nik)
        ->join('departement', 'karyawan.kode_dept', '=', 'departement.kode_dept')
        ->first();

        $presensi = DB::table('presensi')
        ->where('nik', $nik)
        ->whereRaw('MONTH(tgl_presensi)="' . $bulan . '"')
        ->whereRaw('YEAR(tgl_presensi)="' . $tahun . '"')
        ->orderBy('tgl_presensi')
        ->get();
        return view('presensi.cetaklaporan', compact('namaBulan', 'bulan', 'tahun', 'karyawan', 'presensi'));
    }
}
