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
                    <h4 class="page-title pull-left">Pengawas</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a >Beranda</a></li>
                        <li><span>Pengawas</span></li>
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
                        <form action="/supervisor/pengawas" class="row justify-content-start">
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
                                        <th>Usulan Ruang</th>
                                        <th>Ruang</th>
                                        <th>Pengawas</th>
                                        <th>No. Rekening</th>
                                        <th>Bank</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pengawas as $row)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $row?->tanggal }}</td>
                                            <td>{{ $row?->nama_prodi }}</td>
                                            <td>{{ $row?->semester }}</td>
                                            <td>{{ $row?->kelas }}</td>
                                            <td>{{ $row?->praktikum }}</td>
                                            <td>{{ $row?->nama_matkul }}</td>
                                            <td>{{ $row?->lokasi }}</td>
                                            <td>{{ $row?->ruang }}</td>
                                            <td>{{ $row?->nama }}</td>
                                            <td>{{ $row?->norek }}</td>
                                            <td>{{ $row?->bank }}</td>
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
