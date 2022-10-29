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
                        <li><a href="{{ route('pengawas.absensi.index') }}">Kehadiran</a></li>
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
                <div class="card mb-3">
                    <div class="card-body">
                        <h4 class="header-title">Detail Ujian</h4>
                        <div class="row">
                            <div class="text-center">
                                <p><b>Tanggal</b></p>
                                <p>{{ $ujian?->tanggal }}</p>
                                <p><b>Program Studi</b></p>
                                <p>{{ $ujian?->Matkul?->Semester?->Prodi?->nama_prodi }}</p>
                                <p><b>Semester</b></p>
                                <p>{{ $ujian?->Matkul?->Semester?->semester }}</p>
                                <p><b>Mata Kuliah</b></p>
                                <p>{{ $ujian?->Matkul?->nama_matkul }}<br>{{ $ujian?->Matkul?->kode_matkul }}</p>
                                <p><b>Kelas / Praktikum</b></p>
                                <p>{{ $ujian?->Praktikum?->Kelas?->kelas }} / {{ $ujian?->Praktikum?->praktikum }}</p>
                                <p><b>Ruang</b></p>
                                <p>{{ $ujian?->ruang }}</p>
                                <p><b>Jam</b></p>
                                <p>{{ $ujian?->jam_mulai }} - {{ $ujian?->jam_selesai }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        @if (session()->has('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <h4 class="header-title float-left">Kehadiran</h4>
                        
                        <a href="{{ route('pengawas.absensi.ttd', $ujian->id) }}" class="btn btn-success text-sm px-3 py-2 mb-3 float-right">
                             <i class="fas fa-file-pdf">&nbsp; TTD</i>
                        </a>

                        <!-- <i class="fa fa-check text-danger"></i> -->

                        <div class="table-responsive">
                            <form method="post" action="{{ route('pengawas.absensi.update') }}">
                                @csrf
                                @method('PUT')
                                <table class="table" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th style="width: 5px">No</th>
                                            <th>NIM</th>
                                            <th>Nama</th>
                                            <th colspan="2">Kehadiran</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        <?php $i = 0; ?>
                                        @foreach ($mahasiswas as $mahasiswa)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $mahasiswa?->nim }}</td>
                                            <td>{{ $mahasiswa?->nama }}</td>
                                            <td>
                                                <div class="form-check">
                                                    @if ($mahasiswa?->kehadiran == "Hadir")
                                                        <input class="form-check-input" type="radio" name="{{ 'kehadiran['. $i .']' }}" id="{{ 'radio' . $mahasiswa?->id }}" value="Hadir" checked>
                                                    @elseif ($mahasiswa?->kehadiran == "Tidak Hadir")
                                                        <input class="form-check-input" type="radio" name="{{ 'kehadiran['. $i .']' }}" id="{{ 'radio' . $mahasiswa?->id }}" value="Hadir">
                                                    @else
                                                        <input class="form-check-input" type="radio" name="{{ 'kehadiran['. $i .']' }}" id="{{ 'radio' . $mahasiswa?->id }}" value="Hadir" checked>
                                                    @endif
                                                    <label class="form-check-label" for="{{ 'radio' . $mahasiswa?->id }}">Hadir</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check">
                                                    @if ($mahasiswa?->kehadiran == "Tidak Hadir")
                                                        <input class="form-check-input" type="radio" name="{{ 'kehadiran['. $i .']' }}" id="{{ 'radio' . $mahasiswa?->id }}" value="Tidak Hadir" checked>
                                                    @else
                                                        <input class="form-check-input" type="radio" name="{{ 'kehadiran['. $i .']' }}" id="{{ 'radio' . $mahasiswa?->id }}" value="Tidak Hadir">
                                                    @endif
                                                    <label class="form-check-label" for="{{ 'radio' . $mahasiswa?->id }}">Tidak Hadir</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php $i = $i + 1; ?>
                                        <input type="text" hidden value="{{ $mahasiswa?->id }}" name="mhs_id[]">
                                        @endforeach
                                    </tbody>
                                </table>

                                <input type="text" hidden value="{{ $ujian?->id }}" name="ujian_id">
                                @if ($ujian->tanggal == $now)
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                @else
                                    <button type="submit" class="btn btn-primary" disabled>Simpan</button>
                                @endif
                            </form>
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
