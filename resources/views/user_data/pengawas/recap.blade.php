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
                <h4 class="page-title pull-left">Rekapitulasi Pengawas</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a >Beranda</a></li>
                    <li><a>Pengawas</a></li>
                    <li><span>Rekapitulasi Pengawas</span></li>
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
                    <h4 class="header-title float-left">Rekapitulasi Pengawas</h4>
                    <div class="float-right mb-3">
                        <a href="{{ route('data.pengawas.recap.export') }}" class="btn btn-success py-2 mr-2">Export &nbsp;&nbsp;<i
                            class="fas fa-file-excel-o"></i></a>
                    </div>
                    <div class="table-responsive">
                        <table id="example" class="table" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th class="col-2">Nama Pengawas</th>
                                    <th>NIK/NIP/NPI</th>
                                    <th>Status Kepegawaian</th>
                                    <th>Bank</th>
                                    <th>No. Rekening</th>
                                    <th>Total Mengawas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pengawas as $pengawas)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pengawas?->nama }}</td>
                                    <td>{{ $pengawas?->nik }}</td>
                                    <td>{{ $pengawas?->pns }}</td>
                                    <td>{{ $pengawas?->bank }}</td>
                                    <td>{{ $pengawas?->norek }}</td>
                                    <td>{{ $pengawas?->total }}</td>
                                </tr>
                                @endforeach
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