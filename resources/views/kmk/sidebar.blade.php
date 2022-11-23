<div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo my-1 d-flex justify-content-center">
            <a href="{{ route('pjUjianDashboard') }}"><img
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
                    <li class="{{ Request::routeIs('kmkDashboard') ? 'active' : '' }} m-1 mb-1">
                        <a href="{{ route('kmkDashboard') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Beranda</span></a>
                    </li>

                    <li class="{{ Request::routeIs('kmk.kehadiran') ? 'active' : '' }} m-1">
                        <a href="{{ route('kmk.kehadiran') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Kehadiran</span></a>
                    </li>

                    <li class="{{ Request::routeIs('kmk.ketidakhadiran') ? 'active' : '' }} m-1">
                        <a href="{{ route('kmk.ketidakhadiran') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Ketidakhadiran</span></a>
                    </li>

                    <li class="{{ Request::routeIs('kmk.susulan') ? 'active' : '' }} m-1">
                        <a href="{{ route('kmk.susulan') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Susulan</span></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
