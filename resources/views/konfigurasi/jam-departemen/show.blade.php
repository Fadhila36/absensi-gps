@extends('layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Jam Kerja
                    </div>
                    <h2 class="page-title">
                        Show Jam Kerja Departement
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="div page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <select name="kode_cabang" id="kode_cabang" class="form-select" disabled>
                                    <option value="">Pilih Cabang</option>
                                    @foreach ($cabang as $d)
                                        <option {{ $jam_kerja_dept->kode_cabang == $d->kode_cabang ? 'selected' : '' }}
                                            value="{{ $d->kode_cabang }}">{{ strtoupper($d->nama_cabang) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <select name="kode_dept" id="kode_dept" class="form-select" disabled>
                                    <option value="">Pilih Departemen</option>
                                    @foreach ($departemen as $d)
                                        <option {{ $jam_kerja_dept->kode_dept == $d->kode_dept ? 'selected' : '' }}
                                            value="{{ $d->kode_dept }}">{{ strtoupper($d->nama_dept) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row mt-2">
                <div class="col-6">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Hari</th>
                                <th>Jam Kerja</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jam_kerja_dept_detail as $s)
                                <tr>
                                    <td>{{ $s->hari }}
                                        <input type="hidden" name="hari[]" value="{{ $s->hari }}">
                                    </td>
                                    <td>
                                        {{ $s->nama_jam_kerja }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="{{ url()->previous() }}" class="btn btn-primary w-100">Kembali</a>
                </div>
                <div class="col-6">
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="6" class="text-center">Master Jam Kerja</th>
                            </tr>
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Awal Masuk</th>
                                <th>Jam Masuk</th>
                                <th>Akhir Masuk</th>
                                <th>Jam Pulang</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jam_kerja as $item)
                                <tr>
                                    <td>{{ $item->kode_jam_kerja }}</td>
                                    <td>{{ $item->nama_jam_kerja }}</td>
                                    <td>{{ $item->awal_jam_masuk }}</td>
                                    <td>{{ $item->jam_masuk }}</td>
                                    <td>{{ $item->akhir_jam_masuk }}</td>
                                    <td>{{ $item->jam_pulang }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
