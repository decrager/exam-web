<div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo my-1 d-flex justify-content-center">
            <a href="{{ route('pjLokasiDashboard') }}"><img
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
                    <li class="{{ Request::routeIs('pjLokasiDashboard') ? 'active' : '' }} m-1">
                        <a href="{{ route('pjLokasiDashboard') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Beranda</span></a>
                    </li>

                    <li class="{{ Request::routeIs('pjLokasi.pengawas.*') ? 'active' : '' }} m-1">
                        <a href="" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Pengawas</span></a>
                        <ul class="collapse">
                            <li class="{{ Request::routeIs('pjLokasi.pengawas.daftar.*') ? 'active' : '' }} m-1"><a href="{{ route('pjLokasi.pengawas.daftar.index') }}">Daftar Pengawas</a></li>
                            <li class="{{ Request::routeIs('pjLokasi.pengawas.absensi.*') ? 'active' : '' }} m-1"><a href="{{ route('pjLokasi.pengawas.absensi.index') }}">Kehadiran</a></li>
                        </ul>
                    </li>

                    <li class="{{ Request::routeIs('pjLokasi.soal.*') ? 'active' : '' }} m-1">
                        <a href="{{ route('pjLokasi.soal.index') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Soal Ujian</span></a>
                    </li>

                    <li class="{{ Request::is('pj_lokasi/pelanggaran*') ? 'active' : '' }} m-1">
                        <a href="/pj_lokasi/pelanggaran" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Pelanggaran</span></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
