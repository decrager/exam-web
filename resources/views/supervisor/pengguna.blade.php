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
                    <h4 class="page-title pull-left">Pengguna</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="">Beranda</a></li>
                        <li><span>Pengguna</span></li>
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
                        <h4 class="header-title">Data Pengguna</h4>
                        
                        <div class="table-responsive">
                            <table id="example" class="table" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Lokasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pengguna as $pengguna)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $pengguna->name }}</td>
                                            <td>{{ $pengguna->email }}</td>
                                            <td>
                                                @if ($pengguna->role == 'data')
                                                    Data
                                                @elseif ($pengguna->role == 'pj_ujian')
                                                    PJ Ujian
                                                @elseif ($pengguna->role == 'prodi')
                                                    Program Studi
                                                @elseif ($pengguna->role == 'pj_lokasi')
                                                    PJ Lokasi
                                                @elseif ($pengguna->role == 'berkas')
                                                    Berkas
                                                @elseif ($pengguna->role == 'assisten')
                                                    Asisten Perlokasi
                                                @elseif ($pengguna->role == 'pj_susulan')
                                                    PJ Susulan
                                                @elseif ($pengguna->role == 'supervisor')
                                                    Supervisor
                                                @elseif ($pengguna->role == 'pj_online')
                                                    PJ Online
                                                @elseif ($pengguna->role == 'pj_labkom')
                                                    PJ Lab Kom
                                                @elseif ($pengguna->role == 'superadmin')
                                                    Superadmin
                                                @endif
                                            </td>
                                            <td>
                                                @if ($pengguna->lokasi == null)
                                                    -
                                                @else
                                                    {{ $pengguna->Lokasi }}
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