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
                    <h4 class="page-title pull-left">Penjadwalan Ujian Susulan</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="">Beranda</a></li>
                        <li><span>Penjadwalan</span></li>
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
                        <h4 class="header-title">Penjadwalan Ujian Susulan</h4>
                        <div class="table-responsive">
                            <table id="example" class="table" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th class="col-2">Program Studi</th>
                                        <th>Semester</th>
                                        <th>Kelas</th>
                                        <th>Praktikum</th>
                                        <th class="col-2">Mata Kuliah</th>
                                        <th>Tipe</th>
                                        <th>Jumlah Mahasiswa</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jadwal as $jadwal)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $jadwal?->nama_prodi }}</td>
                                            <td>{{ $jadwal?->semester }}</td>
                                            <td>{{ $jadwal?->kelas }}</td>
                                            <td>{{ $jadwal?->praktikum }}</td>
                                            <td>{{ $jadwal?->nama_matkul }}</td>
                                            <td>{{ $jadwal?->tipe_mk }}</td>
                                            <td>{{ $jadwal?->total_mhs }}</td>
                                            <td>
                                                <form action="{{ route('pjSusulan.penjadwalan.form') }}" method="GET">
                                                    @csrf
                                                    <input hidden type="text" name="prodi_id"
                                                        value="{{ $jadwal?->prodi_id }}">
                                                    <input hidden type="text" name="semester_id"
                                                        value="{{ $jadwal?->semester_id }}">
                                                    <input hidden type="text" name="kelas_id"
                                                        value="{{ $jadwal?->kelas_id }}">
                                                    <input hidden type="text" name="praktikum_id"
                                                        value="{{ $jadwal?->prak_id }}">
                                                    <input hidden type="text" name="matkul_id"
                                                        value="{{ $jadwal?->matkul_id }}">
                                                    <input hidden type="text" name="tipe_mk"
                                                        value="{{ $jadwal?->tipe_mk }}">
                                                    <input hidden type="text" name="nama_prodi"
                                                        value="{{ $jadwal?->nama_prodi }}">
                                                    <input hidden type="text" name="semester"
                                                        value="{{ $jadwal?->semester }}">
                                                    <input hidden type="text" name="kelas" value="{{ $jadwal?->kelas }}">
                                                    <input hidden type="text" name="praktikum"
                                                        value="{{ $jadwal?->praktikum }}">
                                                    <input hidden type="text" name="nama_matkul"
                                                        value="{{ $jadwal?->nama_matkul }}">
                                                    <button type="submit" class="btn btn-primary"><i
                                                            class="fas fa-calendar-plus"></i></button>
                                                </form>
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
