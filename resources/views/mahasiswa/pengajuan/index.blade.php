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
                    <h4 class="page-title pull-left">Pengajuan Ujian Susulan</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="">Beranda</a></li>
                        <li><a>Susulan</a></li>
                        <li><span>Pengajuan</span></li>
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
                        <h4 class="header-title">Pengajuan Ujian Susulan</h4>
                        <a href="{{ route('mahasiswa.susulan.pengajuan.form') }}" class="btn btn-primary text-sm bg-blue px-3 mb-3">
                            Ajukan
                        </a>
                        <!-- <i class="fa fa-check text-danger"></i> -->

                        <div class="table-responsive">
                            <table id="example" class="table" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th class="col-2">Mata Kuliah</th>
                                        <th>file</th>
                                        <th>status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>
                                            <a href="#" class="btn btn-primary text-sm px-3 py-1">
                                                Belum Disetujui
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th class="col-2">Mata Kuliah</th>
                                        <th>file</th>
                                        <th>Status</th>
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