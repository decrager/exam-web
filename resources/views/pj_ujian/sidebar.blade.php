<div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo mt-2">
            <a href="{{ route('dashboard') }}" class="text-dark">Aplikasi Ujian SV IPB</a>
        </div>
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">    
                    <li class="{{ Request::routeIs('dashboard') ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Beranda</span></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
