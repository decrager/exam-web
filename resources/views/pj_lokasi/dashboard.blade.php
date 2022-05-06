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
                    <h4 class="page-title pull-left">Dashboard</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="index.html">Home</a></li>
                        <li><span>Dashboard</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- page title area end -->
    <div class="main-content-inner">
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="single-report bg-white">
                    <span>Report</span>
                    <div class="number">000</div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="single-report bg-white">
                    <span>Report</span>
                    <div class="number">000</div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="single-report bg-white">
                    <span>Report</span>
                    <div class="number">000</div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- data table start -->
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title float-left pt-2">Jadwal Ujian</h4>
                        <div class="row mb-1 justify-content-end">
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
                            <div class="col-md-2 pr--0">
                                <div class="form-group">
                                    <select class="custom-select">
                                        <option selected="selected">Mata Kuliah</option>
                                        <option value="#">-</option>
                                        <option value="#">-</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- <i class="fa fa-check text-danger"></i> -->

                        <div class="table-responsive">
                            <table id="example" class="table" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th class="border-0" scope="col">No</th>
                                        <th class="border-0" scope="col">Tanggal</th>
                                        <th class="border-0" scope="col">Program Studi</th>
                                        <th class="border-0" scope="col">Semester</th>
                                        <th class="border-0" scope="col">Kelas</th>
                                        <th class="border-0" scope="col">Praktikum</th>
                                        <th class="border-0" scope="col">Mata Kuliah</th>
                                        <th class="border-0" scope="col">Lokasi</th>
                                        <th class="border-0" scope="col">Jam Mulai</th>
                                        <th class="border-0" scope="col">Jam Selesai</th>
                                        <th class="border-0" scope="col">Aksi</th>
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
                                        <td class="border-0">
                                            <a href="#" class="btn btn-primary text-sm px-3 py-1">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="border-0" scope="col">No</th>
                                        <th class="border-0" scope="col">Tanggal</th>
                                        <th class="border-0" scope="col">Program Studi</th>
                                        <th class="border-0" scope="col">Semester</th>
                                        <th class="border-0" scope="col">Kelas</th>
                                        <th class="border-0" scope="col">Praktikum</th>
                                        <th class="border-0" scope="col">Mata Kuliah</th>
                                        <th class="border-0" scope="col">Lokasi</th>
                                        <th class="border-0" scope="col">Jam Mulai</th>
                                        <th class="border-0" scope="col">Jam Selesai</th>
                                        <th class="border-0" scope="col">Aksi</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- data table end -->
        </div>

        <div class="row">
            <!-- data table start -->
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Rekapitulasi Pelanggaran</h4>
                        <figure class="highcharts-figure">
                            <div id="container"></div>
                        </figure>
                    </div>
                </div>
            </div>
            <!-- data table end -->
        </div>
    </div>
@endsection
