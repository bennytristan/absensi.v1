@foreach ($konfigurasijamkerjabytgl as $d)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ date('d-m-Y', strtotime($d->tanggal)) }}</td>
        <td>{{ $d->nama_jam_kerja }}</td>
        <td>
            <a href="#" class="btn btn-danger btn-sm hapus" nik="{{ $d->nik }}"
                tanggal="{{ $d->tanggal }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="icon icon-tabler icons-tabler-trash">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M4 7l16 0" />
                    <path d="M10 11l0 6" />
                    <path d="M14 11l0 6" />
                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                </svg></a>
        </td>
    </tr>
@endforeach

<script>
    $(function() {

        function loadsetjamkerjabydate() {
            var nik = "{{ $nik }}";
            $("#loadsetjamkerjabydate").load('/konfigurasi/' + nik + '/' + bulan + '/' + tahun +
                '/getjamkerjabytgl');
        }

        $(".hapus").click(function(e) {
            e.preventDefault();
            var nik = $(this).attr("nik");
            var tanggal = $(this).attr("tanggal");
            $.ajax({
                type: 'POST',
                url: '/konfigurasi/deletejamkerjabytgl',
                data: {
                    _token: '{{ csrf_token() }}',
                    nik: nik,
                    tanggal: tanggal,
                },
                cache: false,
                success: function(respond) {
                    if (respond == 0) {
                        Swal.fire({
                            title: 'Berhasil',
                            text: 'Data Berhasil Dihapus',
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        }).then((result) => {
                            loadsetjamkerjabydate();
                        });
                    } else {
                        Swal.fire({
                            title: 'Gagal',
                            text: 'Data Gagal Dihapus',
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        }).then((result) => {
                            loadsetjamkerjabydate();
                        });
                    }
                }
            });
        });
    });
</script>
