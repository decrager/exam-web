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
                    <h4 class="page-title pull-left">Tambah Absensi</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a href="">Beranda</a></li>
                        <li><a>Pengawas</a></li>
                        <li><a href=""><span>Absensi</span></a></li>
                        <li><span>Tambah Absensi</span></li>
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
                            <div class="card-body">
                                <h4 class="header-title">Absensi Pengawas Ujian</h4>

                                <div class="form-group">
                                    <label for="thn_ajaran" class="col-form-label">Tahun Ajaran</label>
                                    <input class="form-control" type="text" readonly value="" id="thn_ajaran"
                                        name="thn_ajaran" />
                                </div>

                                <div class="form-group">
                                    <label for="hari" class="col-form-label">Hari</label>
                                    <input class="form-control" type="text" readonly value="" id="hari"
                                        name="hari" />
                                </div>

                                <div class="form-group">
                                    <label for="jam" class="col-form-label">Jam</label>
                                    <input class="form-control" type="text" readonly value="" id="jam"
                                        name="jam" />
                                </div>

                                <div class="form-group">
                                    <label for="tanggal" class="col-form-label">Tanggal</label>
                                    <input class="form-control" type="text" readonly value="" id="tanggal"
                                        name="tanggal" />
                                </div>
                                
                                <div class="form-group">
                                    <label for="prodi" class="col-form-label">Program Studi</label>
                                    <input class="form-control" type="text" readonly value=""
                                        id="prodi" name="prodi" />
                                </div>

                                <div class="form-group">
                                    <label for="semester" class="col-form-label">Semester</label>
                                    <input class="form-control" type="text" readonly value=""
                                        id="semester" name="semester" />
                                </div>

                                <div class="form-group">
                                    <label for="kelas" class="col-form-label">Kelas</label>
                                    <input class="form-control" type="text" readonly value=""
                                        id="kelas" name="kelas" />
                                </div>

                                <div class="form-group">
                                    <label for="matkul" class="col-form-label">Mata Kuliah</label>
                                    <input class="form-control" type="text" readonly value="" id="matkul"
                                        name="matkul" />
                                </div>

                                <div class="form-group">
                                    <label for="jml_berkas" class="col-form-label">Jumlah Lembar Soal</label>
                                    <input class="form-control" type="text" placeholder="Ketik jumlah..." id="jml_berkas"
                                        name="jml_berkas" />
                                </div>

                                <div class="form-group">
                                    <label for="bulan" class="col-form-label">Bulan</label>
                                    <input class="form-control" type="month" id="bulan" name="bulan" />
                                </div>

                                <div class="form-group">
                                    <label for="tahun" class="col-form-label">Tahun</label>
                                    <input class="form-control" type="text" placeholder="Ketik tahun..." id="tahun"
                                        name="tahun" />
                                </div>

                                <div class="form-group">
                                    <label for="nama_serah" class="col-form-label">Nama yang menyerahkan</label>
                                    <input class="form-control" type="text" placeholder="Ketik nama penyerah..." id="nama_serah"
                                        name="nama_serah" />
                                </div>
                                <div class="form-group">
                                    <label class="" for="">Tanda Tangan yang Menyerahkan:</label>
                                    <br />
                                    <div id="sign"> </div>
                                    <br />
                                    <button id="clear" class="btn btn-danger btn-sm">Clear Signature</button>
                                    <textarea id="signature64" style="display: none"></textarea>
                                </div>
                                

                                <div class="form-group">
                                    <label for="nama_terima" class="col-form-label">Nama yang menerima</label>
                                    <input class="form-control" type="text" placeholder="Ketik nama penerima..." id="nama_terima"
                                        name="nama_terima" />
                                </div>

                                <div class="form-group">
                                    <label class="" for="">Tanda Tangan yang Menyerahkan:</label>
                                    <br />
                                    <div id="sign2"> </div>
                                    <br />
                                    <button id="clear2" class="btn btn-danger btn-sm">Clear Signature</button>
                                    <textarea id="signature65" style="display: none"></textarea>
                                </div>

                                <button class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
                    <!-- Textual inputs end -->
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var sign = $('#sign').signature({
            syncField: '#signature64',
            syncFormat: 'PNG'
        });
        $('#clear').click(function(e) {
            e.preventDefault();
            sign.signature('clear');
            $("#signature64").val('');
        });

        var sign2 = $('#sign2').signature({
            syncField: '#signature65',
            syncFormat: 'PNG'
        });
        $('#clear2').click(function(e) {
            e.preventDefault();
            sign2.signature('clear');
            $("#signature65").val('');
        });
    </script>
@endsection
