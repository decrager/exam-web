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
    {{-- <div class="page-title-area mb-5">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Change Password</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="index.html">Home</a></li>
                    <li><span>Change Password</span></li>
                </ul>
            </div>
        </div>
    </div>
</div> --}}
    <!-- page title area end -->
    <div class="main-content-inner">
        <div class="row">
            <div class="col-lg-12 col-ml-12">
                <div class="row">
                    <!-- Textual inputs start -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                @if (session()->has('success'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                <h4 class="header-title">Profil</h4>
                                <p class="text-muted font-14 mb-4">
                                    {{-- Masukkan password yang lama sebelum password yang baru --}}
                                </p>

                                <form action="{{ route('mahasiswa.profile.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    @foreach ($errors->all() as $error)
                                        <p class="text-danger">{{ $error }}</p>
                                    @endforeach

                                    <div class="form-group">
                                        <label for="oldPass" class="col-form-label">Nama Mahasiswa <i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <input class="form-control" type="text" name="nama" value="{{ $profil->nama }}" required/>
                                    </div>

                                    <div class="form-group">
                                        <label for="newPass" class="col-form-label">NIM Mahasiswa <i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <input class="form-control" type="text" name="nim" value="{{ $profil->nim }}" required/>
                                    </div>

                                    <div class="form-group">
                                        <label for="newPass" class="col-form-label">Email/Username <b>(Yang digunakan untuk Login)</b><i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <input class="form-control" type="text" name="email" value="{{ $profil->email }}" required/>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Program Studi <i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <select class="custom-select" name="prodi" required>
                                            <option value="">Pilih Program Studi</option>
                                            @foreach ($dbProdi as $prodi)
                                                <option value="{{ $prodi->nama_prodi }}" {{ $profil->nama_prodi == $prodi->nama_prodi ? 'selected' : '' }}>{{ $prodi->nama_prodi }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Semester <i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <select class="custom-select" name="semester" required>
                                            <option value="">Pilih Semester</option>
                                            @foreach ($dbSemester as $semester)
                                                <option value="{{ $semester->semester }}" {{ $profil->semester == $semester->semester ? 'selected' : '' }}>{{ $semester->semester }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label-sm">Kelas <i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <select class="custom-select" name="kelas" required>
                                            <option selected="selected" value="">Pilih Kelas</option>
                                            @foreach ($dbKelas as $kelas)
                                                <option value="{{ $kelas->kelas }}" {{ $profil->kelas == $kelas->kelas ? 'selected' : '' }}>{{ $kelas->kelas }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label-sm">Praktikum <i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <select class="custom-select" name="praktikum" required>
                                            <option selected="selected" value="">Pilih Praktikum</option>
                                            @foreach ($dbPraktikum as $praktikum)
                                                <option value="{{ $praktikum->praktikum }}" {{ $profil->praktikum == $praktikum->praktikum ? 'selected' : '' }}>{{ $praktikum->praktikum }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <input type="text" name="mhs_id" value="{{ $profil->id }}" hidden>
                                    <button type="submit" class="btn btn-primary" onclick="return confirm('Yakin data yang diubah sudah benar?')">Ubah & Simpan</button>
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
