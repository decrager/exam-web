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
                    <h4 class="page-title pull-left">Amplop</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a>Beranda</a></li>
                        <li><a><span>Kelengkapan</span></a></li>
                        <li><span>Amplop</span></li>
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
                        <h4 class="header-title">Amplop</h4>
                        <form action="/berkas/kelengkapan/amplop" class="row justify-content-start">
                            @include('layouts.filter')
                        </form>

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
                                        <th>Tipe</th>
                                        <th>Ruang</th>
                                        <th>Print</th>
                                        <th>Pengambilan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($amplop as $ujian)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $ujian?->tanggal }}</td>
                                            <td>{{ $ujian?->Matkul?->Semester?->Prodi?->nama_prodi }}</td>
                                            <td>{{ $ujian?->Matkul?->Semester?->semester }}</td>
                                            <td>{{ $ujian?->Praktikum?->Kelas?->kelas }}</td>
                                            <td>{{ $ujian?->Praktikum?->praktikum }}</td>
                                            <td>{{ $ujian?->Matkul?->nama_matkul }}</td>
                                            <td>{{ $ujian?->tipe_mk }}</td>
                                            <td>{{ $ujian?->ruang }}</td>
                                            <td>
                                                @if ($ujian?->Amplop?->print == 'Belum')
                                                    <button class="btn btn-danger btn-sm">Belum diprint</button>
                                                @else
                                                    <button class="btn btn-success btn-sm">Sudah diprint</button>
                                                @endif
                                            </td>
                                            <td>
                                                <form class="btn-group" role="group" action="{{ route('berkas.amplop.update', $ujian?->Amplop?->id) }}" method="POST">
                                                    @if ($ujian?->Amplop?->pengambilan == 'Belum')
                                                        <button class="btn btn-danger btn-sm">Belum diambil</button>
                                                    @else
                                                        <button class="btn btn-success btn-sm">Sudah diambil</button>
                                                    @endif
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Yakin ingin mengubah status Pengambilan?')"> <i class="fas fa-check"></i></button>
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
