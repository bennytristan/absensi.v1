@extends('layout.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Data Set Jam Kerja Departemen
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <select name="kode_cabang" id="kode_cabang" class="form-select" disabled>
                                    <option value="">Pilih Cabang</option>
                                    @foreach ($cabang as $d)
                                        <option {{ $jamkerjadept->kode_cabang == $d->kode_cabang ? 'selected' : '' }}
                                            value="{{ $d->kode_cabang }}">{{ strtoupper($d->nama_cabang) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <select name="kode_dept" id="nama_dept" class="form-select" disabled>
                                    <option value="">Pilih Departemen</option>
                                    @foreach ($departemen as $d)
                                        <option {{ $jamkerjadept->kode_dept == $d->kode_dept ? 'selected' : '' }}
                                            value="{{ $d->kode_dept }}">{{ strtoupper($d->nama_dept) }}</option>
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
                            @foreach ($jamkerjadetail as $s)
                                <tr>
                                    <td>
                                        {{ $s->hari }}
                                        <input type="hidden" name="hari[]" value="{{ $s->hari }}">
                                    </td>
                                    <td>
                                        {{ $s->nama_jam_kerja }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

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

        </div>
    </div>
@endsection
