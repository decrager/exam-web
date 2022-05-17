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
                <h4 class="page-title pull-left">Periode Ujian</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a >Beranda</a></li>
                    <li><span>Periode Ujian</span></li>
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
            <div class="card">
                <div class="card-body">
                    @if (session()->has('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <h4 class="header-title">Periode Ujian</h4>
                    <a href="{{ Route('data.periode.edit', $master?->id) }}" class="btn btn-primary text-sm bg-blue px-3 mb-3">
                        Perbarui Data
                    </a>
                    <div class="table-responsive">
                        <table class="table" style="width: 100%; font-size: 16px">
                            <thead>
                                <tr>
                                    <th class="col-1">No</th>
                                    <th>Nama</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>1</th>
                                    <th>Tahun Ajaran</th>
                                    <th>{{ $master?->thn_ajaran }}</th>
                                </tr>
                                <tr>
                                    <th>2</th>
                                    <th>Semester Akademik</th>
                                    <th>
                                        @if ($master?->smt_akademik == 1)
                                            Ganjil
                                        @else
                                            Genap
                                        @endif
                                    </th>
                                </tr>
                                <tr>
                                    <th>3</th>
                                    <th>Periode</th>
                                    <th>
                                        @if ($master?->isuas == 1)
                                            UAS
                                        @else
                                            UTS
                                        @endif
                                    </th>
                                </tr>
                                <tr>
                                    <th>4</th>
                                    <th>Periode Mulai</th>
                                    <th>{{ $master?->periode_mulai }}</th>
                                </tr>
                                <tr>
                                    <th>5</th>
                                    <th>Periode Akhir</th>
                                    <th>{{ $master?->periode_akhir }}</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- data table end -->
    </div>
</div>
@endsection