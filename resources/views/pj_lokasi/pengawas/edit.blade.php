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
                                <form action="{{ route('pjLokasi.pengawas.update', $pengawas->id) }}" method="POST">
                                    <h4 class="header-title">Penugasan Pengawas Ujian</h4>
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="nama" class="col-form-label">Nama Pengawas</label>
                                        <input class="form-control" type="text" placeholder="Ketik nama pengawas..." id="nama" name="nama" value="{{ $pengawas->nama }}" required/>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">PNS</label>
                                        <select class="custom-select" name="pns" required>
                                            <option>Pilih</option>
                                            @if ($pengawas->pns == 'pns')
                                            <option selected="selected" value="pns">PNS</option>
                                            @else
                                            <option selected="selected" value="nonpns">NON PNS</option>
                                            @endif
                                            <option value="pns">PNS</option>
                                            <option value="nonpns">NON PNS</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="norek" class="col-form-label">Nomor Rekening</label>
                                        <input class="form-control" type="text" placeholder="Ketik..." id="norek" name="norek" value="{{ $pengawas->norek }}"/>
                                    </div>

                                    <div class="form-group">
                                        <label for="bank" class="col-form-label">Bank</label>
                                        <select class="custom-select" name="bank">
                                            <option>Pilih bank</option>
                                            @if ($pengawas?->bank)
                                                <option selected="selected" value="{{ $pengawas?->bank }}">{{ $pengawas->bank }}</option>
                                            @endif
                                            <option value="BRI">BRI</option>
                                            <option value="BNI">BNI</option>
                                            <option value="Mandiri">Mandiri</option>
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
