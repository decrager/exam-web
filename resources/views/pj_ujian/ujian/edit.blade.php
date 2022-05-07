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
                    <h4 class="page-title pull-left">Edit Jadwal Ujian</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="">Beranda</a></li>
                        <li><a href=""><span>Jadwal Ujian</span></a></li>
                        <li><span>Edit Jadwal Ujian</span></li>
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
                                <form action="" method="POST">
                                    <h4 class="header-title">Ubah Jadwal Ujian</h4>

                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label class="col-form-label">Program Studi</label>
                                        <select class="custom-select">
                                            <option selected="selected">
                                                Pilih Program Studi
                                            </option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Semester</label>
                                        <select class="custom-select">
                                            <option selected="selected">
                                                Pilih Semester
                                            </option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Kelas</label>
                                        <select class="custom-select">
                                            <option selected="selected">
                                                Pilih Kelas
                                            </option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Praktikum</label>
                                        <select class="custom-select">
                                            <option selected="selected">
                                                Pilih Praktikum
                                            </option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Mata Kuliah</label>
                                        <select class="custom-select">
                                            <option selected="selected">
                                                Pilih Mata Kuliah
                                            </option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Lokasi</label>
                                        <select class="custom-select" name="lokasi">
                                            <option selected="selected">
                                                Pilih Lokasi
                                            </option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Ruang</label>
                                        <select class="custom-select" name="ruang">
                                            <option selected="selected">Pilih ruang</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Hari</label>
                                        <select class="custom-select" name="hari">
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
                                        <input class="form-control" type="date" name="tanggal" value="2022-05-04"
                                            id="tanggal" />
                                    </div>

                                    <div class="form-group">
                                        <label for="tahun" class="col-form-label">Tahun</label>
                                        <input class="form-control" type="text" readonly name="tahun" value="2022"
                                            id="tahun" />
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Jenis Mata Kuliah</label>
                                        <select class="custom-select" name="jenis_mk">
                                            <option selected="selected">
                                                Pilih Jenis Mata Kuliah
                                            </option>
                                            <option value="K">Kuliah</option>
                                            <option value="P">Praktikum</option>
                                            <option value="R">Responsi</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="jam_mulai" class="col-form-label">Jam Mulai</label>
                                        <input class="form-control" type="time" value="08:00" name="mulai"
                                            id="jam_mulai" />
                                    </div>

                                    <div class="form-group">
                                        <label for="jam_selesai" class="col-form-label">Jam Selesai</label>
                                        <input class="form-control" type="time" value="10:00" name="selesai"
                                            id="jam_selesai" />
                                    </div>

                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Software yang
                                            Dibutuhkan</label>
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

                                    <div class="form-group">
                                        <label class="col-form-label">Sesi</label>
                                        <select class="custom-select" name="sesi">
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

                                    <button class="btn btn-primary">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Textual inputs end -->
                </div>
            </div>
            <!-- Custom file input start -->
            <div class="col-12">
                <div class="card mt-5">
                    <div class="card-body">
                        <h4 class="header-title">Custom file input</h4>
                        <form action="#">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Upload</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="inputGroupFile01" />
                                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="inputGroupFile02" />
                                    <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">Upload</span>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-secondary" type="button">
                                        Button
                                    </button>
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="inputGroupFile03" />
                                    <label class="custom-file-label" for="inputGroupFile03">Choose file</label>
                                </div>
                            </div>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="inputGroupFile04" />
                                    <label class="custom-file-label" for="inputGroupFile04">Choose file</label>
                                </div>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button">
                                        Button
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Custom file input end -->
        </div>
    </div>
@endsection
