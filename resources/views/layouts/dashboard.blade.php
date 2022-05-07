<!-- page title area start -->
<div class="page-title-area mb-3">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Beranda</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a>Beranda</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- page title area end -->
<div class="main-content-inner">
    <div class="row">
        <div class="col-12 col-md-4">
            <div class="single-report bg-white">
                <span>Jumlah Pelanggaran</span>
                <div class="number">000</div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="single-report bg-white">
                <span>Ujian Hari Ini</span>
                <div class="number">000</div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="single-report bg-white">
                <span>Jumlah Pengawas Yang Sudah Hadir</span>
                <div class="number">000</div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title float-left pt-2">Jadwal Ujian</h4>
                    <div class="row mb-1 justify-content-end">
                        <div class="col-md-2">
                            <div class="form-group">
                                <select class="custom-select">
                                    <option selected="selected">Program Studi</option>
                                    <option value="#">-</option>
                                    <option value="#">-</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select class="custom-select">
                                    <option selected="selected">Semester</option>
                                    <option value="#">-</option>
                                    <option value="#">-</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select class="custom-select">
                                    <option selected="selected">Kelas</option>
                                    <option value="#">-</option>
                                    <option value="#">-</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select class="custom-select">
                                    <option selected="selected">Praktikum</option>
                                    <option value="#">-</option>
                                    <option value="#">-</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 pr--0">
                            <div class="form-group">
                                <select class="custom-select">
                                    <option selected="selected">Mata Kuliah</option>
                                    <option value="#">-</option>
                                    <option value="#">-</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- <i class="fa fa-check text-danger"></i> -->

                    <div class="table-responsive">
                        <table id="example" class="table" style="width: 100%">
                            <thead>
                                <tr>
                                    <th class="border-0" scope="col">No</th>
                                    <th class="border-0" scope="col">Tanggal</th>
                                    <th class="border-0 col-2" scope="col">Program Studi</th>
                                    <th class="border-0" scope="col">Semester</th>
                                    <th class="border-0" scope="col">Kelas</th>
                                    <th class="border-0" scope="col">Praktikum</th>
                                    <th class="border-0 col-2" scope="col">Mata Kuliah</th>
                                    <th class="border-0" scope="col">Lokasi</th>
                                    <th class="border-0" scope="col">Ruang</th>
                                    <th class="border-0" scope="col">Jam Mulai</th>
                                    <th class="border-0" scope="col">Jam Selesai</th>
                                    <th class="border-0" scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th class="border-0" scope="row">1</th>
                                    <td class="border-0">-</td>
                                    <td class="border-0">-</td>
                                    <td class="border-0">-</td>
                                    <td class="border-0">-</td>
                                    <td class="border-0">-</td>
                                    <td class="border-0">-</td>
                                    <td class="border-0">-</td>
                                    <td class="border-0">-</td>
                                    <td class="border-0">-</td>
                                    <td class="border-0">-</td>
                                    <td class="border-0"><button class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#detail"><i class="fas fa-info"></i></button></td>
                                </tr>
                            </tbody>
                            <tfoot class="d-none">
                                <tr>
                                    <th class="border-0" scope="col">No</th>
                                    <th class="border-0" scope="col">Tanggal</th>
                                    <th class="border-0" scope="col">Program Studi</th>
                                    <th class="border-0" scope="col">Semester</th>
                                    <th class="border-0" scope="col">Kelas</th>
                                    <th class="border-0" scope="col">Praktikum</th>
                                    <th class="border-0" scope="col">Mata Kuliah</th>
                                    <th class="border-0" scope="col">Lokasi</th>
                                    <th class="border-0" scope="col">Jam Mulai</th>
                                    <th class="border-0" scope="col">Jam Selesai</th>
                                    <th class="border-0" scope="col">Aksi</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- data table end -->
    </div>

    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Rekapitulasi Pelanggaran</h4>
                    <figure class="highcharts-figure">
                        <div id="container"></div>
                    </figure>
                </div>
            </div>
        </div>
        <!-- data table end -->
    </div>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detail">
        Detail
    </button>

    <!-- Modal -->
    <div class="modal fade" id="detail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                <h6>Tanggal</h6>
                                                <p>Value</p>
                                            </div>
                                            <div class="form-group">
                                                <h6>Program Studi</h6>
                                                <p>Value</p>
                                            </div>
                                            <div class="form-group">
                                                <h6>Semester</h6>
                                                <p>Value</p>
                                            </div>
                                            <div class="form-group">
                                                <h6>Kelas - Praktikum</h6>
                                                <p>Value - value</p>
                                            </div>
                                            <div class="form-group">
                                                <h6>Mata Kuliah</h6>
                                                <p>Value</p>
                                            </div>
                                            <div class="form-group">
                                                <h6>Lokasi</h6>
                                                <p>Value</p>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <h6>Ruang</h6>
                                                <p>Value</p>
                                            </div>
                                            <div class="form-group">
                                                <h6>Jam Mulai - Jam Selesai</h6>
                                                <p>Value - Value</p>
                                            </div>
                                            <div class="form-group">
                                                <h6>Tipe Mata Kuliah</h6>
                                                <p>Value</p>
                                            </div>
                                            <div class="form-group">
                                                <h6>Sesi</h6>
                                                <p>Value</p>
                                            </div>
                                            <div class="form-group">
                                                <h6>Software</h6>
                                                <p>Value</p>
                                            </div>
                                            <div class="form-group">
                                                <h6>Pelaksanaan</h6>
                                                <p>Value</p>
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
</div>
