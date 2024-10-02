@foreach ($presensi as $d)
    @php
        $foto_in = Storage::url('uploads/absensi/' . $d->foto_in);
        $foto_out = Storage::url('uploads/absensi/' . $d->foto_out);
    @endphp
    @if ($d->status == 'h')
        <tr>
            <td style="text-align: center">{{ $loop->iteration }}</td>
            <td style="text-align: center">{{ $d->nik }}</td>
            <td>{{ $d->nama_lengkap }}</td>
            <td style="text-align: center">{{ $d->kode_cabang }}</td>
            <td style="text-align: center">{{ $d->kode_dept }}</td>
            <td style="text-align: center">
                <span class="badge bg-primary">{{ strtoupper($d->nama_jam_kerja) }}</span>
            </td>
            {{-- {{ $d->nama_jam_kerja }} {{ $d->jam_masuk }} s/d {{ $d->jam_pulang }}</td> --}}
            <td style="text-align: center">{{ $d->jam_in }}</td>
            <td style="text-align: center">
                @if ($d->foto_in != null)
                    <img src="{{ url($foto_in) }}" alt="" class="avatar">
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-photo-off">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M15 8h.01" />
                        <path
                            d="M7 3h11a3 3 0 0 1 3 3v11m-.856 3.099a2.991 2.991 0 0 1 -2.144 .901h-12a3 3 0 0 1 -3 -3v-12c0 -.845 .349 -1.608 .91 -2.153" />
                        <path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l5 5" />
                        <path d="M16.33 12.338c.574 -.054 1.155 .166 1.67 .662l3 3" />
                        <path d="M3 3l18 18" />
                    </svg>
                @endif
            </td>
            <td style="text-align: center">{!! $d->jam_out != null ? $d->jam_out : '<span class="badge bg-danger">BELUM ABSEN</span>' !!}</td>
            <td style="text-align: center">
                @if ($d->foto_out != null)
                    <img src="{{ url($foto_out) }}" alt="" class="avatar">
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-photo-off">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M15 8h.01" />
                        <path
                            d="M7 3h11a3 3 0 0 1 3 3v11m-.856 3.099a2.991 2.991 0 0 1 -2.144 .901h-12a3 3 0 0 1 -3 -3v-12c0 -.845 .349 -1.608 .91 -2.153" />
                        <path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l5 5" />
                        <path d="M16.33 12.338c.574 -.054 1.155 .166 1.67 .662l3 3" />
                        <path d="M3 3l18 18" />
                    </svg>
                @endif
            </td>
            <td style="text-align: center">
                @if ($d->status == 'h')
                    <span class="badge bg-black">H</span>
                @endif
            </td>
            <td>
                @if ($d->jam_in >= $d->jam_masuk)
                    @php
                        $jamterlambat = selisih($d->jam_masuk, $d->jam_in);
                    @endphp
                    <span class="badge bg-danger">TERLAMBAT : {{ $jamterlambat }}</span>
                @else
                    <span class="badge bg-success">TEPAT WAKTU</span>
                @endif
            </td>
            <td style="text-align: center">
                @if ($d->lokasi_in != null)
                    <a href="#" class="badge bg-primary badge-sm showmap" id="{{ $d->id }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map-2"
                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M18 6l0 .01"></path>
                            <path d="M18 13l-3.5 -5a4 4 0 1 1 7 0l-3.5 5"></path>
                            <path d="M10.5 4.75l-1.5 -.75l-6 3l0 13l6 -3l6 3l6 -3l0 -2"></path>
                            <path d="M9 4l0 13"></path>
                            <path d="M15 15l0 5"></path>
                        </svg>
                    </a>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map-2" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M18 6l0 .01"></path>
                        <path d="M18 13l-3.5 -5a4 4 0 1 1 7 0l-3.5 5"></path>
                        <path d="M10.5 4.75l-1.5 -.75l-6 3l0 13l6 -3l6 3l6 -3l0 -2"></path>
                        <path d="M9 4l0 13"></path>
                        <path d="M15 15l0 5"></path>
                    </svg>
                @endif
            </td>
            <td>
                <a href="#" class="btn btn-success btn-sm koreksiAbsensi" nik="{{ $d->nik }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                        <path d="M16 5l3 3" />
                    </svg>Koreksi</a>
            </td>
        </tr>
    @else
        <tr>
            <td style="text-align: center">{{ $loop->iteration }}</td>
            <td style="text-align: center">{{ $d->nik }}</td>
            <td>{{ $d->nama_lengkap }}</td>
            <td style="text-align: center">{{ $d->kode_cabang }}</td>
            <td style="text-align: center">{{ $d->kode_dept }}</td>
            <td style="text-align: center"><span class="badge bg-danger">BELUM ABSEN</span></td>
            <td style="text-align: center"><span class="badge bg-danger">BELUM ABSEN</span></td>
            <td style="text-align: center"><span class="badge bg-danger">BELUM ABSEN</span></td>
            <td style="text-align: center"><span class="badge bg-danger">BELUM ABSEN</span></td>
            <td style="text-align: center"><span class="badge bg-danger">BELUM ABSEN</span></td>
            <td style="text-align: center">
                @if ($d->status == 'i')
                    <span class="badge bg-orange">I</span>
                @elseif ($d->status == 's')
                    <span class="badge bg-warning">S</span>
                @elseif ($d->status == 'a')
                    <span class="badge bg-danger">A</span>
                @elseif ($d->status == 'c')
                    <span class="badge bg-blue">C</span>
                @endif
            </td>
            <td style="text-align: center">
                @if ($d->status == 'i')
                    <span class="badge bg-orange">{{ $d->kode_ijin }}</span>
                @elseif ($d->status == 's')
                    <span class="badge bg-warning">{{ $d->kode_ijin }}</span>
                @elseif ($d->status == 'a')
                    <span class="badge bg-danger">{{ $d->kode_ijin }}</span>
                @elseif ($d->status == 'c')
                    <span class="badge bg-blue">{{ $d->kode_ijin }}</span>
                @else
                    <span>-</span>
                @endif
            </td>
            <td style="text-align: center"></td>
            <td>
                <a href="#" class="btn btn-success btn-sm koreksiAbsensi" nik="{{ $d->nik }}"><svg
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                        <path d="M16 5l3 3" />
                    </svg>Koreksi</a>
            </td>
        </tr>
    @endif
@endforeach

<script>
    $(function() {
        $('.showmap').click(function(e) {
            var id = $(this).attr('id');
            $.ajax({
                type: 'POST',
                url: '/showmaps',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                cache: false,
                success: function(respond) {
                    $("#loadmap").html(respond);
                }
            });
            $('#modal-showmap').modal("show");
        });

        $('.koreksiAbsensi').click(function(e) {
            var nik = $(this).attr('nik');
            var tanggal = "{{ $tanggal }}";

            $.ajax({
                type: 'POST',
                url: '/koreksiabsensi',
                data: {
                    _token: "{{ csrf_token() }}",
                    nik: nik,
                    tanggal: tanggal
                },
                cache: false,
                success: function(respond) {
                    $("#loadkoreksiabsensi").html(respond);
                }
            });
            $('#modal-koreksiAbsen').modal("show");
        });
    });
</script>
