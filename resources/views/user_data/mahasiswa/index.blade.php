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
                <h4 class="page-title pull-left">Mahasiswa</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="">Beranda</a></li>
                    <li><span>Mahasiswa</span></li>
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
                    <h4 class="header-title">Mahasiswa</h4>
                    <a href="{{ Route('data.mahasiswa.form') }}" class="btn btn-primary text-sm bg-blue px-3 mb-3">
                        Tambah Data
                    </a>
                    <div class="table-responsive">
                        <table id="example" class="table" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th class="col-2">Program Studi</th>
                                    <th>Semester</th>
                                    <th>Kelas</th>
                                    <th>Praktikum</th>
                                    <th>Nama</th>
                                    <th>NIM</th>
                                    <th>Email</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mahasiswa as $mahasiswa)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $mahasiswa?->Praktikum?->Kelas?->Semester?->Prodi?->nama_prodi }}</td>
                                    <td>{{ $mahasiswa?->Praktikum?->Kelas?->Semester?->semester }}</td>
                                    <td>{{ $mahasiswa?->Praktikum?->Kelas?->kelas }}</td>
                                    <td>{{ $mahasiswa?->Praktikum?->praktikum }}</td>
                                    <td>{{ $mahasiswa?->nama }}</td>
                                    <td>{{ $mahasiswa?->nim }}</td>
                                    <td>{{ $mahasiswa?->email }}</td>
                                    <td>
                                        <form action="{{ route('data.mahasiswa.destroy', $mahasiswa?->id) }}" method="POST" class="btn-group" role="group">
                                            <a href="{{ route('data.mahasiswa.edit', $mahasiswa?->id) }}" class="btn btn-warning"><i class="fas fa-pen"></i></a>
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
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