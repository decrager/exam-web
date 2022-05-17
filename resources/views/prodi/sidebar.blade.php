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
        <a href="{{ route('prodiDashboard') }}" class="text-dark text-center d-block"
            >Aplikasi Ujian SV IPB</a
        >
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">    
                    <li class="{{ Request::routeIs('prodiDashboard') ? 'active' : '' }} m-1">
                        <a href="{{ route('prodiDashboard') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Beranda</span></a>
                    </li>

                    <li class="{{ Request::routeIs('prodi.jadwal.*') ? 'active' : '' }} m-1">
                        <a href="{{ route('prodi.jadwal.index') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Jadwal Ujian</span></a>
                    </li>

                    <li class="{{ Request::routeIs('prodi.pengawas.*') ? 'active' : '' }} m-1">
                        <a  aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Pengawas</span></a>
                        <ul class="collapse">
                            <li class="{{ Request::routeIs('prodi.pengawas.list') ? 'active' : '' }} m-1"><a href="{{ route('prodi.pengawas.list') }}">Daftar Pengawas</a></li>
                            <li class="{{ Request::routeIs('prodi.pengawas.penugasan.*') ? 'active' : '' }} m-1"><a href="{{ route('prodi.pengawas.penugasan.index') }}">Penugasan</a></li>
                        </ul>
                    </li>

                    <li class="{{ Request::routeIs('prodi.berkas') ? 'active' : '' }} m-1">
                        <a href="{{ route('prodi.berkas') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Soal Ujian</span></a>
                    </li>

                    <li class="{{ Request::routeIs('prodi.pelanggaran') ? 'active' : '' }} m-1">
                        <a href="{{ route('prodi.pelanggaran') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Pelanggaran</span></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
