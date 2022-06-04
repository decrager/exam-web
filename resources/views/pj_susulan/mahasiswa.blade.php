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
                    <h4 class="page-title pull-left">Mahasiswa yang Mengajukan</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a >Beranda</a></li>
                        <li><span>Mahasiswa</span></li>
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
                        <h4 class="header-title">Daftar Mahasiswa yang Mengajukan</h4>
                        <div class="table-responsive">
                            <table id="example" class="table" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th class="col-2">Program Studi</th>
                                        <th>Semester</th>
                                        <th class="col-2">Mata Kuliah</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>NIM</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mahasiswa as $mahasiswa)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $mahasiswa?->Matkul?->Semester?->Prodi?->nama_prodi }}</td>
                                            <td>{{ $mahasiswa?->Matkul?->Semester?->semester }}</td>
                                            <td>{{ $mahasiswa?->Matkul?->nama_matkul }}</td>
                                            <td>{{ $mahasiswa?->Mahasiswa?->nama }}</td>
                                            <td>{{ $mahasiswa?->Mahasiswa?->nim }}</td>
                                            <td>
                                                @if ($mahasiswa?->status == 'Belum')
                                                    <span class="badge bg-warning">Belum disetujui</span>
                                                @elseif ($mahasiswa?->status == 'Ditolak')
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @elseif ($mahasiswa?->status == 'Disetujui')
                                                    <span class="badge bg-success">Disetujui</span>
                                                @else
                                                    <span class="badge bg-green">Terjadwal</span>
                                                @endif
                                            </td>
                                            <td><Button class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="{{ '#detail' . $mahasiswa?->id }}"><i
                                                        class="fas fa-info"></i></Button></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- data table end -?->
        </div>
    </div>

    <!-- Modal -->
    @foreach ($mahasiswas as $mahasiswa)
        <div class="modal fade" id="{{ "detail" . $mahasiswa?->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- Textual inputs start -->
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body p-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <h6>Program Studi</h6>
                                                    <p>{{ $mahasiswa?->Matkul?->Semester?->Prodi?->nama_prodi }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Semester</h6>
                                                    <p>{{ $mahasiswa?->Matkul?->Semester?->semester }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Nama Mahasiswa</h6>
                                                    <p>{{ $mahasiswa?->Mahasiswa?->nama }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>NIM</h6>
                                                    <p>{{ $mahasiswa?->Mahasiswa?->nim }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Kelas - Praktikum</h6>
                                                    <p>{{ $mahasiswa?->Mahasiswa?->Praktikum?->Kelas?->kelas }} -
                                                        {{ $mahasiswa?->Mahasiswa?->Praktikum?->praktikum }}</p>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <h6>Mata Kuliah</h6>
                                                    <p>{{ $mahasiswa?->Matkul?->nama_matkul }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Tipe Mata Kuliah</h6>
                                                    <p>
                                                        @if ($mahasiswa?->tipe_mk == 'K')
                                                            Kuliah
                                                        @elseif ($mahasiswa?->tipe_mk == 'P')
                                                            Praktikum
                                                        @else
                                                            Responsi
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Status</h6>
                                                    <p>
                                                        @if ($mahasiswa?->status == 'Belum')
                                                            <span class="badge bg-warning">Belum disetujui</span>
                                                        @elseif ($mahasiswa?->status == 'Ditolak')
                                                            <span class="badge bg-danger">Ditolak</span>
                                                        @elseif ($mahasiswa?->status == 'Disetujui')
                                                            <span class="badge bg-success">Disetujui</span>
                                                        @else
                                                            <span class="badge bg-success bg-green">Terjadwal</span>
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Bukti Persyaratan</h6>
                                                    <a href="{{ Storage::files('storage/files/syarat/'. $mahasiswa?->file) }}" target="_blank" class="btn btn-success btn-sm mt-1"> <i class="fas fa-eye"></i>&ensp; Lihat</a>
                                                </div>
                                                <div class="form-group">
                                                    @if ($mahasiswa?->status == 'Belum')
                                                        <h6>Persetujuan</h6>
                                                        <form action="{{ route('pjSusulan.mahasiswa.update', $mahasiswa?->id) }}" class="btn-group mt-1" role="group" method="POST">
                                                            <button type="submit" class="btn btn-success btn-sm" name="status" value="Disetujui" onclick="return confirm('Yakin ingin menyetujui pengajuan?')"><i
                                                                    class="fas fa-check" ></i>&ensp; Setujui</button>
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn btn-danger btn-sm" name="status" value="Ditolak" onclick="return confirm('Yakin ingin menolak pengajuan?')"><i
                                                                    class="fas fa-xmark" ></i>&ensp; Tolak</button>
                                                        </form>
                                                    @elseif ($mahasiswa?->status == 'Disetujui')
                                                        <h6>Ubah Persetujuan</h6>
                                                        <form action="{{ route('pjSusulan.mahasiswa.update', $mahasiswa?->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn btn-danger btn-sm" name="status" value="Ditolak" onclick="return confirm('Yakin ingin menolak pengajuan?')"><i
                                                                    class="fas fa-xmark" ></i>&ensp; Tolak</button>
                                                        </form>
                                                    @elseif ($mahasiswa?->status == 'Ditolak')
                                                        <h6>Ubah Persetujuan</h6>
                                                        <form action="{{ route('pjSusulan.mahasiswa.update', $mahasiswa?->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn btn-success btn-sm" name="status" value="Disetujui" onclick="return confirm('Yakin ingin menyetujui pengajuan?')">
                                                                 <i class="fas fa-check" ></i>&ensp; Setujui
                                                            </button>
                                                        </form>
                                                    @else
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Textual inputs end -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
