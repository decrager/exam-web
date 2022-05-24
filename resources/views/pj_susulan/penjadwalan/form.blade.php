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
                    <h4 class="page-title pull-left">Tambah Jadwal Ujian Susulan</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a >Beranda</a></li>
                        <li><a ><span>Penjadwalan</span></a></li>
                        <li><span>Tambah Penjadwalan</span></li>
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
                                <form action="{{ route('pjSusulan.jadwal.create') }}" method="POST">
                                    <h4 class="header-title">Penjadwalan Ujian Susulan</h4>
                                    @csrf

                                    <div class="form-group">
                                        <label for="tahun" class="col-form-label">Tahun Ajaran</label>
                                        <input class="form-control" type="text" readonly name="tahun"
                                            value="{{ $master->thn_ajaran }}" id="tahun" />
                                    </div>

                                    <div class="form-group">
                                        <label for="prodi" class="col-form-label">Program Studi</label>
                                        <input class="form-control" type="text" readonly value="{{ $nama_prodi }}"
                                            id="prodi" name="prodi" />
                                    </div>

                                    <div class="form-group">
                                        <label for="semester" class="col-form-label">Semester</label>
                                        <input class="form-control" type="text" readonly value="{{ $semester }}"
                                            id="semester" name="semester" />
                                    </div>

                                    <div class="form-group">
                                        <label for="kelas" class="col-form-label">Kelas</label>
                                        <input class="form-control" type="text" readonly value="{{ $kelas }}"
                                            id="kelas" name="kelas" />
                                    </div>

                                    <div class="form-group">
                                        <label for="praktikum" class="col-form-label">Praktikum</label>
                                        <input class="form-control" type="text" readonly value="{{ $praktikum }}"
                                            id="praktikum" name="praktikum" />
                                    </div>

                                    <div class="form-group">
                                        <label for="matkul" class="col-form-label">Mata Kuliah</label>
                                        <input class="form-control" type="text" readonly value="{{ $nama_matkul }}"
                                            id="matkul" name="matkul" />
                                    </div>

                                    <div class="form-group">
                                        <label for="tipe_mk" class="col-form-label">Tipe Mata Kuliah</label>
                                        <input class="form-control" type="text" readonly value="{{ $tipe_mk }}"
                                            id="tipe_mk" name="tipe_mk" />
                                    </div>

                                    <div class="form-group">
                                        <label for="example-text-input" class="col-form-label">Kapasitas<i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <input class="form-control @error('kapasitas') is-invalid @enderror" type="text"
                                            placeholder="Ketik kapasitas" id="example-text-input" name="kapasitas"
                                            required />
                                        @error('kapasitas')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Usulan Ruang</label>
                                        <select class="custom-select @error('lokasi') is-invalid @enderror" name="lokasi">
                                            <option selected="selected" value="-">Pilih lokasi</option>
                                            <option value="Lab. Komputer">Lab. Komputer</option>
                                            <option value="Lab. Prodi">Lab. Prodi</option>
                                            <option value="Ruang Kelas">Ruang Kelas</option>
                                        </select>
                                        @error('lokasi')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Ruang<i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <select class="custom-select @error('ruang') is-invalid @enderror" name="ruang">
                                            <option selected="selected" value="-">Pilih ruang</option>
                                            @foreach ($dbRuang as $ruang)
                                                <option value="{{ $ruang?->ruangan }}">{{ $ruang?->ruangan }}</option>
                                            @endforeach
                                        </select>
                                        @error('ruang')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Hari<i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <select class="custom-select @error('hari') is-invalid @enderror" name="hari"
                                            required>
                                            <option selected="selected" value="-">Pilih hari</option>
                                            <option value="senin">Senin</option>
                                            <option value="selasa">Selasa</option>
                                            <option value="rabu">Rabu</option>
                                            <option value="kamis">Kamis</option>
                                            <option value="jumat">Jumat</option>
                                            <option value="sabtu">Sabtu</option>
                                        </select>
                                        @error('hari')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="tgl" class="col-form-label">Tanggal<i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <input class="form-control @error('tanggal') is-invalid @enderror" type="date"
                                            id="tgl" name="tanggal" required />
                                        @error('tanggal')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="jam_mulai" class="col-form-label">Jam Mulai<i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <input class="form-control @error('jam_mulai') is-invalid @enderror" type="text"
                                            id="jam_mulai" name="jam_mulai" placeholder="Ketik..." required />
                                        @error('jam_mulai')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="jam_selesai" class="col-form-label">Jam Selesai<i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <input class="form-control @error('jam_selesai') is-invalid @enderror" type="text"
                                            id="jam_selesai" name="jam_selesai" placeholder="Ketik..." required />
                                        @error('jam_selesai')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="software" class="col-form-label">Software</label>
                                        <input class="form-control @error('software') is-invalid @enderror" type="text"
                                            placeholder="Ketik..." id="software" name="software" />
                                        @error('software')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Perbanyak</label>
                                        <select class="custom-select @error('perbanyak') is-invalid @enderror"
                                            name="perbanyak">
                                            <option selected="selected" value="0">Pilih opsi</option>
                                            <option value="1">Perbanyak</option>
                                            <option value="0">Tidak</option>
                                        </select>
                                        @error('perbanyak')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Sesi<i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <select class="custom-select @error('sesi') is-invalid @enderror" name="sesi"
                                            required>
                                            <option selected="selected" value="1">Pilih sesi</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                        </select>
                                        @error('sesi')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Pelaksanaan<i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <select class="custom-select @error('pelaksanaan') is-invalid @enderror"
                                            name="pelaksanaan" required>
                                            <option selected="selected" value="-">Pilih pelaksanaan</option>
                                            <option value="Online">Online</option>
                                            <option value="Offline">Offline</option>
                                        </select>
                                        @error('pelaksanaan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <input hidden type="text" name="matkul_id" value="{{ $matkul_id }}">
                                    <input hidden type="text" name="prak_id" value="{{ $praktikum_id }}">
                                    <input hidden type="text" name="isuas" value="{{ $master->isuas }}">
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
