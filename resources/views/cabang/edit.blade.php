<form action="{{ url('/cabang/update/' . $cabang->kode_cabang) }}" method="POST" id="form-editCabang">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-id-badge-2">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M7 12h3v4h-3z" />
                        <path d="M10 6h-6a1 1 0 0 0 -1 1v12a1 1 0 0 0 1 1h16a1 1 0 0 0 1 -1v-12a1 1 0 0 0 -1 -1h-6" />
                        <path d="M10 3m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v3a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z" />
                        <path d="M14 16h2" />
                        <path d="M14 12h4" />
                    </svg> </span>
                <input type="text" value="{{ $cabang->kode_cabang }}" id="kode_cabang" class="form-control"
                    name="kode_cabang" placeholder="Kode Cabang" disabled>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-building-skyscraper">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M3 21l18 0" />
                        <path d="M5 21v-14l8 -4v18" />
                        <path d="M19 21v-10l-6 -4" />
                        <path d="M9 9l0 .01" />
                        <path d="M9 12l0 .01" />
                        <path d="M9 15l0 .01" />
                        <path d="M9 18l0 .01" />
                    </svg>
                </span>
                <input type="text" value="{{ $cabang->nama_cabang }}" id="nama_cabang" class="form-control"
                    name="nama_cabang" placeholder="Nama Cabang">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-map-pins">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M10.828 9.828a4 4 0 1 0 -5.656 0l2.828 2.829l2.828 -2.829z" />
                        <path d="M8 7l0 .01" />
                        <path d="M18.828 17.828a4 4 0 1 0 -5.656 0l2.828 2.829l2.828 -2.829z" />
                        <path d="M16 15l0 .01" />
                    </svg>
                </span>
                <input type="text" value="{{ $cabang->lokasi_cabang }}" id="lokasi_cabang" class="form-control"
                    name="lokasi_cabang" placeholder="Lokasi Cabang">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="input-icon mb-3">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-radar">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M21 12h-8a1 1 0 1 0 -1 1v8a9 9 0 0 0 9 -9" />
                        <path d="M16 9a5 5 0 1 0 -7 7" />
                        <path d="M20.486 9a9 9 0 1 0 -11.482 11.495" />
                    </svg>
                </span>
                <input type="text" value="{{ $cabang->radius_cabang }}" id="radius_cabang" class="form-control"
                    name="radius_cabang" placeholder="Radius Cabang">
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12">
            <div class="form-group">
                <button class="btn btn-primary w-100">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-send">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M10 14l11 -11" />
                        <path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5" />
                    </svg>
                    Simpan
                </button>
            </div>
        </div>
    </div>
</form>
<script>
    $(function() {
        $('#form-editCabang').on('submit', function(e) {
            let kode_cabang = $("#form-editCabang").find("#kode_cabang").val();;
            let nama_cabang = $("#form-editCabang").find("#nama_cabang").val();;
            let lokasi_cabang = $("#form-editCabang").find("#lokasi_cabang").val();;
            let radius_cabang = $("#form-editCabang").find("#radius_cabang").val();;
            if (kode_cabang == "") {
                // alert('kode_cabang harus diisi');
                Swal.fire({
                    title: 'Warning',
                    text: 'Kode Cabang harus diisi',
                    icon: 'warning',
                    confirmButtonText: 'Ok',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $("#kode_cabang").focus();
                    }
                });
                return false;
            } else if (nama_cabang == "") {
                Swal.fire({
                    title: 'Warning',
                    text: 'Nama Cabang harus diisi',
                    icon: 'warning',
                    confirmButtonText: 'Ok',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $("#nama_cabang").focus();
                    }
                });
                return false;
            } else if (lokasi_cabang == "") {
                Swal.fire({
                    title: 'Warning',
                    text: 'Lokasi Cabang harus diisi',
                    icon: 'warning',
                    confirmButtonText: 'Ok',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $("#lokasi_cabang").focus();
                    }
                });
                return false;
            } else if (radius_cabang == "") {
                Swal.fire({
                    title: 'Warning',
                    text: 'Radius Cabang harus diisi',
                    icon: 'warning',
                    confirmButtonText: 'Ok',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $("#radius_cabang").focus();
                    }
                });
                return false;
            }
        });
    })
</script>
