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
                    <h4 class="page-title pull-left">Ubah Pengajuan Ujian Susulan</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a >Beranda</a></li>
                        <li><a>Susulan</a></li>
                        <li><a ><span>Pengajuan</span></a></li>
                        <li><span>Ubah Pengajuan</span></li>
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
                                @foreach ($pengajuan as $pengajuan)
                                <form action="{{ route('mahasiswa.susulan.update', $pengajuan?->id) }}" method="POST" enctype="multipart/form-data">
                                    <h4 class="header-title">Masukkan Pengajuan</h4>
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label class="col-form-label">Mata Kuliah</label>
                                        <select class="custom-select @error('matkul_id') is-invalid @enderror" name="matkul_id" required>
                                            <option>Select</option>
                                            <option selected="selected" value="{{ $pengajuan?->matkul_id }}">{{ $pengajuan?->Matkul?->nama_matkul }}</option>
                                            @foreach ($matkul as $matkul)
                                                <option value="{{ $matkul?->id }}">{{ $matkul?->nama_matkul }}</option>
                                            @endforeach
                                        </select>
                                        @error('matkul_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="col-form-label">Tipe Mata Kuliah</label>
                                        <select class="custom-select @error('tipe_mk') is-invalid @enderror" name="tipe_mk" required>
                                            <option>Select</option>
                                            <option selected="{{ $pengajuan?->tipe_mk }}">
                                                @if ($pengajuan?->tipe_mk == 'K')
                                                Kuliah
                                                @elseif ($pengajuan?->tipe_mk == 'P')
                                                Praktikum
                                                @else
                                                Responsi
                                                @endif
                                            </option>
                                            <option value="K">Kuliah</option>
                                            <option value="P">Praktikum</option>
                                        </select>
                                        @error('tipe_mk')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Alasan <i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <input type="text" class="form-control @error('alasan') is-invalid @enderror" id="alasan" name="alasan" placeholder="Ketik alasan susulan" 
                                        @if ($pengajuan?->alasan)
                                            value="{{ $pengajuan?->alasan }}"
                                        @endif
                                            required/>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Bukti Persyaratan</label>
                                        <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" required placeholder="File type: PDF"/>
                                        <small class="text-muted">Max file size: 2mb</small>
                                        @error('file')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <button class="btn btn-primary">Simpan</button>
                                </form>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!-- Textual inputs end -->
                </div>
            </div>
        </div>
    </div>
@endsection
