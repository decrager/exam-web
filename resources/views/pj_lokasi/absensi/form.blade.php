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
                    <h4 class="page-title pull-left">Tambah Absensi</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="">Beranda</a></li>
                        <li><a>Pengawas</a></li>
                        <li><a href=""><span>Absensi</span></a></li>
                        <li><span>Tambah Absensi</span></li>
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
                                <h4 class="header-title">Absensi Pengawas Ujian</h4>

                                <div class="form-group">
                                    <label for="nama" class="col-form-label">Nama</label>
                                    <input class="form-control" type="text" readonly value="Aldo Bramantio" id="nama"
                                        name="nama" />
                                </div>

                                <div class="form-group">
                                    <label for="prodi" class="col-form-label">Program Studi</label>
                                    <input class="form-control" type="text" readonly value="Manajemen Informatika"
                                        id="prodi" name="prodi" />
                                </div>

                                <div class="form-group">
                                    <label for="matkul" class="col-form-label">Mata Kuliah</label>
                                    <input class="form-control" type="text" readonly value="RPL" id="matkul"
                                        name="matkul" />
                                </div>

                                <div class="form-group">
                                    <label for="lokasi" class="col-form-label">Lokasi</label>
                                    <input class="form-control" type="text" readonly value="K-35" id="lokasi"
                                        name="lokasi" />
                                </div>

                                <div class="col-md-12 bg-danger">
                                    <label class="" for="">Signature:</label>
                                    <br />
                                    <div id="sig"></div>
                                    <br />
                                    <button id="clear" class="btn btn-danger btn-sm">Clear Signature</button>
                                    <textarea id="signature64" name="signed" style="display: none"></textarea>
                                </div>

                                <button class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
                    <!-- Textual inputs end -->
                </div>
            </div>
        </div>
    </div>
@endsection
