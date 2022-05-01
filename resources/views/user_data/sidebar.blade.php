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
        <a href="{{ route('dashboardData') }}" class="text-dark text-center d-block"
            >Aplikasi Ujian SV IPB</a
        >
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">    
                    <li class="{{ Request::routeIs('dashboardData') ? 'active' : '' }}">
                        <a href="{{ route('dashboardData') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Beranda</span></a>
                    </li>

                    <li class="{{ Request::routeIs('data.mahasiswa.*') ? 'active' : '' }}">
                        <a href="{{ route('data.mahasiswa.view') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Mahasiswa</span></a>
                    </li>

                    <li class="{{ Request::routeIs('data.ketersediaan.*') ? 'active' : '' }}">
                        <a href="" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Ketersediaan</span></a>
                        <ul class="collapse">
                            <li class="{{ Request::routeIs('data.ketersediaan.amplop') ? 'active' : '' }}"><a href="{{ route('data.ketersediaan.amplop') }}">Amplop</a></li>
                            <li class="{{ Request::routeIs('data.ketersediaan.bap') ? 'active' : '' }}"><a href="{{ route('data.ketersediaan.bap') }}">BAP</a></li>
                        </ul>
                    </li>

                    <li class="{{ Request::routeIs('data.berkas') ? 'active' : '' }}">
                        <a href="{{ route('data.berkas') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Berkas</span></a>
                    </li>

                    <li class="{{ Request::routeIs('data.pelanggaran') ? 'active' : '' }}">
                        <a href="{{ route('data.pelanggaran') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Pelanggaran</span></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
