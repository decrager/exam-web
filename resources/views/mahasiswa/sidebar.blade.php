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
        <a href="{{ route('mahasiswaDashboard') }}" class="text-dark text-center d-block"
            >Aplikasi Ujian SV IPB</a
        >
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">    
                    <li class="{{ Request::routeIs('mahasiswaDashboard') ? 'active' : '' }}">
                        <a href="{{ route('mahasiswaDashboard') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Beranda</span></a>
                    </li>

                    <li class="{{ Request::routeIs('mahasiswa.susulan.*') ? 'active' : '' }}">
                        <a href="" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Susulan</span></a>
                        <ul class="collapse">
                            <li class="{{ Request::routeIs('mahasiswa.susulan.jadwal') ? 'active' : '' }}"><a href="{{ route('mahasiswa.susulan.jadwal') }}">Jadwal</a></li>
                            <li class="{{ Request::routeIs('mahasiswa.susulan.pengajuan.*') ? 'active' : '' }}"><a href="{{ route('mahasiswa.susulan.pengajuan.index') }}">Pengajuan</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
