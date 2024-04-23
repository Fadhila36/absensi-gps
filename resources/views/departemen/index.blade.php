@extends('layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Departemen
                    </div>
                    <h2 class="page-title">
                        Data Departemen
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
                                        <div class="alert alert-success">
                                            {{ Session::get('success') }}
                                        </div>
                                    @endif
                                    @if (Session::has('warning'))
                                        <div class="alert alert-warning">
                                            {{ Session::get('warning') }}
                                        </div>
                                    @endif
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <a href="#" class="btn btn-primary" id="btnTambahDepartemen">
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
                                    <form action="{{ url('/departemen') }}" method="GET">
                                        <div class="row">
                                            <div class="col-10">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="nama_dept"
                                                        name="nama_dept" placeholder="Cari Departemen"
                                                        value="{{ Request('nama_dept') }}">
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
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode Departemen</th>
                                                <th>Nama Departemen</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($departemen as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration}}</td>
                                                    <td>{{ $item->kode_dept }}</td>
                                                    <td>{{ $item->nama_dept }}</td>
                                                    <td>
                                                        <td>
                                                        <div class="btn-group">
                                                            <a href="#" class="edit btn btn-info btn-sm"
                                                                kode_dept="{{ $item->kode_dept }}">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                    <path
                                                                        d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                                    <path
                                                                        d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                                    <path d="M16 5l3 3" />
                                                                </svg>
                                                            </a>
                                                            <form
                                                                action="{{ url('/departemen/' . $item->kode_dept . '/delete') }}" method="POST"
                                                                style="margin-left: 5px">
                                                                @csrf
                                                                <a class="btn btn-danger btn-sm delete-confirm">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Add Data --}}
    <div class="modal modal-blur fade" id="modal-addDepartemen" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Departemen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('/departemen/store') }}" method="POST" id="form-addDepartemen">
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
                                        </svg> </span>
                                    <input type="text" value="" id="kode_dept" class="form-control"
                                        name="kode_dept" placeholder="Kode Dept">
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
                                    <input type="text" value="" id="nama_dept" class="form-control"
                                        name="nama_dept" placeholder="Nama Departemen">
                                </div>
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
    <div class="modal modal-blur fade" id="modal-editDepartemen" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Departemen</h5>
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
            $('#btnTambahDepartemen').on('click', function() {
                $('#modal-addDepartemen').modal('show');
            })
            $('.edit').on('click', function() {
                let kode_dept = $(this).attr('kode_dept');
                $.ajax({
                    type: "POST",
                    url: "/departemen/edit",
                    cache: false,
                    data: {
                        _token: "{{ csrf_token() }}",
                        kode_dept: kode_dept
                    },
                    success: function(respond) {
                        $('#loadEditForm').html(respond);
                    }
                })
                $('#modal-editDepartemen').modal('show');
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
            $('#form-addDepartemen').on('submit', function(e) {
                let nik = $("#nik").val();
                let nama_lengkap = $("#nama_lengkap").val();
                let jabatan = $("#jabatan").val();
                let no_hp = $("#no_hp").val();
                let kode_dept = $("#form-addDepartemen").find("#kode_dept").val();
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
                }
            });
        })
    </script>
@endpush
