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

                    <li class="{{ Request::routeIs('mahasiswa.*') ? 'active' : '' }}">
                        <a href="{{ route('mahasiswa.view') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Mahasiswa</span></a>
                    </li>

                    <li class="{{ Request::routeIs('ketersediaan.*') ? 'active' : '' }}">
                        <a aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Ketersediaan</span></a>
                        <ul class="collapse">
                            <li class="{{ Request::routeIs('ketersediaan.amplop') ? 'active' : '' }}"><a href="{{ route('ketersediaan.amplop') }}">Amplop</a></li>
                            <li class="{{ Request::routeIs('ketersediaan.bap') ? 'active' : '' }}"><a href="{{ route('ketersediaan.bap') }}">BAP</a></li>
                        </ul>
                    </li>

                    <li class="{{ Request::routeIs('berkas') ? 'active' : '' }}">
                        <a href="{{ route('berkas') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Berkas</span></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
