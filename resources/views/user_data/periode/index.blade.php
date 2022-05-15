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
                    <li><a href="">Beranda</a></li>
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
                    <a href="{{ Route('') }}" class="btn btn-primary text-sm bg-blue px-3 mb-3">
                        Perbarui Data
                    </a>
                    <div class="table-responsive">
                        <table id="example" class="table" style="width: 100%">
                            <thead>
                                <tr>
                                    <th class="col-1">No</th>
                                    <th>Nama</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Tahun Ajaran</td>
                                    <td>{{ $master->thn_ajaran }}</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Semester Akademik</td>
                                    <td>{{ $master->smt_akademik }}</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Periode</td>
                                    <td>
                                        @if ($master->isuas == 1)
                                            UAS
                                        @else
                                            UTS
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Periode Mulai</td>
                                    <td>{{ $master->periode_mulai }}</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Periode Akhir</td>
                                    <td>{{ $master->periode_akhir }}</td>
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