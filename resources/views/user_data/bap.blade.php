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
                    <h4 class="page-title pull-left">Ketersediaan BAP</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a >Beranda</a></li>
                        <li><a><span>Ketersediaan</span></a></li>
                        <li><span>BAP</span></li>
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
                        <h4 class="header-title">BAP</h4>
                        <form action="/data/bap" class="row justify-content-start">
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
                                        <th>Ruang</th>
                                        <th>Print</th>
                                        <th>Pengambilan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bap as $ujian)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $ujian?->tanggal }}</td>
                                        <td>{{ $ujian?->Matkul?->Semester?->Prodi?->nama_prodi }}</td>
                                        <td>{{ $ujian?->Matkul?->Semester?->semester }}</td>
                                        <td>{{ $ujian?->Praktikum?->Kelas?->kelas }}</td>
                                        <td>{{ $ujian?->Praktikum?->praktikum }}</td>
                                        <td>{{ $ujian?->Matkul?->nama_matkul }}</td>
                                        <td>{{ $ujian?->ruang }}</td>
                                        <td>
                                            <form action="{{ route('data.bap.update', $ujian?->Bap?->id) }}" method="POST" class="btn-group" role="group">
                                                @if ($ujian?->Bap?->print == 'Belum')
                                                    <button class="btn btn-danger btn-sm">Belum diprint</button>
                                                @else
                                                    <button class="btn btn-success btn-sm">Sudah diprint</button>
                                                @endif
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Yakin ingin mengubah status BAP?')"> <i class="fas fa-check"></i></button>
                                            </form>
                                        </td>
                                        <td>
                                            @if ($ujian?->Bap?->pengambilan == 'Belum')
                                                <button class="btn btn-danger btn-sm">Belum diambil</button>
                                            @else
                                                <button class="btn btn-success btn-sm">Sudah diambil</button>
                                            @endif
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
