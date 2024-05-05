@extends('layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Karyawan
                    </div>
                    <h2 class="page-title">
                        Data Karyawan
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="div page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    @if (Session::has('success'))
                                        <div class="alert alert-success" role="alert">
                                            <div class="d-flex">
                                                <div>
                                                    <!-- Download SVG icon from http://tabler-icons.io/i/check -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon"
                                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M5 12l5 5l10 -10"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    {{ Session::get('success') }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if (Session::has('error'))
                                        <div class="alert alert-danger" role="alert">
                                            <div class="d-flex">
                                                <div>
                                                    <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon"
                                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path>
                                                        <path d="M12 8v4"></path>
                                                        <path d="M12 16h.01"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    {{ Session::get('error') }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <a href="#" class="btn btn-primary" id="btnTambahKaryawan">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-circle-plus">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                            <path d="M9 12h6" />
                                            <path d="M12 9v6" />
                                        </svg>
                                        Tambah Data
                                    </a>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <form action="{{ url('/karyawan') }}" method="GET">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="nama_karyawan"
                                                        name="nama_karyawan" placeholder="Cari Karyawan"
                                                        value="{{ Request('nama_karyawan') }}">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <select name="kode_dept" id="kode_dept" class="form-select">
                                                        <option value="">Departemen</option>
                                                        @foreach ($departemen as $item)
                                                            <option
                                                                {{ Request('kode_dept') == $item->kode_dept ? 'selected' : '' }}
                                                                value="{{ $item->kode_dept }}">{{ $item->nama_dept }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                                            <path d="M21 21l-6 -6" />
                                                        </svg>
                                                        Cari
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>NIK</th>
                                                    <th>Nama</th>
                                                    <th>Jabatan</th>
                                                    <th>No. HP</th>
                                                    <th>Foto</th>
                                                    <th>Departemen</th>
                                                    <th>Cabang</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($karyawan as $d)
                                                    @php
                                                        $path = Storage::url('upload/karyawan/' . $d->foto);
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $loop->iteration + $karyawan->firstItem() - 1 }}</td>
                                                        <td>{{ $d->nik }}</td>
                                                        <td>{{ $d->nama_lengkap }}</td>
                                                        <td>{{ $d->jabatan }}</td>
                                                        <td>{{ $d->no_hp }}</td>
                                                        <td>
                                                            @if (empty($d->foto))
                                                                <img src="{{ asset('assets/img/avatar.png') }}"
                                                                    class="avatar" alt="no-photo">
                                                            @else
                                                                <img src="{{ url($path) }}" alt="avatar"
                                                                    class="avatar">
                                                            @endif
                                                        </td>
                                                        <td>{{ $d->nama_dept }}</td>
                                                        <td>{{ $d->kode_cabang }}</td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <a href="#" class="edit btn btn-info btn-sm"
                                                                    nik="{{ $d->nik }}">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                                        <path stroke="none" d="M0 0h24v24H0z"
                                                                            fill="none" />
                                                                        <path
                                                                            d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                                        <path
                                                                            d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                                        <path d="M16 5l3 3" />
                                                                    </svg>
                                                                </a>
                                                                <a href="/setting/set-jam-kerja/{{ $d->nik }}" class="btn btn-success btn-sm"
                                                                    nik="{{ $d->nik }}">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-clock">
                                                                        <path stroke="none" d="M0 0h24v24H0z"
                                                                            fill="none" />
                                                                        <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                                                        <path d="M12 7v5l3 3" />
                                                                    </svg>
                                                                </a>
                                                                <form action="{{ url('/karyawan/delete/' . $d->nik) }}"
                                                                    method="POST" style="margin-left: 5px">
                                                                    @csrf
                                                                    <a class="btn btn-danger btn-sm delete-confirm">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            width="24" height="24"
                                                                            viewBox="0 0 24 24" fill="none"
                                                                            stroke="currentColor" stroke-width="2"
                                                                            stroke-linecap="round" stroke-linejoin="round"
                                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-trash-x">
                                                                            <path stroke="none" d="M0 0h24v24H0z"
                                                                                fill="none" />
                                                                            <path d="M4 7h16" />
                                                                            <path
                                                                                d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                            <path
                                                                                d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                                            <path d="M10 12l4 4m0 -4l-4 4" />
                                                                        </svg>
                                                                    </a>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    {{ $karyawan->links('vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Add Data --}}
    <div class="modal modal-blur fade" id="modal-addKaryawan" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('/karyawan/store') }}" method="POST" id="form-addKaryawan"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-id-badge-2">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M7 12h3v4h-3z" />
                                            <path
                                                d="M10 6h-6a1 1 0 0 0 -1 1v12a1 1 0 0 0 1 1h16a1 1 0 0 0 1 -1v-12a1 1 0 0 0 -1 -1h-6" />
                                            <path
                                                d="M10 3m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v3a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z" />
                                            <path d="M14 16h2" />
                                            <path d="M14 12h4" />
                                        </svg>
                                    </span>
                                    <input type="text" maxlength="10" value="" id="nik" class="form-control"
                                        name="nik"placeholder="Nik">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                        </svg> </span>
                                    <input type="text" value="" id="nama_lengkap" class="form-control"
                                        name="nama_lengkap" placeholder="Nama Lengkap">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-device-analytics">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M3 4m0 1a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1z" />
                                            <path d="M7 20l10 0" />
                                            <path d="M9 16l0 4" />
                                            <path d="M15 16l0 4" />
                                            <path d="M8 12l3 -3l2 2l3 -3" />
                                        </svg></span>
                                    <input type="text" value="" id="jabatan" class="form-control"
                                        name="jabatan" placeholder="Jabatan">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-device-mobile">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M6 5a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2v-14z" />
                                            <path d="M11 4h2" />
                                            <path d="M12 17v.01" />
                                        </svg></span>
                                    <input type="number" value="" id="no_hp" class="form-control"
                                        name="no_hp" placeholder="No Handphone">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-label">Photo</div>
                                <input type="file" name="foto" class="form-control">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <select name="kode_dept" id="kode_dept" class="form-select">
                                    <option value="">Departemen</option>
                                    @foreach ($departemen as $item)
                                        <option {{ Request('kode_dept') == $item->kode_dept ? 'selected' : '' }}
                                            value="{{ $item->kode_dept }}">{{ $item->nama_dept }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <select name="kode_cabang" id="kode_cabang" class="form-select">
                                    <option value="">Cabang</option>
                                    @foreach ($cabang as $item)
                                        <option {{ Request('kode_cabang') == $item->kode_cabang ? 'selected' : '' }}
                                            value="{{ $item->kode_cabang }}">{{ strtoupper($item->nama_cabang) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="form-group">
                                    <button class="btn btn-primary w-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-send">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M10 14l11 -11" />
                                            <path
                                                d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5" />
                                        </svg>
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Edit Data --}}
    <div class="modal modal-blur fade" id="modal-editKaryawan" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="loadEditForm">

                </div>
            </div>
        </div>
    </div>
@endsection

@push('myscript')
    <script>
        $(function() {
            $('#btnTambahKaryawan').on('click', function() {
                $('#modal-addKaryawan').modal('show');
            })
            $('.edit').on('click', function() {
                let nik = $(this).attr('nik');
                $.ajax({
                    type: "POST",
                    url: "/karyawan/edit",
                    cache: false,
                    data: {
                        _token: "{{ csrf_token() }}",
                        nik: nik
                    },
                    success: function(respond) {
                        $('#loadEditForm').html(respond);
                    }
                })
                $('#modal-editKaryawan').modal('show');
            })

            $('.delete-confirm').on('click', function(e) {
                let form = $(this).closest('form');
                e.preventDefault();
                Swal.fire({
                    title: "Apakan anda yakin?",
                    text: "Data yang di hapus tidak dapat dikembalikan!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Ya, hapus!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                        Swal.fire({
                            title: "Deleted!",
                            text: "Data anda telah di hapus.",
                            icon: "success"
                        });
                    }
                });
            })
            $('#form-addKaryawan').on('submit', function(e) {
                let nik = $("#nik").val();
                let nama_lengkap = $("#nama_lengkap").val();
                let jabatan = $("#jabatan").val();
                let no_hp = $("#no_hp").val();
                let kode_dept = $("#form-addKaryawan").find("#kode_dept").val();
                let kode_cabang = $("#form-addKaryawan").find("#kode_cabang").val();
                if (nik == "") {
                    // alert('Nik harus diisi');
                    Swal.fire({
                        title: 'Warning',
                        text: 'Nik harus diisi',
                        icon: 'warning',
                        confirmButtonText: 'Ok',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $("#nik").focus();
                        }
                    });
                    return false;
                } else if (nama_lengkap == "") {
                    Swal.fire({
                        title: 'Warning',
                        text: 'Nama harus diisi',
                        icon: 'warning',
                        confirmButtonText: 'Ok',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $("#nama_lengkap").focus();
                        }
                    });
                    return false;
                } else if (jabatan == "") {
                    Swal.fire({
                        title: 'Warning',
                        text: 'Jabatan harus diisi',
                        icon: 'warning',
                        confirmButtonText: 'Ok',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $("#jabatan").focus();
                        }
                    });
                    return false;
                } else if (no_hp == "") {
                    Swal.fire({
                        title: 'Warning',
                        text: 'Nomor HP harus diisi',
                        icon: 'warning',
                        confirmButtonText: 'Ok',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $("#no_hp").focus();
                        }
                    });
                    return false;
                } else if (kode_dept == "") {
                    Swal.fire({
                        title: 'Warning',
                        text: 'Kode departemen harus diisi',
                        icon: 'warning',
                        confirmButtonText: 'Ok',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $("#kode_dept").focus();
                        }
                    });
                    return false;
                } else if (kode_cabang == "") {
                    Swal.fire({
                        title: 'Warning',
                        text: 'Nama Cabang harus diisi',
                        icon: 'warning',
                        confirmButtonText: 'Ok',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $("#kode_cabang").focus();
                        }
                    });
                    return false;
                }
            });
        })
    </script>
@endpush
