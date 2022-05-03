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
        <a href="{{ route('pjLokasiDashboard') }}" class="text-dark text-center d-block"
            >Aplikasi Ujian SV IPB</a
        >
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">    
                    <li class="{{ Request::routeIs('pjLokasiDashboard') ? 'active' : '' }}">
                        <a href="{{ route('pjLokasiDashboard') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Beranda</span></a>
                    </li>

                    <li class="{{ Request::routeIs('pjLokasi.pengawas.*') ? 'active' : '' }}">
                        <a href="" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Pengawas</span></a>
                        <ul class="collapse">
                            <li class="{{ Request::routeIs('pjLokasi.pengawas.list') ? 'active' : '' }}"><a href="{{ route('pjLokasi.pengawas.list') }}">Daftar Pengawas</a></li>
                            <li class="{{ Request::routeIs('pjLokasi.pengawas.penugasan.*') ? 'active' : '' }}"><a href="{{ route('pjLokasi.pengawas.penugasan.index') }}">Penugasan</a></li>
                            <li class="{{ Request::routeIs('pjLokasi.pengawas.absensi.*') ? 'active' : '' }}"><a href="{{ route('pjLokasi.pengawas.absensi.index') }}">Absensi</a></li>
                        </ul>
                    </li>

                    <li class="{{ Request::routeIs('pjLokasi.berkas') ? 'active' : '' }}">
                        <a href="{{ route('pjLokasi.berkas') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Berkas</span></a>
                    </li>

                    <li class="{{ Request::routeIs('pjLokasi.pelanggaran.*') ? 'active' : '' }}">
                        <a href="{{ route('pjLokasi.pelanggaran.index') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Pelanggaran</span></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
