@extends('layouts.presensi')
@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">E-Presensi</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
@endsection
@section('content')
    <div class="row" style="margin-top: 60px;">
        <div class="col">
            <div class="alert alert-warning position-relative" role="alert"
                style="border-radius: 10px; background-color: #fff3cd; color: #856404; border-color: #ffeeba; text-align: center; padding: 20px;">
                <div style="position: relative;">
                    <ion-icon name="alert-circle-outline"
                        style="font-size: 25px; color: #856404; position: absolute; top: -30px; left: 50%; transform: translateX(-50%);">
                    </ion-icon>
                    <span style="display: block; margin-top: 20px;">Maaf, Anda tidak memiliki jadwal untuk hari ini. Silakan
                        absen pada tanggal lain atau hubungi HRD.</span>
                </div>
            </div>
        </div>
    </div>
@endsection
