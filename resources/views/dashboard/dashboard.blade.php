@extends('layouts.presensi')
@section('content')
<style>
    .logout{
        position: absolute;
        color: white;
        font-size: 30px;
        text-decoration: none;
        right: 8px
    }
    .logout:hover{
        color:white
    }
</style>
    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="section" id="user-section">
            <a href="{{ url('/logout') }}" class="logout">
                <ion-icon name="log-out-outline"></ion-icon>
            </a>
            <div id="user-detail">
                <div class="avatar">
                    @if (!empty(Auth::guard('karyawan')->user()->foto))
                        @php
                            $path = Storage::url('upload/karyawan/' . Auth::guard('karyawan')->user()->foto);
                        @endphp
                        <img src="{{ url($path) }}" alt="avatar" class="imaged w64" style="height: 64px">
                    @else
                        <img src="assets/img/sample/avatar/avatar1.jpg" alt="avatar" class="imaged w64 rounded">
                    @endif
                </div>
                <div id="user-info">
                    <h3 id="user-name">{{ Auth::guard('karyawan')->user()->nama_lengkap }}</h3>
                    <span id="user-role">{{ Auth::guard('karyawan')->user()->jabatan }}</span>
                </div>
            </div>
        </div>

        <div class="section" id="menu-section">
            <div class="card">
                <div class="card-body text-center">
                    <div class="list-menu">
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="{{ url('/editprofile') }}" class="green" style="font-size: 40px;">
                                    <ion-icon name="person-sharp"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">Profil</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="{{ url('presensi/izin') }}" class="danger" style="font-size: 40px;">
                                    <ion-icon name="calendar-number"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">Cuti</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="{{ url('presensi/histori') }}" class="warning" style="font-size: 40px;">
                                    <ion-icon name="document-text"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">Histori</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="" class="orange" style="font-size: 40px;">
                                    <ion-icon name="location"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                Lokasi
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section mt-2" id="presence-section">
            <div class="todaypresence">
                <div class="row">
                    <div class="col-6">
                        <div class="card gradasigreen">
                            <div class="card-body">
                                <div class="presencecontent">
                                    <div class="iconpresence">
                                        @if ($presensi_hari_ini != null)
                                            @php
                                                $path = Storage::url('upload/absensi/' . $presensi_hari_ini->foto_in);
                                            @endphp
                                            <img src="{{ url($path) }}" alt="" class="imaged w48">
                                        @else
                                            <ion-icon name="camera"></ion-icon>
                                        @endif
                                    </div>
                                    <div class="presencedetail">
                                        <h4 class="presencetitle">Masuk</h4>
                                        <span>
                                            {{ $presensi_hari_ini != null ? $presensi_hari_ini->jam_in : 'Belum Absen' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card gradasired">
                            <div class="card-body">
                                <div class="presencecontent">
                                    <div class="iconpresence">
                                        @if ($presensi_hari_ini != null && $presensi_hari_ini->jam_out != null)
                                            @php
                                                $path = Storage::url('upload/absensi/' . $presensi_hari_ini->foto_out);
                                            @endphp
                                            <img src="{{ url($path) }}" alt="" class="imaged w48">
                                        @else
                                            <ion-icon name="camera"></ion-icon>
                                        @endif
                                    </div>
                                    <div class="presencedetail">
                                        <h4 class="presencetitle">Pulang</h4>
                                        <span>
                                            {{ $presensi_hari_ini != null && $presensi_hari_ini->jam_out != null ? $presensi_hari_ini->jam_out : 'Belum Absen' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="rekappresensi">
                <h3>Rekap Presensi Bulan {{ $namaBulan[$bulan_ini] }} {{ $tahun_ini }}</h3>
                <div class="row">
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body text-center" style="padding: 12px 12px !important; line-height: 0.8rem">
                                <span class="badge badge-danger"
                                    style="position: absolute; top: 3px; right: 11px; font-size: 0.6rem; z-index: 999">{{ $rekapPresensi->jmlHadir }}</span>
                                <ion-icon name="briefcase-outline" style="font-size: 1.6rem;"
                                    class="text-primary mb-1"></ion-icon>
                                <br>
                                <span style="font-size: 0.8rem; font-weight:500">Hadir</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body text-center" style="padding: 12px 12px !important; line-height: 0.8rem">
                                <span class="badge badge-danger"
                                    style="position: absolute; top: 3px; right: 11px; font-size: 0.6rem; z-index: 999">{{ $dataIzin->jmlIzin }}</span>
                                <ion-icon name="reader-outline" style="font-size: 1.6rem;"
                                    class="text-success mb-1"></ion-icon>
                                <br>
                                <span style="font-size: 0.8rem; font-weight:500">Izin</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body text-center" style="padding: 12px 12px !important; line-height: 0.8rem">
                                <span class="badge badge-danger"
                                    style="position: absolute; top: 3px; right: 11px; font-size: 0.6rem; z-index: 999">{{ $dataIzin->jmlSakit }}</span>
                                <ion-icon name="medkit-outline" style="font-size: 1.6rem;"
                                    class="text-warning mb-1"></ion-icon>
                                <br>
                                <span style="font-size: 0.8rem; font-weight:500">Sakit</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body text-center" style="padding: 12px 12px !important; line-height: 0.8rem">
                                <span class="badge badge-danger"
                                    style="position: absolute; top: 3px; right: 11px; font-size: 0.6rem; z-index: 999">{{ $rekapPresensi->jmlTerlambat }}</span>
                                <ion-icon name="time-outline" style="font-size: 1.6rem;"
                                    class="text-danger mb-1"></ion-icon>
                                <br>
                                <span style="font-size: 0.8rem; font-weight:500">Telat</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="presencetab mt-2">
                <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                    <ul class="nav nav-tabs style1" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                                Bulan Ini
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                                Leaderboard
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content mt-2" style="margin-bottom:100px;">
                    <div class="tab-pane fade show active" id="home" role="tabpanel">
                        <ul class="listview image-listview">
                            @foreach ($histori_bulan as $bulan)
                                @php
                                    $path = Storage::url('upload/absensi/' . $bulan->foto_in);
                                @endphp
                                <li>
                                    <div class="item">
                                        <div class="icon-box bg-primary">
                                            <ion-icon name="calendar-outline" role="img" class="md hydrated"
                                                aria-label="image outline"></ion-icon>
                                        </div>
                                        <div class="in">
                                            <div>{{ date('d-m-y', strtotime($bulan->tgl_presensi)) }}</div>
                                            <div style="display: flex; flex-direction: column; align-items: center;">
                                                <span class="badge badge-success">{{ $bulan->jam_in }}</span>
                                                <span
                                                    class="badge badge-danger">{{ $bulan != null && $bulan->jam_out != null ? $bulan->jam_out : 'Belum Absen' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel">
                        <ul class="listview image-listview">
                            @foreach ($leaderboard as $ld)
                                <li>
                                    <div class="item">
                                        <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                                        <div class="in">
                                            <div>
                                                <b>{{ $ld->nama_lengkap }}</b><br>
                                                <small class="text-muted">{{ $ld->jabatan }}</small>
                                            </div>
                                            <spa
                                                class="badge {{ $ld->jam_in < '07:00' ? 'badge-success' : 'badge-danger' }}">
                                                {{ $ld->jam_in }}
                                            </spa>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->
@endsection
