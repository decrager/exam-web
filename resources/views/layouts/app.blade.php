<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <link rel="icon" type="image/x-icon" href="{{ asset('images/icon/IPB.png') }}">
    <title>
        @if (empty($title))
            Title
        @else
            {{ $title }}
        @endif
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

    <link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css">

    <style>
        .kbw-signature {
            width: 100%;
            height: 200px;
        }

        #sig canvas {
            width: 100% !important;
            height: auto;
        }

    </style>

    <!-- modernizr css -->
    <script src="{{ asset('js/vendor/modernizr-2.8.3.min.js') }}"></script>
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
    <script type="text/javascript" src="http://keith-wood.name/js/jquery.signature.js"></script>

    <script type="text/javascript">
        var sig = $('#sig').signature({
            syncField: '#signature64',
            syncFormat: 'PNG'
        });
        $('#clear').click(function(e) {
            e.preventDefault();
            sig.signature('clear');
            $("#signature64").val('');
        });
    </script>

    <script>
        $(document).ready(function() {
            $("#example").DataTable();
        });

        Highcharts.chart("container", {
            title: {
                text: "Grafik Pelanggaran",
            },

            subtitle: {
                text: "Subtitle",
            },

            yAxis: {
                title: {
                    text: "Text",
                },
            },

            xAxis: {
                title: {
                    text: "Date",
                    style: {
                        color: "#000"
                    },
                },
                categories: [1, 2, 3, 4, 5, 6, 7, 8],
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
                    data: [43934, 52503, 57177, 69658, 97031, 119931, 137133, 154175],
                },
                // {
                // 	name: "Manufacturing",
                // 	data: [24916, 24064, 29742, 29851, 32490, 30282, 38121, 40434],
                // },
            ],

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
    </script>
</body>

</html>
