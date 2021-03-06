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
                    <h4 class="page-title pull-left">Ubah Data Ujian</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a >Beranda</a></li>
                        <li><a ><span>Data Ujian</span></a></li>
                        <li><span>Ubah Data Ujian</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- page title area end -->
    <div class="main-content-inner">
        <div class="row">
            <div class="col-lg-12 col-ml-12">
                <div class="row">
                    <!-- Textual inputs start -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('prodi.ujian.update', $matkul_id) }}" method="POST">
                                    <h4 class="header-title">Ubah Jadwal Ujian Periode
                                        @if ($master?->isuas == 1)
                                            UAS
                                        @else
                                            UTS
                                        @endif
                                    </h4>

                                    @csrf
                                    @method('PUT')

                                    <div class="form-group">
                                        <label for="tahun" class="col-form-label">Tahun Ajaran</label>
                                        <input class="form-control" type="text" readonly name="tahun"
                                            value="{{ $master?->thn_ajaran }}" id="tahun" />
                                    </div>

                                    <div class="form-group">
                                        <label for="prodi" class="col-form-label">Program Studi</label>
                                        <input class="form-control" type="text" readonly id="prodi"
                                            value="{{ $prodi }}" />
                                    </div>

                                    <div class="form-group">
                                        <label for="semester" class="col-form-label">Semester</label>
                                        <input class="form-control" type="text" readonly id="semester"
                                            value="{{ $semester }}" />
                                    </div>

                                    @if ($tipe_mk == 'K')
                                        <?php $tipe = 'Kuliah' ?>
                                    @elseif ($tipe_mk == 'P')
                                        <?php $tipe = 'Praktikum' ?>
                                    @else
                                        <?php $tipe = 'Responsi' ?>
                                    @endif

                                    <div class="form-group">
                                        <label for="MataKuliah" class="col-form-label">Mata Kuliah - Tipe</label>
                                        <input class="form-control" type="text" readonly id="MataKuliah"
                                            value="{{ $matkul }} - {{ $tipe }}" />
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Usulan Ruang  <i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <select class="custom-select" name="lokasi">
                                            <option selected="selected" value="-" {{ $lokasi == "-" ? 'selected' : '' }}>Pilih Usulan Ruang</option>
                                            <option value="Lab. Komputer" {{ $lokasi == "Lab. Komputer" ? 'selected' : '' }}>Lab. Komputer</option>
                                            <option value="Lab. Prodi" {{ $lokasi == "Lab. Prodi" ? 'selected' : '' }}>Lab. Prodi</option>
                                            <option value="Ruang Kelas" {{ $lokasi == "Ruang Kelas" ? 'selected' : '' }}>Ruang Kelas</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Software yang Dibutuhkan (Optional)</label>
                                        <input class="form-control" type="text" name="software" placeholder="Ketik software yang dibutuhkan..." value="{{ $software }}"/>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Perbanyak Soal <i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <select class="custom-select" name="perbanyak">
                                            <option value="0" {{ $perbanyak == "0" ? 'selected' : '' }}>Pilih</option>
                                            <option value="1" {{ $perbanyak == "1" ? 'selected' : '' }}>Perbanyak Teori & Praktik</option>
                                            <option value="3" {{ $perbanyak == "3" ? 'selected' : '' }}>Perbanyak Teori Saja</option>
                                            <option value="4" {{ $perbanyak == "4" ? 'selected' : '' }}>Perbanyak Praktik Saja</option>
                                            <option value="2" {{ $perbanyak == "2" ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Kertas Buram <i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <select class="custom-select" name="kertas">
                                            <option value="0" {{ $kertas == "0" ? 'selected' : '' }}>Pilih</option>
                                            <option value="1" {{ $kertas == "1" ? 'selected' : '' }}>Pakai</option>
                                            <option value="2" {{ $kertas == "2" ? 'selected' : '' }}>Tidak Pakai</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Textual inputs end -->
                </div>
            </div>
        </div>
    </div>
@endsection
