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
                        <h4 class="header-title">Daftar Pengawas</h4>
                        <form action="/prodi/pengawas/daftar" class="row mb-1 justify-content-start">
                            <div class="col-md-2">
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
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select class="custom-select matkul-select" name="dbMatkul" id="dbMatkul">
                                        @if (request('dbMatkul'))
                                            <option value="">Mata Kuliah</option>
                                            <option selected="selected" value="{{ request('dbMatkul') }}">{{ request('dbMatkul') }}</option>
                                        @else
                                            <option selected="selected" value="">Mata Kuliah</option>
                                        @endif
                                        @foreach ($matkuls as $matkul)
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
                            <div class="col-auto">
                                <div class="form-group">
                                    <select class="custom-select" name="dbRuang">
                                        @if (request('dbRuang'))
                                            <option value="">Ruang</option>
                                            <option selected="selected" value="{{ request('dbRuang') }}">{{ request('dbRuang') }}</option>
                                        @else
                                            <option selected="selected" value="">Kode Ruang</option>
                                        @endif
                                        @foreach ($dbRuang as $ruang)
                                            <option value="{{ $ruang->ruangan }}">{{ $ruang->ruangan }}</option>
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
                                        <th>Kelas / Prk</th>
                                        <th class="col-2">Mata Kuliah</th>
                                        <th>Waktu</th>
                                        <th>Ruang</th>
                                        <th>Pengawas</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pengawas as $pengawas)
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
                                                <form action="{{ route('prodi.pengawas.destroy', $pengawas?->id) }}" method="POST">
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('prodi.pengawas.penugasan.edit', $pengawas?->id) }}" class="btn btn-warning"> <i class="fas fa-pen"></i></a>
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
@endsection
