@extends('layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Izin & Sakit
                    </div>
                    <h2 class="page-title">
                        Data Pengajuan Izin & Sakit
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="col-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>NIK</th>
                            <th>NAMA KARYAWAN</th>
                            <th>JABATAN</th>
                            <th>STATUS</th>
                            <th>KETERANGAN</th>
                            <th>STATUS APPROVAL</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($izinSakit as $d)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ date('d-m-Y', strtotime($d->tgl_izin)) }}</td>
                                <td>{{ $d->nik }}</td>
                                <td>{{ $d->nama_lengkap }}</td>
                                <td>{{ $d->jabatan }}</td>
                                <td>{{ $d->status == 'i' ? 'izin' : 'sakit' }}</td>
                                <td>{{ $d->keterangan }}</td>
                                <td>
                                    @if ($d->status_approved == 1)
                                        <span class="badge bg-success text-white">Disetujui</span>
                                    @elseif ($d->status_approved == 2)
                                        <span class="badge bg-danger text-white">Ditolak</span>
                                    @else
                                        <span class="badge bg-warning text-white">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($d->status_approved == 0)
                                        <a href="#" class="btn btn-primary btn-sm" id="approve" data-id="{{ $d->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-external-link">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6" />
                                                <path d="M11 13l9 -9" />
                                                <path d="M15 4h5v5" />
                                            </svg>
                                        </a>
                                    @else
                                        <a href="{{ url('/presensi/izin-sakit/cancel/' . $d->id) }}" class="btn btn-danger btn-sm" >
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-circle-x">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                                <path d="M10 10l4 4m0 -4l-4 4" />
                                            </svg>
                                            Batalkan
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Aksi Sakit & Izin --}}
    <div class="modal modal-blur fade" id="modal-izinSakit" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Data Izin & Sakit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('/presensi/izin-sakit/approve') }}" method="POST">
                        @csrf
                        <input type="hidden" id="izinSakitId" name="izinSakitId">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <select name="status_approved" id="status_approved" class="form-select">
                                        <option value="1">Disetujui</option>
                                        <option value="2">Ditolak</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="form-group">
                                    <button class="btn btn-primary w-100" type="submit">
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
    @endsection
    @push('myscript')
        <script>
            $(function() {
                $("#approve").on('click', function(e) {
                    e.preventDefault();
                    let id = $(this).attr('data-id');
                    $("#izinSakitId").val(id);
                    $("#modal-izinSakit").modal('show');
                })
            })
        </script>
    @endpush
