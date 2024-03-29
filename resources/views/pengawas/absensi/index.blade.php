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
                    <h4 class="page-title pull-left">Kehadiran</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a>Beranda</a></li>
                        <li><span>Kehadiran</span></li>
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
                @if (session()->has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        {{-- @if (session()->has('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif --}}
                        <h4 class="header-title">Jadwal Ujian</h4>
                        {{-- <a href="{{ route('pjLokasi.pengawas.absensi.export') }}" class="btn btn-danger text-sm px-3 py-2 mb-3 float-right">
                             <i class="fas fa-file-pdf">&nbsp; Export</i>
                        </a> --}}

                        <!-- <i class="fa fa-check text-danger"></i> -->

                        <div class="table-responsive">
                            <table id="example" class="table" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Program Studi</th>
                                        <th>Semester</th>
                                        <th>Mata Kuliah</th>
                                        <th>Kelas/Prak</th>
                                        <th>Ruang</th>
                                        <th>Jam</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jadwal as $ujian)
                                        <tr>
                                            <td>{{ $loop?->iteration }}</td>
                                            <td>{{ $ujian?->tanggal }}</td>
                                            <td>{{ $ujian?->nama_prodi }}</td>
                                            <td>{{ $ujian?->semester }}</td>
                                            <td>{{ $ujian?->nama_matkul }}</td>
                                            <td>{{ $ujian?->kelas }}/{{ $ujian?->praktikum }}</td>
                                            <td>{{ $ujian?->ruang }}</td>
                                            <td>{{ $ujian?->jam_mulai }} - {{ $ujian?->jam_selesai }}</td>
                                            <td>
                                                <a href="{{ route('pengawas.absensi.form', $ujian->id) }}" class="btn btn-primary">Isi &nbsp;<i class="fas fa-file-signature"></i></a>
                                                <a class="btn btn-danger text-sm @if($ujian?->kehadiran == null) disabled @endif" href="{{ asset('storage/files/kehadiran/' . $ujian?->kehadiran) }}" target="_blank"><i class="fas fa-file-pdf"></i></a>
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

    <script>
        $('.matkul-select').select2({
            theme: 'bootstrap-5',
            selectionCssClass: "select2normal",
            dropdownCssClass: "select2--small"
        });
    </script>
@endsection
