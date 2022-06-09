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
                    <h4 class="page-title pull-left">Export Kehadiran</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a >Beranda</a></li>
                        <li><a>Pengawas</a></li>
                        <li><a ><span>Kehadiran</span></a></li>
                        <li><span>Export Kehadiran</span></li>
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
                                <form action="{{ route('pjLokasi.pdf') }}" method="POST">
                                    <h4 class="header-title">Export Kehadiran Pengawas Ujian</h4>
                                    @csrf

                                    <div class="form-group">
                                        <label class="col-form-label">Sesi</label>
                                        <select class="custom-select" name="sesi" id="sesi" onchange="myFunction()" required>
                                            <option selected value="">Pilih sesi</option>
                                            @if ($hari == 'Jumat')
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                            @else
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            @endif
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="pukul" class="col-form-label">Pukul</label>
                                        <input class="form-control" id="pukul" value="Pilih Sesi" name="pukul" readonly/>
                                    </div>

                                    <div class="form-group">
                                        <label class="" for="">Tanda Tangan: (Jika sudah mengisi sekali, boleh tidak mengisi lagi)</label>
                                        <br />
                                        <div id="sign"> </div>
                                        <br />
                                        <button id="clear" class="btn btn-danger btn-sm">Clear Signature</button>
                                        <textarea id="signature" name="ttd" style="display: none"></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Export</button>
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

    <script>
        function myFunction() {
            var x = document.getElementById("sesi").value;
            
            const weekday = ["Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu"];
            const d = new Date();
            var day = weekday[d.getDay()];

            if (x == "2" && day == "Jumat") {
                var jam = "14.00 - 16.15";
            } else if (x == "1") {
                var jam = "08.00 - 10.15";
            } else if (x == "2") {
                var jam = "10.30 - 12.45";
            } else if (x == "3") {
                var jam = "13.15 - 15.30";
            } else {
                var jam = "Pilih sesi";
            }

            document.getElementById("pukul").value = jam;
        }
    </script>
@endsection
