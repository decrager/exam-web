<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <link rel="icon" type="image/x-icon" href="{{ asset('images/icon/IPB.png') }}">
    <title>
        {{ $title }}
    </title>
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

    <!-- Start datatable css -->
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />

    <!-- others css -->
    <link rel="stylesheet" href="{{ asset('css/typography.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/default-css.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}" />

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <style>
        .kbw-signature {
            width: 15%;
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
    integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
        
    {{-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script> --}}
    @if (Request::routeIs('pjLokasi.pengawas.absensi.export') || Request::routeIs('pjUjian.kelengkapan.berkas.ttd') || Request::routeIs('pjLokasi.soal.form') || Request::routeIs('berkas.kelengkapan.berkas.ttd'))
    <link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css">
    <script type="text/javascript" src="http://keith-wood.name/js/jquery.signature.js"></script>
    @else
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- End Select2-->
</head>

<body>
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->

    <!-- page container area start -->
    <div class="page-container">
        <!-- sidebar menu area start -->
        @if (auth()->user()->role == 'data')
            @include('user_data.sidebar')
        @elseif (auth()->user()->role == 'pj_ujian')
            @include('pj_ujian.sidebar')
        @elseif (auth()->user()->role == 'prodi')
            @include('prodi.sidebar')
        @elseif (auth()->user()->role == 'assisten')
            @include('assisten.sidebar')
        @elseif (auth()->user()->role == 'berkas')
            @include('berkas.sidebar')
        @elseif (auth()->user()->role == 'mahasiswa')
            @include('mahasiswa.sidebar')
        @elseif (auth()->user()->role == 'pj_lokasi')
            @include('pj_lokasi.sidebar')
        @elseif (auth()->user()->role == 'pj_online')
            @include('pj_online.sidebar')
        @elseif (auth()->user()->role == 'pj_susulan')
            @include('pj_susulan.sidebar')
        @elseif (auth()->user()->role == 'supervisor')
            @include('supervisor.sidebar')
        @elseif (auth()->user()->role == 'pj_labkom')
            @include('pj_labkom.sidebar')
        @elseif (auth()->user()->role == 'superadmin')
            @include('superadmin.sidebar')
        @endif
        <!-- sidebar menu area end -->

        <!-- main content area start -->
        <div class="main-content">
            @yield('main-content')

            <!-- footer area start-->
            <footer>
                <div class="footer-area">
                    <p>© Copyright 2022. All right reserved.</p>
                </div>
            </footer>
            <!-- footer area end-->
        </div>
        <!-- main content area end -->
    </div>
    <!-- page container area end -->

    <!-- jquery latest version -->
    <!-- <script src="assets/js/vendor/jquery-2.2.4.min.js"></script> -->
    
    <script src="https://kit.fontawesome.com/b3b03a4327.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>

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

    <!-- Start datatable js -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <!-- others plugins -->
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

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
        $('.matkul-select').select2({
            theme: 'bootstrap-5',
            selectionCssClass: "select2--small",
            dropdownCssClass: "select2normal"
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#example").DataTable({
                lengthMenu: [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, 'All']
                ]
            });

            let datas = <?php echo json_encode($data); ?>;
            let label = <?php echo json_encode($label); ?>;

            var data = datas.map(function(v) {
                return parseInt(v, 10);
            });
            // var label = labels.map(function(v) { return parseInt(v, 10); });

            Highcharts.chart("container", {
                title: {
                    text: "Grafik Pelanggaran",
                },

                subtitle: {
                    text: "Keterangan",
                },

                yAxis: {
                    title: {
                        text: "Jumlah",
                    },
                },

                xAxis: {
                    title: {
                        text: "Date",
                        style: {
                            color: "#000"
                        },
                    },
                    categories: label,
                    labels: {
                        style: {
                            color: "#000",
                        },
                    },
                },

                legend: {
                    layout: "vertical",
                    align: "right",
                    verticalAlign: "middle",
                },

                series: [{
                    name: "Pelanggaran",
                    data: data,
                }, ],

                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 500,
                        },
                        chartOptions: {
                            legend: {
                                layout: "horizontal",
                                align: "center",
                                verticalAlign: "bottom",
                            },
                        },
                    }, ],
                },
            });

            Highcharts.chart("pjonlinechart", {
                title: {
                    text: "Grafik Pelanggaran",
                },

                subtitle: {
                    text: "Keterangan",
                },

                yAxis: {
                    title: {
                        text: "Jumlah",
                    },
                },

                xAxis: {
                    title: {
                        text: "Date",
                        style: {
                            color: "#000"
                        },
                    },
                    categories: label,
                    labels: {
                        style: {
                            color: "#000",
                        },
                    },
                },

                legend: {
                    layout: "vertical",
                    align: "right",
                    verticalAlign: "middle",
                },

                series: [{
                    name: "Pelanggaran",
                    data: data,
                }, ],

                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 500,
                        },
                        chartOptions: {
                            legend: {
                                layout: "horizontal",
                                align: "center",
                                verticalAlign: "bottom",
                            },
                        },
                    }, ],
                },
            });
        });
    </script>

    <!-- Dependent Dropdown Filtering -->
    <script>
        $(document).ready(function() {
            $('#prodi').on('change', function() {
                var prodi_id = $(this).val();
                if (prodi_id) {
                    $.ajax({
                        url: '/getSemester/' + prodi_id,
                        type: "GET",
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: "json",
                        success: function(data) {
                            if (data) {
                                $('#semester').empty();
                                $('#semester').append(
                                    '<option selected="selected" value="">Pilih Semester</option>'
                                    );
                                $.each(data, function(key, semester) {
                                    $('select[name="semester"]').append(
                                        '<option value="' + semester.id + '">' +
                                        semester.semester + '</option>');
                                });
                            } else {
                                $('#semester').empty();
                            }
                        }
                    });
                } else {
                    $('#semester').empty();
                }
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
                                $('#kelas').empty();
                                $('#kelas').append(
                                    '<option selected="selected" value="">Pilih Kelas</option>'
                                    );
                                $.each(data, function(key, kelas) {
                                    $('select[name="kelas"]').append('<option value="' +
                                        kelas.id + '">' + kelas.kelas + '</option>');
                                });
                            } else {
                                $('#kelas').empty();
                            }
                        }
                    });

                    $.ajax({
                        url: '/getMatkul/' + semester_id,
                        type: "GET",
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: "json",
                        success: function(data) {
                            if (data) {
                                $('#matkul').empty();
                                $('#matkul').append(
                                    '<option selected="selected" value="">Pilih Mata Kuliah</option>'
                                );
                                $.each(data, function(key, matkul) {
                                    $('select[name="matkul"]').append(
                                        '<option value="' + matkul.id + '">' +
                                        matkul.nama_matkul + '</option>');
                                });
                            } else {
                                $('#matkul').empty();
                            }
                        }
                    });
                } else {
                    $('#kelas').empty();
                    $('#matkul').empty();
                }
            });

            $('#kelas').on('change', function() {
                var kelas_id = $(this).val();
                if (kelas_id) {
                    $.ajax({
                        url: '/getPrak/' + kelas_id,
                        type: "GET",
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: "json",
                        success: function(data) {
                            if (data) {
                                $('#praktikum').empty();
                                $('#praktikum').append(
                                    '<option selected="selected" value="">Pilih Praktikum</option>'
                                    );
                                $.each(data, function(key, praktikum) {
                                    $('select[name="praktikum"]').append(
                                        '<option value="' + praktikum.id + '">' +
                                        praktikum.praktikum + '</option>');
                                });
                            } else {
                                $('#praktikum').empty();
                            }
                        }
                    });
                } else {
                    $('#praktikum').empty();
                }
            });
        });
    </script>
</body>

</html>
