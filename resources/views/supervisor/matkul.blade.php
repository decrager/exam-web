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
                        <h4 class="header-title">Mata Kuliah</h4>
                        <form action="/supervisor/matkul" class="row justify-content-start">
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
                                        <th>Perbanyak</th>
                                        <th>Jumlah Fotokopi</th>
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
                                            <td>
                                                @if ($ujian?->perbanyak == "1")
                                                    <span class="badge badge-success">Perbanyak</span>
                                                @elseif ($ujian?->perbanyak == "2")
                                                    <span class="badge badge-danger">Tidak</span>
                                                @else 
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $ujian?->jumlah }}</td>
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