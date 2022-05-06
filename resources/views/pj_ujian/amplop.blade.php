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
                    <h4 class="page-title pull-left">Amplop</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="">Beranda</a></li>
                        <li><a><span>Kelengkapan</span></a></li>
                        <li><span>Amplop</span></li>
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
                        <h4 class="header-title">Amplop</h4>
                        <div class="table-responsive">
                            <table id="example" class="table" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Program Studi</th>
                                        <th>Semester</th>
                                        <th>Kelas</th>
                                        <th>Praktikum</th>
                                        <th>Mata Kuliah</th>
                                        <th>Jenis</th>
                                        <th>Lokasi</th>
                                        <th>Ketersediaan</th>
                                        <th>Status</th>
                                        <th>Pengambilan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>04-05-2022</td>
                                        <td>Manajemen Informatika</td>
                                        <td>4</td>
                                        <td>A</td>
                                        <td>2</td>
                                        <td>RPL</td>
                                        <td>Responsi</td>
                                        <td>K-35</td>
                                        <td><button class="btn btn-danger btn-sm px-3">Belum</button></td>
                                        <td><button class="btn btn-danger btn-sm px-3">Belum</button></td>
                                        <td><button class="btn btn-danger btn-sm px-3">Belum</button></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Program Studi</th>
                                        <th>Semester</th>
                                        <th>Kelas</th>
                                        <th>Praktikum</th>
                                        <th>Mata Kuliah</th>
                                        <th>Jenis</th>
                                        <th>Lokasi</th>
                                        <th>Ketersediaan</th>
                                        <th>Status</th>
                                        <th>Pengambilan</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- data table end -->
        </div>
    </div>
@endsection