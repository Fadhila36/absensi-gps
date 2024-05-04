<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Laporan Presensi Karyawan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">
    <style>
        @page {
            size: A4;
            margin: 20mm;
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
            font-size: 12px;
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
            padding: 3px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
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
            margin-top: 10px;
            max-width: 200px;
            text-align: center;
        }

        .signature p {
            margin: 0;
            border-top: 1px solid #000;
            padding-top: 5px;
            display: inline-block;
            width: fit-content;
        }

        /* Tambahkan margin-right pada tanda tangan Raini */
        .signature.raini {
            margin-left: 50px;
        }
    </style>
</head>

<body class="A4 landscape">
    <section class="sheet padding-10mm">
        <div class="container">
            <div class="logo">
                <img src="{{ asset('assets/img/login/inditara.png') }}" alt="Logo Perusahaan">
            </div>
            <div class="company-info">
                <p>REKAP PRESENSI KARYAWAN</p>
                <p>PERIODE {{ strtoupper($namaBulan[$bulan]) }} {{ $tahun }}</p>
                <strong>PT. Intelek Digital Nusantara</strong>
                <p>Jl. Swadaya I Dalam 8, Desa/Kelurahan Pejaten Timur, Kec. Pasar Minggu,</p>
                <p>Kota Adm. Jakarta Selatan, Provinsi DKI Jakarta, Kode Pos: 12510</p>
            </div>
        </div>

        <div class="table-container">
            <table>
                <tr>
                    <td rowspan="2">Nik</td>
                    <td rowspan="2">Nama Karyawan</td>
                    <td colspan="31">Tanggal</td>
                    <td rowspan="2">TH</td>
                    <td rowspan="2">TK</td>
                </tr>
                <tr>
                    <?php 
                 for ($i = 1; $i <= 31; $i++) {
                     ?>
                    <th>{{ $i }}</th>
                    <?php
                 }
                ?>
                </tr>
                @foreach ($rekap as $d)
                    <tr>
                        <td>{{ $d->nik }}</td>
                        <td>{{ $d->nama_lengkap }}</td>
                        <?php 
                        $totalHadir = 0;
                        $totalTerlambat = 0;
                 for ($i = 1; $i <= 31; $i++) {
                    $tgl = "tgl_" . $i;
                    
                    $hadir = explode("-",$d->$tgl);
                    if(empty($d->$tgl)){
                        $hadir = ['',''];
                        $totalHadir += 0;
                    } else {
                        $hadir = explode("-",$d->$tgl);
                        $totalHadir += 1;
                        if($hadir[0] > $d->jam_masuk){
                            $totalTerlambat += 1;
                        }
                    }

                     ?>
                        <td>
                            <span
                                style="color:
                                {{ $hadir[0] > $d->jam_masuk ? 'red' : '' }}">{{ !empty($hadir[0]) ? $hadir[0] : '-' }}</span>
                            <span
                                style="color:
                                {{ $hadir[1] > $d->jam_pulang ? 'red' : '' }}">{{ !empty($hadir[1]) ? $hadir[1] : '-' }}</span>
                        </td>
                        <?php
                 }
                ?>
                        <td>{{ $totalHadir }}</td>
                        <td>{{ $totalTerlambat }}</td>
                    </tr>
                @endforeach
            </table>
        </div>

        <div class="signature-container">
            <div class="signature">
                <p><u>Muhamad Farid</u><br><span style="font-style: italic; font-size: 12px;">CEO</span></p>
            </div>
            <!-- Tambahkan class "raini" pada tanda tangan Raini -->
            <div class="signature raini">
                <p><u>Raini Raisya Dewi</u><br><span style="font-style: italic; font-size: 12px;">HRD</span></p>
            </div>
        </div>
    </section>
</body>

</html>
