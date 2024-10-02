@extends('layout.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Pengaturan Jam Kerja Departemen
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <form action="/konfigurasi/jamkerjadept/store" method="POST">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <select name="kode_cabang" id="nama_cabang" class="form-select" required>
                                        <option value="">Pilih Cabang</option>
                                        @foreach ($cabang as $d)
                                            <option value="{{ $d->kode_cabang }}">{{ strtoupper($d->nama_cabang) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <select name="kode_dept" id="nama_dept" class="form-select" required>
                                        <option value="">Pilih Departemen</option>
                                        @foreach ($departemen as $d)
                                            <option value="{{ $d->kode_dept }}">{{ strtoupper($d->nama_dept) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-4">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Hari</th>
                                    <th>Jam Kerja</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        Senin
                                        <input type="hidden" name="hari[]" value="senin">
                                    </td>
                                    <td>
                                        <select name="kode_jam_kerja[]" id="kode_jam_kerja" class="form-select" required>
                                            <option value="">Pilih Jam Kerja</option>
                                            @foreach ($jamkerja as $d)
                                                <option value="{{ $d->kode_jam_kerja }}">{{ $d->nama_jam_kerja }}</option>
                                            @endforeach
                                        </select>

                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Selasa
                                        <input type="hidden" name="hari[]" value="selasa">
                                    </th>
                                    <td><select name="kode_jam_kerja[]" id="kode_jam_kerja" class="form-select" required>
                                            <option value="">Pilih Jam Kerja</option>
                                            @foreach ($jamkerja as $d)
                                                <option value="{{ $d->kode_jam_kerja }}">{{ $d->nama_jam_kerja }}</option>
                                            @endforeach
                                        </select></td>
                                </tr>
                                <tr>
                                    <th>
                                        Rabu
                                        <input type="hidden" name="hari[]" value="rabu">
                                    </th>
                                    <td><select name="kode_jam_kerja[]" id="kode_jam_kerja" class="form-select" required>
                                            <option value="">Pilih Jam Kerja</option>
                                            @foreach ($jamkerja as $d)
                                                <option value="{{ $d->kode_jam_kerja }}">{{ $d->nama_jam_kerja }}</option>
                                            @endforeach
                                        </select></td>
                                </tr>
                                <tr>
                                    <th>
                                        Kamis
                                        <input type="hidden" name="hari[]" value="kamis">
                                    </th>
                                    <td><select name="kode_jam_kerja[]" id="kode_jam_kerja" class="form-select" required>
                                            <option value="">Pilih Jam Kerja</option>
                                            @foreach ($jamkerja as $d)
                                                <option value="{{ $d->kode_jam_kerja }}">{{ $d->nama_jam_kerja }}</option>
                                            @endforeach
                                        </select></td>
                                </tr>
                                <tr>
                                    <th>
                                        Jumat
                                        <input type="hidden" name="hari[]" value="jumat">
                                    </th>
                                    <td><select name="kode_jam_kerja[]" id="kode_jam_kerja" class="form-select" required>
                                            <option value="">Pilih Jam Kerja</option>
                                            @foreach ($jamkerja as $d)
                                                <option value="{{ $d->kode_jam_kerja }}">{{ $d->nama_jam_kerja }}</option>
                                            @endforeach
                                        </select></td>
                                </tr>
                                <tr>
                                    <th>
                                        Sabtu
                                        <input type="hidden" name="hari[]" value="sabtu">
                                    </th>
                                    <td><select name="kode_jam_kerja[]" id="kode_jam_kerja" class="form-select">
                                            <option value="">Pilih Jam Kerja</option>
                                            @foreach ($jamkerja as $d)
                                                <option value="{{ $d->kode_jam_kerja }}">{{ $d->nama_jam_kerja }}</option>
                                            @endforeach
                                        </select></td>
                                </tr>
                                <tr>
                                    <th>
                                        Minggu
                                        <input type="hidden" name="hari[]" value="minggu">
                                    </th>
                                    <td><select name="kode_jam_kerja[]" id="kode_jam_kerja" class="form-select">
                                            <option value="">Pilih Jam Kerja</option>
                                            @foreach ($jamkerja as $d)
                                                <option value="{{ $d->kode_jam_kerja }}">{{ $d->nama_jam_kerja }}</option>
                                            @endforeach
                                        </select></td>
                                </tr>
                            </tbody>
                        </table>
                        <button class="btn btn-primary w-100" type="submit">Simpan</button>


                    </div>
                    <div class="col-8">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="8">Master Jam Kerja</th>
                                </tr>
                                <tr>
                                    <th>Kode Kerja</th>
                                    <th>Nama Jam Kerja</th>
                                    <th>Awal Jam Masuk</th>
                                    <th>Jam Masuk</th>
                                    <th>Akhir Jam Masuk</th>
                                    <th>Jam Pulang</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jamkerja as $d)
                                    <tr>
                                        <td>{{ $d->kode_jam_kerja }}</td>
                                        <td>{{ $d->nama_jam_kerja }}</td>
                                        <td>{{ $d->awal_jam_masuk }}</td>
                                        <td>{{ $d->jam_masuk }}</td>
                                        <td>{{ $d->akhir_jam_masuk }}</td>
                                        <td>{{ $d->jam_pulang }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
