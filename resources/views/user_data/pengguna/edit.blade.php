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
                    <h4 class="page-title pull-left">Ubah Pengguna</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="">Beranda</a></li>
                        <li><a href=""><span>Pengguna</span></a></li>
                        <li><span>Ubah Pengguna</span></li>
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
                                    <h4 class="header-title">Ubah Pengguna</h4>
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="nama" class="col-form-label">Nama</label>
                                        <input class="form-control" type="text" placeholder="Ketik nama..." id="nama"
                                            name="nama" />
                                    </div>

                                    <div class="form-group">
                                        <label for="email" class="col-form-label">Email</label>
                                        <input class="form-control" type="email" placeholder="Ketik email..." name="email"
                                            id="email" />
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Jenis Pengguna</label>
                                        <select class="custom-select" name="role">
                                            <option selected="selected">
                                                Pilih jenis pengguna
                                            </option>
                                            <option value="assisten">Assisten Lokasi</option>
                                            <option value="berkas">Berkas</option>
                                            <option value="data">Data</option>
                                            <option value="mahasiswa">Mahasiswa</option>
                                            <option value="pj_lokasi">PJ Lokasi</option>
                                            <option value="pj_online">PJ Online</option>
                                            <option value="pj_susulan">PJ Susulan</option>
                                            <option value="pj_ujian">PJ Ujian</option>
                                            <option value="prodi">Program Studi</option>
                                            <option value="supervisor">Supervisor (Komdik/Pembina)</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Lokasi</label>
                                        <select class="custom-select" name="id_lokasi">
                                            <option selected="selected">
                                                Pilih jenis pengguna
                                            </option>
                                            <option value="">Lokasi 1</option>
                                            <option value="">Lokasi 2</option>
                                            <option value="">Lokasi 3</option>
                                        </select>
                                    </div>

                                    <button class="btn btn-primary">Simpan</button>
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
