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
                    <h4 class="page-title pull-left">Daftar Pengawas</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a >Beranda</a></li>
                        <li><span>Daftar Pengawas</span></li>
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
                        <div class="mb-3">
                            <h4 class="header-title justify-content-start d-inline">Daftar Pengawas</h4>
                            <button class="btn btn-success mb-3 float-end" data-bs-toggle="modal" data-bs-target="#export">
                                <i class="fas fa-file-excel-o">&ensp;Export</i>
                            </button>
                        </div>
                        <form action="/pj_ujian/pengawas" class="row">
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
                                        <th>Kelas / Prk</th>
                                        <th class="col-2">Mata Kuliah</th>
                                        <th>Waktu</th>
                                        <th>Ruang</th>
                                        <th>Pengawas</th>
                                        {{-- <th>No. Rekening</th>
                                        <th>Bank</th> --}}
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataPengawas as $pengawas)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $pengawas?->tanggal }}</td>
                                            <td>{{ $pengawas?->nama_prodi }}</td>
                                            <td>{{ $pengawas?->semester }}</td>
                                            <td>{{ $pengawas?->kelas }} / {{ $pengawas?->praktikum }}</td>
                                            <td>{{ $pengawas?->nama_matkul }}</td>
                                            <td>{{ $pengawas?->jam_mulai }} - {{ $pengawas?->jam_selesai }}</td>
                                            <td>{{ $pengawas?->ruang }}</td>
                                            <td>{{ $pengawas?->nama }}</td>
                                            {{-- <td>{{ $pengawas?->norek }}</td>
                                            <td>{{ $pengawas?->bank }}</td> --}}
                                            <td>
                                                <form action="{{ route('pjUjian.pengawas.destroy', $pengawas?->id) }}" method="POST">
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('pjUjian.pengawas.pengawas.edit', $pengawas?->id) }}" class="btn btn-warning"> <i class="fas fa-pen"></i></a>
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus data?')"> <i class="fas fa-trash"></i></button>
                                                    </div>
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

    <div class="modal fade" id="export" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pilih Lokasi Pengawas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Textual inputs start -->
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body p-2">
                                    <div class="row">
                                        @foreach ($dbLokasi as $lokasi)
                                        <form action="{{ route('pjUjian.pengawas.export') }}" class="col-4 text-center mb-3">
                                            <button type="submit" class="btn btn-primary" style="width: 125px">
                                                <input type="text" name="lokasi" id="lokasi" value="{{ $lokasi->lokasi }}" hidden>
                                                <i class="fas fa-location-dot">&nbsp; {{ $lokasi->lokasi }}</i>
                                            </button>
                                        </form>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Textual inputs end -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
