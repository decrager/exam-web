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
                    <h4 class="page-title pull-left">Tambah Pengajuan Ujian Susulan</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="">Beranda</a></li>
                        <li><a>Susulan</a></li>
                        <li><a href=""><span>Pengajuan</span></a></li>
                        <li><span>Tambah Pengajuan</span></li>
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
                                    <h4 class="header-title">Masukkan Pengajuan</h4>
                                    @csrf
                                    <div class="form-group">
                                        <label class="col-form-label">Mata Kuliah</label>
                                        <select class="custom-select" name="matkul">
                                            <option selected="selected">Select</option>
                                            <option value="#">-</option>
                                            <option value="#">-</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Tipe Mata Kuliah</label>
                                        <select class="custom-select" name="jenis_mk">
                                            <option selected="selected">Select</option>
                                            <option value="#">Kuliah</option>
                                            <option value="#">Praktikum</option>
                                            <option value="#">Responsi</option>
                                        </select>
                                    </div>
                                    <a href="input-form.html" class="btn btn-primary text-sm bg-blue px-3 mb-3">
                                        Submit
                                    </a>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Textual inputs end -->
                </div>
            </div>
        </div>
    </div>
@endsection
