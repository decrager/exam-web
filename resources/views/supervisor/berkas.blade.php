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
                        <li><a href="">Beranda</a></li>
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
                        <h4 class="header-title">Soal Ujian</h4>

                        <div class="row justify-content-start">
                            @include('layouts.filter')
                        </div>

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
                                        <th>Lokasi</th>
                                        <th>Ruang</th>
                                        <th>Jumlah</th>
                                        <th>Pengambilan</th>
                                        <th>Fotokopi</th>
                                        <th>Lengkap</th>
                                        <th>Asisten</th>
                                        <th>Serah Terima</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($berkas as $ujian)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $ujian->tanggal }}</td>
                                            <td>{{ $ujian->Matkul->Semester->Prodi->nama_prodi }}</td>
                                            <td>{{ $ujian->Matkul->Semester->semester }}</td>
                                            <td>{{ $ujian->Praktikum->Kelas->kelas }}</td>
                                            <td>{{ $ujian->Praktikum->praktikum }}</td>
                                            <td>{{ $ujian->Matkul->nama_matkul }}</td>
                                            <td>{{ $ujian->tipe_mk }}</td>
                                            <td>{{ $ujian->lokasi }}</td>
                                            <td>{{ $ujian->ruang }}</td>
                                            <td>
                                                @if ($ujian->tipe_mk == 'K')
                                                    <?php $berkas = $ujian->Praktikum->Kelas->jml_mhs + 6; ?>
                                                @else
                                                    <?php $berkas = $ujian->Praktikum->jml_mhs + 3; ?>
                                                @endif
                                                {{ $berkas }}
                                            </td>
                                            <td>
                                                @if ($ujian->Berkas->pengambilan == 'Belum')
                                                    <button class="btn btn-danger btn-sm">Belum diambil</button>
                                                @else
                                                    <button class="btn btn-success btn-sm">Sudah diambil</button>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($ujian->Berkas->fotokopi == 'Belum')
                                                    <button class="btn btn-danger btn-sm">Belum difotokopi</button>
                                                @elseif ($ujian->Berkas->fotokopi == 'Sudah difotokopi')
                                                    <button class="btn btn-warning btn-sm">Sudah difotokopi</button>
                                                @else
                                                    <button class="btn btn-success btn-sm">Sudah diambil</button>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($ujian->Berkas->lengkap == 'Belum')
                                                    <button class="btn btn-danger btn-sm">Belum lengkap</button>
                                                @else
                                                    <button class="btn btn-success btn-sm">Sudah lengkap</button>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($ujian->Berkas->asisten == 'Belum')
                                                    <button class="btn btn-danger btn-sm">Belum diambil</button>
                                                @else
                                                    <button class="btn btn-success btn-sm">Sudah diambil</button>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($ujian->Berkas->serah_terima)
                                                    <button class="btn btn-danger btn-sm">Belum diserahkan</button>
                                                @else
                                                    <button class="btn btn-success btn-sm">Sudah diserahkan</button>
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