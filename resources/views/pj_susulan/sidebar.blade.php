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
        <a href="{{ route('pjSusulanDashboard') }}" class="text-dark text-center d-block"
            >Aplikasi Ujian SV IPB</a
        >
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">    
                    <li class="{{ Request::routeIs('pjSusulanDashboard') ? 'active' : '' }} m-1">
                        <a href="{{ route('pjSusulanDashboard') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Beranda</span></a>
                    </li>

                    <li class="{{ Request::routeIs('pjSusulan.jadwal.*') ? 'active' : '' }} m-1">
                        <a href="{{ route('pjSusulan.jadwal.index') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Jadwal Ujian Susulan</span></a>
                    </li>

                    <li class="{{ Request::routeIs('pjSusulan.ketentuan.*') ? 'active' : '' }} m-1">
                        <a href="{{ route('pjSusulan.ketentuan.index') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Ketentuan</span></a>
                    </li>

                    <li class="{{ Request::routeIs('pjSusulan.mahasiswa.*') ? 'active' : '' }} m-1">
                        <a href="{{ route('pjSusulan.mahasiswa.index') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Mahasiswa</span></a>
                    </li>

                    <li class="{{ Request::routeIs('pjSusulan.penjadwalan.*') ? 'active' : '' }} m-1">
                        <a href="{{ route('pjSusulan.penjadwalan.index') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Penjadwalan</span></a>
                    </li>

                    <li class="{{ Request::routeIs('pjSusulan.pelanggaran') ? 'active' : '' }} m-1">
                        <a href="{{ route('pjSusulan.pelanggaran') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Pelanggaran</span></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
