<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Laporan Presensi Karyawan</title>

    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

    <!-- Set page size here: A5, A4 or A3 -->
    <!-- Set also "landscape" if you need -->
    <style>
        @page {
            size: A4;
            margin: 0;
        }

        body {
            background-color: #fff;
            padding: 20px;
            font-family: Arial, Helvetica, sans-serif;
            color: #333;
            margin: 0;
        }

        .container {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            width: 70px;
            height: 70px;
            margin-bottom: 10px;
        }

        .company-info {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }

        .table-container {
            margin-top: 40px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .employee-img {
            width: 100px;
            height: auto;
        }

        .foto {
            width: 80px;
            height: auto;
        }

        .keterangan-terlambat {
            font-weight: bold;
            color: red;
        }

        .keterangan-tepat-waktu {
            font-weight: bold;
            color: green;
        }

        .signature-container {
            position: absolute;
            bottom: 20px;
            left: 0;
            right: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            padding: 0 20px;
            box-sizing: border-box;
        }

        .signature {
            border: none;
            /* Hapus border */
            margin-top: 10px;
            /* Ubah jarak atas */
            margin-right: 20px;
            /* Tambah margin kanan */
            max-width: 200px;
            /* Atur lebar maksimum */
        }

        .signature p {
            margin: 0;
            border-top: 1px solid #000;
            padding-bottom: 5px;
            /* Tambah ruang di bawah tanda tangan */
            display: inline-block;
            /* Garis akan mengikuti panjang tulisan */
        }

        /* Added CSS */
        .table-container table:first-child {
            margin-bottom: 20px;
        }

        .table-container table:last-child th,
        .table-container table:last-child td {
            padding: 10px;
        }

        .table-container table:last-child th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .table-container table:last-child tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .table-container table:last-child tbody tr:hover {
            background-color: #e0e0e0;
        }

        .table-container table:last-child tbody tr td:last-child {
            text-align: left;
        }

        .table-container table:last-child tbody tr td:nth-last-child(2) {
            text-align: left;
        }

        .table-container table:last-child tbody tr td:nth-last-child(3) {
            text-align: left;
        }

        .table-container table:last-child tbody tr td:nth-last-child(4) {
            text-align: left;
        }

        .table-container table:last-child tbody tr td:nth-last-child(5) {
            text-align: left;
        }

        .table-container table:last-child tbody tr td:nth-last-child(6) {
            text-align: left;
        }

        .table-container table:last-child tbody tr td:nth-last-child(7) {
            text-align: left;
        }

        .table-container table:last-child tbody tr td:nth-last-child(8) {
            text-align: left;
        }

        .table-container table:last-child tbody tr td img {
            width: 50px;
            height: auto;
        }

        .table-container table:last-child tbody tr td .keterangan-terlambat,
        .table-container table:last-child tbody tr td .keterangan-tepat-waktu {
            display: block;
            margin-top: 5px;
        }
    </style>
</head>

<body class="A4">
    <?php
    function selisih($jam_masuk, $jam_keluar)
    {
        [$h, $m, $s] = explode(':', $jam_masuk);
        $dtAwal = mktime($h, $m, $s, '1', '1', '1');
        [$h, $m, $s] = explode(':', $jam_keluar);
        $dtAkhir = mktime($h, $m, $s, '1', '1', '1');
        $dtSelisih = $dtAkhir - $dtAwal;
        $totalmenit = $dtSelisih / 60;
        $jam = floor($totalmenit / 60); // Menghitung jumlah jam terlambat
        $menit = $totalmenit % 60; // Menghitung sisa menit terlambat
        return $jam . ' jam ' . round($menit) . ' menit';
    }
    ?>
    <section class="sheet padding-10mm">

        <div class="container">
            <div class="logo">
                <img src="{{ asset('assets/img/login/inditara.png') }}" alt="Logo Perusahaan">
            </div>
            <div class="company-info">
                <p>LAPORAN PRESENSI KARYAWAN</p>
                <p>PERIODE {{ strtoupper($namaBulan[$bulan]) }} {{ $tahun }}</p>
                <strong>PT. Intelek Digital Nusantara</strong>
                <p>Jl. Swadaya I Dalam 8, Desa/Kelurahan Pejaten Timur, Kec. Pasar Minggu,</p>
                <p>Kota Adm. Jakarta Selatan, Provinsi DKI Jakarta, Kode Pos: 12510</p>
            </div>
        </div>

        <div class="table-container">
            <table>
                <tr>
                    <td rowspan="4" class="employee-img">
                        @php
                            $path = Storage::url('upload/karyawan/' . $karyawan->foto);
                        @endphp
                        <img src="{{ url($path) }}" alt="Karyawan">
                    </td>
                    <td>NIK</td>
                    <td>{{ $karyawan->nik }}</td>
                </tr>
                <tr>
                    <td>Nama Karyawan</td>
                    <td>{{ $karyawan->nama_lengkap }}</td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td>{{ $karyawan->jabatan }}</td>
                </tr>
                <tr>
                    <td>Departemen</td>
                    <td>{{ $karyawan->nama_dept }}</td>
                </tr>
            </table>

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Foto</th>
                        <th>Jam Pulang</th>
                        <th>Foto</th>
                        <th>Keterangan</th>
                        <th>Jumlah Jam Kerja</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($presensi as $d)
                        @php
                            $path_in = Storage::url('upload/absensi/' . $d->foto_in);
                            $path_out = Storage::url('upload/absensi/' . $d->foto_out);
                            $jamTerlambat = selisih($d->jam_masuk, $d->jam_in);
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ date('d-m-Y', strtotime($d->tgl_presensi)) }}</td>
                            <td>{{ $d->jam_in }}</td>
                            <td><img src="{{ url($path_in) }}" class="foto" alt=""></td>
                            <td>{{ $d->jam_out != null ? $d->jam_out : 'Belum Absen' }}</td>
                            <td>
                                @if ($d->jam_out != null)
                                    <img src="{{ url($path_out) }}" class="foto" alt="">
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-camera">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M5 7h1a2 2 0 0 0 2 -2a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2" />
                                        <path d="M9 13a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                                    </svg>
                                @endif
                            </td>
                            <td class="{{ $d->jam_in > $d->jam_masuk ? 'keterangan-terlambat' : 'keterangan-tepat-waktu' }}">
                                @if ($d->jam_in > $d->jam_masuk)
                                    Terlambat {{ $jamTerlambat }}
                                @else
                                    Tepat Waktu
                                @endif
                            </td>
                            <td>
                                @if ($d->jam_out != null)
                                    @php
                                        $jmlJamKerja = selisih($d->jam_in, $d->jam_out);
                                    @endphp
                                @else
                                    @php
                                        $jmlJamKerja = 0;
                                    @endphp
                                @endif
                                {{ $jmlJamKerja }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <table class="signature-container">
            <tr>
                <td class="signature">
                    <p><u>Muhamad Farid</u><br><i>CEO</i></p>
                </td>
                <td class="signature">
                    <p><u>Raini</u><br><i>HRD</i></p>
                </td>
            </tr>
        </table>

    </section>
</body>

</html>
