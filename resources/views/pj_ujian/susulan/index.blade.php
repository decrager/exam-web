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
                        <li><a>Beranda</a></li>
                        <li><a><span>Susulan</span></a></li>
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
                        @if (session()->has('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <h4 class="header-title pt-2">Jadwal Ujian Susulan</h4>
                        <form action="/pj_ujian/susulan/susulan" class="row mb-1 justify-content-start">
                            @include('layouts.filter')
                        </form>
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
                                        <th>Usulan Ruang</th>
                                        <th>Ruang</th>
                                        <th>Jam Mulai</th>
                                        <th>Jam Selesai</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($susulan as $susulan)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $susulan?->tanggal }}</td>
                                            <td>{{ $susulan?->Matkul?->Semester?->Prodi?->nama_prodi }}</td>
                                            <td>{{ $susulan?->Matkul?->Semester?->semester }}</td>
                                            <td>{{ $susulan?->Praktikum?->Kelas?->kelas }}</td>
                                            <td>{{ $susulan?->Praktikum?->praktikum }}</td>
                                            <td>{{ $susulan?->Matkul?->nama_matkul }}</td>
                                            <td>{{ $susulan?->lokasi }}</td>
                                            <td>{{ $susulan?->ruang }}</td>
                                            <td>{{ $susulan?->jam_mulai }}</td>
                                            <td>{{ $susulan?->jam_selesai }}</td>
                                            <td>
                                                <form action="{{ route('pjUjian.susulan.jadwal.destroy', $susulan?->id) }}"
                                                    method="POST" class="btn-group" role="group">
                                                    <a class="btn btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="{{ '#detail' . $susulan?->id }}"><i
                                                            class="fas fa-info text-white"></i></a>
                                                    <a href="{{ route('pjUjian.susulan.susulan.edit', $susulan?->id) }}"
                                                        class="btn btn-warning"> <i class="fas fa-pen"></i></a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="text" hidden name="prak_id" value="{{ $susulan?->prak_id }}">
                                                    <input type="text" hidden name="matkul_id" value="{{ $susulan?->matkul_id }}">
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus jadwal ujian susulan ini?')"> <i class="fas fa-trash"></i></button>
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

    <!-- Modal -->
    @foreach ($susulans as $ujian)
        <div class="modal fade" id="{{ 'detail' . $ujian?->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
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
                                                    <p>{{ $ujian?->tanggal }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Program Studi</h6>
                                                    <p>{{ $ujian?->Matkul?->Semester?->Prodi?->nama_prodi }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Semester</h6>
                                                    <p>{{ $ujian?->Matkul?->Semester?->semester }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Kelas - Praktikum</h6>
                                                    <p>{{ $ujian?->Praktikum?->Kelas?->kelas }} -
                                                        {{ $ujian?->Praktikum?->praktikum }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Kode Mata Kuliah</h6>
                                                    <p>{{ $ujian?->Matkul?->kode_matkul }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Mata Kuliah</h6>
                                                    <p>{{ $ujian?->Matkul?->nama_matkul }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Usulan Ruang</h6>
                                                    <p>{{ $ujian?->lokasi }}</p>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <h6>Kode Ruang</h6>
                                                    <p>{{ $ujian?->ruang }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Jam Mulai - Jam Selesai</h6>
                                                    <p>{{ $ujian?->jam_mulai }} - {{ $ujian?->jam_selesai }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Tipe Mata Kuliah</h6>
                                                    <p>{{ $ujian?->tipe_mk }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Sesi</h6>
                                                    <p>{{ $ujian?->sesi }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Software</h6>
                                                    <p>{{ $ujian?->software }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Pelaksanaan</h6>
                                                    <p>{{ $ujian?->pelaksanaan }}</p>
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
