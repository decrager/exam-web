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
                    <h4 class="page-title pull-left">Absensi</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a>Beranda</a></li>
                        <li><a href="{{ route('pengawas.absensi.index') }}">Absensi</a></li>
                        <li><span>Kehadiran</span></li>
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
                <div class="card mb-3">
                    <div class="card-body">
                        <h4 class="header-title">Detail Ujian</h4>
                        <div class="row">
                            <div class="col-2" style="font-size: 16px">
                                Tanggal <br>
                                Program Studi <br>
                                Semester <br>
                                Mata Kuliah <br>
                                Kode Mata Kuliah <br>
                                Kelas / Praktikum <br>
                                Ruang <br>
                                Jam <br>
                            </div>
                            <div class="col-3" style="font-size: 16px">
                                : &nbsp; {{ $ujian?->tanggal }}<br>
                                : &nbsp; {{ $ujian?->Matkul?->Semester?->Prodi?->nama_prodi }}<br>
                                : &nbsp; {{ $ujian?->Matkul?->Semester?->semester }}<br>
                                : &nbsp; {{ $ujian?->Matkul?->nama_matkul }}<br>
                                : &nbsp; {{ $ujian?->Matkul?->kode_matkul }}<br>
                                : &nbsp; {{ $ujian?->Praktikum?->Kelas?->kelas }} / {{ $ujian?->Praktikum?->praktikum }}<br>
                                : &nbsp; {{ $ujian?->ruang }}<br>
                                : &nbsp; {{ $ujian?->jam_mulai }} - {{ $ujian?->jam_selesai }}<br>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('pengawas.absensi.export') }}" method="POST">
                            <h4 class="header-title">Tanda Tangan Pengawas</h4>
                            @csrf
                            
                            <div class="form-group">
                                <label for="pengawas1" class="col-form-label">Nama Pengawas 1 <i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                <input class="form-control" type="text" placeholder="Ketik nama pengawas tanpa gelar"
                                id="pengawas1" name="pengawas1" required/>
                            </div>
                            
                            <div class="form-group">
                                <label class="" for="">Tanda tangan pengawas 1: <i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                <br />
                                <div id="sign"> </div>
                                <br />
                                <button id="clear" class="btn btn-danger btn-sm">Clear Signature</button>
                                <textarea id="signature64" name="ttd1" style="display: none" required></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="pengawas2" class="col-form-label">Nama Pengawas 2 (Opsional)</label>
                                <input class="form-control" type="text" placeholder="Ketik nama pengawas tanpa gelar"
                                id="pengawas2" name="pengawas2"/>
                            </div>

                            <div class="form-group">
                                <label class="" for="">Tanda tangan pengawas 2: (Opsional)</label>
                                <br />
                                <div id="sign2"> </div>
                                <br />
                                <button id="clear2" class="btn btn-danger btn-sm">Clear Signature</button>
                                <textarea id="signature65" name="ttd2" style="display: none"></textarea>
                            </div>

                            <input type="text" value="{{ $ujian->id }}" name="ujian_id" hidden>
                            <button type="submit" class="btn btn-primary">Export</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- data table end -->
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
