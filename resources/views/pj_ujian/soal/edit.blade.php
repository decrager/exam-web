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
                <h4 class="page-title pull-left">Edit Soal Ujian</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="index.html">Home</a></li>
                    <li><a><span>Soal Ujian</span></a></li>
                    <li><span>Edit Soal Ujian</span></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- page title area end -->
<div class="main-content-inner">
    <div class="row">
        <div class="col-lg-12 col-ml-12">
            <div class="row">
                <!-- Textual inputs start -->
                <div class="col-12">
                    <div class="card">
                        <form action="" method="POST">
                            <div class="card-body">
                                <h4 class="header-title">Upload Soal</h4>

                                <div class="form-group">
                                    <label for="prodi" class="col-form-label">Program Studi</label>
                                    <input class="form-control" type="text" readonly value="Manajemen Informatika"
                                        id="prodi" name="prodi" />
                                </div>

                                <div class="form-group">
                                    <label for="semester" class="col-form-label">Semester</label>
                                    <input class="form-control" type="text" readonly value="5" id="semester"
                                        name="semester" />
                                </div>

                                <div class="form-group">
                                    <label for="kelas" class="col-form-label">Kelas</label>
                                    <input class="form-control" type="text" readonly value="A" id="kelas"
                                        name="kelas" />
                                </div>

                                <div class="form-group">
                                    <label for="praktikum" class="col-form-label">Praktikum</label>
                                    <input class="form-control" type="text" readonly value="2" id="praktikum"
                                        name="praktikum" />
                                </div>

                                <div class="form-group">
                                    <label for="matkul" class="col-form-label">Mata Kuliah</label>
                                    <input class="form-control" type="text" readonly value="RPL" id="matkul"
                                        name="matkul" />
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Upload Soal</span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="inputGroupFile01" />
                                        <label class="custom-file-label" for="inputGroupFile01">Pilih file</label>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary text-sm bg-blue px-3 mb-3">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection