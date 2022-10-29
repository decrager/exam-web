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
                        <li><a >Beranda</a></li>
                        <li><a><span>Akademik</span></a></li>
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
                        @if (session()->has('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <h4 class="header-title">Mata Kuliah</h4>
                        <a href="{{ route('data.akademik.matkul.form') }}" class="btn btn-primary text-sm bg-blue px-3 mb-3">
                            Tambah Data
                        </a>
                        <div class="table-responsive">
                            <table id="example" class="table" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Program Studi</th>
                                        <th>Nama Program Studi</th>
                                        <th>Semester</th>
                                        <th>Kode MK</th>
                                        <th>Mata Kuliah</th>
                                        <th>SKS</th>
                                        <th>SKS Kuliah</th>
                                        <th>SKS Praktikum</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($matkul as $matkul)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $matkul?->Semester?->Prodi?->kode_prodi }}</td>
                                        <td>{{ $matkul?->Semester?->Prodi?->nama_prodi }}</td>
                                        <td>{{ $matkul?->Semester?->semester }}</td>
                                        <td>{{ $matkul?->kode_matkul }}</td>
                                        <td>{{ $matkul?->nama_matkul }}</td>
                                        <td>{{ $matkul?->sks }}</td>
                                        <td>{{ $matkul?->sks_kul }}</td>
                                        <td>{{ $matkul?->sks_prak }}</td>
                                        <td>
                                            <form action="{{ route('data.matkul.destroy', $matkul?->id) }}" method="POST" class="btn-group" role="group">
                                                <a href="{{ route('data.akademik.matkul.edit', $matkul?->id) }}" class="btn btn-warning"> <i class="fas fa-pen"></i></a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus praktikum ini?')"> <i class="fas fa-trash"></i></button>
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