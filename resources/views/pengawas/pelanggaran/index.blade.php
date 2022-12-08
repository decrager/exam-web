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
                    <h4 class="page-title pull-left">Rekapitulasi Ketidakhadiran</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a >Beranda</a></li>
                        <li><span>Ketidakhadiran</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="main-content-inner">
        <!-- page title area end -->
        <div class="row mb-3">
            <!-- data table start -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Rekapitulasi Ketidakhadiran</h4>
                        <figure class="highcharts-figure">
                            <div id="container"></div>
                        </figure>
                    </div>
                </div>
            </div>
            <!-- data table end -->
        </div>

        <div class="row">
            <!-- data table start -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Ketidakhadiran</h4>
                        {{-- <a href="{{ route('pengawas.ketidakhadiran.form') }}" class="btn btn-primary text-sm bg-blue px-3 mb-3">Tambah Data</a> --}}
                        <div class="table-responsive">
                            <table id="example" class="table" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>NIM</th>
                                        <th class="col-2">Program Studi</th>
                                        <th>Semester</th>
                                        <th>Jumlah Ketidakhadiran</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mhs as $mhs)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $mhs?->nama }}</td>
                                            <td>{{ $mhs?->nim }}</td>
                                            <td>{{ $mhs?->nama_prodi }}</td>
                                            <td>{{ $mhs?->semester }}</td>
                                            <td>{{ $mhs?->total }}</td>
                                            <td><button class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="{{ '#detail' . $mhs?->mhs_id }}"><i
                                                        class=" fas fa-info"></i></button></td>
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
    </div>

    <!-- Modal -->
    @foreach ($mhs2 as $mhs)
        <div class="modal fade" id="{{ 'detail' . $mhs?->mhs_id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Detail Ketidakhadiran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="max-height: 600px;">
                        <div class="row">
                            <!-- Textual inputs start -->
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body p-2">
                                        <div class="row">
                                            <div class="col-5">
                                                <div class="form-group">
                                                    <h6>Nama</h6>
                                                    <p>{{ $mhs?->nama }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>NIM</h6>
                                                    <p>{{ $mhs?->nim }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Program Studi</h6>
                                                    <p>{{ $mhs?->nama_prodi }}
                                                    </p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Semester</h6>
                                                    <p>{{ $mhs?->semester }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Kelas - Praktikum</h6>
                                                    <p>{{ $mhs?->kelas }} -
                                                        {{ $mhs?->praktikum }}</p>
                                                </div>
                                            </div>
                                            <div class="col-7">
                                                @foreach ($allPelanggaran as $pelanggaran)
                                                    @if ($pelanggaran?->mhs_id == $mhs?->mhs_id)
                                                        <div class="row">
                                                            <div class="col-7">
                                                                <h6 class="mb-2 pt-1">Ketidakhadiran:</h6>
                                                            </div>
                                                            {{-- <div class="col-5">
                                                                <a href="/pengawas/ketidakhadiran/edit/{{ $pelanggaran?->id }}" class="btn btn-warning btn-sm"><i
                                                                    class="fas fa-pen"></i></a>
                                                                <form class="btn-group" role="group" action="/pengawas/ketidakhadiran/delete/{{ $pelanggaran?->id }}" method="POST">
                                                                    @csrf
                                                                    @method('delete')

                                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')"><i class="fas fa-trash"></i></button>
                                                                </form>
                                                            </div> --}}
                                                        </div>
                                                        <div class="form-group pl-3">
                                                            <h6>Mata Kuliah</h6>
                                                            <p>{{ $pelanggaran?->Ujian?->tanggal }}</p>
                                                        </div>
                                                        <div class="form-group pl-3">
                                                            <h6>Mata Kuliah</h6>
                                                            <p>{{ $pelanggaran?->Ujian?->Matkul?->nama_matkul }}</p>
                                                        </div>
                                                        <div class="form-group pl-3 mb-2">
                                                            <h6>Alasan</h6>
                                                            <p>{{ $pelanggaran?->pelanggaran }}</p>
                                                        </div>
                                                    @endif
                                                @endforeach
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
