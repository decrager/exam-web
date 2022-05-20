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
                    <h4 class="page-title pull-left">Ubah Data Mahasiswa</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a >Beranda</a></li>
                        <li><a ><span>Mahasiswa</span></a></li>
                        <li><span>Ubah Data Mahasiswa</span></li>
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
                                <form action="{{ route('data.mahasiswa.update', $mahasiswa?->id) }}" method="POST">
                                    <h4 class="header-title">Tambah Data Mahasiswa</h4>
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label class="col-form-label">Program Studi</label>
                                        <select class="custom-select" name="prodi" id="prodi" required>
                                            <option>Pilih Program Studi</option>
                                            <option selected="selected" value="{{ $mahasiswa?->Praktikum?->Kelas?->Semester?->Prodi?->id }}">{{ $mahasiswa?->Praktikum?->Kelas?->Semester?->Prodi?->nama_prodi }}</option>
                                            @foreach ($dbProdi as $prodi)
                                                <option value="{{ $prodi?->id }}">{{ $prodi?->nama_prodi }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Semester</label>
                                        <select class="custom-select" name="semester" id="semester" required>
                                            <option>Pilih Semester</option>
                                            <option selected="selected" value="{{ $mahasiswa?->Praktikum?->Kelas?->Semester?->id }}">{{ $mahasiswa?->Praktikum?->Kelas?->Semester?->semester }}</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label-sm">Kelas</label>
                                        <select class="custom-select" name="kelas" id="kelas" required>
                                            <option>Pilih Kelas</option>
                                            <option selected="selected" value="{{ $mahasiswa?->Praktikum?->Kelas?->id }}">{{ $mahasiswa?->Praktikum?->Kelas?->kelas }}</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label-sm">Praktikum</label>
                                        <select class="custom-select" name="praktikum" id="praktikum" required>
                                            <option>Pilih Praktikum</option>
                                            <option selected="selected" value="{{ $mahasiswa?->Praktikum?->id }}">{{ $mahasiswa?->Praktikum?->praktikum }}</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="nama" class="col-form-label">Nama Mahasiswa</label>
                                        <input class="form-control" type="text" placeholder="Ketik nama..." id="nama" name="nama" value="{{ $mahasiswa?->nama }}" required/>
                                    </div>

                                    <div class="form-group">
                                        <label for="nim" class="col-form-label">Nim Mahasiswa</label>
                                        <input class="form-control" type="text" placeholder="Ketik nim..." id="nim" name="nim" value="{{ $mahasiswa?->nim }}" required/>
                                    </div>

                                    <div class="form-group">
                                        <label for="email" class="col-form-label">Email</label>
                                        <input class="form-control" type="email" placeholder="Ketik email..." value="{{ $mahasiswa?->email }}" name="email"
                                            id="email" required/>
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
