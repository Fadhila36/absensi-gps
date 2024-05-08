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
    </style>
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="{{ url('/dashboard') }}" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Form Pengajuan Izin</div>
        <div class="right"></div>
    </div>
@endsection
@section('content')
    <div class="row" style="margin-top: 70px">
        <div class="col">
            <form action="{{ url('/presensi/izin/store') }}" method="POST" enctype="multipart/form-data" id="formizin">
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
                    <input type="text" id="jml_hari" name="jml_hari" class="form-control datepicker"
                        placeholder="Jumlah hari" disabled>
                </div>
                <div class="form-group">
                    <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control" placeholder="Keterangan"></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary w-100">Kirim</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('myscript')
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




            // $("#tgl_izin").change(function(e) {
            //     let tgl_izin = $(this).val();
            //     $.ajax({
            //         type: 'POST',
            //         url: '/presensi/izin/check',
            //         data: {
            //             _token: '{{ csrf_token() }}',
            //             tgl_izin: tgl_izin
            //         },
            //         cache: false,
            //         success: function(respond) {
            //             if (respond == 1) {
            //                 Swal.fire({
            //                     title: 'Oops!',
            //                     text: 'Anda Sudah Mengajukan Izin/Sakit Pada Tanggal Ini!',
            //                     icon: 'warning',
            //                 }).then((result) => {
            //                     $("#tgl_izin").val("");
            //                 });
            //             }
            //         }
            //     });
            // })
            $("#formizin").submit(function(e) {
                let tgl_izin_dari = $('#tgl_izin_dari').val();
                let tgl_izin_sampai = $('#tgl_izin_sampai').val();
                let keterangan = $('#keterangan').val();
                if (tgl_izin_dari == "" || tgl_izin_sampai == "") {
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Tanggal Harus Di Isi!',
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
