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
                    <h4 class="page-title pull-left">Kehadiran</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a>Beranda</a></li>
                        <li><span>Kehadiran</span></li>
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
                        @if (session()->has('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="justify-content-start">
                            <h4 class="header-title justify-content-start">Kehadiran Mahasiswa</h4>
                        </div>
                        <form action="/pj_ujian/kehadiran" class="row justify-content-start">
                            @include('layouts.filter')
                        </form>

                        <div class="table-responsive">
                            <table id="dataTable" class="table" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th class="col-2">Program Studi</th>
                                        <th>Semester</th>
                                        <th>Kelas</th>
                                        <th>Praktikum</th>
                                        <th class="col-2">Mata Kuliah</th>
                                        <th>Hadir</th>
                                        <th>Tidak Hadir</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $kehadiran)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $kehadiran['tanggal'] }}</td>
                                            <td>{{ $kehadiran['nama_prodi'] }}</td>
                                            <td>{{ $kehadiran['semester'] }}</td>
                                            <td>{{ $kehadiran['kelas'] }}</td>
                                            <td>{{ $kehadiran['praktikum'] }}</td>
                                            <td>{{ $kehadiran['nama_matkul'] }}</td>
                                            <td>{{ $kehadiran['hadir'] }}</td>
                                            <td>{{ $kehadiran['absen'] }}</td>
                                            <td><a class="btn btn-danger text-sm @if($kehadiran['file'] == null) disabled @endif" href="{{ asset('storage/files/kehadiran/' . $kehadiran['file']) }}" target="_blank"><i class="fas fa-file-pdf"></i></a></td>
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
