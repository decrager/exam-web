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
                    <h4 class="page-title pull-left">Susulan</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="">Beranda</a></li>
                        <li><span>Susulan</span></li>
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
                        <h4 class="header-title">Daftar Mahasiswa yang Mengajukan Susulan</h4>
                        <div class="table-responsive">
                            <table id="example" class="table" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th class="col-2">Program Studi</th>
                                        <th>Semester</th>
                                        <th class="col-2">Mata Kuliah</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>NIM</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($susulan as $susulan)
                                    <tr>
                                        <td>1</td>
                                        <td>Manajemen Informatika</td>
                                        <td>4</td>
                                        <td>RPL</td>
                                        <td>Irfan Zafar</td>
                                        <td>J3C219155</td>
                                        <td><span class="badge bg-danger">Belum disetujui</span></td>
                                        <td><Button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detail"><i class="fas fa-info"></i></Button></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- data table end -->
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="detail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Textual inputs start -->
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body p-2">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <h6>Program Studi</h6>
                                                <p>Value</p>
                                            </div>
                                            <div class="form-group">
                                                <h6>Semester</h6>
                                                <p>Value</p>
                                            </div>
                                            <div class="form-group">
                                                <h6>Nama Mahasiswa</h6>
                                                <p>Value</p>
                                            </div>
                                            <div class="form-group">
                                                <h6>NIM</h6>
                                                <p>Value</p>
                                            </div>
                                            <div class="form-group">
                                                <h6>Kelas - Praktikum</h6>
                                                <p>Value - value</p>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <h6>Mata Kuliah</h6>
                                                <p>Value</p>
                                            </div>
                                            <div class="form-group">
                                                <h6>Tipe Mata Kuliah</h6>
                                                <p>Value</p>
                                            </div>
                                            <div class="form-group">
                                                <h6>Status</h6>
                                                <p><span class="badge bg-danger">Belum disetujui</span></p>
                                            </div>
                                            <div class="form-group">
                                                <h6>Bukti Persyaratan</h6>
                                                <button class="btn btn-success btn-sm mt-1"><i class="fas fa-download"></i>&ensp; Download</button>
                                            </div>
                                            <div class="form-group">
                                                <h6>Persetujuan</h6>
                                                <div class="btn-group mt-1" role="group">
                                                    <button class="btn btn-success btn-sm"><i class="fas fa-check"></i>&ensp; Setujui</button>
                                                    <button class="btn btn-danger btn-sm"><i class="fas fa-xmark"></i>&ensp; Tolak</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Textual inputs end -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection