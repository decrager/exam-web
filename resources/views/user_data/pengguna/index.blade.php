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
                        <li><a >Beranda</a></li>
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
                        @if (session()->has('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <h4 class="header-title">Data Pengguna</h4>
                        <a href="{{ route('data.pengguna.form') }}" class="btn btn-primary text-sm bg-blue px-3 mb-3">
                            Tambah Data
                        </a>
                        <div class="table-responsive">
                            <table id="example" class="table" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Lokasi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pengguna as $pengguna)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $pengguna?->name }}</td>
                                            <td>{{ $pengguna?->email }}</td>
                                            <td>
                                                @if ($pengguna?->role == 'data')
                                                    Data & Akademik
                                                @elseif ($pengguna?->role == 'pj_ujian')
                                                    PJ Ujian
                                                @elseif ($pengguna?->role == 'prodi')
                                                    Program Studi
                                                @elseif ($pengguna?->role == 'pj_lokasi')
                                                    PJ Lokasi
                                                @elseif ($pengguna?->role == 'berkas')
                                                    Berkas
                                                @elseif ($pengguna?->role == 'assisten')
                                                    Asisten Perlokasi
                                                @elseif ($pengguna?->role == 'pj_susulan')
                                                    PJ Susulan
                                                @elseif ($pengguna?->role == 'supervisor')
                                                    Supervisor
                                                @elseif ($pengguna?->role == 'pj_online')
                                                    PJ Online
                                                @elseif ($pengguna?->role == 'pj_labkom')
                                                    PJ Lab Kom
                                                @endif
                                            </td>
                                            <td>{{ $pengguna?->lokasi }}</td>
                                            <td>
                                                <form action="{{ route('data.pengguna.destroy', $pengguna?->id) }}" method="POST" class="btn-group" role="group">
                                                    <a href="{{ route('data.pengguna.edit', $pengguna?->id) }}" class="btn btn-warning"> <i class="fas fa-pen"></i></a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus pengguna ini?')"> <i class="fas fa-trash"></i></button>
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
