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
                    <li class="{{ Request::routeIs('dashboardData') ? 'active' : '' }} m-1">
                        <a href="{{ route('dashboardData') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Beranda</span></a>
                    </li>

                    <li class="{{ Request::routeIs('data.mahasiswa.*') ? 'active' : '' }} m-1">
                        <a href="{{ route('data.mahasiswa.view') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Mahasiswa</span></a>
                    </li>

                    <li class="{{ Request::routeIs('data.ketersediaan.*') ? 'active' : '' }} m-1">
                        <a href="" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Ketersediaan</span></a>
                        <ul class="collapse">
                            <li class="{{ Request::routeIs('data.ketersediaan.amplop') ? 'active' : '' }} m-1"><a href="{{ route('data.ketersediaan.amplop') }}">Amplop</a></li>
                            <li class="{{ Request::routeIs('data.ketersediaan.bap') ? 'active' : '' }} m-1"><a href="{{ route('data.ketersediaan.bap') }}">BAP</a></li>
                        </ul>
                    </li>

                    <li class="{{ Request::routeIs('data.pengguna.*') ? 'active' : '' }} m-1">
                        <a href="{{ route('data.pengguna.index') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Pengguna</span></a>
                    </li>
                    
                    <li class="{{ Request::routeIs('data.pelanggaran') ? 'active' : '' }} m-1">
                        <a href="{{ route('data.pelanggaran') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Pelanggaran</span></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
