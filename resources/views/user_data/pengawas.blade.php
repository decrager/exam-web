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
                    <h4 class="page-title pull-left">Kehadiran Pengawas</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a >Beranda</a></li>
                        <li><a>Pengawas</a></li>
                        <li><span>Kehadiran</span></li>
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
                        <h4 class="header-title">Kehadiran</h4>
                        <a href="#" class="btn btn-danger text-sm px-3 py-2 mb-3 float-right">
                             <i class="fas fa-file-pdf">&nbsp; Export</i>
                        </a>
                        <form action="/pj_lokasi/pengawas/kehadiran" class="row justify-content-start">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select class="custom-select" name="dbProdi" id="dbProdi">
                                        @if (request('dbProdi'))
                                            <option value="">Program Studi</option>
                                            <option selected="selected" value="{{ request('dbProdi') }}">{{ request('dbProdi') }}</option>
                                        @else
                                            <option selected="selected" value="">Program Studi</option>
                                        @endif
                                        @foreach ($dbProdi as $prodi)
                                            <option value="{{ $prodi->nama_prodi }}">{{ $prodi->nama_prodi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select class="custom-select matkul-select" name="dbMatkul" id="dbMatkul">
                                        @if (request('dbMatkul'))
                                            <option value="">Mata Kuliah</option>
                                            <option selected="selected" value="{{ request('dbMatkul') }}">{{ request('dbMatkul') }}</option>
                                        @else
                                            <option selected="selected" value="">Mata Kuliah</option>
                                        @endif
                                        @foreach ($dbMatkul as $matkul)
                                            <option value="{{ $matkul->nama_matkul }}">{{ $matkul->nama_matkul }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1 align-content-center">
                                <button type="submit" class="btn btn-primary py-2"> <i class="fas fa-filter"></i></button>
                            </div>
                        </form>

                        <!-- <i class="fa fa-check text-danger"></i> -->

                        <div class="table-responsive">
                            <table id="example" class="table" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Status Kepegawaian</th>
                                        <th>Nomor Telepon</th>
                                        <th class="col-2">Program Studi</th>
                                        <th class="col-2">Mata Kuliah</th>
                                        <th>Ruang</th>
                                        <th>Kehadiran</th>
                                        <th>File</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($penugasan as $pengawas)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $pengawas?->nama }}</td>
                                            <td>{{ $pengawas?->pns }}</td>
                                            <td>{{ $pengawas?->tlp }}</td>
                                            <td>{{ $pengawas?->nama_prodi }}</td>
                                            <td>{{ $pengawas?->nama_matkul }}</td>
                                            <td>{{ $pengawas?->ruang }}</td>
                                            <td>
                                                @if ($pengawas?->presensi)
                                                <span class="badge badge-success">Hadir</span>
                                                @else
                                                <span class="badge badge-warning text-dark">Belum Hadir</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ asset('storage/files/pdf/' . $pengawas?->file) }}" target="_blank" class="btn btn-success btn-sm @if($pengawas?->file == null) disabled @endif"><i class="fas fa-eye"></i></a>
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
