@extends('layout.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-fluid">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Pengaturan Jam Kerja
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    @if (Session::get('success'))
                                        <div class="alert alert-success">
                                            {{ Session::get('success') }}
                                        </div>
                                    @endif

                                    @if (Session::get('warning'))
                                        <div class="alert alert-warning">
                                            {{ Session::get('warning') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <a href="#" class="btn btn-primary" id="btnTambahJk">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M12 5l0 14" />
                                            <path d="M5 12l14 0" />
                                        </svg>
                                        Tambah Data Jam Kerja
                                    </a>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <table class="table table-bordered">
                                        <thead style="text-align: center">
                                            <tr>
                                                <th>No</th>
                                                <th>Kode JK</th>
                                                <th>Nama JK</th>
                                                <th>Awal Jam Masuk</th>
                                                <th>Jam Masuk</th>
                                                <th>Akhir Jam Masuk</th>
                                                <th>Jam Pulang</th>
                                                <th>Total Jam</th>
                                                <th>Istirahat</th>
                                                <th>Awal Istirahat</th>
                                                <th>Akhir Istirahat</th>
                                                <th>Lintas Hari</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($jam_kerja as $d)
                                                <tr>
                                                    <td style="text-align: center">{{ $loop->iteration }}</td>
                                                    <td style="text-align: center">{{ $d->kode_jam_kerja }}</td>
                                                    <td>{{ $d->nama_jam_kerja }}</td>
                                                    <td style="text-align: center">{{ $d->awal_jam_masuk }}</td>
                                                    <td style="text-align: center">{{ $d->jam_masuk }} </td>
                                                    <td style="text-align: center">{{ $d->akhir_jam_masuk }} </td>
                                                    <td style="text-align: center">{{ $d->jam_pulang }} </td>
                                                    <td class="text-center">{{ $d->total_jam }}</td>
                                                    <td style="text-align: center">
                                                        @if ($d->status_istirahat == 1)
                                                            <span class="badge bg-success"><svg
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-checkbox">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                    <path d="M9 11l3 3l8 -8" />
                                                                    <path
                                                                        d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9" />
                                                                </svg></span>
                                                        @else
                                                            <span class="badge bg-danger text-center"><svg
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-cancel">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                                                    <path d="M18.364 5.636l-12.728 12.728" />
                                                                </svg></span>
                                                        @endif
                                                    </td>
                                                    <td style="text-align: center">{{ $d->awal_jam_istirahat }}</td>
                                                    <td style="text-align: center">{{ $d->akhir_jam_istirahat }}</td>
                                                    <td style="text-align: center">
                                                        @if ($d->lintashari == 1)
                                                            <span class="badge bg-success" data-bs-toggle="tooltip"
                                                                data-bs-placement="bottom" title="Lintas Hari Aktif"><svg
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-checkbox">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                    <path d="M9 11l3 3l8 -8" />
                                                                    <path
                                                                        d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9" />
                                                                </svg></span>
                                                        @else
                                                            <span class="badge bg-danger" data-bs-toggle="tooltip"
                                                                data-bs-placement="bottom"
                                                                title="Lintas Hari Tidak Aktif"><svg
                                                                    xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-cancel">
                                                                    <path stroke="none" d="M0 0h24v24H0z"
                                                                        fill="none" />
                                                                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                                                    <path d="M18.364 5.636l-12.728 12.728" />
                                                                </svg></span>
                                                        @endif
                                                    </td>
                                                    <td style="text-align: center">
                                                        <div class="btn-group">
                                                            <a href="#" class="edit badge bg-info badge-sm"
                                                                kode_jam_kerja="{{ $d->kode_jam_kerja }}"
                                                                data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                                title="Ubah">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                                    <path stroke="none" d="M0 0h24v24H0z"
                                                                        fill="none" />
                                                                    <path
                                                                        d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                                    <path
                                                                        d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                                    <path d="M16 5l3 3" />
                                                                </svg>
                                                            </a>
                                                            <form
                                                                action="/konfigurasi/jamkerja/{{ $d->kode_jam_kerja }}/delete"
                                                                method="POST" style="margin-left: 5px">
                                                                @csrf
                                                                <a class="badge bg-danger badge-sm delete-confirm"
                                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                                    title="Hapus">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-trash-x">
                                                                        <path stroke="none" d="M0 0h24v24H0z"
                                                                            fill="none" />
                                                                        <path d="M4 7h16" />
                                                                        <path
                                                                            d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                        <path
                                                                            d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                                        <path d="M10 12l4 4m0 -4l-4 4" />
                                                                    </svg>
                                                                </a>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Tambah --}}
    <div class="modal modal-blur fade" id="modal-inputjk" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Jam Kerja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/konfigurasi/storejamkerja" method="POST" id="frmJk">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="input-icon mb-2">
                                    <span class="input-icon-addon">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-qrcode">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M4 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                            <path d="M7 17l0 .01" />
                                            <path
                                                d="M14 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                            <path d="M7 7l0 .01" />
                                            <path
                                                d="M4 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                            <path d="M17 7l0 .01" />
                                            <path d="M14 14l3 0" />
                                            <path d="M20 14l0 .01" />
                                            <path d="M14 14l0 3" />
                                            <path d="M14 20l3 0" />
                                            <path d="M17 17l3 0" />
                                            <path d="M20 17l0 3" />
                                        </svg>
                                    </span>
                                    <input type="text" value="" class="form-control" id="kode_jam_kerja"
                                        placeholder="Kode Jam Kerja" name="kode_jam_kerja" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="input-icon mb-2">
                                    <span class="input-icon-addon">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-file-time">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                            <path
                                                d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                            <path d="M12 14m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                            <path d="M12 12.496v1.504l1 1" />
                                        </svg>
                                    </span>
                                    <input type="text" value="" class="form-control" id="nama_jam_kerja"
                                        name="nama_jam_kerja" placeholder="Nama Jam Kerja" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="input-icon mb-2">
                                    <span class="input-icon-addon">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-clock-check">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M20.942 13.021a9 9 0 1 0 -9.407 7.967" />
                                            <path d="M12 7v5l3 3" />
                                            <path d="M15 19l2 2l4 -4" />
                                        </svg>
                                    </span>
                                    <input type="text" value="" class="form-control" id="awal_jam_masuk"
                                        name="awal_jam_masuk" placeholder="Awal Jam Kerja" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="input-icon mb-2">
                                    <span class="input-icon-addon">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-clock-hour-8">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                            <path d="M12 12l-3 2" />
                                            <path d="M12 7v5" />
                                        </svg>
                                    </span>
                                    <input type="text" value="" class="form-control" id="jam_masuk"
                                        name="jam_masuk" placeholder="Jam Masuk" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="input-icon mb-2">
                                    <span class="input-icon-addon">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-alarm">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M12 13m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                            <path d="M12 10l0 3l2 0" />
                                            <path d="M7 4l-2.75 2" />
                                            <path d="M17 4l2.75 2" />
                                        </svg>
                                    </span>
                                    <input type="text" value="" class="form-control" id="akhir_jam_masuk"
                                        name="akhir_jam_masuk" placeholder="Akhir Jam Masuk" autocomplete="off">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="input-icon mb-2">
                                    <span class="input-icon-addon">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-clock-stop">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M21 12a9 9 0 1 0 -9 9" />
                                            <path d="M12 7v5l1 1" />
                                            <path d="M16 16h6v6h-6z" />
                                        </svg>
                                    </span>
                                    <input type="text" value="" class="form-control" id="jam_pulang"
                                        name="jam_pulang" placeholder="Jam Pulang" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="input-icon mb-2">
                                    <span class="input-icon-addon">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-clock-stop">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M21 12a9 9 0 1 0 -9 9" />
                                            <path d="M12 7v5l1 1" />
                                            <path d="M16 16h6v6h-6z" />
                                        </svg>
                                    </span>
                                    <input type="text" value="" class="form-control" id="total_jam"
                                        name="total_jam" placeholder="Total Jam" autocomplete="off">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <select name="status_rehat" id="status_rehat" class="form-select">
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
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-alarm">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M12 13m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                            <path d="M12 10l0 3l2 0" />
                                            <path d="M7 4l-2.75 2" />
                                            <path d="M17 4l2.75 2" />
                                        </svg>
                                    </span>
                                    <input type="text" value="" class="form-control" id="awal_rehat"
                                        name="awal_rehat" placeholder="Awal Jam Istirahat" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row setjamrehat">
                            <div class="col-12">
                                <div class="input-icon mb-2">
                                    <span class="input-icon-addon">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-alarm">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M12 13m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                            <path d="M12 10l0 3l2 0" />
                                            <path d="M7 4l-2.75 2" />
                                            <path d="M17 4l2.75 2" />
                                        </svg>
                                    </span>
                                    <input type="text" value="" class="form-control" id="akhir_rehat"
                                        name="akhir_rehat" placeholder="Akhir Jam Istirahat" autocomplete="off">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <select name="lintashari" id="lintashari" class="form-select">
                                        <option value="">Litas Hari</option>
                                        <option value="1">Ya</option>
                                        <option value="0">Tidak</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="form-group">
                                    <button class="btn btn-primary w-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-send">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M10 14l11 -11" />
                                            <path
                                                d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5" />
                                        </svg>
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div class="modal modal-blur fade" id="modal-editjk" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Jam Kerja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="loadeditform">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('myscript')
    <script>
        $(function() {

            function showsetjamrehat() {
                var status_rehat = $("#status_rehat").val();
                if (status_rehat == "1") {
                    $(".setjamrehat").show();
                } else {
                    $(".setjamrehat").hide();
                }
            }

            $("#status_rehat").change(function() {
                showsetjamrehat();
            });
            showsetjamrehat();

            $('#kode_jam_kerja').mask('AAAAA');
            $('#awal_jam_masuk, #jam_masuk, #akhir_jam_masuk, #jam_pulang, #awal_rehat, #akhir_rehat')
                .mask('00:00');
            $("#total_jam").mask("0");
            $("#btnTambahJk").click(function() {
                $("#modal-inputjk").modal("show");
            });

            $(".delete-confirm").click(function(e) {
                var form = $(this).closest('form');
                e.preventDefault();
                Swal.fire({
                    title: "Anda yakin akan menghapus Data ini?",
                    text: "Jika YA data akan terhapus permanen!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Hapus Data ini!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                        Swal.fire({
                            title: "Deleted!",
                            text: "Data Berhasil Dihapus.",
                            icon: "success"
                        });
                    }
                })
            });

            $("#frmJk").submit(function() {
                var kode_jam_kerja = $("#kode_jam_kerja").val();
                var nama_jam_kerja = $("#nama_jam_kerja").val();
                var awal_jam_masuk = $("#awal_jam_masuk").val();
                var jam_masuk = $("#jam_masuk").val();
                var akhir_jam_masuk = $("#akhir_jam_masuk").val();
                var awal_rehat = $("#awal_rehat").val();
                var akhir_rehat = $("#akhir_rehat").val();
                var jam_pulang = $("#jam_pulang").val();
                var total_jam = $("#total_jam").val();
                var status_rehat = $("#status_rehat").val();
                var lintashari = $("#lintashari").val();

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

            $(".edit").click(function() {
                var kode_jam_kerja = $(this).attr('kode_jam_kerja');
                $.ajax({
                    type: 'POST',
                    url: '/konfigurasi/editjamkerja',
                    cache: false,
                    data: {
                        _token: "{{ csrf_token() }}",
                        kode_jam_kerja: kode_jam_kerja
                    },
                    success: function(respond) {
                        $("#loadeditform").html(respond);
                    }
                });
                $("#modal-editjk").modal("show");
            });
        });
    </script>
@endpush
