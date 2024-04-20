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
            @foreach ($dataIzin as $di)
                <ul class="listview image-listview">
                    <li>
                        <div class="item">
                            <div class="in">
                                <div>
                                    <b>{{ date('d-m-Y', strtotime($di->tgl_izin)) }}
                                        ({{ $di->status == 's' ? 'Sakit' : 'Izin' }})</b><br>
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
                </ul>
            @endforeach
        </div>
    </div>
    <div class="fab-button bottom-right" style="margin-bottom: 70px">
        <a href="{{ url('presensi/izin/create') }}" class="fab"><ion-icon name="add-circle-outline"></ion-icon></a>
    </div>
@endsection
