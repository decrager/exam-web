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
                    <h4 class="page-title pull-left">Tambah Data Pengawas</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a >Beranda</a></li>
                        <li><a>Pengawas</a></li>
                        <li><a><span>Data Pengawas</span></a></li>
                        <li><span>Tambah Data Pengawas</span></li>
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
                                <form action="{{ route('data.pengawas.data.create') }}" method="POST">
                                    <h4 class="header-title">Tambah Data Pengawas</h4>
                                    @csrf

                                    <div class="form-group">
                                        <label for="nama" class="col-form-label">Nama <i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <input class="form-control" type="text" placeholder="Ketik..." name="nama" required id="nama" />
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Status Kepegawaian <i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <select class="custom-select" name="pns" id="pns" required>
                                            <option selected="selected" value="">Pilih</option>
                                            <option value="PNS">PNS</option>
                                            <option value="Non PNS">Non PNS</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="nik" class="col-form-label">NIK / NIP / NPI <i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <input class="form-control" type="text" placeholder="Ketik..." name="nik" required id="nik" />
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Bank <i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <select class="custom-select" name="bank" id="bank" required>
                                            <option selected="selected" value="">Pilih Bank</option>
                                            <option value="BNI">BNI</option>
                                            <option value="BRI">BRI</option>
                                            <option value="Mandiri">Mandiri</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="norek" class="col-form-label">Nomor Rekening <i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <input class="form-control" type="text" placeholder="Ketik..." name="norek" required id="norek" />
                                    </div>

                                    <div class="form-group">
                                        <label for="tlp" class="col-form-label">Nomor Telepon <i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <input class="form-control" type="text" placeholder="Ketik..." name="tlp" required id="tlp" />
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
