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
                    <h4 class="page-title pull-left">Tambah Penugasan</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a >Beranda</a></li>
                        <li><a>Pengawas</a></li>
                        <li><a ><span>Penugasan</span></a></li>
                        <li><span>Tambah Penugasan</span></li>
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
                        <div class="card mb-3">
                            <div class="card-body">
                                <h4 class="header-title">Detail Ujian</h4>
                                <div class="row">
                                    <div class="text-left">
                                        <p><b>Tanggal</b></p>
                                        <p>&nbsp;&nbsp;{{ $ujian?->tanggal }}</p>
                                        <p><b>Program Studi</b></p>
                                        <p>&nbsp;&nbsp;{{ $ujian?->Matkul?->Semester?->Prodi?->nama_prodi }}</p>
                                        <p><b>Semester</b></p>
                                        <p>&nbsp;&nbsp;{{ $ujian?->Matkul?->Semester?->semester }}</p>
                                        <p><b>Mata Kuliah</b></p>
                                        <p>&nbsp;&nbsp;{{ $ujian?->Matkul?->nama_matkul }}<br>{{ $ujian?->Matkul?->kode_matkul }}</p>
                                        <p><b>Kelas / Praktikum</b></p>
                                        <p>&nbsp;&nbsp;{{ $ujian?->Praktikum?->Kelas?->kelas }} / {{ $ujian?->Praktikum?->praktikum }}</p>
                                        <p><b>Ruang</b></p>
                                        <p>&nbsp;&nbsp;{{ $ujian?->ruang }}</p>
                                        <p><b>Jam</b></p>
                                        <p>&nbsp;&nbsp;{{ $ujian?->jam_mulai }} - {{ $ujian?->jam_selesai }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('prodi.pengawas.create') }}" method="POST">
                                    <h4 class="header-title">Penugasan Pengawas Ujian</h4>

                                    @csrf

                                    <div class="form-group">
                                        <label for="pengawas" class="col-form-label">Nama Pengawas <i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <select class="custom-select pengawas-select" name="pengawas_id" id="pengawas">
                                            <option selected value="">Pilih Pengawas</option>
                                            @foreach ($pengawas as $pengawas)
                                                <option value="{{ $pengawas?->id }}">{{ $pengawas?->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">NIK / NIP / NPI</label>
                                        <div id="nik">
                                            <input class="form-control" type="text" readonly value="" name="nik" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="pns" class="col-form-label">Status Kepegawaian</label>
                                        <div id="pns">
                                            <input class="form-control" type="text" readonly value="" name="pns" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="tlp" class="col-form-label">Nomor Telepon</label>
                                        <div id="tlp">
                                            <input class="form-control" type="text" readonly value="" name="tlp" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="bank" class="col-form-label">Bank</label>
                                        <div id="bank">
                                            <input class="form-control" type="text" readonly value="" name="bank" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="norek" class="col-form-label">Nomor Rekening</label>
                                        <div id="norek">
                                            <input class="form-control" type="text" readonly value="" name="norek" />
                                        </div>
                                    </div>

                                    <input hidden name="ujian_id" value="{{ $ujian->id }}" />
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Textual inputs end -->
                </div>
            </div>
        </div>
    </div>

    <script>
        // $(document).ready(function() {
            $('.pengawas-select').select2({
                theme: 'bootstrap-5',
                dropdownCssClass: "select2--small",
            });
            $('#pengawas').on('change', function() {
                var pengawas_id = $(this).val();
                if (pengawas_id) {
                    $.ajax({
                        url: '/getPengawas/' + pengawas_id,
                        type: "GET",
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: "json",
                        success: function(data) {
                            if (data) {
                                $('#nik').empty();
                                $('#pns').empty();
                                $('#tlp').empty();
                                $('#bank').empty();
                                $('#norek').empty();
                                $.each(data, function(key, pengawas) {
                                    $('#nik').append(
                                        '<input class="form-control" type="text" readonly value="' +
                                        pengawas.nik + '" name="nik"/>')

                                    $('#pns').append(
                                        '<input class="form-control" type="text" readonly value="' +
                                        pengawas.pns + '" name="pns"/>')

                                    $('#tlp').append(
                                        '<input class="form-control" type="text" readonly value="' +
                                        pengawas.tlp + '" name="tlp"/>')

                                    $('#bank').append(
                                        '<input class="form-control" type="text" readonly value="' +
                                        pengawas.bank + '" name="bank"/>')
                                    $('#norek').append(
                                        '<input class="form-control" type="text" readonly value="' +
                                        pengawas.norek + '" name="norek"/>')
                                });
                            } else {
                                $('#nik').empty();
                                $('#nik').append('<input class="form-control" type="text" readonly value="" name="nik"/>');
                                $('#pns').empty();
                                $('#pns').append('<input class="form-control" type="text" readonly value="" name="pns"/>');
                                $('#tlp').empty();
                                $('#tlp').append('<input class="form-control" type="text" readonly value="" name="tlp"/>');
                                $('#bank').empty();
                                $('#bank').append('<input class="form-control" type="text" readonly value="" name="bank"/>');
                                $('#norek').empty();
                                $('#norek').append('<input class="form-control" type="text" readonly value="" name="norek"/>');
                            }
                        }
                    });
                } else {
                    $('#nik').empty();
                    $('#nik').append('<input class="form-control" type="text" readonly value="" name="nik"/>');
                    $('#pns').empty();
                    $('#pns').append('<input class="form-control" type="text" readonly value="" name="pns"/>');
                    $('#tlp').empty();
                    $('#tlp').append('<input class="form-control" type="text" readonly value="" name="tlp"/>');
                    $('#bank').empty();
                    $('#bank').append('<input class="form-control" type="text" readonly value="" name="bank"/>');
                    $('#norek').empty();
                    $('#norek').append('<input class="form-control" type="text" readonly value="" name="norek"/>');
                }
            });
        // });
    </script>
@endsection
