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
                    <h4 class="page-title pull-left">Soal Ujian</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a >Beranda</a></li>
                        <li><a><span>Kelengkapan</span></a></li>
                        <li><span>Soal Ujian</span></li>
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
                        <h4 class="header-title">Soal Ujian</h4>
                        <a href="{{ route('pjUjian.kelengkapan.berkas.ttd') }}" class="btn btn-success justify-content-end text-sm px-3 mb-3">Serah Terima Berkas</a>
                        <form action="/pj_ujian/kelengkapan/berkas" class="row justify-content-start">
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
                                        <th>Tipe</th>
                                        <th>Ruang</th>
                                        <th>Kalibrasi</th>
                                        <th>Verifikasi</th>
                                        <th>Validasi</th>
                                        <th>Fotokopi</th>
                                        <th>Lengkap</th>
                                        <th>Asisten</th>
                                        <th>Serah Terima</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($berkas as $ujian)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $ujian?->tanggal }}</td>
                                            <td>{{ $ujian?->Matkul?->Semester?->Prodi?->nama_prodi }}</td>
                                            <td>{{ $ujian?->Matkul?->Semester?->semester }}</td>
                                            <td>{{ $ujian?->Praktikum?->Kelas?->kelas }}</td>
                                            <td>{{ $ujian?->Praktikum?->praktikum }}</td>
                                            <td>{{ $ujian?->Matkul?->nama_matkul }}</td>
                                            <td>{{ $ujian?->tipe_mk }}</td>
                                            <td>{{ $ujian?->ruang }}</td>
                                            <td>
                                                @if ($ujian?->Berkas?->kalibrasi == 'Belum')
                                                    <button class="btn btn-danger btn-sm">Belum dikalibrasi</button>
                                                @else
                                                    <button class="btn btn-success btn-sm">Sudah dikalibrasi</button>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($ujian?->Berkas?->verifikasi == 'Belum')
                                                    <button class="btn btn-danger btn-sm">Belum diverifikasi</button>
                                                @else
                                                    <button class="btn btn-success btn-sm">Terverifikasi</button>
                                                @endif
                                            </td>
                                            <td>
                                                <form action="{{ route('pjUjian.berkas.update', $ujian?->Berkas?->id) }}"
                                                    method="POST" class="btn-group" role="group">
                                                    @if ($ujian?->Berkas?->validasi == 'Belum')
                                                        <button class="btn btn-danger btn-sm">Belum divalidasi</button>
                                                    @else
                                                        <button class="btn btn-success btn-sm">Tervalidasi</button>
                                                    @endif
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-success btn-sm"
                                                        onclick="return confirm('Yakin mengubah status pengambilan?')"><i
                                                            class="fas fa-check"></i></button>
                                                </form>
                                            </td>
                                            <td>
                                                @if ($ujian?->Berkas?->fotokopi == 'Belum')
                                                    <button class="btn btn-danger btn-sm">Belum difotokopi</button>
                                                @elseif ($ujian?->Berkas?->fotokopi == 'Sudah difotokopi')
                                                    <button class="btn btn-warning btn-sm">Sudah difotokopi</button>
                                                @else
                                                    <button class="btn btn-success btn-sm">Sudah diambil</button>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($ujian?->Berkas?->lengkap == 'Belum')
                                                    <button class="btn btn-danger btn-sm">Belum lengkap</button>
                                                @else
                                                    <button class="btn btn-success btn-sm">Sudah lengkap</button>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($ujian?->Berkas?->asisten == 'Belum')
                                                    <button class="btn btn-danger btn-sm">Belum diambil</button>
                                                @else
                                                    <button class="btn btn-success btn-sm">Sudah diambil</button>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($ujian?->Berkas?->serah_terima == 'Belum')
                                                    <button class="btn btn-danger btn-sm">Belum diserahkan</button>
                                                @else
                                                    <button class="btn btn-success btn-sm">Sudah diserahkan</button>
                                                @endif
                                            </td>
                                            <td>
                                                <form action="{{ route('pjUjian.serahterima.destroy', $ujian?->id) }}" method="POST" class="btn-group" role="group">
                                                    <a class="btn btn-success @if($ujian?->Berkas?->file == null) disabled @endif" href="{{ asset('storage/files/pdf/' . $ujian?->Berkas?->file) }}" target="_blank"><i class="fas fa-download"></i></a>
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-danger @if($ujian?->Berkas?->serah_terima == 'Belum') disabled @endif" onclick="return confirm('Yakin ingin menghapus file Serah Terima untuk ujian ini?')"><i class="fas fa-trash"></i></button>
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
