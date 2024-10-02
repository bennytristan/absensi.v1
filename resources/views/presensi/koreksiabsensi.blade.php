<form action="/storekoreksiabsensi" method="POST" id="frmKoreksiAbsensi">
    @csrf
    <input type="hidden" name="nik" value="{{ $karyawan->nik }}">
    <input type="hidden" name="tanggal" value="{{ $tanggal }}">
    <table class="table">
        <tr>
            <td>Tanggal</td>
            <td>{{ date('d-m-Y', strtotime($tanggal)) }}</td>
        </tr>
        <tr>
            <td>Nik</td>
            <td>{{ $karyawan->nik }}</td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>{{ $karyawan->nama_lengkap }}</td>
        </tr>
    </table>
    <div class="row mb-3">
        <div class="col-12">
            <div class="form-group">
                <select name="status" id="status" class="form-select">
                    <option value="">Status Kehadiran</option>
                    <option
                        @if ($cekpresensi != null) @if ($cekpresensi->status === 'h')
                        selected @endif
                        @endif
                        value="h">Hadir</option>
                    <option
                        @if ($cekpresensi != null) @if ($cekpresensi->status === 'a')
                        selected @endif
                        @endif value="a">Tidak Hadir</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row mb-3" id="frm_jamkerja">
        <div class="col-12">
            <div class="form-group">
                <select name="kode_jam_kerja" id="kode_jam_kerja" class="form-select">
                    <option value="">Pilih Jam Kerja</option>
                    @foreach ($jamkerja as $d)
                        <option
                            @if ($cekpresensi != null) @if ($cekpresensi->kode_jam_kerja === $d->kode_jam_kerja)
                        selected @endif
                            @endif
                            value="{{ $d->kode_jam_kerja }}">{{ $d->nama_jam_kerja }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row mb-3" id="frmJam_in">
        <div class="col-12">
            <div class="input-icon">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-clock-edit">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M21 12a9 9 0 1 0 -9.972 8.948c.32 .034 .644 .052 .972 .052" />
                        <path d="M12 7v5l2 2" />
                        <path d="M18.42 15.61a2.1 2.1 0 0 1 2.97 2.97l-3.39 3.42h-3v-3l3.42 -3.39z" />
                    </svg>
                </span>
                <input type="text" value="{{ $cekpresensi != null ? $cekpresensi->jam_in : '' }}"
                    class="form-control" id="jam_in" name="jam_in" placeholder="Jam Masuk" autocomplete="off">
            </div>
        </div>
    </div>
    <div class="row mb-3" id="frmjam_out">
        <div class="col-12">
            <div class="input-icon">
                <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-clock-edit">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M21 12a9 9 0 1 0 -9.972 8.948c.32 .034 .644 .052 .972 .052" />
                        <path d="M12 7v5l2 2" />
                        <path d="M18.42 15.61a2.1 2.1 0 0 1 2.97 2.97l-3.39 3.42h-3v-3l3.42 -3.39z" />
                    </svg>
                </span>
                <input type="text" value="{{ $cekpresensi != null ? $cekpresensi->jam_out : '' }}"
                    class="form-control" id="jam_out" name="jam_out" placeholder="Jam Pulang" autocomplete="off">
            </div>
        </div>
    </div>


    <div class="row mt-3">
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

        function loadkoreksi() {
            var status = $("#status").val();
            if (status == 'a') {
                $("#frmJam_in").hide();
                $("#frmjam_out").hide();
                $("#frm_jamkerja").hide();
            } else {
                $("#frmJam_in").show();
                $("#frmjam_out").show();
                $("#frm_jamkerja").show();
            }
        }
        loadkoreksi();
        $("#status").change(function(e) {
            loadkoreksi();
        });

        $('#jam_in').mask('00:00');
        $('#jam_out').mask('00:00');

        $("#frmKoreksiAbsensi").submit(function() {
            var jam_in = $("#jam_in").val();
            var jam_out = $("#jam_out").val();
            var kode_jam_kerja = $("#kode_jam_kerja").val();
            var status = $("#status").val();

            if (status == "") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Status Kehadiran Masih Kososng!',
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                }).then((result) => {
                    $("#status").focus();
                });
                return false;
            } else if (kode_jam_kerja == "" && status == "h") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Jam Kerja Masih Kososng!',
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                }).then((result) => {
                    $("#kode_jam_kerja").focus();
                });
                return false;
            } else if (jam_in == "" && status == "h") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Jam Masuk Masih Kososng!',
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                }).then((result) => {
                    $("#jam_in").focus();
                });
                return false;
            } else if (jam_out == "" && status == "h") {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Jam Pulang Masih Kososng!',
                    icon: 'warning',
                    confirmButtonText: 'Ok'
                }).then((result) => {
                    $("#jam_out").focus();
                });
                return false;
            }
        });
    });
</script>
