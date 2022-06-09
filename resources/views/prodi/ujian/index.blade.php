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
                                        <th>Tanggal</th>
                                        <th class="col-2">Program Studi</th>
                                        <th>Semester</th>
                                        <th class="col-2">Mata Kuliah</th>
                                        <th>Usulan Ruang</th>
                                        <th>Perbanyak Teori</th>
                                        <th>Perbanyak Praktik</th>
                                        <th>Kertas Buram</th>
                                        <th>Software</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ujian as $jadwal)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $jadwal?->tanggal }}</td>
                                            <td>{{ $jadwal?->nama_prodi }}</td>
                                            <td>{{ $jadwal?->semester }}</td>
                                            <td>{{ $jadwal?->nama_matkul }}</td>
                                            <td>
                                                @if (empty($jadwal?->lokasi))
                                                    -
                                                @else
                                                    {{ $jadwal?->lokasi }}
                                                @endif
                                            </td>
                                            @if ($jadwal?->perbanyak == "1")
                                                <td><span class="badge badge-success">Ya</span></td>
                                                <td><span class="badge badge-success">Ya</span></td>
                                            @elseif ($jadwal?->perbanyak == "2")
                                                <td><span class="badge badge-danger">Tidak</span></td>
                                                <td><span class="badge badge-danger">Tidak</span></td>
                                            @elseif ($jadwal?->perbanyak == "3")
                                                <td><span class="badge badge-success">Ya</span></td>
                                                <td><span class="badge badge-danger">Tidak</span></td>
                                            @elseif ($jadwal?->perbanyak == "4")
                                                <td><span class="badge badge-danger">Tidak</span></td>
                                                <td><span class="badge badge-success">Ya</span></td>
                                            @else
                                                <td>-</td>
                                                <td>-</td>
                                            @endif
                                            <td>
                                                @if ($jadwal->kertas == 0)
                                                    -
                                                @elseif ($jadwal->kertas == 1)
                                                    <span class="badge badge-success">Pakai</span>
                                                @elseif ($jadwal->kertas == 2)
                                                    <span class="badge badge-danger">Tidak Pakai</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (empty($jadwal?->software))
                                                    -
                                                @else
                                                    {{ $jadwal?->software }}
                                                @endif    
                                            </td>
                                            <td>
                                                <form action="{{ route('prodi.jadwal.edit') }}" method="GET">
                                                    @csrf
                                                    <input type="text" hidden name="prodi" value="{{ $jadwal?->nama_prodi }}">
                                                    <input type="text" hidden name="semester" value="{{ $jadwal?->semester }}">
                                                    <input type="text" hidden name="matkul_id" value="{{ $jadwal?->matkul_id }}">
                                                    <input type="text" hidden name="matkul" value="{{ $jadwal?->nama_matkul }}">
                                                    <input type="text" hidden name="tipe_mk" value="{{ $jadwal?->tipe_mk }}">
                                                    <input type="text" hidden name="lokasi" value="{{ $jadwal?->lokasi }}">
                                                    <input type="text" hidden name="perbanyak" value="{{ $jadwal?->perbanyak }}">
                                                    <input type="text" hidden name="kertas" value="{{ $jadwal?->kertas }}">
                                                    <input type="text" hidden name="software" value="{{ $jadwal?->software }}">
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
