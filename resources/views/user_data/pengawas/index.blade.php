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
                    @foreach ($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">
                        {{ $error }}
                    </div>
                    @endforeach
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

                        <button type="button" class="btn btn-success px-3 mx-1 text-sm" data-bs-toggle="modal" data-bs-target="#importModal">
                            Import
                        </button>
                        <button type="button" class="btn btn-danger px-3" data-bs-toggle="modal" data-bs-target="#resetModal">
                            Reset
                        </button>

                    </div>
                </div>
            </div>
        </div>
        <!-- data table end -->
    </div>
</div>

<div class="modal fade" id="resetModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('data.resetPengawas') }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Reset Data Pengawas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p style="font-size: 16px;"><b>Masukkan password anda untuk mengkonfirmasi:</b></p>
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

<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('data.importPengawas') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Data Pengawas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p style="font-size: 16px;"><b>Download template excel yang sudah disesuaikan:</b></p>
                    <a href="{{ asset('storage/template/pengawas.xlsx') }}" class="btn btn-success mb-2" target="_blank"><i class="fas fa-file-excel"></i>&nbsp; Unduh Template</a>
                    <div class="form-group">
                        <label for="password" class="col-form-label" style="font-size: 16px;"><b>Upload:</b></label>
                        <input class="form-control" type="file" placeholder="Upload file" id="file" name="file" required/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection