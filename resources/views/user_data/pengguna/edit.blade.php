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
                        <li><a >Beranda</a></li>
                        <li><a ><span>Pengguna</span></a></li>
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
                                <form action="{{ route('data.pengguna.update', $pengguna?->id) }}" method="POST">
                                    <h4 class="header-title">Tambah Pengguna</h4>
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Nama</label>
                                        <input class="form-control" type="text" placeholder="Ketik nama..." value="{{ $pengguna?->name }}" id="name" name="name" required/>
                                    </div>

                                    <div class="form-group">
                                        <label for="email" class="col-form-label">Email</label>
                                        <input class="form-control" type="email" placeholder="Ketik email..." value="{{ $pengguna?->email }}" name="email"
                                            id="email" required/>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Jenis Pengguna</label>
                                        <select class="custom-select" name="role" required>
                                            <option>Pilih jenis pengguna</option>
                                            @if ($pengguna?->role == 'data')
                                            <option selected="selected" value="{{ $pengguna?->role }}">Data & Akademik</option>
                                            @elseif ($pengguna?->role == 'pj_ujian')
                                            <option selected="selected" value="{{ $pengguna?->role }}">PJ Ujian</option>
                                            @elseif ($pengguna?->role == 'prodi')
                                            <option selected="selected" value="{{ $pengguna?->role }}">Program Studi</option>
                                            @elseif ($pengguna?->role == 'pj_lokasi')
                                            <option selected="selected" value="{{ $pengguna?->role }}">PJ Lokasi</option>
                                            @elseif ($pengguna?->role == 'berkas')
                                            <option selected="selected" value="{{ $pengguna?->role }}">Berkas</option>
                                            @elseif ($pengguna?->role == 'assisten')
                                            <option selected="selected" value="{{ $pengguna?->role }}">Asisten Perlokasi</option>
                                            @elseif ($pengguna?->role == 'pj_susulan')
                                            <option selected="selected" value="{{ $pengguna?->role }}">PJ Susulan</option>
                                            @elseif ($pengguna?->role == 'supervisor')
                                            <option selected="selected" value="{{ $pengguna?->role }}">Supervisor (Komdik/Pembina)</option>
                                            @elseif ($pengguna?->role == 'pj_online')
                                            <option selected="selected" value="{{ $pengguna?->role }}">PJ Online</option>
                                            @elseif ($pengguna?->role == 'pj_labkom')
                                            <option selected="selected" value="{{ $pengguna?->role }}">PJ Lab Komputer</option>
                                            @endif
                                            <option value="assisten">Assisten Lokasi</option>
                                            <option value="berkas">Berkas</option>
                                            <option value="data">Data</option>
                                            <option value="pj_lokasi">PJ Lokasi</option>
                                            <option value="pj_online">PJ Online</option>
                                            <option value="pj_susulan">PJ Susulan</option>
                                            <option value="pj_ujian">PJ Ujian</option>
                                            <option value="prodi">Program Studi</option>
                                            <option value="supervisor">Supervisor (Komdik/Pembina)</option>
                                            <option value="pj_labkom">PJ Lab Komputer</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Lokasi (Optional)</label>
                                        <select class="custom-select" name="lokasi">
                                            <option value="-">Pilih lokasi</option>
                                            <option selected="selected" value="{{ $pengguna?->lokasi }}">{{ $pengguna?->lokasi }}</option>
                                            @foreach ($dbLokasi as $lokasi)
                                                <option value="{{ $lokasi?->lokasi }}">{{ $lokasi?->lokasi }}</option>
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
