<div class="row mt-2">
    <div class="col-12">
        <table class="table table-bordered">
            <thead style="text-align: center">
                <tr>
                    <th>No</th>
                    <th>Nik</th>
                    <th>Nama Karyawan</th>
                    <th>Jabatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="loadlistkaryawanlibur"></tbody>
        </table>
    </div>
</div>

<script>
    $(function() {
        function loadlistkaryawanlibur() {
            var kode_libur = "{{ $kode_libur }}";
            $("#loadlistkaryawanlibur").load('/konfigurasi/harilibur/' + kode_libur +
                '/getsetlistkaryawanlibur');
        }
        loadlistkaryawanlibur();
    });
</script>
