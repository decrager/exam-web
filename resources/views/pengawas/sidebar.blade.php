<div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo my-1 d-flex justify-content-center">
            <a href="{{ route('pengawasDashboard') }}"><img
                src="{{ asset('images/icon/SV_IPB.png') }}"
                class="d-block"
                alt=""
                width="100%"
            /></a>
        </div>
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">    
                    <li class="{{ Request::routeIs('pengawasDashboard') ? 'active' : '' }} m-1">
                        <a href="{{ route('pengawasDashboard') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Beranda</span></a>
                    </li>

                    <li class="{{ Request::routeIs('pengawas.absensi.*') ? 'active' : '' }} m-1">
                        <a href="{{ route('pengawas.absensi.index') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Kehadiran</span></a>
                    </li>

                    <li class="{{ Request::routeIs('pengawas.ketidakhadiran.*') ? 'active' : '' }} m-1">
                        <a href="{{ route('pengawas.ketidakhadiran.index') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Ketidakhadiran</span></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
