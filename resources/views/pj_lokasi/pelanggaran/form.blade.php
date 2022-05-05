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
                    <h4 class="page-title pull-left">Tambah Pelanggaran</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="">Beranda</a></li>
                        <li><a href=""><span>Pelanggaran</span></a></li>
                        <li><span>Tambah Pelanggaran</span></li>
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
                                <h4 class="header-title">Masukkan Data Pelanggaran</h4>

                                <div class="form-group">
                                    <label class="col-form-label">Prodi</label>
                                    <select class="custom-select">
                                        <option selected="selected">Select</option>
                                        <option value="#">-</option>
                                        <option value="#">-</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Semester</label>
                                    <select class="custom-select">
                                        <option selected="selected">Select</option>
                                        <option value="#">-</option>
                                        <option value="#">-</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Mata Kuliah</label>
                                    <select class="custom-select">
                                        <option selected="selected">Select</option>
                                        <option value="#">-</option>
                                        <option value="#">-</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Nama Mahasiswa</label>
                                    <select class="custom-select">
                                        <option selected="selected">Select</option>
                                        <option value="#">-</option>
                                        <option value="#">-</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="example-text-input" class="col-form-label">Pelanggaran</label>
                                    <input class="form-control" type="text" id="example-text-input" />
                                </div>
                                <a href="input-form.html" class="btn btn-primary text-sm bg-blue px-3 mb-3">
                                    Submit
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Textual inputs end -->
                </div>
            </div>
        </div>
    </div>
@endsection
