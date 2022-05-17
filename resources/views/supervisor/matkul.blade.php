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
                    <h4 class="page-title pull-left">Mata Kuliah</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="">Beranda</a></li>
                        <li><span>Mata Kuliah</span></li>
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
                        <h4 class="header-title">Mata Kuliah</h4>
                        <div class="table-responsive">
                            <table id="example" class="table" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th class="col-2">Program Studi</th>
                                        <th>Semester</th>
                                        <th class="col-2">Mata Kuliah</th>
                                        <th>Tipe Mata Kuliah</th>
                                        <th>Perbanyak</th>
                                        <th>Jumlah Fotokopi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($matkul as $ujian)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $ujian?->tanggal }}</td>
                                            <td>{{ $ujian?->nama_prodi }}</td>
                                            <td>{{ $ujian?->semester }}</td>
                                            <td>{{ $ujian?->nama_matkul }}</td>
                                            <td>{{ $ujian?->tipe_mk }}</td>
                                            <td>
                                                @if ($ujian?->perbanyak == 1)
                                                    <span class="badge bg-success">Perbanyak</span>
                                                @else
                                                    <span class="badge bg-danger">Tidak</span>
                                                @endif
                                            </td>
                                            <td>{{ $ujian?->jumlah }}</td>
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