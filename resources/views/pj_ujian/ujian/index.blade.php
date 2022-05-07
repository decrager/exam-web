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
                    <h4 class="page-title pull-left">Jadwal Ujian</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="">Beranda</a></li>
                        <li><span>Jadwal Ujian</span></li>
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
                        <h4 class="header-title">Daftar Jadwal Ujian</h4>
                        <div class="float-right">
                            <button class="btn btn-success py-2 mr-2">Export &nbsp;&nbsp;<i class="fas fa-file-excel-o"></i></button>
                            <a href="{{ route('pjUjian.jadwal.tambah') }}"
                                class="btn btn-primary bg-blue float-right mb-3 py-2">
                                Tambah Jadwal
                            </a>
                        </div>
                        <div class="row justify-content-start">
                            <div class="col-md-2 pl--0">
                                <div class="form-group">
                                    <select class="custom-select">
                                        <option selected="selected">Program Studi</option>
                                        <option value="#">-</option>
                                        <option value="#">-</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select class="custom-select">
                                        <option selected="selected">Semester</option>
                                        <option value="#">-</option>
                                        <option value="#">-</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select class="custom-select">
                                        <option selected="selected">Kelas</option>
                                        <option value="#">-</option>
                                        <option value="#">-</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select class="custom-select">
                                        <option selected="selected">Praktikum</option>
                                        <option value="#">-</option>
                                        <option value="#">-</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select class="custom-select">
                                        <option selected="selected">Mata Kuliah</option>
                                        <option value="#">-</option>
                                        <option value="#">-</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1 align-content-center">
                                <button class="btn btn-primary py-2"><i class="fas fa-filter"></i></button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="example" class="table" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th class="col-2">Program Studi</th>
                                        <th>Semester</th>
                                        <th>Kelas</th>
                                        <th>Praktikum</th>
                                        <th class="col-2">Mata Kuliah</th>
                                        <th>Lokasi</th>
                                        <th>Ruang</th>
                                        <th>Hari</th>
                                        <th>Tanggal</th>
                                        <th>Jam Mulai</th>
                                        <th>Jam Selesai</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Manajemen Informatika</td>
                                        <td>4</td>
                                        <td>A</td>
                                        <td>2</td>
                                        <td>RPL</td>
                                        <td>K-35</td>
                                        <td>Lab. Komputer</td>
                                        <td>Senin</td>
                                        <td>09/05/2022</td>
                                        <td>08.00</td>
                                        <td>10.00</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#detail"><i
                                                        class="fas fa-info text-white"></i></button>
                                                <button class="btn btn-warning"><i class="fas fa-pen"></i></button>
                                                <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- data table end -->
        </div>
    </div>

    <div class="modal fade" id="detail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                <p>Value</p>
                                            </div>
                                            <div class="form-group">
                                                <h6>Program Studi</h6>
                                                <p>Value</p>
                                            </div>
                                            <div class="form-group">
                                                <h6>Semester</h6>
                                                <p>Value</p>
                                            </div>
                                            <div class="form-group">
                                                <h6>Kelas - Praktikum</h6>
                                                <p>Value - value</p>
                                            </div>
                                            <div class="form-group">
                                                <h6>Mata Kuliah</h6>
                                                <p>Value</p>
                                            </div>
                                            <div class="form-group">
                                                <h6>Lokasi</h6>
                                                <p>Value</p>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <h6>Ruang</h6>
                                                <p>Value</p>
                                            </div>
                                            <div class="form-group">
                                                <h6>Jam Mulai - Jam Selesai</h6>
                                                <p>Value - Value</p>
                                            </div>
                                            <div class="form-group">
                                                <h6>Tipe Mata Kuliah</h6>
                                                <p>Value</p>
                                            </div>
                                            <div class="form-group">
                                                <h6>Sesi</h6>
                                                <p>Value</p>
                                            </div>
                                            <div class="form-group">
                                                <h6>Software</h6>
                                                <p>Value</p>
                                            </div>
                                            <div class="form-group">
                                                <h6>Pelaksanaan</h6>
                                                <p>Value</p>
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
@endsection
