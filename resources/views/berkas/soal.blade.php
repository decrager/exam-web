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
                    <h4 class="page-title pull-left">Data Berkas</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a>Beranda</a></li>
                        <li><span>Data Berkas</span></li>
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
                        <h4 class="header-title">Mata Kuliah</h4>
                        <form action="/berkas/soal" class="row justify-content-start">
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
                            <div class="col-auto">
                                <div class="form-group">
                                    <select class="custom-select" name="dbSemester" id="dbSemester">
                                        @if (request('dbSemester'))
                                            <option value="">Semester</option>
                                            <option selected="selected" value="{{ request('dbSemester') }}">{{ request('dbSemester') }}</option>
                                        @else
                                            <option selected="selected" value="">Semester</option>
                                        @endif
                                        @foreach ($dbSemester as $semester)
                                            <option value="{{ $semester->semester }}">{{ $semester->semester }}</option>
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
                            <div class="col-auto">
                                <div class="form-group">
                                    <input type="date" name="dbTanggal" id="tanggal" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-1 align-content-center">
                                <button type="submit" class="btn btn-primary py-2"> <i class="fas fa-filter"></i></button>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table id="example" class="table" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th class="col-2">Program Studi</th>
                                        <th>Semester</th>
                                        <th class="col-2">Mata Kuliah</th>
                                        <th>Perbanyak Teori</th>
                                        <th>Perbanyak Praktik</th>
                                        <th>Kertas Buram</th>
                                        <th>Jumlah Fotokopi</th>
                                        <th>Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($soal as $ujian)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $ujian?->tanggal }}</td>
                                            <td>{{ $ujian?->nama_prodi }}</td>
                                            <td>{{ $ujian?->semester }}</td>
                                            <td>{{ $ujian?->nama_matkul }}</td>
                                            @if ($ujian?->perbanyak == "1")
                                                <td><span class="badge badge-success">Ya</span></td>
                                                <td><span class="badge badge-success">Ya</span></td>
                                            @elseif ($ujian?->perbanyak == "2")
                                                <td><span class="badge badge-danger">Tidak</span></td>
                                                <td><span class="badge badge-danger">Tidak</span></td>
                                            @elseif ($ujian?->perbanyak == "3")
                                                <td><span class="badge badge-success">Ya</span></td>
                                                <td><span class="badge badge-danger">Tidak</span></td>
                                            @elseif ($ujian?->perbanyak == "4")
                                                <td><span class="badge badge-danger">Tidak</span></td>
                                                <td><span class="badge badge-success">Ya</span></td>
                                            @else
                                                <td>-</td>
                                                <td>-</td>
                                            @endif
                                            <td>
                                                @if ($ujian?->kertas == "0" || empty($ujian->kertas))
                                                    -
                                                @elseif ($ujian?->kertas == "1")
                                                    <span class="badge badge-success">Pakai</span>
                                                @elseif ($ujian?->kertas == "2")
                                                    <span class="badge badge-danger">Tidak Pakai</span>
                                                @endif
                                            </td>
                                            <td>{{ $ujian?->jumlah }}</td>
                                            <td><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="{{ '#detail' . $ujian?->id }}"><i class="fas fa-info text-white"></i></button></td>
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

    @foreach ($soal as $matkul)
        <div class="modal fade" id="{{ 'detail' . $matkul?->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Detail Kelas</h5>
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
                                            @foreach ($prak as $ujian)
                                                @if ($ujian?->id == $matkul?->id)
                                                    <div class="col-4 text-center mb-3">
                                                        <div class="row">
                                                            <h6 class="">Kelas {{ $ujian?->kelas }}/{{ $ujian?->praktikum }}</h6>
                                                        </div>
                                                        <div class="row">
                                                            <h5><span class="badge bg-primary">{{ $ujian?->jml_mhs + 3 }}</span></h5>
                                                        </div>
                                                    </div>
                                                @endif
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
    @endforeach
@endsection
