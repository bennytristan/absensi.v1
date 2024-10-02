<form action="/konfigurasi/updatejamkerja" method="POST" id="frmJkedit">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="input-icon mb-2">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-qrcode">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M4 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                        <path d="M7 17l0 .01" />
                        <path d="M14 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                        <path d="M7 7l0 .01" />
                        <path d="M4 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                        <path d="M17 7l0 .01" />
                        <path d="M14 14l3 0" />
                        <path d="M20 14l0 .01" />
                        <path d="M14 14l0 3" />
                        <path d="M14 20l3 0" />
                        <path d="M17 17l3 0" />
                        <path d="M20 17l0 3" />
                    </svg>
                </span>
                <input type="text" value="{{ $jamkerja->kode_jam_kerja }}" class="form-control"
                    id="kode_jam_kerja_edit" placeholder="Kode Jam Kerja" name="kode_jam_kerja" readonly>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="input-icon mb-2">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-time">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                        <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                        <path d="M12 14m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                        <path d="M12 12.496v1.504l1 1" />
                    </svg>
                </span>
                <input type="text" value="{{ $jamkerja->nama_jam_kerja }}" class="form-control"
                    id="nama_jam_kerja_edit" name="nama_jam_kerja" placeholder="Nama Jam Kerja">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="input-icon mb-2">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-clock-check">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M20.942 13.021a9 9 0 1 0 -9.407 7.967" />
                        <path d="M12 7v5l3 3" />
                        <path d="M15 19l2 2l4 -4" />
                    </svg>
                </span>
                <input type="text" value="{{ $jamkerja->awal_jam_masuk }}" class="form-control"
                    id="awal_jam_masuk_edit" name="awal_jam_masuk" placeholder="Awal Jam Kerja">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="input-icon mb-2">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-clock-hour-8">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                        <path d="M12 12l-3 2" />
                        <path d="M12 7v5" />
                    </svg>
                </span>
                <input type="text" value="{{ $jamkerja->jam_masuk }}" class="form-control" id="jam_masuk_edit"
                    name="jam_masuk" placeholder="Jam Masuk">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="input-icon mb-2">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-alarm">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 13m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                        <path d="M12 10l0 3l2 0" />
                        <path d="M7 4l-2.75 2" />
                        <path d="M17 4l2.75 2" />
                    </svg>
                </span>
                <input type="text" value="{{ $jamkerja->akhir_jam_masuk }}" class="form-control"
                    id="akhir_jam_masuk_edit" name="akhir_jam_masuk" placeholder="Akhir Jam Masuk">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="input-icon mb-2">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-clock-stop">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M21 12a9 9 0 1 0 -9 9" />
                        <path d="M12 7v5l1 1" />
                        <path d="M16 16h6v6h-6z" />
                    </svg>
                </span>
                <input type="text" value="{{ $jamkerja->jam_pulang }}" class="form-control" id="jam_pulang_edit"
                    name="jam_pulang" placeholder="Jam Pulang">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="input-icon mb-2">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-clock-stop">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M21 12a9 9 0 1 0 -9 9" />
                        <path d="M12 7v5l1 1" />
                        <path d="M16 16h6v6h-6z" />
                    </svg>
                </span>
                <input type="text" value="{{ $jamkerja->total_jam }}" class="form-control" id="total_jam_edit"
                    name="total_jam" placeholder="Jam Pulang">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mb-2">
            <div class="form-group">
                <select name="status_rehat" id="status_rehat_edit" class="form-select">
                    <option value="">Istirahat</option>
                    <option value="1">Ya</option>
                    <option value="0">Tidak</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row setjamrehat">
        <div class="col-12">
            <div class="input-icon mb-2">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-alarm">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 13m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                        <path d="M12 10l0 3l2 0" />
                        <path d="M7 4l-2.75 2" />
                        <path d="M17 4l2.75 2" />
                    </svg>
                </span>
                <input type="text" value="" class="form-control" id="awal_rehat_edit" name="awal_rehat"
                    placeholder="Awal Jam Istirahat" autocomplete="off">
            </div>
        </div>
    </div>
    <div class="row setjamrehat">
        <div class="col-12">
            <div class="input-icon mb-2">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-alarm">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 13m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                        <path d="M12 10l0 3l2 0" />
                        <path d="M7 4l-2.75 2" />
                        <path d="M17 4l2.75 2" />
                    </svg>
                </span>
                <input type="text" value="" class="form-control" id="akhir_rehat_edit" name="akhir_rehat"
                    placeholder="Akhir Jam Istirahat" autocomplete="off">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <select name="lintashari" id="lintashari_edit" class="form-select">
                    <option value="">Lintas Hari</option>
                    <option value="1" {{ $jamkerja->lintashari == 1 ? 'selected' : '' }}>Ya</option>
                    <option value="0" {{ $jamkerja->lintashari == 0 ? 'selected' : '' }}>Tidak</option>
                </select>
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
    function showsetjamrehat() {
        var status_rehat = $("#status_rehat_edit").val();
        if (status_rehat == "1") {
            $(".setjamrehat").show();
        } else {
            $(".setjamrehat").hide();
        }
    }

    $("#status_rehat_edit").change(function() {
        showsetjamrehat();
    });
    showsetjamrehat();

    $('#kode_jam_kerja').mask('AAAAA');
    $('#awal_jam_masuk_edit, #jam_masuk_edit, #akhir_jam_masuk_edit, #jam_pulang_edit, #awal_rehat_edit, #akhir_rehat_edit')
        .mask('00:00');
    $("#total_jam").mask("0");
    $("#frmJkedit").submit(function() {

        var nama_jam_kerja = $("#nama_jam_kerja_edit").val();
        var awal_jam_masuk = $("#awal_jam_masuk_edit").val();
        var jam_masuk = $("#jam_masuk_edit").val();
        var akhir_jam_masuk = $("#akhir_jam_masuk_edit").val();
        var awal_rehat = $("#awal_rehat_edit").val();
        var akhir_rehat = $("#akhir_rehat_edit").val();
        var jam_pulang = $("#jam_pulang_edit").val();
        var total_jam = $("#total_jam_edit").val();
        var status_rehat = $("#status_rehat_edit").val();
        var lintashari = $("#lintashari_edit").val();

        if (kode_jam_kerja == '') {
            Swal.fire({
                title: 'warning!',
                text: 'Kode Jam Kerja Harus Diisi',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#kode_jam_kerja").focus();
            });
            return false;

        } else if (nama_jam_kerja == '') {
            Swal.fire({
                title: 'warning!',
                text: 'Nama Jam Kerja Harus Diisi',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#nama_jam_kerja").focus();
            });
            return false;

        } else if (awal_jam_masuk == '') {
            Swal.fire({
                title: 'warning!',
                text: 'Awal Jam Masuk Harus Diisi',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#awal_jam_masuk").focus();
            });
            return false;

        } else if (jam_masuk == '') {
            Swal.fire({
                title: 'warning!',
                text: 'Jam Masuk Harus Diisi',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#jam_masuk").focus();
            });
            return false;

        } else if (akhir_jam_masuk == '') {
            Swal.fire({
                title: 'warning!',
                text: 'Akhir Jam Masuk Harus Diisi',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#akhir_jam_masuk").focus();
            });
            return false;

        } else if (status_rehat === "") {
            Swal.fire({
                title: 'warning!',
                text: ' Status Istirahat Harus Diisi',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#status_rehat").focus();
            });
            return false;

        } else if (awal_rehat == '' && status_rehat == "1") {
            Swal.fire({
                title: 'warning!',
                text: ' Awal Jam Istirahat Harus Diisi',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#awal_rehat").focus();
            });
            return false;

        } else if (akhir_rehat == '' && status_rehat == "1") {
            Swal.fire({
                title: 'warning!',
                text: 'Akhir Jam Istirahat Harus Diisi',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#akhir_rehat").focus();
            });
            return false;

        } else if (jam_pulang == '') {
            Swal.fire({
                title: 'warning!',
                text: 'Jam Pulang Harus Diisi',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#jam_pulang").focus();
            });
            return false;

        } else if (total_jam == '') {
            Swal.fire({
                title: 'warning!',
                text: 'Total Jam Kerja Harus Diisi',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#total_jam").focus();
            });
            return false;

        } else if (lintashari == '') {
            Swal.fire({
                title: 'warning!',
                text: 'Lintas Hari Harus Diisi',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#lintashari").focus();
            });
            return false;
        }
    });
</script>
