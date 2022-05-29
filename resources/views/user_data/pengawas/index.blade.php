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
                <h4 class="page-title pull-left">Data Pengawas</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a >Beranda</a></li>
                    <li><a>Pengawas</a></li>
                    <li><span>Data Pengawas</span></li>
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
                    <h4 class="header-title">Pengawas</h4>
                    <a href="{{ Route('data.pengawas.data.form') }}" class="btn btn-primary text-sm bg-blue px-3 mb-3">
                        Tambah Data
                    </a>
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
                                    <th>No. Telepon</th>
                                    <th>Aksi</th>
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
                                    <td>{{ $pengawas?->tlp }}</td>
                                    <td>
                                        <form action="{{ route('data.pengawas.data.delete', $pengawas?->id) }}" method="POST" class="btn-group" role="group">
                                            <a href="{{ route('data.pengawas.data.edit', $pengawas?->id) }}" class="btn btn-warning"> <i class="fas fa-pen"></i></a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data pengawas ini?')"> <i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
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