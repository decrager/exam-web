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
                    <h4 class="page-title pull-left">Ubah Kelas</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a >Beranda</a></li>
                        <li><a><span>Akademik</span></a></li>
                        <li><a ><span>Kelas</span></a></li>
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
                                <form action="{{ route('data.kelas.update', $kelas?->id) }}" method="POST">
                                    <h4 class="header-title">Ubah Kelas</h4>
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label class="col-form-label">Program Studi<i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <select class="custom-select" name="prodi" id="prodi" required>
                                            <option>Pilih Program Studi</option>
                                            <option selected="selected" value="{{ $kelas?->Semester?->Prodi?->id }}">{{ $kelas?->Semester?->Prodi?->nama_prodi }}</option>
                                            @foreach ($dbProdi as $prodi)
                                                <option value="{{ $prodi?->id }}">{{ $prodi?->nama_prodi }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Semester<i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <select class="custom-select" name="semester" id="semester" required>
                                            <option>Pilih Semester</option>
                                            <option selected="selected" value="{{ $kelas?->Semester?->id }}">{{ $kelas?->Semester?->semester }}</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="kelas" class="col-form-label">Kelas<i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <input class="form-control" type="text" placeholder="Ketik..." id="kelas" name="kelas" value="{{ $kelas?->kelas }}" required/>
                                    </div>

                                    <div class="form-group">
                                        <label for="jml_mhs" class="col-form-label">Jumlah Mahasiswa<i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <input class="form-control" type="text" placeholder="Ketik..." id="jml_mhs" name="jml_mhs" value="{{ $kelas?->jml_mhs }}" required/>
                                    </div>

                                    {{-- <input type="text" hidden name="jml_mhs" value=0> --}}
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
