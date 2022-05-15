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
                    <h4 class="page-title pull-left">Daftar Pengawas</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="">Beranda</a></li>
                        <li><span>Daftar Pengawas</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- page title area end -->
    <div class="main-content-inner">
        <div class="row">
            <!-- data table start -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Daftar Pengawas</h4>
                        <div class="row justify-content-start">
                            @include('layouts.filter')
                        </div>
                        <div class="table-responsive">
                            <table id="example" class="table" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th class="col-2">Program Studi</th>
                                        <th>Semester</th>
                                        <th>Kelas</th>
                                        <th>Praktikum</th>
                                        <th class="col-2">Mata Kuliah</th>
                                        <th>Lokasi</th>
                                        <th>Ruang</th>
                                        <th>Pengawas</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pengawas as $pengawas)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $pengawas->Ujian->tanggal }}</td>
                                            <td>{{ $pengawas->Ujian->Matkul->Semester->Prodi->nama_prodi }}</td>
                                            <td>{{ $pengawas->Ujian->Matkul->Semester->semester }}</td>
                                            <td>{{ $pengawas->Ujian->Praktikum->Kelas->kelas }}</td>
                                            <td>{{ $pengawas->Ujian->Praktikum->praktikum }}</td>
                                            <td>{{ $pengawas->Ujian->Matkul->nama_matkul }}</td>
                                            <td>{{ $pengawas->Ujian->lokasi }}</td>
                                            <td>{{ $pengawas->Ujian->ruang }}</td>
                                            <td>{{ $pengawas->nama }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-warning"><i class="fas fa-pen"></i></button>
                                                    <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- data table end -->
        </div>
    </div>
@endsection