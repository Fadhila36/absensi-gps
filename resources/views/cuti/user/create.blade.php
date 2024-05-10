@extends('layouts.presensi')
@section('header')
    {{-- Datepicker --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        .datepicker-modal {
            max-height: 470px !important;
        }

        .datepicker-date-display {
            background-color: #0f3a7f !important;
        }

        .datepicker-cancel,
        .datepicker-clear,
        .datepicker-today,
        .datepicker-done {
            color: #0f3a7f !important;
        }

        .datepicker-table td.is-selected {
            background-color: #0f3a7f !important;
        }

        /* Style tambahan untuk tampilan yang lebih menarik */
        .form-container {
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .btn-primary {
            background-color: #0f3a7f;
            border: none;
            padding: 1px 20px;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0c295d;
        }
    </style>
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="{{ url('/dashboard') }}" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Form Pengajuan Cuti</div>
        <div class="right"></div>
    </div>
@endsection
@section('content')
    <div class="row justify-content-center" style="margin-top: 70px">
        <div class="col-md-6">
            <div class="form-container">
                <form action="{{ url('/presensi/cuti/store') }}" method="POST" enctype="multipart/form-data"
                    id="formizin">
                    @csrf
                    <div class="form-group">
                        <input type="text" id="tgl_izin_dari" name="tgl_izin_dari" class="form-control datepicker"
                            placeholder="Dari">
                    </div>
                    <div class="form-group">
                        <input type="text" id="tgl_izin_sampai" name="tgl_izin_sampai" class="form-control datepicker"
                            placeholder="Sampai">
                    </div>
                    <div class="form-group">
                        <input type="text" id="jml_hari" name="jml_hari" class="form-control" placeholder="Jumlah hari"
                            readonly>
                    </div>
                    <div class="form-group">
                        <select name="kode_cuti" id="kode_cuti" class="form-control select-materialize">
                            <option value="">Pilih Kategori Cuti</option>
                            @foreach ($master_cuti as $c)
                                <option value="{{ $c->kode_cuti }}">{{ $c->nama_cuti }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control" placeholder="Keterangan"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('myscript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
    <script>
        let currYear = (new Date()).getFullYear();

        $(document).ready(function() {
            $(".datepicker").datepicker({
                format: "yyyy-mm-dd"
            });

            function loadjumlahhari() {
                let dari = $("#tgl_izin_dari").val();
                let sampai = $("#tgl_izin_sampai").val();
                let date1 = new Date(dari);
                let date2 = new Date(sampai);

                let Difference_In_Time = date2.getTime() - date1.getTime();
                let Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
                let jml_hari = 0; // declare jml_hari outside the if block

                if (dari !== "" && sampai !== "") { // fix the condition
                    jml_hari = Difference_In_Days + 1; // assign value to jml_hari
                }

                $("#jml_hari").val(jml_hari.toString() + " Hari"); // convert jml_hari to string explicitly
            }

            $('#tgl_izin_dari, #tgl_izin_sampai').change(function() {
                loadjumlahhari();
            });

            $("#formizin").submit(function(e) {
                let tgl_izin_dari = $('#tgl_izin_dari').val();
                let tgl_izin_sampai = $('#tgl_izin_sampai').val();
                let keterangan = $('#keterangan').val();
                let kode_cuti = $('#kode_cuti').val();
                if (tgl_izin_dari == "" || tgl_izin_sampai == "") {
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Tanggal Harus Di Isi!',
                        icon: 'warning',
                    });
                    return false;
                } else if (kode_cuti == "") {
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Kategori Cuti Harus Di Isi!',
                        icon: 'warning',
                    });
                    return false;
                } else if (keterangan == "") {
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Keterangan Harus Di Isi!',
                        icon: 'warning',
                    });
                    return false;
                }
            });
        });
    </script>
@endpush
