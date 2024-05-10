@extends('layouts.presensi')
@section('header')
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="{{ url('/dashboard') }}" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Data Izin / Sakit</div>
        <div class="right"></div>
    </div>

    <style>
        .history-content {
            display: flex;
            align-items: flex-start;
            /* Mengatur item agar align ke atas */
        }

        .icon-presensi ion-icon {
            font-size: 48px;
            color: rgb(21, 95, 207);
        }

        .data-presensi {
            margin-left: 10px;
        }

        .data-presensi h3 {
            margin: 0;
            line-height: 1.5;
        }

        .data-presensi h4 {
            margin: 0;
        }

        /* Menambahkan gaya untuk status */
        .status {
            margin-left: auto;
            /* Agar status muncul di sebelah kanan */
        }

        .status .badge {
            font-size: 12px;
            padding: 5px 10px;
            border-radius: 5px;
        }
    </style>
@endsection
@section('content')
    <div class="row" style="margin-top: 70px">
        <div class="col">
            @php
                $messageSuccess = session()->get('success');
                $messageError = session()->get('error');
            @endphp
            @if ($messageSuccess)
                <div class="alert alert-success">
                    {{ $messageSuccess }}
                </div>
            @elseif ($messageError)
                <div class="alert alert-danger">
                    {{ $messageError }}
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col">
            @foreach ($dataIzin as $d)
                @php
                    if ($d->status == 'i') {
                        $status = 'Izin';
                    } elseif ($d->status == 's') {
                        $status = 'Sakit';
                    } elseif ($d->status == 'c') {
                        $status = 'Cuti';
                    } else {
                        $status = 'Not found';
                    }
                @endphp
                <div class="card mt-1">
                    <div class="card-body">
                        <div class="history-content">
                            <div class="icon-presensi">
                                @if ($d->status == 'i')
                                    <ion-icon name="document-outline" role="img" class="md hydrated"
                                        style="font-size: 48px; color:rgb(21,55,207)" aria-label="image outline"></ion-icon>
                                @elseif ($d->status == 's')
                                    <ion-icon name="medkit-outline" role="img" class="md hydrated"
                                        style="font-size: 48px; color:rgb(191,7,65)" aria-label="image outline"></ion-icon>
                                @elseif ($d->status == 'c')
                                    <ion-icon name="calendar-clear-outline" role="img" class="md hydrated"
                                        style="font-size: 48px; color:rgb(46,204,113)"
                                        aria-label="image outline"></ion-icon>
                                @endif
                            </div>
                            <div class="data-presensi">
                                <h3>{{ \Carbon\Carbon::parse($d->tgl_izin_dari)->locale(config('app.locale'))->isoFormat('LL') }}
                                    ({{ $status }})
                                </h3>
                                <small>{{ \Carbon\Carbon::parse($d->tgl_izin_dari)->locale(config('app.locale'))->isoFormat('LL') }}
                                    s/d
                                    {{ \Carbon\Carbon::parse($d->tgl_izin_sampai)->locale(config('app.locale'))->isoFormat('LL') }}</small>
                                <p>
                                    {{ $d->keterangan }}
                                    <br>
                                    @if ($d->status == "c")
                                        <span class="badge bg-warning">{{ $d->nama_cuti }}</span>
                                    @endif
                                    <br>
                                    @if (!empty($d->doc_sid))
                                        <span style="color: rgb(30, 144, 255)">
                                            <ion-icon name="document-attach-outline"></ion-icon> Lihat SID
                                        </span>
                                    @endif
                                </p>
                            </div>
                            <div class="status">
                                @if ($d->status_approved == 0)
                                    <span class="badge badge-warning">Menunggu</span>
                                @elseif($d->status_approved == 1)
                                    <span class="badge badge-success">Disetujui</span>
                                @elseif($d->status_approved == 2)
                                    <span class="badge badge-danger">Ditolak</span>
                                @endif
                                <p style="margin-top: 5px; font-weight: bold">
                                    {{ hitung_hari($d->tgl_izin_dari, $d->tgl_izin_sampai) }} Hari</p>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <ul class="listview image-listview">
                    <li>
                        <div class="item">
                            <div class="in">
                                <div>
                                    <b>{{ date('d-m-Y', strtotime($di->tgl_izin_dari)) }}
                                        ({{ $di->status == 's' ? 'Sakit' : 'Izin' }})
                                    </b><br>
                                    <small class="text-muted">{{ $di->keterangan }}</small>
                                </div>
                                @if ($di->status_approved == 0)
                                    <span class="badge badge-warning">Waiting</span>
                                @elseif($di->status_approved == 1)
                                    <span class="badge badge-success">Approved</span>
                                @elseif($di->status_approved == 2)
                                    <span class="badge badge-danger">Rejected</span>
                                @endif
                            </div>
                        </div>
                    </li>
                </ul> --}}
            @endforeach
        </div>
    </div>
    {{-- <div class="fab-button bottom-right" style="margin-bottom: 70px">
        <a href="{{ url('presensi/izin/create') }}" class="fab"><ion-icon name="add-circle-outline"></ion-icon></a>
    </div> --}}
    <div class="fab-button animate bottom-right dropdown" style="margin-bottom: 70px">
        <a href="#" class="fab bg-primary" data-toggle="dropdown">
            <ion-icon name="add-outline" role="img" class="md hydrated" aria-label="add outline"></ion-icon>
        </a>
        <div class="dropdown-menu">
            <a href="{{ url('presensi/izin/create') }}" class="dropdown-item bg-primary">
                <ion-icon name="document-outline" role="img" class="md hydrated" aria-label="image outline"></ion-icon>
                <p>Izin Absen</p>
            </a>
            <a href="{{ url('presensi/sakit/create') }}" class="dropdown-item bg-primary">
                <ion-icon name="medkit-outline" role="img" class="md hydrated" aria-label="videocam outline"></ion-icon>
                <p>Sakit</p>
            </a>
            <a href="{{ url('presensi/cuti/create') }}" class="dropdown-item bg-primary">
                <ion-icon name="calendar-clear-outline" role="img" class="md hydrated"
                    aria-label="videocam outline"></ion-icon>
                <p>Cuti</p>
            </a>
        </div>
    </div>
@endsection
