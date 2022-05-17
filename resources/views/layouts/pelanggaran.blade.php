<!-- page title area start -->
<div class="page-title-area mb-3">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Rekapitulasi Pelanggaran</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="">Beranda</a></li>
                    <li><span>Pelanggaran</span></li>
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
                    @if (auth()->user()->role == 'berkas' or auth()->user()->role == 'pj_ujian' or auth()->user()->role == 'supervisor')
                        <h4 class="header-title float-left">Pelanggaran</h4>
                        <button class="btn btn-success float-right mb-3"><i
                                class="fas fa-file-excel-o"></i>&ensp;Export</button>
                    @else
                        <h4 class="header-title">Pelanggaran</h4>
                    @endif
                    <div class="table-responsive">
                        <table id="example" class="table" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Mahasiswa</th>
                                    <th>NIM</th>
                                    <th class="col-2">Program Studi</th>
                                    <th>Semester</th>
                                    <th>Jumlah Pelanggaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mhs as $mhs)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $mhs?->nama }}</td>
                                        <td>{{ $mhs?->nim }}</td>
                                        <td>{{ $mhs?->nama_prodi }}</td>
                                        <td>{{ $mhs?->semester }}</td>
                                        <td>{{ $mhs?->total }}</td>
                                        <td><button class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="{{ '#detail' . $mhs?->mhs_id }}"><i
                                                    class=" fas fa-info"></i></button></td>
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

<!-- Modal -->
@foreach ($mhs2 as $mhs)
    <div class="modal fade" id="{{ 'detail' . $mhs?->mhs_id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Pelanggaran</h5>
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
                                                <h6>Nama</h6>
                                                <p>{{ $mhs?->nama }}</p>
                                            </div>
                                            <div class="form-group">
                                                <h6>NIM</h6>
                                                <p>{{ $mhs?->nim }}</p>
                                            </div>
                                            <div class="form-group">
                                                <h6>Program Studi</h6>
                                                <p>{{ $mhs?->nama_prodi }}
                                                </p>
                                            </div>
                                            <div class="form-group">
                                                <h6>Semester</h6>
                                                <p>{{ $mhs?->semester }}</p>
                                            </div>
                                            <div class="form-group">
                                                <h6>Kelas - Praktikum</h6>
                                                <p>{{ $mhs?->kelas }} -
                                                    {{ $mhs?->praktikum }}</p>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            @foreach ($allPelanggaran as $pelanggaran)
                                                @if ($pelanggaran?->mhs_id == $mhs?->mhs_id)
                                                    <h6 class="mb-2">Pelanggaran:
                                                    </h6>
                                                    <div class="form-group pl-3">
                                                        <h6>Mata Kuliah</h6>
                                                        <p>{{ $pelanggaran?->Ujian?->Matkul?->nama_matkul }}</p>
                                                    </div>
                                                    <div class="form-group pl-3 mb-2">
                                                        <h6>Pelanggaran</h6>
                                                        <p>{{ $pelanggaran?->pelanggaran }}</p>
                                                    </div>
                                                @endif
                                            @endforeach
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
