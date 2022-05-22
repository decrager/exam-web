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
                    <h4 class="page-title pull-left">Tambah Penugasan</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a >Beranda</a></li>
                        <li><a>Pengawas</a></li>
                        <li><a ><span>Penugasan</span></a></li>
                        <li><span>Tambah Penugasan</span></li>
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
                                <form action="{{ route('pjUjian.pengawas.penugasan.create') }}" method="POST">
                                    <h4 class="header-title">Penugasan Pengawas Ujian</h4>

                                    @csrf

                                    <div class="form-group">
                                        <label for="nama" class="col-form-label">Nama Pengawas</label>
                                        <input class="form-control" type="text" placeholder="Ketik nama pengawas..." id="nama" name="nama" required/>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">PNS</label>
                                        <select class="custom-select" name="pns" required>
                                            <option selected="selected" value="">
                                                Pilih
                                            </option>
                                            <option value="PNS">PNS</option>
                                            <option value="NON PNS">NON PNS</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="norek" class="col-form-label">Nomor Rekening (Optional)</label>
                                        <input class="form-control" type="text" placeholder="Ketik..." id="norek" name="norek"/>
                                    </div>

                                    <div class="form-group">
                                        <label for="bank" class="col-form-label">Bank (Optional)</label>
                                        <select class="custom-select" name="bank">
                                            <option selected="selected" value="">Pilih bank</option>
                                            <option value="BRI">BRI</option>
                                            <option value="BNI">BNI</option>
                                            <option value="Mandiri">Mandiri</option>
                                        </select>
                                    </div>

                                    <input hidden name="ujian_id" value="{{ $ujian->id }}"/>
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
