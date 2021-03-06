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
                    <h4 class="page-title pull-left">Tambah Lokasi & Ruangan</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a >Beranda</a></li>
                        <li><a ><span>Lokasi & Ruangan</span></a></li>
                        <li><span>Tambah Data</span></li>
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
                                <form action="{{ route('data.ruangan.create') }}" method="POST">
                                    <h4 class="header-title">Tambah Lokasi & Ruangan</h4>
                                    @csrf

                                    <div class="form-group">
                                        <label for="lokasi" class="col-form-label">Lokasi <i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <input class="form-control" type="text" placeholder="Ketik..." name="lokasi" id="lokasi" />
                                    </div>

                                    <div class="form-group">
                                        <label for="ruangan" class="col-form-label">Ruangan <i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <input class="form-control" type="text" placeholder="Ketik..." id="ruangan" name="ruangan" />
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
