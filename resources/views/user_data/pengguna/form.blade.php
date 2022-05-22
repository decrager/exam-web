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
                    <h4 class="page-title pull-left">Tambah Pengguna</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a >Beranda</a></li>
                        <li><a ><span>Pengguna</span></a></li>
                        <li><span>Tambah Pengguna</span></li>
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
                                <form action="{{ route('data.pengguna.create') }}" method="POST">
                                    <h4 class="header-title">Tambah Pengguna</h4>
                                    @csrf

                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Nama</label>
                                        <input class="form-control" type="text" placeholder="Ketik nama..." id="name" name="name" required/>
                                    </div>

                                    <div class="form-group">
                                        <label for="email" class="col-form-label">Email</label>
                                        <input class="form-control" type="email" placeholder="Ketik email..." name="email"
                                            id="email" required/>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Jenis Pengguna</label>
                                        <select class="custom-select" name="role" required>
                                            <option selected="selected" value="">
                                                Pilih jenis pengguna
                                            </option>
                                            <option value="assisten">Assisten Lokasi</option>
                                            <option value="berkas">Berkas</option>
                                            <option value="data">Data & Akademik</option>
                                            <option value="pj_lokasi">PJ Lokasi</option>
                                            <option value="pj_online">PJ Online</option>
                                            <option value="pj_susulan">PJ Susulan</option>
                                            <option value="pj_ujian">PJ Ujian</option>
                                            <option value="prodi">Program Studi</option>
                                            <option value="pj_labkom">PJ Lab Komputer</option>
                                            <option value="supervisor">Supervisor (Komdik/Pembina)</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Lokasi (Optional)</label>
                                        <select class="custom-select" name="lokasi">
                                            <option selected="selected" value="-">Pilih lokasi</option>
                                            @foreach ($dbLokasi as $lokasi)
                                                <option value="{{ $lokasi->lokasi }}">{{ $lokasi->lokasi }}</option>
                                            @endforeach
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
