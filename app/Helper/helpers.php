<?php
function hitung_jam_terlambat($jadwal_jam_masuk, $jam_presensi)
{
  $j1 = strtotime($jadwal_jam_masuk);
  $j2 = strtotime($jam_presensi);

  $diffterlambat = $j2 - $j1;

  $jamterlambat = floor($diffterlambat / (60 * 60));
  $menitterlambat = floor(($diffterlambat - $jamterlambat * 60 * 60) / 60);
  $jamterlambat = $jamterlambat <= 9 ? '0' . $jamterlambat : $jamterlambat;
  $menitterlambat = $menitterlambat <= 9 ? '0' . $menitterlambat : $menitterlambat;

  $terlambat = $jamterlambat . ':' . $menitterlambat;
  return $terlambat;
}


function hitung_jam_terlambat_desimal($jadwal_jam_masuk, $jam_presensi)
{
  $j1 = strtotime($jadwal_jam_masuk);
  $j2 = strtotime($jam_presensi);

  $diffterlambat = $j2 - $j1;

  $jamterlambat = floor($diffterlambat / (60 * 60));
  $menitterlambat = floor(($diffterlambat - $jamterlambat * 60 * 60) / 60);

  $jterlambat = $jamterlambat <= 9 ? "0" . $jamterlambat : $jamterlambat;
  $mterlambat = $menitterlambat <= 9 ? "0" . $menitterlambat : $menitterlambat;

  $desimalterlambat = ROUND(($menitterlambat / 60), 2);
  return $desimalterlambat;
}

function hitung_hari($tanggal_mulai, $tanggal_akhir)
{
  $tanggal_ = date_create($tanggal_mulai);
  $tanggal_2 = date_create($tanggal_akhir); // waktu sekarang
  $diff = date_diff($tanggal_, $tanggal_2);

  return $diff->days + 1;
}
