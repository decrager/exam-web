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
                    <h4 class="page-title pull-left">Tambah Jadwal Ujian</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="">Beranda</a></li>
                        <li><a href=""><span>Jadwal Ujian</span></a></li>
                        <li><span>Tambah Jadwal Ujian</span></li>
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
                                <form action="{{ route('pjUjian.jadwal.create') }}" method="POST">
                                    @csrf

                                    <h4 class="header-title">Tambah Jadwal Ujian Periode
                                        @if ($master->isuas == 1)
                                            UAS
                                        @else
                                            UTS
                                        @endif
                                    </h4>

                                    <div class="form-group">
                                        <label for="tahun" class="col-form-label">Tahun Ajaran</label>
                                        <input class="form-control" type="text" readonly name="tahun"
                                            value="{{ $master->thn_ajaran }}" id="tahun" />
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Program Studi</label>
                                        <select class="custom-select" name="prodi" id="prodi" required>
                                            <option selected="selected">Pilih Program Studi</option>
                                            @foreach ($dbProdi as $prodi)
                                                <option value="{{ $prodi->id }}">{{ $prodi->nama_prodi }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Semester</label>
                                        <select class="custom-select" name="semester" id="semester" required>
                                            <option selected="selected">Pilih Semester</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label-sm">Kelas</label>
                                        <select class="custom-select" name="kelas" id="kelas" required>
                                            <option selected="selected">Pilih Kelas</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label-sm">Praktikum</label>
                                        <select class="custom-select" name="praktikum" id="kelas" required>
                                            <option selected="selected">Pilih Praktikum</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Mata Kuliah</label>
                                        <select class="custom-select" name="matkul" id="matkul" required>
                                            <option selected="selected">Pilih Mata Kuliah</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Tipe Mata Kuliah</label>
                                        <select class="custom-select" name="tipe_mk" required>
                                            <option selected="selected">
                                                Pilih Tipe Mata Kuliah
                                            </option>
                                            <option value="K">Kuliah</option>
                                            <option value="P">Praktikum</option>
                                            <option value="R">Responsi</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Kapasitas</label>
                                        <input class="form-control" type="text" placeholder="Ketik kapasitas"
                                            id="example-text-input" name="kapasitas"/>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Hari</label>
                                        <select class="custom-select" name="hari" required>
                                            <option selected="selected">
                                                Pilih Hari
                                            </option>
                                            <option value="Senin">Senin</option>
                                            <option value="Selasa">Selasa</option>
                                            <option value="Rabu">Rabu</option>
                                            <option value="Kamis">Kamis</option>
                                            <option value="Jumat">Jumat</option>
                                            <option value="Sabtu">Sabtu</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="tanggal" class="col-form-label">Tanggal</label>
                                        <input class="form-control" type="date" name="tanggal" id="tanggal" required />
                                    </div>

                                    <div class="form-group">
                                        <label for="jam_mulai" class="col-form-label">Jam Mulai</label>
                                        <input class="form-control" type="time" name="jam_mulai" id="jam_mulai"
                                            required />
                                    </div>

                                    <div class="form-group">
                                        <label for="jam_selesai" class="col-form-label">Jam Selesai</label>
                                        <input class="form-control" type="time" name="jam_selesai" id="jam_selesai"
                                            required />
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Sesi</label>
                                        <select class="custom-select" name="sesi" required>
                                            <option selected="selected">
                                                Pilih Sesi
                                            </option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Pelaksanaan</label>
                                        <select class="custom-select" name="pelaksanaan">
                                            <option selected="selected">
                                                Pilih Pelaksanaan
                                            </option>
                                            <option value="Online">Online</option>
                                            <option value="Offline">Offline</option>
                                        </select>
                                    </div>

                                    <input hidden type="text" name="lokasi" value="-">
                                    <input hidden type="text" name="ruang" value="">
                                    <input hidden type="text" name="perbanyak" value="0">
                                    <input hidden type="text" name="software" value="-">
                                    <input hidden type="text" name="isuas" value="{{ $master->isuas }}">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
