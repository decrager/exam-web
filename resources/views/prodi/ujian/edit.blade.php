@extends('layouts.app')

@section('main-content')
    <!-- header area start -->
    <div class="header-area">
        <div class="row align-items-center">
            <!-- nav and search button -->
            <div class="col-md-6 col-sm-8 clearfix">
                <div class="nav-btn pull-left">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
            <!-- profile info & task notification -->
            @include('layouts.profile')
        </div>
    </div>
    <!-- header area end -->

    <!-- page title area start -->
    <div class="page-title-area mb-3">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="breadcrumbs-area clearfix">
                    <h4 class="page-title pull-left">Ubah Jadwal Ujian</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a >Beranda</a></li>
                        <li><a ><span>Jadwal Ujian</span></a></li>
                        <li><span>Ubah Jadwal Ujian</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- page title area end -->
    <div class="main-content-inner">
        <div class="row">
            <div class="col-lg-12 col-ml-12">
                <div class="row">
                    <!-- Textual inputs start -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('prodi.ujian.update', $ujian?->id) }}" method="POST">
                                    <h4 class="header-title">Ubah Jadwal Ujian Periode
                                        @if ($master?->isuas == 1)
                                            UAS
                                        @else
                                            UTS
                                        @endif
                                    </h4>

                                    @csrf
                                    @method('PUT')

                                    <div class="form-group">
                                        <label for="tahun" class="col-form-label">Tahun Ajaran</label>
                                        <input class="form-control" type="text" readonly name="tahun"
                                            value="{{ $master?->thn_ajaran }}" id="tahun" />
                                    </div>

                                    <div class="form-group">
                                        <label for="prodi" class="col-form-label">Program Studi</label>
                                        <input class="form-control" type="text" readonly id="prodi"
                                            value="{{ $ujian?->Matkul?->Semester?->Prodi?->nama_prodi }}" />
                                    </div>

                                    <div class="form-group">
                                        <label for="semester" class="col-form-label">Semester</label>
                                        <input class="form-control" type="text" readonly id="semester"
                                            value="{{ $ujian?->Matkul?->Semester?->semester }}" />
                                    </div>

                                    <div class="form-group">
                                        <label for="Kelas" class="col-form-label">Kelas - Praktikum</label>
                                        <input class="form-control" type="text" readonly id="Kelas"
                                            value="{{ $ujian?->Praktikum?->Kelas?->kelas }} - {{ $ujian?->Praktikum?->praktikum }}" />
                                    </div>

                                    <div class="form-group">
                                        <label for="MataKuliah" class="col-form-label">Mata Kuliah - Tipe</label>
                                        <input class="form-control" type="text" readonly id="MataKuliah"
                                            value="{{ $ujian?->Matkul?->nama_matkul }} - {{ $ujian?->tipe_mk }}" />
                                    </div>

                                    <div class="form-group">
                                        <label for="Hari" class="col-form-label">Hari</label>
                                        <input class="form-control" type="text" readonly id="Hari"
                                            value="{{ $ujian?->hari }}" />
                                    </div>

                                    <div class="form-group">
                                        <label for="Tanggal" class="col-form-label">Tanggal</label>
                                        <input class="form-control" type="text" readonly id="Tanggal"
                                            value="{{ $ujian?->tanggal }}" />
                                    </div>

                                    <div class="form-group">
                                        <label for="Jam_Mulai" class="col-form-label">Jam Mulai</label>
                                        <input class="form-control" type="text" readonly id="Jam_Mulai"
                                            value="{{ $ujian?->jam_mulai }}" />
                                    </div>

                                    <div class="form-group">
                                        <label for="Jam_Mulai" class="col-form-label">Jam Selesai</label>
                                        <input class="form-control" type="text" readonly id="Jam_Mulai"
                                            value="{{ $ujian?->jam_selesai }}" />
                                    </div>

                                    <div class="form-group">
                                        <label for="Sesi" class="col-form-label">Sesi</label>
                                        <input class="form-control" type="text" readonly id="Sesi"
                                            value="{{ $ujian?->sesi }}" />
                                    </div>

                                    <div class="form-group">
                                        <label for="Pelaksanaan" class="col-form-label">Pelaksanaan</label>
                                        <input class="form-control" type="text" readonly id="Pelaksanaan"
                                            value="{{ $ujian?->pelaksanaan }}" />
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Lokasi</label>
                                        <select class="custom-select" name="lokasi">
                                            <option selected="selected">
                                                Pilih Lokasi
                                            </option>
                                            <option value="Lab. Komputer">Lab. Komputer</option>
                                            <option value="Lab. Prodi">Lab. Prodi</option>
                                            <option value="Ruang Kelas">Ruang Kelas</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Ruang</label>
                                        <select class="custom-select" name="ruang">
                                            <option selected="selected">Pilih ruang</option>
                                            @foreach ($dbRuang as $ruang)
                                                <option value="{{ $ruang?->ruang }}">{{ $ruang?->ruang }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Software yang Dibutuhkan</label>
                                        <input class="form-control" type="text"
                                            placeholder="Ketik software yang dibutuhkan..." id="example-text-input" />
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Perbanyak Soal</label>
                                        <select class="custom-select" name="perbanyak">
                                            <option selected="selected">
                                                Pilih Perbanyak atau Tidak
                                            </option>
                                            <option value="1">Perbanyak</option>
                                            <option value="0">Tidak</option>
                                        </select>
                                    </div>

                                    <button class="btn btn-primary">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Textual inputs end -->
                </div>
            </div>
        </div>
    </div>
@endsection
