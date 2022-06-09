<!-- page title area start -->
<div class="page-title-area mb-3">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Beranda</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a>Beranda</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- page title area end -->
<div class="main-content-inner">
    <div class="row mb-3">
        <div class="col-12 col-md-4">
            <div class="single-report bg-white">
                <span>Jumlah Ketidakhadiran</span>
                <div class="number">
                    @foreach ($totalPelanggaran as $total)
                        {{ $total->total }}
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="single-report bg-white">
                <span>Ujian Hari Ini</span>
                <div class="number">
                    @foreach ($totalUjian as $total)
                        {{ $total->total }}
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="single-report bg-white">
                <span>Jumlah Pengawas Yang Sudah Hadir</span>
                <div class="number">
                    @foreach ($totalKehadiran as $total)
                        {{ $total->total }}
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <!-- data table start -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Rekapitulasi Ketidakhadiran</h4>
                    <figure class="highcharts-figure">
                        <div id="container"></div>
                    </figure>
                </div>
            </div>
        </div>
        <!-- data table end -->
    </div>
    
    <div class="row mb-3">
        <!-- data table start -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title pt-2">Jadwal Ujian</h4>
                    @if (auth()->user()->role == 'data')
                        <form action="/data" class="row mb-1 justify-content-start">@include('layouts.filter')</form>
                    @elseif (auth()->user()->role == 'pj_ujian')
                        <form action="/pj_ujian" class="row mb-1 justify-content-start">@include('layouts.filter')</form>
                    @elseif (auth()->user()->role == 'prodi')
                        <form action="/prodi" class="row mb-1 justify-content-start">@include('layouts.filter')</form>
                    @elseif (auth()->user()->role == 'pj_lokasi')
                        <form action="/pj_lokasi" class="row mb-1 justify-content-start">@include('layouts.filter')</form>
                    @elseif (auth()->user()->role == 'berkas')
                        <form action="/berkas" class="row mb-1 justify-content-start">@include('layouts.filter')</form>
                    @elseif (auth()->user()->role == 'assisten')
                        <form action="/assisten" class="row mb-1 justify-content-start">@include('layouts.filter')</form>
                    @elseif (auth()->user()->role == 'pj_susulan')
                        <form action="/pj_susulan" class="row mb-1 justify-content-start">@include('layouts.filter')</form>
                    @elseif (auth()->user()->role == 'supervisor')
                        <form action="/supervisor" class="row mb-1 justify-content-start">@include('layouts.filter')</form>
                    @elseif (auth()->user()->role == 'pj_online')
                        <form action="/pj_online" class="row mb-1 justify-content-start">@include('layouts.filter')</form>
                    @elseif (auth()->user()->role == 'pj_labkom')
                        <form action="/pj_labkom" class="row mb-1 justify-content-start">@include('layouts.filter')</form>
                    @elseif (auth()->user()->role == 'superadmin')
                        <form action="/superadmin" class="row mb-1 justify-content-start">@include('layouts.filter')</form>
                    @elseif (auth()->user()->role == 'mahasiswa')
                        <form action="/mahasiswa" class="row mb-1 justify-content-start">@include('layouts.filter')</form>
                    @endif
                    <!-- <i class="fa fa-check text-danger"></i> -->

                    <div class="table-responsive">
                        <table id="example" class="table" style="width: 100%">
                            <thead>
                                <tr>
                                    <th class="border-0" scope="col">No</th>
                                    <th class="border-0" scope="col">Tanggal</th>
                                    <th class="border-0 col-2" scope="col">Program Studi</th>
                                    <th class="border-0" scope="col">Semester</th>
                                    <th class="border-0" scope="col">Kelas</th>
                                    <th class="border-0" scope="col">Praktikum</th>
                                    <th class="border-0 col-2" scope="col">Mata Kuliah</th>
                                    <th class="border-0" scope="col">Usulan Ruang</th>
                                    <th class="border-0" scope="col">Ruang</th>
                                    <th class="border-0" scope="col">Jam Mulai</th>
                                    <th class="border-0" scope="col">Jam Selesai</th>
                                    <th class="border-0" scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dbUjian as $ujian)
                                    <tr>
                                        <td class="border-0" scope="row">{{ $loop?->iteration }}</td>
                                        <td class="border-0">{{ $ujian?->tanggal }}</td>
                                        <td class="border-0">{{ $ujian?->Matkul?->Semester?->Prodi?->nama_prodi }}
                                        </td>
                                        <td class="border-0">{{ $ujian?->Matkul?->Semester?->semester }}</td>
                                        <td class="border-0">{{ $ujian?->Praktikum?->Kelas?->kelas }}</td>
                                        <td class="border-0">{{ $ujian?->Praktikum?->praktikum }}</td>
                                        <td class="border-0">{{ $ujian?->Matkul?->nama_matkul }}</td>
                                        <td class="border-0">{{ $ujian?->lokasi }}</td>
                                        <td class="border-0">{{ $ujian?->ruang }}</td>
                                        <td class="border-0">{{ $ujian?->jam_mulai }}</td>
                                        <td class="border-0">{{ $ujian?->jam_selesai }}</td>
                                        <td class="border-0"><button class="btn btn-primary"
                                                data-bs-toggle="modal"
                                                data-bs-target="{{ '#detail' . $ujian?->id }}"><i
                                                    class="fas fa-info"></i></button></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- data table end -->
    </div>

    <!-- Modal -->
    @foreach ($dbUjian as $ujian)
        <div class="modal fade" id="{{ 'detail' . $ujian?->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- Textual inputs start -->
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body p-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <h6>Tanggal</h6>
                                                    <p>{{ $ujian?->tanggal }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Program Studi</h6>
                                                    <p>{{ $ujian?->Matkul?->Semester?->Prodi?->nama_prodi }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Semester</h6>
                                                    <p>{{ $ujian?->Matkul?->Semester?->semester }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Kelas - Praktikum</h6>
                                                    <p>{{ $ujian?->Praktikum?->Kelas?->kelas }} -
                                                        {{ $ujian?->Praktikum?->praktikum }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Kode Mata Kuliah</h6>
                                                    <p>{{ $ujian?->Matkul?->kode_matkul }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Mata Kuliah</h6>
                                                    <p>{{ $ujian?->Matkul?->nama_matkul }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Usulan Ruang</h6>
                                                    <p>{{ $ujian?->lokasi }}</p>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <h6>Ruang</h6>
                                                    <p>{{ $ujian?->ruang }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Jam Mulai - Jam Selesai</h6>
                                                    <p>{{ $ujian?->jam_mulai }} - {{ $ujian?->jam_selesai }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Tipe Mata Kuliah</h6>
                                                    <p>{{ $ujian?->tipe_mk }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Sesi</h6>
                                                    <p>{{ $ujian?->sesi }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Software</h6>
                                                    <p>{{ $ujian?->software }}</p>
                                                </div>
                                                <div class="form-group">
                                                    <h6>Pelaksanaan</h6>
                                                    <p>{{ $ujian?->pelaksanaan }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Textual inputs end -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
