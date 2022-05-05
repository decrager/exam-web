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
    <div class="page-title-area mb-5">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="breadcrumbs-area clearfix">
                    <h4 class="page-title pull-left">Daftar Pengawas</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="">Beranda</a></li>
                        <li><span>Daftar Pengawas</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- page title area end -->
    <div class="main-content-inner">
        <div class="row">
            <!-- data table start -->
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">DataTable</h4>
                        <a href="input-form.html" class="btn btn-primary text-sm bg-blue px-3 mb-3">
                            Tambah Data
                        </a>
                        <!-- <i class="fa fa-check text-danger"></i> -->

                        <div class="table-responsive">
                            <table id="example" class="table" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Program Studi</th>
                                        <th scope="col">Semester</th>
                                        <th scope="col">Kelas</th>
                                        <th scope="col">Praktikum</th>
                                        <th scope="col">Mata Kuliah</th>
                                        <th scope="col">Jenis MK</th>
                                        <th scope="col">Lokasi</th>
                                        <th scope="col">Pengawas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th class="border-0" scope="row">1</th>
                                        <td class="border-0">-</td>
                                        <td class="border-0">-</td>
                                        <td class="border-0">-</td>
                                        <td class="border-0">-</td>
                                        <td class="border-0">-</td>
                                        <td class="border-0">-</td>
                                        <td class="border-0">-</td>
                                        <td class="border-0">-</td>
                                        <td class="border-0">-</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Program Studi</th>
                                        <th scope="col">Semester</th>
                                        <th scope="col">Kelas</th>
                                        <th scope="col">Praktikum</th>
                                        <th scope="col">Mata Kuliah</th>
                                        <th scope="col">Jenis MK</th>
                                        <th scope="col">Lokasi</th>
                                        <th scope="col">Pengawas</th>
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