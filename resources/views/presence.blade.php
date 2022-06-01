<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge"/>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/icon/IPB.png') }}">
    <title>{{ $title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/fontawesome.min.css"
        integrity="sha512-xX2rYBFJSj86W54Fyv1de80DWBq7zYLn2z0I9bIhQG+rxIF6XVJUpdGnsNHWRa6AvP89vtFupEPDP8eZAtu9qA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/icon/favicon.ico') }}" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/metisMenu.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/slicknav.min.css') }}" />

    <!-- others css -->
    <link rel="stylesheet" href="{{ asset('css/typography.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/default-css.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}" />

    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.signature.css') }}">
    <link type="text/css" href="{{ asset('jquery-ui/jquery-ui.css') }}" rel="stylesheet">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="{{ asset('jquery-ui/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.ui.touch-punch.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.signature.js') }}"></script>

    <style>
        .kbw-signature {
            width: 150px;
            height: 120px;
        }

        #sign canvas {
            width: 100% !important;
            height: auto;
        }
    </style>

    <!-- modernizr css -->
    <script src="{{ asset('js/vendor/modernizr-2.8.3.min.js') }}"></script>

    <!-- select2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
        integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
        integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>

<body>
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->

    <div class="main-content-inner">
        <div class="row my-4 mx-3">
            <div class="col-lg-12 col-ml-12">
                <div class="row">
                    <!-- Textual inputs start -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('presensi.update', $pengawas?->id) }}" method="POST">
                                    <h4 class="header-title">Kehadiran Pengawas Ujian</h4>
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="nama" class="col-form-label">Nama</label>
                                        <input class="form-control" type="text" readonly value="{{ $pengawas?->Pengawas?->nama }}" id="nama"
                                            name="nama" />
                                    </div>
    
                                    <div class="form-group">
                                        <label for="tgl" class="col-form-label">Tanggal</label>
                                        <input class="form-control" type="text" readonly value="{{ $pengawas?->Ujian?->tanggal }}"
                                            id="tgl" name="tgl" />
                                    </div>
    
                                    <div class="form-group">
                                        <label for="prodi" class="col-form-label">Program Studi</label>
                                        <input class="form-control" type="text" readonly value="{{ $pengawas?->Ujian?->Matkul?->Semester?->Prodi?->nama_prodi }}"
                                            id="prodi" name="prodi" />
                                    </div>
    
                                    <div class="form-group">
                                        <label for="matkul" class="col-form-label">Mata Kuliah</label>
                                        <input class="form-control" type="text" readonly value="{{ $pengawas?->Ujian?->Matkul?->nama_matkul }}" id="matkul"
                                            name="matkul" />
                                    </div>
    
                                    <div class="form-group">
                                        <label for="ruang" class="col-form-label">Kode Ruang</label>
                                        <input class="form-control" type="text" readonly value="{{ $pengawas?->Ujian?->ruang }}" id="ruang"
                                            name="ruang" />
                                    </div>
    
                                    <div class="form-group">
                                        <label for="norek" class="col-form-label">No. Rekening</label>
                                        <input class="form-control" type="text" readonly value="{{ $pengawas?->Pengawas?->norek }}" id="norek"
                                            name="norek" />
                                    </div>
    
                                    <div class="form-group">
                                        <label for="bank" class="col-form-label">Bank</label>
                                        <input class="form-control" type="text" readonly value="{{ $pengawas?->Pengawas?->bank }}" id="bank"
                                            name="bank" />
                                    </div>
    
                                    <div class="form-group">
                                        <label for="tlp" class="col-form-label">Nomor Telepon</label>
                                        <input class="form-control" type="text" readonly value="{{ $pengawas?->Pengawas?->tlp }}" id="tlp"
                                            name="tlp" />
                                    </div>
    
                                    <div class="form-group">
                                        <label class="" for="">Tanda Tangan: <i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <br />
                                        <div id="sign"> </div>
                                        <br />
                                        <button id="clear" class="btn btn-danger btn-sm">Clear Signature</button>
                                        <textarea id="signature" name="ttd" style="display: none" required></textarea>
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
    
    <!-- others plugins -->
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    
    <script type="text/javascript">
        var sign = $('#sign').signature({
            syncField: '#signature',
            syncFormat: 'PNG'
        });
        $('#clear').click(function(e) {
            e.preventDefault();
            sign.signature('clear');
            $("#signature").val('');
        });
    </script>

    <script src="https://kit.fontawesome.com/b3b03a4327.js" crossorigin="anonymous"></script>

    <!-- bootstrap 4 js -->
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('js/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('js/jquery.slicknav.min.js') }}"></script>

    <!-- Highcharts -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>

</html>
