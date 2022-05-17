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
                    <h4 class="page-title pull-left">Pengajuan Ujian Susulan</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a >Beranda</a></li>
                        <li><a>Susulan</a></li>
                        <li><span>Pengajuan</span></li>
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
                        <h4 class="header-title">Pengajuan Ujian Susulan</h4>
                        <a href="{{ route('mahasiswa.susulan.pengajuan.form') }}"
                            class="btn btn-primary text-sm bg-blue px-3 mb-3">
                            Ajukan
                        </a>
                        <!-- <i class="fa fa-check text-danger"></i> -->

                        <div class="table-responsive">
                            <table id="example" class="table" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th class="col-2">Mata Kuliah</th>
                                        <th>Bukti Persyaratan</th>
                                        <th>status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($susulan as $pengajuan)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $pengajuan?->nama_matkul }}</td>
                                        <td><a href="{{ asset('storage/files/syarat/' . $pengajuan?->file) }}" target="_blank" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a></td>
                                        <td>
                                            @if ($pengajuan?->status == 'Belum')
                                                <span class="badge badge-warning">Belum disetujui</span>
                                            @elseif ($pengajuan?->status == 'Ditolak')
                                                <span class="badge badge-danger">Ditolak</span>
                                            @elseif ($pengajuan?->status == 'Disetujui')
                                                <span class="badge badge-success">Disetujui</span>
                                            @else
                                                <span class="badge badge-success bg-green">Terjadwal</span>
                                            @endif
                                        </td>
                                        @if ($pengajuan?->status == 'Belum')
                                        <td>
                                            <form action="{{ route('mahasiswa.susulan.delete', $pengajuan?->id) }}" class="btn-group" role="group" method="POST">
                                                <a href="{{ route('mahasiswa.susulan.pengajuan.edit', $pengajuan?->id) }}" class="btn btn-warning"><i class="fas fa-pen"></i></a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin membatalkan pengajuan?')"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                        @else
                                        <td>
                                            <button href="{{ route('mahasiswa.susulan.pengajuan.edit', $pengajuan?->id) }}" class="btn btn-warning"><i class="fas fa-pen"></i></button>
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin membatalkan pengajuan?')"><i class="fas fa-trash"></i></button>
                                        </td>
                                        @endif
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
