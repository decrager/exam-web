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
                        <li><a >Beranda</a></li>
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
                        <h4 class="header-title">Mahasiswa</h4>
                        <form action="/supervisor/mahasiswa" class="row mb-1 justify-content-start">
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
                            <div class="col-auto">
                                <div class="form-group">
                                    <select class="custom-select" name="dbKelas" id="dbKelas">
                                        @if (request('dbKelas'))
                                            <option value="">Kelas</option>
                                            <option selected="selected" value="{{ request('dbKelas') }}">{{ request('dbKelas') }}</option>
                                        @else
                                            <option selected="selected" value="">Kelas</option>
                                        @endif
                                        @foreach ($dbKelas as $kelas)
                                            <option value="{{ $kelas->kelas }}">{{ $kelas->kelas }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-group">
                                    <select class="custom-select" name="dbPraktikum" id="dbPraktikum">
                                        @if (request('dbPraktikum'))
                                            <option value="">Praktikum</option>
                                            <option selected="selected" value="{{ request('dbPraktikum') }}">{{ request('dbPraktikum') }}</option>
                                        @else
                                            <option selected="selected" value="">Praktikum</option>
                                        @endif
                                        @foreach ($dbPraktikum as $praktikum)
                                            <option value="{{ $praktikum->praktikum }}">{{ $praktikum->praktikum }}</option>
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
                                        <th class="col-2">Program Studi</th>
                                        <th>Semester</th>
                                        <th>Kelas</th>
                                        <th>Praktikum</th>
                                        <th>Nama</th>
                                        <th>NIM</th>
                                        <th>Email</th>
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