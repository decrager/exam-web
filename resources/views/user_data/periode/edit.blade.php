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
                    <h4 class="page-title pull-left">Perbarui Data</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a >Beranda</a></li>
                        <li><a ><span>Periode Ujian</span></a></li>
                        <li><span>Perbarui Data</span></li>
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
                                <form action="{{ route('data.periode.update', $master?->id) }}" method="POST">
                                    <h4 class="header-title">Perbarui Data Periode Ujian</h4>
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="thn_ajaran" class="col-form-label">Tahun Ajaran</label>
                                        <input class="form-control" type="text" placeholder="yyyy/yyyy" value="{{ $master?->thn_ajaran }}" id="thn_ajaran" name="thn_ajaran" required/>
                                    </div>

                                    <div class="form-group">
                                        <label for="smt_akademik" class="col-form-label">Semester Akademik</label>
                                        <div class="form-check" id="smt_akademik">
                                            <input class="form-check-input" type="radio" name="smt_akademik" id="ganjil" value=1 @if($master?->smt_akademik == 1) checked @endif>
                                            <label class="form-check-label" for="ganjil">
                                              Ganjil
                                            </label>
                                          </div>
                                          <div class="form-check">
                                            <input class="form-check-input" type="radio" name="smt_akademik" id="genap" value=2 @if($master?->smt_akademik == 2) checked @endif>
                                            <label class="form-check-label" for="genap">
                                              Genap
                                            </label>
                                          </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="isuas" class="col-form-label">Periode</label>
                                        <div class="form-check" id="isuas">
                                            <input class="form-check-input" type="radio" name="isuas" id="uts" value=0 @if($master?->isuas == 0) checked @endif>
                                            <label class="form-check-label" for="uts">
                                              UTS
                                            </label>
                                        </div>
                                        <div class="form-check" id="isuas">
                                            <input class="form-check-input" type="radio" name="isuas" id="uas" value=1 @if($master?->isuas == 1) checked @endif>
                                            <label class="form-check-label" for="uas">
                                              UAS
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="periode_mulai" class="col-form-label">Periode Mulai</label>
                                        <input class="form-control" type="date" value="{{ $master?->periode_mulai }}" id="periode_mulai" name="periode_mulai" required/>
                                    </div>

                                    <div class="form-group">
                                        <label for="periode_akhir" class="col-form-label">Periode Akhir</label>
                                        <input class="form-control" type="date" value="{{ $master?->periode_akhir }}" id="periode_akhir" name="periode_akhir" required/>
                                    </div>

                                    <button class="btn btn-primary">Simpan</button>
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
