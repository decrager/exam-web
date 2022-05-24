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
                    <h4 class="page-title pull-left">Ubah Mata Kuliah</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a >Beranda</a></li>
                        <li><a><span>Akademik</span></a></li>
                        <li><a ><span>Mata Kuliah</span></a></li>
                        <li><span>Ubah Data</span></li>
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
                                <form action="{{ route('data.matkul.update', $matkul?->id) }}" method="POST">
                                    <h4 class="header-title">Ubah Data Mata Kuliah</h4>
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label class="col-form-label">Program Studi<i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <select class="custom-select" name="prodi" id="prodi" required>
                                            <option>Pilih Program Studi</option>
                                            <option selected="selected" value="{{ $matkul?->Semester?->Prodi?->id }}">{{ $matkul?->Semester?->Prodi?->nama_prodi }}</option>
                                            @foreach ($dbProdi as $prodi)
                                                <option value="{{ $prodi?->id }}">{{ $prodi?->nama_prodi }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Semester<i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <select class="custom-select" name="semester" id="semester" required>
                                            <option>Pilih Semester</option>
                                            <option selected="selected" value="{{ $matkul?->Semester?->id }}">{{ $matkul?->Semester?->semester }}</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="kode_matkul" class="col-form-label">Kode Mata Kuliah<i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <input class="form-control" type="text" placeholder="Ketik..." value="{{ $matkul?->kode_matkul }}" id="kode_matkul" name="kode_matkul" required/>
                                    </div>

                                    <div class="form-group">
                                        <label for="nama_matkul" class="col-form-label">Mata Kuliah<i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <input class="form-control" type="text" placeholder="Ketik..." value="{{ $matkul?->nama_matkul }}" id="nama_matkul" name="nama_matkul" required/>
                                    </div>

                                    <div class="form-group">
                                        <label for="sks" class="col-form-label">SKS<i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <input class="form-control" type="text" placeholder="Ketik..." value="{{ $matkul?->sks }}" id="sks" name="sks" required/>
                                    </div>

                                    <div class="form-group">
                                        <label for="sks_kul" class="col-form-label">SKS Kuliah<i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <input class="form-control" type="text" placeholder="Ketik..." value="{{ $matkul?->sks_kul }}" id="sks_kul" name="sks_kul" required/>
                                    </div>

                                    <div class="form-group">
                                        <label for="sks_prak" class="col-form-label">SKS Praktikum<i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <input class="form-control" type="text" placeholder="Ketik..." value="{{ $matkul?->sks_prak }}" id="sks_prak" name="sks_prak" required/>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Simpan</button>
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
