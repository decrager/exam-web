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
                        <li><a>Rekapitulasi</a></li>
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
                        <div class="row justify-content-start">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select class="custom-select">
                                        <option selected="selected" value="">Program Studi</option>
                                        <option value="#">-</option>
                                        <option value="#">-</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select class="custom-select">
                                        <option selected="selected" value="">Semester</option>
                                        <option value="#">-</option>
                                        <option value="#">-</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select class="custom-select">
                                        <option selected="selected" value="">Mata Kuliah</option>
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
                                        <th class="col-1">No</th>
                                        <th class="col-2">Program Studi</th>
                                        <th>Semester</th>
                                        <th>Mata Kuliah</th>
                                        <th>Kelas</th>
                                        <th>Praktikum</th>
                                        <th>Jumlah Fotokopi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ujian as $ujian)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $ujian?->Matkul?->Semester?->Prodi?->nama_prodi }}</td>
                                            <td>{{ $ujian?->Matkul?->Semester?->semester }}</td>
                                            <td>{{ $ujian?->Matkul?->nama_matkul }}</td>
                                            <td>{{ $ujian?->Praktikum?->Kelas?->kelas }}</td>
                                            <td>{{ $ujian?->Praktikum?->praktikum }}</td>
                                            <td>
                                                @if ($ujian?->tipe_mk == 'K')
                                                    <?php $berkas = $ujian?->Praktikum?->Kelas?->jml_mhs + 6; ?>
                                                @else
                                                    <?php $berkas = $ujian?->Praktikum?->jml_mhs + 3; ?>
                                                @endif
                                                {{ $berkas }}
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
