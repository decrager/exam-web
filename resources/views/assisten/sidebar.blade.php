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
        <a href="{{ route('assistenDashboard') }}" class="text-dark text-center d-block"
            >Aplikasi Ujian SV IPB</a
        >
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">    
                    <li class="{{ Request::routeIs('assistenDashboard') ? 'active' : '' }}">
                        <a href="{{ route('assistenDashboard') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Beranda</span></a>
                    </li>

                    <li class="{{ Request::routeIs('assisten.berkas') ? 'active' : '' }}">
                        <a href="{{ route('assisten.berkas') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Berkas</span></a>
                    </li>

                    <li class="{{ Request::routeIs('assisten.pelanggaran') ? 'active' : '' }}">
                        <a href="{{ route('assisten.pelanggaran') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Pelanggaran</span></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
