<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Models\PengajuanIzin;

class PresensiController extends Controller
{

    public function getHari()
    {
        $hari = date("D");

        switch ($hari) {
            case 'Sun':
                $hari_ini = "Minggu";
                break;
            case 'Mon':
                $hari_ini = "Senin";
                break;
            case 'Tue':
                $hari_ini = "Selasa";
                break;
            case 'Wed':
                $hari_ini = "Rabu";
                break;
            case 'Thu':
                $hari_ini = "Kamis";
                break;
            case 'Fri':
                $hari_ini = "Jumat";
                break;
            case 'Sat':
                $hari_ini = "Sabtu";
                break;
            default:
                $hari_ini = "Tidak Di ketahui";
                break;
        }
        return $hari_ini;
    }

    public function create()
    {
        $hari_ini = date('Y-m-d');
        $nama_hari = $this->getHari();
        $nik = auth()->guard('karyawan')->user()->nik;
        $kode_dept = auth()->guard('karyawan')->user()->kode_dept;
        $cek = DB::table('presensi')
            ->where('tgl_presensi', $hari_ini)
            ->where('nik', $nik)
            ->count();
        $kode_cabang = Auth::guard('karyawan')->user()->kode_cabang;
        $lok_kantor = DB::table('cabang')->where('kode_cabang', $kode_cabang)->first();
        $jam_kerja = DB::table('konfigurasi_jam_kerja')
            ->join('jam_kerja', 'konfigurasi_jam_kerja.kode_jam_kerja', '=', 'jam_kerja.kode_jam_kerja')
            ->where('nik', $nik)
            ->where('hari', $nama_hari)
            ->first();

        if ($jam_kerja == null) {
            $jam_kerja = DB::table('konfigurasi_jk_dept_detail')
                ->join('konfigurasi_jk_dept', 'konfigurasi_jk_dept_detail.kode_jk_dept', '=', 'konfigurasi_jk_dept.kode_jk_dept')
                ->join('jam_kerja', 'konfigurasi_jk_dept_detail.kode_jam_kerja', '=', 'jam_kerja.kode_jam_kerja')
                ->where('kode_dept', $kode_dept)
                ->where('kode_cabang', $kode_cabang)
                ->where('hari', $nama_hari)
                ->first();
        }

        if ($jam_kerja == null) {
            return view('presensi.notif-jadwal');
        } else {
            return view('presensi.create', compact('cek', 'lok_kantor', 'jam_kerja'));
        }
    }

    public function store(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $kode_cabang = Auth::guard('karyawan')->user()->kode_cabang;
        $tgl_presensi = date('Y-m-d');
        $jam = date('H:i:s');
        $lok_kantor = DB::table('cabang')->where('kode_cabang', $kode_cabang)->first();
        $lok = explode(',', $lok_kantor->lokasi_cabang);
        $latitudeKantor = $lok[0];
        $longitudeKantor = $lok[1];
        $lokasi = $request->lokasi;
        $lokasiUser = explode(',', $lokasi);
        $latitudeUser = $lokasiUser[0];
        $longitudeUser = $lokasiUser[1];

        // Cek jam kerja
        $nama_hari = $this->getHari();
        $jam_kerja = DB::table('konfigurasi_jam_kerja')
            ->join('jam_kerja', 'konfigurasi_jam_kerja.kode_jam_kerja', '=', 'jam_kerja.kode_jam_kerja')
            ->where('nik', $nik)
            ->where('hari', $nama_hari)
            ->first();


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
        if ($radius > $lok_kantor->radius_cabang) {
            echo "error|Maaf Anda Diluar Jangkauan, Jarak Anda " . $radius . " Meter Dari Kantor|radius";
        } else {
            if ($cek > 0) {
                if ($jam < $jam_kerja->jam_pulang) {
                    echo "error|Maaf Belum Waktunya Melakukan Absensi Pulang|in";
                }
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
                if ($jam < $jam_kerja->awal_jam_masuk) {
                    echo "error|Maaf Belum Waktunya Melakukan Absensi|in";
                } else if ($jam > $jam_kerja->akhir_jam_masuk) {
                    echo "error|Maaf Waktu Untuk Absensi Masuk Telah Lewat|in";
                } else {
                    $data = [
                        'nik' => $nik,
                        'tgl_presensi' => $tgl_presensi,
                        'jam_in' => $jam,
                        'foto_in' => $fileNameIn, // Menggunakan nama foto_in
                        'lokasi_in' => $lokasi,
                        'kode_jam_kerja' => $jam_kerja->kode_jam_kerja
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
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
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
        $dataIzin = DB::table('pengajuan_izin')
        ->leftJoin('master_cuti', 'pengajuan_izin.kode_cuti', '=', 'master_cuti.kode_cuti')
        ->where('nik', $nik)->get();
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
            ->select('presensi.*', 'nama_lengkap', 'nama_dept', 'jam_masuk', 'nama_jam_kerja', 'jam_masuk', "jam_pulang")
            ->leftJoin('jam_kerja', 'presensi.kode_jam_kerja', '=', 'jam_kerja.kode_jam_kerja')
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
            ->leftJoin('jam_kerja', 'presensi.kode_jam_kerja', '=', 'jam_kerja.kode_jam_kerja')
            ->where('nik', $nik)
            ->whereRaw('MONTH(tgl_presensi) = ?', [$bulan])
            ->whereRaw('YEAR(tgl_presensi) = ?', [$tahun])
            ->orderBy('tgl_presensi')
            ->get();

        if (isset($_POST['exportExcel'])) {
            $time = date("d-m-Y H:i:s");
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=Presensi " . $karyawan->nik . " " . $karyawan->nama_lengkap . " " . $time . ".xls");
            return view('presensi.cetak-laporan-excel', compact('namaBulan', 'bulan', 'tahun', 'karyawan', 'presensi'));
        }

        return view('presensi.cetaklaporan', compact('namaBulan', 'bulan', 'tahun', 'karyawan', 'presensi'));
    }

    public function rekap()
    {
        $namaBulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view('presensi.rekap', compact('namaBulan'));
    }

    public function cetakRekap(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $namaBulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        $rekap = DB::table('presensi')
            ->selectRaw('presensi.nik, karyawan.nama_lengkap, jam_masuk, jam_pulang')
            ->leftJoin('jam_kerja', 'presensi.kode_jam_kerja', '=', 'jam_kerja.kode_jam_kerja')
            ->join('karyawan', 'presensi.nik', '=', 'karyawan.nik')
            ->whereRaw('MONTH(tgl_presensi) = ?', [$bulan])
            ->whereRaw('YEAR(tgl_presensi) = ?', [$tahun])
            ->groupByRaw('presensi.nik, nama_lengkap, jam_masuk, jam_pulang');

        if (isset($_POST['exportExcel'])) {
            $time = date("d-m-Y H:i:s");
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=Rekap Presensi $time.xls");
        }

        // Dynamically add columns for each day of the month
        for ($day = 1; $day <= 31; $day++) {
            $rekap->selectRaw('MAX(CASE WHEN DAY(presensi.tgl_presensi) = ? THEN CONCAT(presensi.jam_in, "-", IFNULL(presensi.jam_out, "00:00:00")) ELSE "" END) AS tgl_' . $day, [$day]);
        }

        $rekap = $rekap->get();
        return view('presensi.cetakrekap', compact('rekap', 'bulan', 'tahun', 'namaBulan'));
    }


    public function izinSakit(Request $request)
    {

        $query = PengajuanIzin::query();
        $query->select('id', 'tgl_izin', 'pengajuan_izin.nik', 'nama_lengkap', 'jabatan', 'status', 'status_approved', 'keterangan');
        $query->join('karyawan', 'pengajuan_izin.nik', '=', 'karyawan.nik');
        if (!empty($request->dari) && !empty($request->sampai)) {
            $query->whereBetween('tgl_izin', [$request->dari, $request->sampai]);
        }
        if (!empty($request->nik)) {
            $query->where('pengajuan_izin.nik', $request->nik);
        }
        if (!empty($request->nama_lengkap)) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama_lengkap . '%');
        }
        if ($request->status_approved != "") {
            $query->where('status_approved', $request->status_approved);
        }
        $query->orderBy('tgl_izin', 'desc');
        $izinSakit = $query->paginate(2);
        $izinSakit->appends($request->all());
        return view('presensi.izin-sakit', compact('izinSakit'));
    }

    public function approveIzinSakit(Request $request)
    {
        $status_approved = $request->status_approved;
        $izinSakitId = $request->izinSakitId;
        $update = DB::table('pengajuan_izin')
            ->where('id', $izinSakitId)
            ->update(
                [
                    'status_approved' => $status_approved
                ]
            );
        if ($update) {
            return Redirect::back()->with('success', 'Data Berhasil Diinput');
        } else {
            return Redirect::back()->with('error', 'Data Gagal Diinput');
        }
    }

    public function batalkanIzinSakit($id)
    {
        $update = DB::table('pengajuan_izin')
            ->where('id', $id)
            ->update(
                [
                    'status_approved' => 0
                ]
            );
        if ($update) {
            return Redirect::back()->with('success', 'Data Berhasil Diinput');
        } else {
            return Redirect::back()->with('error', 'Data Gagal Diinput');
        }
    }

    public function checkIzin(Request $request)
    {
        $tgl_izin = $request->tgl_izin;
        $nik = Auth::guard('karyawan')->user()->nik;

        $cek = DB::table('pengajuan_izin')->where('nik', $nik)->where('tgl_izin', $tgl_izin)->count();
        return $cek;
    }
}
