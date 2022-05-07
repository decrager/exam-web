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
                    <h4 class="page-title pull-left">Soal Ujian</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="">Beranda</a></li>
                        <li><a><span>Kelengkapan</span></a></li>
                        <li><span>Soal Ujian</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- page title area end -->
    <div class="main-content-inner">
        <div class="row">
            <!-- data table start -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Soal Ujian</h4>

                        <div class="row justify-content-start">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select class="custom-select">
                                        <option selected="selected">Program Studi</option>
                                        <option value="#">-</option>
                                        <option value="#">-</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select class="custom-select">
                                        <option selected="selected">Semester</option>
                                        <option value="#">-</option>
                                        <option value="#">-</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select class="custom-select">
                                        <option selected="selected">Kelas</option>
                                        <option value="#">-</option>
                                        <option value="#">-</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select class="custom-select">
                                        <option selected="selected">Praktikum</option>
                                        <option value="#">-</option>
                                        <option value="#">-</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select class="custom-select">
                                        <option selected="selected">Mata Kuliah</option>
                                        <option value="#">-</option>
                                        <option value="#">-</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1 align-content-center">
                                <button class="btn btn-primary py-2"><i class="fas fa-filter"></i></button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="example" class="table" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th class="col-2">Program Studi</th>
                                        <th>Semester</th>
                                        <th>Kelas</th>
                                        <th>Praktikum</th>
                                        <th class="col-2">Mata Kuliah</th>
                                        <th>Jenis</th>
                                        <th>Lokasi</th>
                                        <th>Ruang</th>
                                        <th>Jumlah</th>
                                        <th>Pengambilan</th>
                                        <th>Fotokopi</th>
                                        <th>Lengkap</th>
                                        <th>Asisten</th>
                                        <th>Serah Terima</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>04-05-2022</td>
                                        <td>Manajemen Informatika</td>
                                        <td>4</td>
                                        <td>A</td>
                                        <td>2</td>
                                        <td>RPL</td>
                                        <td>Responsi</td>
                                        <td>K-35</td>
                                        <td>Lab. Komputer</td>
                                        <td>36</td>
                                        <td><button class="btn btn-danger btn-sm">Belum diambil</button></td>
                                        <td><button class="btn btn-danger btn-sm">Belum difotokopi</button></td>
                                        <td><button class="btn btn-danger btn-sm">Belum lengkap</button></td>
                                        <td><button class="btn btn-danger btn-sm">Belum diambil</button></td>
                                        <td><button class="btn btn-danger btn-sm">Belum diserahkan</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- data table end -->
        </div>
    </div>
@endsection