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
                    <h4 class="page-title pull-left">Ubah Penugasan</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a >Beranda</a></li>
                        <li><a>Pengawas</a></li>
                        <li><a ><span>Daftar Pengawas</span></a></li>
                        <li><span>Ubah Penugasan</span></li>
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
                                <form action="{{ route('prodi.pengawas.update', $pengawas?->id) }}" method="POST">
                                    <h4 class="header-title">Penugasan Pengawas Ujian</h4>

                                    @csrf
                                    @method('PUT')

                                    <div class="form-group">
                                        <label for="nama" class="col-form-label">Nama Pengawas</label>
                                        <input class="form-control" type="text" value="{{ $pengawas?->nama }}" id="nama" name="nama" required/>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">PNS</label>
                                        <select class="custom-select" name="pns" required>
                                            <option>Pilih</option>
                                            <option selected="selected" value="{{ $pengawas?->pns }}">{{ $pengawas?->pns }}</option>
                                            <option value="PNS">PNS</option>
                                            <option value="NON PNS">NON PNS</option>
                                        </select>
                                    </div>

                                    <input hidden type="text" value="{{ $pengawas?->ujian_id }}" name="ujian_id" id="ujian_id">
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
