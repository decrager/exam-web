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
                <h4 class="page-title pull-left">Ubah Jadwal Ujian Susulan</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="">Beranda</a></li>
                    <li><a href=""><span>Jadwal Ujian Susulan</span></a></li>
                    <li><span>Ubah Jadwal</span></li>
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
                        <form action="" method="POST">
                            <div class="card-body">
                                <h4 class="header-title">Ubah Penjadwalan Ujian Susulan</h4>
                                @csrf
                                <div class="form-group">
                                    <label for="prodi" class="col-form-label">Program Studi</label>
                                    <input class="form-control" type="text" readonly value="Manajemen Informatika"
                                        id="prodi" name="prodi" />
                                </div>

                                <div class="form-group">
                                    <label for="semester" class="col-form-label">Semester</label>
                                    <input class="form-control" type="text" readonly value="5" id="semester"
                                        name="semester" />
                                </div>

                                <div class="form-group">
                                    <label for="kelas" class="col-form-label">Kelas</label>
                                    <input class="form-control" type="text" readonly value="A" id="kelas"
                                        name="kelas" />
                                </div>

                                <div class="form-group">
                                    <label for="praktikum" class="col-form-label">Praktikum</label>
                                    <input class="form-control" type="text" readonly value="2" id="praktikum"
                                        name="praktikum" />
                                </div>

                                <div class="form-group">
                                    <label for="matkul" class="col-form-label">Mata Kuliah</label>
                                    <input class="form-control" type="text" readonly value="RPL" id="matkul"
                                        name="matkul" />
                                </div>

                                <div class="form-group">
                                    <label for="jenis_mk" class="col-form-label">Jenis</label>
                                    <input class="form-control" type="text" readonly value="Responsi" id="jenis_mk"
                                        name="jenis_mk" />
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">Lokasi</label>
                                    <select class="custom-select" name="lokasi">
                                        <option selected="selected">Pilih lokasi</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">Hari</label>
                                    <select class="custom-select" name="hari">
                                        <option selected="selected">Pilih hari</option>
                                        <option value="senin">Senin</option>
                                        <option value="selasa">Selasa</option>
                                        <option value="rabu">Rabu</option>
                                        <option value="kamis">Kamis</option>
                                        <option value="jumat">Jumat</option>
                                        <option value="sabtu">Sabtu</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="tgl" class="col-form-label">Tanggal</label>
                                    <input class="form-control" type="date" id="tgl" name="tgl" />
                                </div>

                                <div class="form-group">
                                    <label for="tahun" class="col-form-label">Tahun</label>
                                    <input class="form-control" type="text" readonly value="2022" id="tahun"
                                        name="tahun" />
                                </div>

                                <div class="form-group">
                                    <label for="jam_mulai" class="col-form-label">Jam Mulai</label>
                                    <input class="form-control" type="time" value="13:45:00" id="jam_mulai"
                                        name="jam_mulai" />
                                </div>

                                <div class="form-group">
                                    <label for="jam_selesai" class="col-form-label">Jam Selesai</label>
                                    <input class="form-control" type="time" value="13:45:00" id="jam_selesai"
                                        name="jam_selesai" />
                                </div>

                                <div class="form-group">
                                    <label for="software" class="col-form-label">Software</label>
                                    <input class="form-control" type="text" placeholder="Ketik..." id="software"
                                        name="software" />
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">Perbanyak</label>
                                    <select class="custom-select" name="perbanyak">
                                        <option selected="selected">Pilih opsi</option>
                                        <option value="1">Perbanyak</option>
                                        <option value="0">Tidak</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">Sesi</label>
                                    <select class="custom-select" name="sesi">
                                        <option selected="selected">Pilih sesi</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">Pelaksanaan</label>
                                    <select class="custom-select" name="pelaksanaan">
                                        <option selected="selected">Pilih pelaksanaan</option>
                                        <option value="online">Online</option>
                                        <option value="offline">Offline</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Textual inputs end -->
            </div>
        </div>
    </div>
</div>
@endsection