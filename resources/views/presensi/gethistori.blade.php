@if ($histori->isEmpty())
    <div class="alert alert-outline-warning">
        <p>Data Tidak Ditemukan</p>
    </div>
@endif
@foreach ($histori as $hs)
    <ul class="listview image-listview">
        <li>
            <div class="item">
                @php
                    $path = Storage::url('upload/absensi/' . $hs->foto_in);
                @endphp
                <img src="{{ url($path) }}" alt="image" class="image">
                <div class="in">
                    <div>
                        <b>{{ date('d-m-Y', strtotime($hs->tgl_presensi)) }}</b><br>
                    </div>
                    <div style="display: flex; flex-direction: column; align-items: center;">
                        <span class="badge {{ $hs->jam_in < '07:00' ? 'badge-success' : 'badge-danger' }}">
                            {{ $hs->jam_in }}
                        </span>
                        <span class="badge badge-primary">{{ $hs->jam_out }}</span>
                    </div>
                </div>
            </div>
        </li>
    </ul>
@endforeach
