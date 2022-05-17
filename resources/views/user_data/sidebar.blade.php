<div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo mb-3 d-flex justify-content-center">
            <img
                src="{{ asset('images/icon/ipb.png') }}"
                class="d-block"
                alt=""
                width="60px"
            />
        </div>
        <a href="{{ route('dashboardData') }}" class="text-dark text-center d-block"
            >Aplikasi Ujian SV IPB</a
        >
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
                        <a href="{{ route('data.pengguna.index') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Pengguna</span></a>
                    </li>

                    <li class="{{ Request::routeIs('data.mahasiswa.*') ? 'active' : '' }} m-1">
                        <a href="{{ route('data.mahasiswa.view') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Mahasiswa</span></a>
                    </li>

                    <li class="{{ Request::routeIs('data.periode.*') ? 'active' : '' }} m-1">
                        <a href="{{ route('data.periode.index') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Periode</span></a>
                    </li>

                    <li class="{{ Request::routeIs('data.akademik.*') ? 'active' : '' }} m-1">
                        <a  aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Akademik</span></a>
                        <ul class="collapse">
                            <li class="{{ Request::routeIs('data.akademik.prodi.*') ? 'active' : '' }} m-1"><a href="{{ route('data.akademik.prodi.index') }}">Program Studi</a></li>
                            <li class="{{ Request::routeIs('data.akademik.semester.*') ? 'active' : '' }} m-1"><a href="{{ route('data.akademik.semester.index') }}">Semester</a></li>
                            <li class="{{ Request::routeIs('data.akademik.kelas.*') ? 'active' : '' }} m-1"><a href="{{ route('data.akademik.kelas.index') }}">Kelas</a></li>
                            <li class="{{ Request::routeIs('data.akademik.praktikum.*') ? 'active' : '' }} m-1"><a href="{{ route('data.akademik.praktikum.index') }}">Praktikum</a></li>
                            <li class="{{ Request::routeIs('data.akademik.matkul.*') ? 'active' : '' }} m-1"><a href="{{ route('data.akademik.matkul.index') }}">Mata Kuliah</a></li>
                        </ul>
                    </li>

                    <li class="{{ Request::routeIs('data.ketersediaan.*') ? 'active' : '' }} m-1">
                        <a  aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Ketersediaan</span></a>
                        <ul class="collapse">
                            <li class="{{ Request::routeIs('data.ketersediaan.amplop') ? 'active' : '' }} m-1"><a href="{{ route('data.ketersediaan.amplop') }}">Amplop</a></li>
                            <li class="{{ Request::routeIs('data.ketersediaan.bap') ? 'active' : '' }} m-1"><a href="{{ route('data.ketersediaan.bap') }}">BAP</a></li>
                        </ul>
                    </li>

                    <li class="{{ Request::routeIs('data.pelanggaran') ? 'active' : '' }} m-1">
                        <a href="{{ route('data.pelanggaran') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Pelanggaran</span></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
