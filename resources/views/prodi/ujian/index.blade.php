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
                    <h4 class="page-title pull-left">Data Ujian</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a >Beranda</a></li>
                        <li><span>Data Ujian</span></li>
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
                        <h4 class="header-title">Data Ujian</h4>
                        {{-- <div class="float-right">
                            <a href="/prodi/jadwal/export" class="btn btn-success py-2 mr-2">Export &nbsp;&nbsp;<i
                                class="fas fa-file-excel-o"></i></a>
                        </div> --}}
                        <div class="table-responsive">
                            <table id="example" class="table" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th class="col-2">Program Studi</th>
                                        <th>Semester</th>
                                        <th class="col-2">Mata Kuliah</th>
                                        <th>Tipe</th>
                                        <th>Usulan Ruang</th>
                                        <th>Perbanyak</th>
                                        <th>Software</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ujian as $jadwal)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $jadwal?->nama_prodi }}</td>
                                            <td>{{ $jadwal?->semester }}</td>
                                            <td>{{ $jadwal?->nama_matkul }}</td>
                                            <td>
                                                @if ($jadwal?->tipe_mk == 'K')
                                                    Kuliah
                                                @elseif ($jadwal?->tipe_mk == 'P')
                                                    Praktikum
                                                @else
                                                    Responsi
                                                @endif
                                            </td>
                                            <td>{{ $jadwal?->lokasi }}</td>
                                            <td>
                                                @if ($jadwal?->perbanyak == 1)
                                                    <span class="badge badge-success">Perbanyak</span>
                                                @else
                                                    <span class="badge badge-danger">Tidak</span>
                                                @endif
                                            </td>
                                            <td>{{ $jadwal?->software }}</td>
                                            <td>
                                                <form action="{{ route('prodi.jadwal.edit') }}" method="GET">
                                                    @csrf
                                                    <input type="text" hidden name="prodi" value="{{ $jadwal?->nama_prodi }}">
                                                    <input type="text" hidden name="semester" value="{{ $jadwal?->semester }}">
                                                    <input type="text" hidden name="matkul_id" value="{{ $jadwal?->matkul_id }}">
                                                    <input type="text" hidden name="matkul" value="{{ $jadwal?->nama_matkul }}">
                                                    <input type="text" hidden name="tipe_mk" value="{{ $jadwal?->tipe_mk }}">
                                                    <button type="submit" class="btn btn-warning"><i class="fas fa-pen"></i></button>
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
