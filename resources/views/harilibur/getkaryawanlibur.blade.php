@foreach ($karyawanlibur as $d)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $d->nik }}</td>
        <td>{{ $d->nama_lengkap }}</td>
        <td>{{ $d->jabatan }}</td>
        <td>
            <a href="#" class="btn btn-danger btn-sm batallibur" nik="{{ $d->nik }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-square-x">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M3 5a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-14z" />
                    <path d="M9 9l6 6m0 -6l-6 6" />
                </svg></a>
        </td>
    </tr>
@endforeach

<script>
    $(function() {
        function loadlkaryawanlibur() {
            var kode_libur = "{{ $kode_libur }}";
            $("#loadkaryawanlibur").load('/konfigurasi/harilibur/' + kode_libur + '/getkaryawanlibur');
        }

        $(".batallibur").click(function(e) {
            var kode_libur = "{{ $kode_libur }}";
            var nik = $(this).attr('nik');
            $.ajax({
                type: 'POST',
                url: '/konfigurasi/harilibur/batallibur',
                data: {
                    _token: "{{ csrf_token() }}",
                    kode_libur: kode_libur,
                    nik: nik,
                },
                cache: false,
                success: function(respond) {
                    if (respond == "0") {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Data Berhasil Dihapus',
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        })
                        loadlkaryawanlibur();
                    } else if (respond == "1") {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Gagal Dibatalkan!',
                            icon: 'warning',
                            confirmButtonText: 'Ok'
                        });
                    } else {
                        Swal.fire({
                            title: 'Opss!',
                            text: respond,
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        })
                    }
                }
            });
        });
    });
</script>
