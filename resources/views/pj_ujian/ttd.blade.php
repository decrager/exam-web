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
                    <h4 class="page-title pull-left">Serah Terima Berkas</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a >Beranda</a></li>
                        <li><a><span>Kelengkapan</span></a></li>
                        <li><a ><span>Soal ujian</span></a></li>
                        <li><span>Serah Terima Berkas</span></li>
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
                                <h4 class="header-title">Tanda Terima Berkas</h4>

                                <div class="form-group">
                                    <label for="thn_ajaran" class="col-form-label">Tahun Ajaran</label>
                                    <input class="form-control" type="text" readonly value="{{ $master->thn_ajaran }}"
                                        id="thn_ajaran" name="thn_ajaran" />
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">Program Studi</label>
                                    <select class="custom-select" name="prodi" id="prodi" required>
                                        <option selected="selected" value="">Pilih Program Studi</option>
                                        @foreach ($dbProdi as $prodi)
                                            <option value="{{ $prodi->id }}">{{ $prodi->nama_prodi }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">Semester</label>
                                    <select class="custom-select" name="semester" id="semester" required>
                                        <option selected="selected" value="">Pilih Semester</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">Mata Kuliah</label>
                                    <select class="custom-select" name="ttdMatkul" id="ttdMatkul" required>
                                        <option selected="selected" value="">Pilih Mata Kuliah</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label" id="cbKelas">Kelas</label>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">Hari</label>
                                    <select class="custom-select" name="hari" required>
                                        <option selected="selected" value="-">Pilih hari</option>
                                        <option value="senin">Senin</option>
                                        <option value="selasa">Selasa</option>
                                        <option value="rabu">Rabu</option>
                                        <option value="kamis">Kamis</option>
                                        <option value="jumat">Jumat</option>
                                        <option value="sabtu">Sabtu</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="jam" class="col-form-label">Jam Mulai - Jam Selesai</label>
                                    <input class="form-control" type="text" id="jam" name="jam" placeholder="Ketik..." required/>
                                </div>

                                <div class="form-group">
                                    <label for="tanggal" class="col-form-label">Tanggal</label>
                                    <input class="form-control" type="date" name="tanggal" id="tanggal" required />
                                </div>

                                <div class="form-group">
                                    <label for="tglbln" class="col-form-label">Tanggal Bulan, Tahun</label>
                                    <input class="form-control" type="text" readonly value="{{ $tglbln }}"
                                        id="tglbln" name="tglbln" />
                                </div>

                                <div class="form-group">
                                    <label for="jml_berkas" class="col-form-label">Jumlah Berkas</label>
                                    <input class="form-control" type="date" name="jml_berkas" id="jml_berkas" required />
                                </div>

                                <div class="form-group">
                                    <label for="nama_serah" class="col-form-label">Nama yang menyerahkan</label>
                                    <input class="form-control" type="text" placeholder="Ketik nama penyerah..."
                                        id="nama_serah" name="nama_serah" />
                                </div>
                                <div class="form-group">
                                    <label class="" for="">Tanda Tangan yang Menyerahkan:</label>
                                    <br />
                                    <div id="sign"> </div>
                                    <br />
                                    <button id="clear" class="btn btn-danger btn-sm">Clear Signature</button>
                                    <textarea id="signature64" name="ttd_penyerah" style="display: none"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="nama_terima" class="col-form-label">Nama yang menerima</label>
                                    <input class="form-control" type="text" placeholder="Ketik nama penerima..."
                                        id="nama_terima" name="nama_terima" />
                                </div>

                                <div class="form-group">
                                    <label class="" for="">Tanda Tangan yang Menerima:</label>
                                    <br />
                                    <div id="sign2"> </div>
                                    <br />
                                    <button id="clear2" class="btn btn-danger btn-sm">Clear Signature</button>
                                    <textarea id="signature65" name="ttd_penerima" style="display: none"></textarea>
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

        $('#semester').on('change', function() {
            var semester_id = $(this).val();
            if (semester_id) {
                $.ajax({
                    url: '/getKelas/' + semester_id,
                    type: "GET",
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data) {
                            $('#cbKelas').empty();
                            $('#cbKelas').append('Kelas');
                            $.each(data, function(key, kelas) {
                                $('#cbKelas').append('<div class="form-check"><input class="form-check-input" type="checkbox" value="' + kelas.id +
                                    '" id="' + kelas.kelas + '"><label class="form-check-label" for="' + kelas.kelas +'">'+ kelas.kelas + '</label></div>');
                            });
                        } else {
                            $('#cbKelas').empty();
                        }
                    }
                });

                $.ajax({
                        url: '/getMatkul/' + semester_id,
                        type: "GET",
                        data: {"_token":"{{ csrf_token() }}"},
                        dataType: "json",
                        success:function(data)
                        {
                            if(data){
                                $('#ttdMatkul').empty();
                                $('#ttdMatkul').append('<option selected="selected" value="">Pilih Mata Kuliah</option>');
                                $.each(data, function(key, matkul){
                                    $('select[name="ttdMatkul"]').append('<option value="'+ matkul.nama_matkul +'">' + matkul.nama_matkul + '</option><input type="text" hidden name="matkul" value="' + matkul.nama_matkul +'">');
                                });
                            }else{
                                $('#ttdMatkul').empty();
                            }
                        }
                    });
            } else {
                $('#cbKelas').empty();
                $('#ttdMatkul').empty();
            }
        });
    </script>
@endsection
