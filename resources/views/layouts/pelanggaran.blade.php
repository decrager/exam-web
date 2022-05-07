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
                    <h4 class="header-title">Pelanggaran</h4>
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
                                <tr>
                                    <td>1</td>
                                    <td>Irfan Zafar</td>
                                    <td>J3C219155</td>
                                    <td>Manajemen Informatika</td>
                                    <td>4</td>
                                    <td>1</td>
                                    <td><button class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#detail"><i class=" fas fa-info"></i></button></td>
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
                                            <h6>Nama</h6>
                                            <p>Value</p>
                                        </div>
                                        <div class="form-group">
                                            <h6>NIM</h6>
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
                                    </div>
                                    <div class="col-6">
                                        <h6 class="mb-2">Pelanggaran 1:</h6>
                                        <div class="form-group pl-3">
                                            <h6>Mata Kuliah</h6>
                                            <p>Value</p>
                                        </div>
                                        <div class="form-group pl-3 mb-2">
                                            <h6>Pelanggaran</h6>
                                            <p>Value</p>
                                        </div>

                                        <h6 class="mb-2">Pelanggaran 2:</h6>
                                        <div class="form-group pl-3">
                                            <h6>Mata Kuliah</h6>
                                            <p>Value</p>
                                        </div>
                                        <div class="form-group pl-3 mb-2">
                                            <h6>Pelanggaran</h6>
                                            <p>Value</p>
                                        </div>

                                        <h6 class="mb-2">Pelanggaran 3:</h6>
                                        <div class="form-group pl-3">
                                            <h6>Mata Kuliah</h6>
                                            <p>Value</p>
                                        </div>
                                        <div class="form-group pl-3 mb-2">
                                            <h6>Pelanggaran</h6>
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
