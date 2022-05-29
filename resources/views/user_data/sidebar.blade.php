<div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo my-1 d-flex justify-content-center">
            <a href="{{ route('dashboardData') }}"><img src="{{ asset('images/icon/SV_IPB.png') }}"
                    class="d-block" alt="" width="100%" /></a>
        </div>
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">
                    <li class="{{ Request::routeIs('dashboardData') ? 'active' : '' }} m-1">
                        <a href="{{ route('dashboardData') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Beranda</span></a>
                    </li>

                    <li class="{{ Request::routeIs('data.ujian') ? 'active' : '' }} m-1">
                        <a href="{{ route('data.ujian') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Jadwal Ujian</span></a>
                    </li>

                    <li class="{{ Request::routeIs('data.pengguna.*') ? 'active' : '' }} m-1">
                        <a href="{{ route('data.pengguna.index') }}" aria-expanded="true"><i
                                class="fa fa-align-left"></i>
                            <span>Pengguna</span></a>
                    </li>

                    <li class="{{ Request::routeIs('data.mahasiswa.*') ? 'active' : '' }} m-1">
                        <a href="{{ route('data.mahasiswa.view') }}" aria-expanded="true"><i
                                class="fa fa-align-left"></i>
                            <span>Mahasiswa</span></a>
                    </li>

                    <li class="{{ Request::routeIs('data.periode.*') ? 'active' : '' }} m-1">
                        <a href="{{ route('data.periode.index') }}" aria-expanded="true"><i
                                class="fa fa-align-left"></i>
                            <span>Periode</span></a>
                    </li>

                    <li class="{{ Request::routeIs('data.akademik.*') ? 'active' : '' }} m-1">
                        <a href="" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Akademik</span></a>
                        <ul class="collapse">
                            <li class="{{ Request::routeIs('data.akademik.prodi.*') ? 'active' : '' }} m-1"><a
                                    href="{{ route('data.akademik.prodi.index') }}">Program Studi</a></li>
                            <li class="{{ Request::routeIs('data.akademik.semester.*') ? 'active' : '' }} m-1"><a
                                    href="{{ route('data.akademik.semester.index') }}">Semester</a></li>
                            <li class="{{ Request::routeIs('data.akademik.kelas.*') ? 'active' : '' }} m-1"><a
                                    href="{{ route('data.akademik.kelas.index') }}">Kelas</a></li>
                            <li class="{{ Request::routeIs('data.akademik.praktikum.*') ? 'active' : '' }} m-1"><a
                                    href="{{ route('data.akademik.praktikum.index') }}">Praktikum</a></li>
                            <li class="{{ Request::routeIs('data.akademik.matkul.*') ? 'active' : '' }} m-1"><a
                                    href="{{ route('data.akademik.matkul.index') }}">Mata Kuliah</a></li>
                        </ul>
                    </li>

                    <li class="{{ Request::routeIs('data.ketersediaan.*') ? 'active' : '' }} m-1">
                        <a href="" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Ketersediaan</span></a>
                        <ul class="collapse">
                            <li class="{{ Request::routeIs('data.ketersediaan.amplop') ? 'active' : '' }} m-1"><a
                                    href="{{ route('data.ketersediaan.amplop') }}">Amplop</a></li>
                            <li class="{{ Request::routeIs('data.ketersediaan.bap') ? 'active' : '' }} m-1"><a
                                    href="{{ route('data.ketersediaan.bap') }}">BAP</a></li>
                        </ul>
                    </li>

                    <li class="{{ Request::routeIs('data.pengawas.*') ? 'active' : '' }} m-1">
                        <a href="" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Pengawas</span></a>
                        <ul class="collapse">
                            <li class="{{ Request::routeIs('data.pengawas.data.*') ? 'active' : '' }} m-1"><a
                                    href="{{ route('data.pengawas.data.index') }}">Data Pengawas</a></li>
                            <li class="{{ Request::routeIs('data.pengawas.presensi') ? 'active' : '' }} m-1"><a
                                    href="{{ route('data.pengawas.presensi') }}">Kehadiran</a></li>
                        </ul>
                    </li>

                    <li class="{{ Request::routeIs('data.pelanggaran') ? 'active' : '' }} m-1">
                        <a href="{{ route('data.pelanggaran') }}" aria-expanded="true"><i
                                class="fa fa-align-left"></i>
                            <span>Pelanggaran</span></a>
                    </li>

                    <li class="{{ Request::routeIs('data.activity') ? 'active' : '' }} m-1">
                        <a href="{{ route('data.activity') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Aktivitas</span></a>
                    </li>

                </ul>
            </nav>
        </div>
    </div>
</div>
