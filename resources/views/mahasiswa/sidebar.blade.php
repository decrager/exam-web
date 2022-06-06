<div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo my-1 d-flex justify-content-center">
            <a href="{{ route('mahasiswaDashboard') }}"><img
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
                    <li class="{{ Request::routeIs('mahasiswaDashboard') ? 'active' : '' }} m-1">
                        <a href="{{ route('mahasiswaDashboard') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Beranda</span></a>
                    </li>

                    <li class="{{ Request::routeIs('mahasiswa.susulan.*') ? 'active' : '' }} m-1">
                        <a href="" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Susulan</span></a>
                        <ul class="collapse">
                            {{-- <li class="{{ Request::routeIs('mahasiswa.susulan.jadwal') ? 'active' : '' }} m-1"><a href="{{ route('mahasiswa.susulan.jadwal') }}">Jadwal</a></li> --}}
                            <li class="{{ Request::routeIs('mahasiswa.susulan.pengajuan.*') ? 'active' : '' }} m-1"><a href="{{ route('mahasiswa.susulan.pengajuan.index') }}">Pengajuan</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
