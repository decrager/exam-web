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
                    <h4 class="page-title pull-left">Jadwal Ujian Susulan</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="">Beranda</a></li>
                        <li><span>Jadwal Susulan</span></li>
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
                        <h4 class="header-title pt-2">Jadwal Ujian Susulan</h4>
                        <div class="row mb-1 justify-content-start">
                            @include('layouts.filter')
                        </div>
                        <!-- <i class="fa fa-check text-danger"></i> -->

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
                                        <th>Lokasi</th>
                                        <th>Kode Ruang</th>
                                        <th>Jam Mulai</th>
                                        <th>Jam Selesai</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ujian as $jadwal)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $jadwal->tanggal }}</td>
                                            <td>{{ $jadwal->Matkul->Semester->Prodi->nama_prodi }}</td>
                                            <td>{{ $jadwal->Matkul->Semester->semester }}</td>
                                            <td>{{ $jadwal->Praktikum->Kelas->kelas }}</td>
                                            <td>{{ $jadwal->Praktikum->praktikum }}</td>
                                            <td>{{ $jadwal->Matkul->nama_matkul }}</td>
                                            <td>{{ $jadwal->lokasi }}</td>
                                            <td>{{ $jadwal->ruang }}</td>
                                            <td>{{ $jadwal->jam_mulai }}</td>
                                            <td>{{ $jadwal->jam_selesai }}</td>
                                            <td><a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="{{ '#detail' . $jadwal->id }}"><i class="fas fa-info text-white"></i></a></td>
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

    <!-- Modal -->
    @foreach ($ujian as $jadwal)
        <div class="modal fade" id="{{ 'detail' . $jadwal->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- Textual inputs start -->
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body p-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <h6>Tanggal</h6>
                                                    <p>{{ $jadwal->tanggal }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Program Studi</h6>
                                                    <p>{{ $jadwal->Matkul->Semester->Prodi->nama_prodi }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Semester</h6>
                                                    <p>{{ $jadwal->Matkul->Semester->semester }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Kelas - Praktikum</h6>
                                                    <p>{{ $jadwal->Praktikum->Kelas->kelas }} -
                                                        {{ $jadwal->Praktikum->praktikum }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Kode Mata Kuliah</h6>
                                                    <p>{{ $jadwal->Matkul->kode_matkul }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Mata Kuliah</h6>
                                                    <p>{{ $jadwal->Matkul->nama_matkul }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Lokasi</h6>
                                                    <p>{{ $jadwal->lokasi }}</p>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <h6>Kode Ruang</h6>
                                                    <p>{{ $jadwal->ruang }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Jam Mulai - Jam Selesai</h6>
                                                    <p>{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Tipe Mata Kuliah</h6>
                                                    <p>{{ $jadwal->tipe_mk }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Sesi</h6>
                                                    <p>{{ $jadwal->sesi }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Software</h6>
                                                    <p>{{ $jadwal->software }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Pelaksanaan</h6>
                                                    <p>{{ $jadwal->pelaksanaan }}</p>
                                                </div>
                                            </div>
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
    @endforeach
@endsection