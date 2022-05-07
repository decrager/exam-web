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
                    <h4 class="page-title pull-left">Rekapitulasi Pelanggaran</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="">Beranda</a></li>
                        <li><span>Pelanggaran</span></li>
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
                        <h4 class="header-title">Pelanggaran</h4>
                        <div class="table-responsive">
                            <table id="example" class="table" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>NIM</th>
                                        <th class="col-2">Program Studi</th>
                                        <th>Semester</th>
                                        <th>Tanggal</th>
                                        <th>Sesi</th>
                                        <th>Pelanggaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Irfan Zafar</td>
                                        <td>J3C219155</td>
                                        <td>Manajemen Informatika</td>
                                        <td>4</td>
                                        <td>09/05/2022</td>
                                        <td>1</td>
                                        <td>Mencontek</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>NIM</th>
                                        <th class="col-2">Program Studi</th>
                                        <th>Semester</th>
                                        <th>Tanggal</th>
                                        <th>Sesi</th>
                                        <th>Pelanggaran</th>
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