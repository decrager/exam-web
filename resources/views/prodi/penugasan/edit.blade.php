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
                    <h4 class="page-title pull-left">Ubah Penugasan</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a >Beranda</a></li>
                        <li><a>Pengawas</a></li>
                        <li><a ><span>Daftar Pengawas</span></a></li>
                        <li><span>Ubah Penugasan</span></li>
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
                                <form action="{{ route('prodi.pengawas.update', $penugasan?->id) }}" method="POST">
                                    <h4 class="header-title">Penugasan Pengawas Ujian</h4>

                                    @csrf
                                    @method('PUT')

                                    <div class="form-group">
                                        <label for="pengawas" class="col-form-label">Nama Pengawas <i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <select class="custom-select pengawas-select" name="pengawas_id" id="pengawas">
                                            <option value="">Pilih Pengawas</option>
                                            <option selected value="{{ $selected?->id }}">{{ $selected?->nama }}</option>
                                            @foreach ($pengawas as $pengawas)
                                                <option value="{{ $pengawas?->id }}">{{ $pengawas?->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">NIK / NIP / NPI</label>
                                        <div id="nik">
                                            <input class="form-control" type="text" readonly value="{{ $selected?->nik }}" name="nik" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="pns" class="col-form-label">Status Kepegawaian</label>
                                        <div id="pns">
                                            <input class="form-control" type="text" readonly value="{{ $selected?->pns }}" name="pns" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="tlp" class="col-form-label">Nomor Telepon</label>
                                        <div id="tlp">
                                            <input class="form-control" type="text" readonly value="{{ $selected?->tlp }}" name="tlp" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="bank" class="col-form-label">Bank</label>
                                        <div id="bank">
                                            <input class="form-control" type="text" readonly value="{{ $selected?->bank }}" name="bank" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="norek" class="col-form-label">Nomor Rekening</label>
                                        <div id="norek">
                                            <input class="form-control" type="text" readonly value="{{ $selected?->norek }}" name="norek" />
                                        </div>
                                    </div>

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
