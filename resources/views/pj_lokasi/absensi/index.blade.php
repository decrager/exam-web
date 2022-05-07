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
                    <h4 class="page-title pull-left">Absensi</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="">Beranda</a></li>
                        <li><a>Pengawas</a></li>
                        <li><span>Absensi</span></li>
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
                        <h4 class="header-title">Absensi</h4>
                        <a href="#" class="btn btn-danger text-sm px-3 py-2 mb-3 float-right">
                            <i class="fas fa-file-pdf"></i>
                        </a>
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

                        <!-- <i class="fa fa-check text-danger"></i> -->

                        <div class="table-responsive">
                            <table id="example" class="table" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>PNS</th>
                                        <th>NON PNS</th>
                                        <th class="col-2">Program Studi</th>
                                        <th class="col-2">Mata Kuliah</th>
                                        <th>Lokasi</th>
                                        <th>Tanda Tangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-success"><i class="fas fa-file-signature"></i></button>
                                                <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>PNS</th>
                                        <th>NON PNS</th>
                                        <th class="col-2">Program Studi</th>
                                        <th class="col-2">Mata Kuliah</th>
                                        <th>Lokasi</th>
                                        <th>Tanda Tangan</th>
                                        <th>Aksi</th>
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
