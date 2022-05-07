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
        <a href="{{ route('supervisorDashboard') }}" class="text-dark text-center d-block"
            >Aplikasi Ujian SV IPB</a
        >
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">    
                    <li class="{{ Request::routeIs('supervisorDashboard') ? 'active' : '' }}">
                        <a href="{{ route('supervisorDashboard') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Beranda</span></a>
                    </li>

                    <li class="{{ Request::routeIs('supervisor.ujian') ? 'active' : '' }}">
                        <a href="{{ route('supervisor.ujian') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Jadwal Ujian</span></a>
                    </li>

                    <li class="{{ Request::routeIs('supervisor.susulan') ? 'active' : '' }}">
                        <a href="{{ route('supervisor.susulan') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Jadwal Susulan</span></a>
                    </li>

                    <li class="{{ Request::routeIs('supervisor.mhs_susulan') ? 'active' : '' }}">
                        <a href="{{ route('supervisor.mhs_susulan') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Data Susulan</span></a>
                    </li>

                    <li class="{{ Request::routeIs('supervisor.pengawas') ? 'active' : '' }}">
                        <a href="{{ route('supervisor.pengawas') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Pengawas</span></a>
                    </li>

                    <li class="{{ Request::routeIs('supervisor.mahasiswa') ? 'active' : '' }}">
                        <a href="{{ route('supervisor.mahasiswa') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Mahasiswa</span></a>
                    </li>

                    <li class="{{ Request::routeIs('supervisor.matkul') ? 'active' : '' }}">
                        <a href="{{ route('supervisor.matkul') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Mata Kuliah</span></a>
                    </li>

                    <li class="{{ Request::routeIs('supervisor.kelengkapan.*') ? 'active' : '' }}">
                        <a href="" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Kelengkapan</span></a>
                        <ul class="collapse">
                            <li class="{{ Request::routeIs('supervisor.kelengkapan.amplop') ? 'active' : '' }}"><a href="{{ route('supervisor.kelengkapan.amplop') }}">Amplop</a></li>
                            <li class="{{ Request::routeIs('supervisor.kelengkapan.bap') ? 'active' : '' }}"><a href="{{ route('supervisor.kelengkapan.bap') }}">BAP</a></li>
                            <li class="{{ Request::routeIs('supervisor.kelengkapan.berkas') ? 'active' : '' }}"><a href="{{ route('supervisor.kelengkapan.berkas') }}">Soal Ujian</a></li>
                        </ul>
                    </li>

                    <li class="{{ Request::routeIs('supervisor.pengguna') ? 'active' : '' }}">
                        <a href="{{ route('supervisor.pengguna') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Pengguna</span></a>
                    </li>

                    <li class="{{ Request::routeIs('supervisor.pelanggaran') ? 'active' : '' }}">
                        <a href="{{ route('supervisor.pelanggaran') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Pelanggaran</span></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
