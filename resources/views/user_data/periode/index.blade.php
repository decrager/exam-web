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
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger" role="alert">
                            {{ $error }}
                        </div>
                    @endforeach
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
                        <button type="button" class="btn btn-danger float-right" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Reset Data Periodik
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- data table end -->
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('data.resetPeriod') }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Reset Data Periodik</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p style="font-size: 16px;"><b>Data Periodik yang akan direset mencakup:</b></p>
                    <ul>
                        <li>- Data Kehadiran Mahasiswa</li>
                        <li>- Data Ketidahhadiran Mahasiswa</li>
                        <li>- Data Susulan</li>
                        <li>- Data Penugasan</li>
                    </ul>
                    <div class="form-group">
                        <label for="password" class="col-form-label" style="font-size: 16px;"><b>Password</b></label>
                        <input class="form-control" type="password" placeholder="Ketik password" id="password" name="password" required/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection