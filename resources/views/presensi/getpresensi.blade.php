@foreach ($presensi as $d)
    @php
        function selisih($jam_masuk, $jam_keluar)
        {
            [$h, $m, $s] = explode(':', $jam_masuk);
            $dtAwal = mktime($h, $m, $s, '1', '1', '1');
            [$h, $m, $s] = explode(':', $jam_keluar);
            $dtAkhir = mktime($h, $m, $s, '1', '1', '1');
            $dtSelisih = $dtAkhir - $dtAwal;
            $totalmenit = $dtSelisih / 60;
            $jam = floor($totalmenit / 60); // Menghitung jumlah jam terlambat
            $menit = $totalmenit % 60; // Menghitung sisa menit terlambat
            return $jam . ' jam ' . round($menit) . ' menit';
        }
    @endphp
    @php
        $foto_in = Storage::url('upload/absensi/' . $d->foto_in);
        $foto_out = Storage::url('upload/absensi/' . $d->foto_out);
    @endphp
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $d->nik }}</td>
        <td>{{ $d->nama_lengkap }}</td>
        <td>{{ $d->nama_dept }}</td>
        <td>{{ $d->nama_jam_kerja }} ({{date("H:i", strtotime ($d->jam_masuk)) }} s/d {{date("H:i", strtotime ($d->jam_pulang)) }})</td>
        <td>{{ $d->jam_in }}</td>
        <td>
            <img src="{{ url($foto_in) }}" class="avatar" alt="">
        </td>
        <td>{!! $d->jam_out != null ? $d->jam_out : '<span class="badge bg-danger text-white">Belum Absen</span>' !!}</td>
        <td>
            @if ($d->jam_out != null)
                <img src="{{ url($foto_out) }}" class="avatar" alt="">
            @else
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-hourglass-empty">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M6 20v-2a6 6 0 1 1 12 0v2a1 1 0 0 1 -1 1h-10a1 1 0 0 1 -1 -1z" />
                    <path d="M6 4v2a6 6 0 1 0 12 0v-2a1 1 0 0 0 -1 -1h-10a1 1 0 0 0 -1 1z" />
                </svg>
            @endif
        </td>
        <td>
            @if ($d->jam_in >= $d->jam_masuk)
                @php
                    $jamTerlambat = selisih($d->jam_masuk, $d->jam_in);
                @endphp
                <span class="badge bg-danger text-white">Terlambat {{ $jamTerlambat }}</span>
            @else
                <span class="badge bg-success text-white">Tepat Waktu</span>
            @endif
        </td>
        <td>
            <a href="#" class="btn btn-primary showMaps" id="{{ $d->id }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-map-pin">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                    <path d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z" />
                </svg>
            </a>
        </td>
    </tr>
@endforeach

<script>
    $(function() {
        $('.showMaps').click(function() {
            let id = $(this).attr('id');
            $.ajax({
                type: "POST",
                url: "/presensi/showmap",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                cache: false,
                success: function(respond) {
                    $('#loadMaps').html(respond);
                }
            })
            $("#modal-showMaps").modal('show');
        })
    })
</script>
