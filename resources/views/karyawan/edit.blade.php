<form action="/karyawan/{{ Crypt::encrypt($karyawan->nik) }}/update" method="POST" id="formEditKaryawan"
    enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="input-icon mb-3">
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
                <input type="text" value="{{ $karyawan->nik }}" class="form-control" id="nik"
                    placeholder="Nomor Induk Karyawan" name="nik_baru">
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
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-stack-push">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M6 10l-2 1l8 4l8 -4l-2 -1" />
                        <path d="M4 15l8 4l8 -4" />
                        <path d="M12 4v7" />
                        <path d="M15 8l-3 3l-3 -3" />
                    </svg>
                </span>
                <input type="text" value="{{ $karyawan->nama_lengkap }}" class="form-control" id="nama_lengkap"
                    name="nama_lengkap" placeholder="Nama Karyawan">
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
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-stairs-up">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M22 6h-5v5h-5v5h-5v5h-5" />
                        <path d="M6 10v-7" />
                        <path d="M3 6l3 -3l3 3" />
                    </svg>
                </span>
                <input type="text" value="{{ $karyawan->jabatan }}" class="form-control" id="jabatan"
                    name="jabatan" placeholder="Jabatan">
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
                        class="icon icon-tabler icons-tabler-outline icon-tabler-brand-whatsapp">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M3 21l1.65 -3.8a9 9 0 1 1 3.4 2.9l-5.05 .9" />
                        <path
                            d="M9 10a.5 .5 0 0 0 1 0v-1a.5 .5 0 0 0 -1 0v1a5 5 0 0 0 5 5h1a.5 .5 0 0 0 0 -1h-1a.5 .5 0 0 0 0 1" />
                    </svg>
                </span>
                <input type="text" value="{{ $karyawan->no_hp }}" class="form-control" id="no_hp" name="no_hp"
                    placeholder="Nomor Handphone">
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12">
            <input type="file" name="foto" class="form-control">
            <input type="hidden" name="old_foto" value="{{ $karyawan->foto }}">
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12">
            <select name="kode_dept" id="kode_dept" class="form-select">
                <option value="">Departemen</option>
                @foreach ($departemen as $d)
                    <option {{ $karyawan->kode_dept == $d->kode_dept ? 'selected' : '' }} value="{{ $d->kode_dept }}">
                        {{ $d->nama_dept }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12">
            <select name="kode_cabang" id="kode_cabang" class="form-select">
                <option value="">Kantor Cabang</option>
                @foreach ($cabang as $d)
                    <option {{ $karyawan->kode_cabang == $d->kode_cabang ? 'selected' : '' }}
                        value="{{ $d->kode_cabang }}">{{ strtoupper($d->nama_cabang) }}</option>
                @endforeach
            </select>
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
    $("#formEditKaryawan").submit(function() {
        var nik = $("#formEditKaryawan").find("#nik").val();
        var nama_lengkap = $("#formEditKaryawan").find("#nama_lengkap").val();
        var jabatan = $("#formEditKaryawan").find("#jabatan").val();
        var no_hp = $("#formEditKaryawan").find("#no_hp").val();
        var kode_dept = $("#formEditKaryawan").find("#kode_dept").val();
        var kode_cabang = $("#formEditKaryawan").find("#kode_cabang").val();
        if (nik == '') {
            Swal.fire({
                title: 'Warning!',
                text: 'Nik Harus Diisi',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#nik").focus();
            });

            return false;
        } else if (nama_lengkap == '') {
            Swal.fire({
                title: 'Warning!',
                text: 'Nama Harus Diisi',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#nama_lengkap").focus();
            });

            return false;

        } else if (jabatan == '') {
            Swal.fire({
                title: 'Warning!',
                text: 'Jabatan Harus Diisi',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#jabatan").focus();
            });

            return false;

        } else if (no_hp == '') {
            Swal.fire({
                title: 'Warning!',
                text: 'No Handphone Harus Diisi',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#no_hp").focus();
            });

            return false;

        } else if (kode_dept == '') {
            Swal.fire({
                title: 'Warning!',
                text: 'Departemen Harus Diisi',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#kode_dept").focus();
            });

            return false;
        } else if (kode_cabang == '') {
            Swal.fire({
                title: 'Warning!',
                text: 'Kantor Harus Diisi',
                icon: 'warning',
                confirmButtonText: 'Ok'
            }).then((result) => {
                $("#kode_cabang").focus();
            });

            return false;
        }
    });
</script>
