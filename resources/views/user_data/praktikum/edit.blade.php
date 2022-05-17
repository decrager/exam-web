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
                    <h4 class="page-title pull-left">Ubah Praktikum</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="">Beranda</a></li>
                        <li><a><span>Akademik</span></a></li>
                        <li><a href=""><span>Praktikum</span></a></li>
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
                                <form action="{{ route('data.praktikum.update', $praktikum?->id) }}" method="POST">
                                    <h4 class="header-title">Ubah Praktikum</h4>
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label class="col-form-label">Program Studi</label>
                                        <select class="custom-select" name="prodi" id="prodi" required>
                                            <option selected="selected">Pilih Program Studi</option>
                                            @foreach ($dbProdi as $prodi)
                                                <option value="{{ $prodi?->id }}">{{ $prodi?->nama_prodi }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Semester</label>
                                        <select class="custom-select" name="semester" id="semester" required>
                                            <option>Pilih Semester</option>
                                            <option selected="selected" value="{{ $praktikum?->Kelas?->Semester?->id }}">{{ $praktikum?->Kelas?->Semester?->semester }}</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Kelas</label>
                                        <select class="custom-select" name="kelas" id="kelas" required>
                                            <option>Pilih Kelas</option>
                                            <option selected="selected" value="{{ $praktikum?->Kelas?->id }}">{{ $praktikum?->Kelas?->kelas }}</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="praktikum" class="col-form-label">Praktikum</label>
                                        <input class="form-control" type="text" placeholder="Ketik..." id="praktikum" name="praktikum" value="{{ $praktikum?->praktikum }}"/>
                                    </div>

                                    <div class="form-group">
                                        <label for="jml_mhs" class="col-form-label">Jumlah Mahasiswa</label>
                                        <input class="form-control" type="text" placeholder="Ketik..." id="jml_mhs" name="jml_mhs" value="{{ $praktikum?->jml_mhs }}" />
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
