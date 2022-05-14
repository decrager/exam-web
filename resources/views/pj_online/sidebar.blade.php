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
        <a href="{{ route('pjOnlineDashboard') }}" class="text-dark text-center d-block"
            >Aplikasi Ujian SV IPB</a
        >
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">    
                    <li class="{{ Request::routeIs('pjOnlineDashboard') ? 'active' : '' }} m-1">
                        <a href="{{ route('pjOnlineDashboard') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Beranda</span></a>
                    </li>

                    <li class="{{ Request::routeIs('pjOnline.ujian') ? 'active' : '' }} m-1">
                        <a href="{{ route('pjOnline.ujian') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Jadwal Ujian</span></a>
                    </li>

                    <li class="{{ Request::is('pj_online/pelanggaran*') ? 'active' : '' }} m-1">
                        <a href="/pj_online/pelanggaran" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Pelanggaran</span></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
