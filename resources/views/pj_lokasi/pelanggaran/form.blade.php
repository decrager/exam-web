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
                        <li><a >Beranda</a></li>
                        <li><a ><span>Pelanggaran</span></a></li>
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
                                <h4 class="hr-title">Masukkan Data Pelanggaran</h4>
                                <form method="post" action="/pj_lokasi/pelanggaran">
                                    @csrf
                                    <div class="form-group">
                                        <label class="col-form-label">Ujian</label>
                                        <select class="custom-select ujian-select" name="ujian_id" id="">
                                            <option selected="selected">Select</option>
                                            @foreach ($ujians as $ujian)
                                            @if (old('ujian_id') === $ujian->id)
                                              <option value="{{ $ujian->id }}" selected>{{ $ujian->Matkul->Semester->Prodi->nama_prodi }} - {{ $ujian->Matkul->nama_matkul }} - Kelas {{ $ujian->Praktikum->Kelas->kelas }}/P{{ $ujian->Praktikum->praktikum }}</option>
                                            @else
                                              <option value="{{ $ujian->id }}">{{ $ujian->Matkul->Semester->Prodi->nama_prodi }} - {{ $ujian->Matkul->nama_matkul }} - Kelas {{ $ujian->Praktikum->Kelas->kelas }}/P{{ $ujian->Praktikum->praktikum }}</option>                 
                                            @endif
                                          @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Nama Mahasiswa</label>
                                        <select class="custom-select mhs-select" name="mhs_id" id="">
                                            <option selected="selected">Select</option>
                                            @foreach ($mahasiswas as $mahasiswa)
                                            @if (old('mhs_id') === $mahasiswa->id)
                                              <option value="{{ $mahasiswa->id }}" selected>{{ $mahasiswa->nama }} - Kelas {{ $mahasiswa->Praktikum->Kelas->kelas }}/P{{ $mahasiswa->Praktikum->praktikum }}</option>
                                            @else
                                              <option value="{{ $mahasiswa->id }}">{{ $mahasiswa->nama }} - Kelas {{ $mahasiswa->Praktikum->Kelas->kelas }}/P{{ $mahasiswa->Praktikum->praktikum }}</option>                 
                                            @endif
                                          @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Pelanggaran</label>
                                        <input class="form-control" type="text" id="example-text-input" name="pelanggaran"/>
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

    <script>
        $('.ujian-select').select2();
        $('.mhs-select').select2();
    </script>
@endsection
