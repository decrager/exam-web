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
                <h4 class="page-title pull-left">Ubah Ketidakhadiran</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a >Beranda</a></li>
                    <li><a ><span>Ketidakhadiran</span></a></li>
                    <li><span>Edit Ketidakhadiran</span></li>
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
                                <h4 class="header-title">Ubah Data Ketidakhadiran</h4>
                                <form method="post" action="/pj_online/pelanggaran/{{ $pelanggarans?->id }}">
                                    @csrf
                                    @method('put')
                                    <div class="form-group">
                                        <label class="col-form-label">Ujian</label>
                                        <select class="custom-select ujian-select" name="ujian_id" id="ujian_id" required>
                                            <option>Select</option>
                                            @foreach ($ujians as $ujian)
                                                @if (old('ujian_id') === $ujian->id)
                                                    <option value="{{ $ujian->id }}" selected>
                                                        {{ $ujian->Matkul->Semester->Prodi->nama_prodi }} -
                                                        {{ $ujian->Matkul->nama_matkul }} - Kelas
                                                        {{ $ujian->Praktikum->Kelas->kelas }}/P{{ $ujian->Praktikum->praktikum }}
                                                    </option>
                                                @else
                                                    <option value="{{ $ujian->id }}" {{ $ujian->id == $pelanggarans->Ujian->id ? 'selected' : '' }}>
                                                        {{ $ujian->Matkul->Semester->Prodi->nama_prodi }} -
                                                        {{ $ujian->Matkul->nama_matkul }} - Kelas
                                                        {{ $ujian->Praktikum->Kelas->kelas }}/P{{ $ujian->Praktikum->praktikum }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Nama Mahasiswa</label>
                                        <select class="custom-select mhs-select" name="mhs_id" id="mhs_id" required>
                                            <option>Pilih Mahasiswa</option>
                                            <option selected="selected" value="{{ $pelanggarans->Mahasiswa->id }}">{{ $pelanggarans->Mahasiswa->nama }}</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="col-form-label">Alasan Ketidakhadiran <i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <div class="form-check" id="btn">
                                            <input class="form-check-input" onclick="checkButton()" type="radio" name="pelanggaran" value="Sakit" id="pelanggaran1" @if ($pelanggarans->pelanggaran == 'Sakit') checked @endif>
                                            <label class="form-check-label" for="pelanggaran1">
                                                Sakit
                                            </label>
                                        </div>
                                        <div class="form-check" id="btn">
                                            <input class="form-check-input" onclick="checkButton()" type="radio" name="pelanggaran" value="Izin" id="pelanggaran2" @if ($pelanggarans->pelanggaran == 'Izin') checked @endif>
                                            <label class="form-check-label" for="pelanggaran2">
                                                Izin
                                            </label>
                                        </div>
                                        <div class="form-check" id="btn">
                                            <input class="form-check-input" onclick="checkButton()" type="radio" name="pelanggaran" value="Tanpa Keterangan" id="pelanggaran10" @if ($pelanggarans->pelanggaran == 'Tanpa Keterangan') checked @endif>
                                            <label class="form-check-label" for="pelanggaran10">
                                                Tanpa Keterangan
                                            </label>
                                        </div>
                                        <label class="col-form-label">Pelanggaran</label>
                                        <div class="form-check" id="btn">
                                            <input class="form-check-input" onclick="checkButton()" type="radio" name="pelanggaran" value="Terlambat" id="pelanggaran3" @if ($pelanggarans->pelanggaran == 'Terlambat') checked @endif>
                                            <label class="form-check-label" for="pelanggaran3">
                                                Terlambat
                                            </label>
                                        </div>
                                        <div class="form-check" id="btn">
                                            <input class="form-check-input" onclick="checkButton()" type="radio" name="pelanggaran" value="Tidak Membawa KTM" id="pelanggaran4" @if ($pelanggarans->pelanggaran == 'Tidak Membawa KTM') checked @endif>
                                            <label class="form-check-label" for="pelanggaran4">
                                                Tidak Membawa KTM
                                            </label>
                                        </div>
                                        <div class="form-check" id="btn">
                                            <input class="form-check-input" onclick="checkButton()" type="radio" name="pelanggaran" value="Pakaian tidak sesuai SOP" id="pelanggaran5" @if ($pelanggarans->pelanggaran == 'Pakaian tidak sesuai SOP') checked @endif>
                                            <label class="form-check-label" for="pelanggaran5">
                                                Pakaian tidak sesuai SOP
                                            </label>
                                        </div>
                                        <div class="form-check" id="btn">
                                            <input class="form-check-input" onclick="checkButton()" type="radio" name="pelanggaran" value="Tidak memakai seragam Program Studi (Kamis)" id="pelanggaran6" @if ($pelanggarans->pelanggaran == 'Tidak memakai seragam Program Studi (Kamis)') checked @endif>
                                            <label class="form-check-label" for="pelanggaran6">
                                                Tidak memakai seragam Program Studi (Kamis)
                                            </label>
                                        </div>
                                        <div class="form-check" id="btn">
                                            <input class="form-check-input" onclick="checkButton()" type="radio" name="pelanggaran" value="Rambut panjang" id="pelanggaran7" @if ($pelanggarans->pelanggaran == 'Rambut panjang') checked @endif>
                                            <label class="form-check-label" for="pelanggaran7">
                                                Rambut panjang
                                            </label>
                                        </div>
                                        <div class="form-check" id="btn">
                                            <input class="form-check-input" onclick="checkButton()" type="radio" name="pelanggaran" value="Mencontek" id="pelanggaran8" @if ($pelanggarans->pelanggaran == 'Mencontek') checked @endif>
                                            <label class="form-check-label" for="pelanggaran8">
                                                Mencontek
                                            </label>
                                        </div>
                                        @if ($pelanggarans->pelanggaran != 'Mencontek' && $pelanggarans->pelanggaran != 'Rambut Panjang' && $pelanggarans->pelanggaran != 'Tidak memakai seragam Program Studi (Kamis)' && $pelanggarans->pelanggaran != 'Pakaian tidak sesuai SOP' && $pelanggarans->pelanggaran != 'Tidak Membawa KTM' && $pelanggarans->pelanggaran != 'Terlambat' && $pelanggarans->pelanggaran != 'Izin' && $pelanggarans->pelanggaran != 'Sakit' && $pelanggarans->pelanggaran != 'Tanpa Keterangan')
                                        <div class="form-check" id="btn">
                                            <input class="form-check-input" onclick="checkButton()" type="radio" name="pelanggaran" value="" id="pelanggaran9" checked>
                                            <label class="form-check-label" for="pelanggaran9">
                                                Lainnya
                                            </label>
                                            <div id="lainnya">
                                                <input class="form-control" type="text" value="{{ $pelanggarans->pelanggaran }}" name="pelanggaran"/>
                                            </div>
                                        </div>
                                        @else
                                        <div class="form-check" id="btn">
                                            <input class="form-check-input" onclick="checkButton()" type="radio" name="pelanggaran" value="" id="pelanggaran9">
                                            <label class="form-check-label" for="pelanggaran9">
                                                Lainnya
                                            </label>
                                            <div id="lainnya">
                                                <input class="form-control" type="text" readonly/>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary">Perbarui</button>
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
    $('.ujian-select').select2({
        theme: 'bootstrap-5',
        dropdownCssClass: "select2--small",
    }).on('change', function() {
        var ujian_id = $(this).val();
            if (ujian_id) {
                $.ajax({
                    url: '/getUjian/' + ujian_id,
                    type: "GET",
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data) {
                            $('#mhs_id').empty();
                            $('#mhs_id').append(
                                    '<option selected="selected" value="">Pilih Mahasiswa</option>'
                                );
                            $.each(data, function(key, mhs) {
                                $('select[name="mhs_id"]').append('<option value="' + mhs.id + '">' + mhs.nama + '</option>')
                            });
                        } else {
                            $('#mhs_id').empty();
                        }
                    }
                });
            } else {
                $('#mhs_id').empty();
            }
        });
    $('.mhs-select').select2({
        theme: 'bootstrap-5',
        dropdownCssClass: "select2--small",
    });

    function checkButton() {
        if(document.getElementById('pelanggaran9').checked) {
            $('#lainnya').empty();
            $('#lainnya').append('<input class="form-control" type="text" placeholder="Ketik..." name="pelanggaran"/>');
        }
        else if (document.getElementById('pelanggaran10').checked) {
            $('#lainnya').empty();
            $('#lainnya').append('<input class="form-control" type="text" readonly/>');
        }
        else if (document.getElementById('pelanggaran8').checked) {
            $('#lainnya').empty();
            $('#lainnya').append('<input class="form-control" type="text" readonly/>');
        }
        else if (document.getElementById('pelanggaran7').checked) {
            $('#lainnya').empty();
            $('#lainnya').append('<input class="form-control" type="text" readonly/>');
        }
        else if (document.getElementById('pelanggaran6').checked) {
            $('#lainnya').empty();
            $('#lainnya').append('<input class="form-control" type="text" readonly/>');
        }
        else if (document.getElementById('pelanggaran5').checked) {
            $('#lainnya').empty();
            $('#lainnya').append('<input class="form-control" type="text" readonly/>');
        }
        else if (document.getElementById('pelanggaran4').checked) {
            $('#lainnya').empty();
            $('#lainnya').append('<input class="form-control" type="text" readonly/>');
        }
        else if (document.getElementById('pelanggaran3').checked) {
            $('#lainnya').empty();
            $('#lainnya').append('<input class="form-control" type="text" readonly/>');
        }
        else if (document.getElementById('pelanggaran2').checked) {
            $('#lainnya').empty();
            $('#lainnya').append('<input class="form-control" type="text" readonly/>');
        }
        else if (document.getElementById('pelanggaran1').checked) {
            $('#lainnya').empty();
            $('#lainnya').append('<input class="form-control" type="text" readonly/>');
        }
    }
</script>
@endsection