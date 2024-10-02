<div class="row mb-1">
    <div class="col-4">
        <div class="form-group">
            <select name="bulan" id="bulan" class="form-select">
                <option value="">Pilih Bulan</option>
                @for ($b = 1; $b <= 12; $b++)
                    <option {{ $b == date('m') ? 'selected' : '' }} value="{{ $b }}">{{ $namabulan[$b] }}
                    </option>
                @endfor
            </select>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <select name="tahun" id="tahun" class="form-select">Pilih
                Tahun
                @php
                    $tahun_mulai = '2023';
                    $tahun_akhir = date('Y');
                @endphp
                @for ($t = $tahun_mulai; $t <= $tahun_akhir; $t++)
                    <option {{ $t == date('Y') ? 'selected' : '' }} value="{{ $t }}">{{ $t }}
                    </option>
                @endfor
            </select>

        </div>
    </div>
</div>
<hr>
<div class="row mb-1">
    <div class="col-12">
        <div class="row">
            <div class="col-6">
                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-calendar">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M16 2a1 1 0 0 1 .993 .883l.007 .117v1h1a3 3 0 0 1 2.995 2.824l.005 .176v12a3 3 0 0 1 -2.824 2.995l-.176 .005h-12a3 3 0 0 1 -2.995 -2.824l-.005 -.176v-12a3 3 0 0 1 2.824 -2.995l.176 -.005h1v-1a1 1 0 0 1 1.993 -.117l.007 .117v1h6v-1a1 1 0 0 1 1 -1zm3 7h-14v9.625c0 .705 .386 1.286 .883 1.366l.117 .009h12c.513 0 .936 -.53 .993 -1.215l.007 -.16v-9.625z" />
                            <path
                                d="M12 12a1 1 0 0 1 .993 .883l.007 .117v3a1 1 0 0 1 -1.993 .117l-.007 -.117v-2a1 1 0 0 1 -.117 -1.993l.117 -.007h1z" />
                        </svg>
                    </span>
                    <input type="text" value="" class="form-control" id="tanggal" placeholder="Tanggal"
                        name="tanggal" autocomplete="off">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <select name="kode_jam_kerja" id="kode_jam_kerja" class="form-select">
                        <option value="">Pilih Jam Kerja</option>
                        @foreach ($jamkerja as $d)
                            <option value="{{ $d->kode_jam_kerja }}">
                                {{ $d->nama_jam_kerja }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <button id="tambahjamkerja" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-plus">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12.5 21h-6.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v5" />
                            <path d="M16 3v4" />
                            <path d="M8 3v4" />
                            <path d="M4 11h16" />
                            <path d="M16 19h6" />
                            <path d="M19 16v6" />
                        </svg>

                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <table class="table table-bordered">
            <thead style="text-align: center">
                <th>No</th>
                <th>Tanggal</th>
                <th>Jam Kerja</th>
                <th>Aksi</th>
            </thead>
            <tbody id="loadsetjamkerjabydate"></tbody>
        </table>
    </div>
</div>
