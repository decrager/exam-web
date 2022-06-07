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
                    <li class="{{ Request::routeIs('pjUjianDashboard') ? 'active' : '' }} m-1 mb-1">
                        <a href="{{ route('pjUjianDashboard') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Beranda</span></a>
                    </li>

                    <li class="{{ Request::routeIs('pjUjian.jadwal.*') ? 'active' : '' }} m-1 mb-1">
                        <a href="{{ route('pjUjian.jadwal.index') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Jadwal Ujian</span></a>
                    </li>

                    {{-- <li class="{{ Request::routeIs('pjUjian.soal.*') ? 'active' : '' }} m-1 mb-1">
                        <a href="{{ route('pjUjian.soal.index') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Soal Ujian</span></a>
                    </li> --}}

                    <li class="{{ Request::routeIs('pjUjian.pengawas.*') ? 'active' : '' }} m-1">
                        <a href="" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Pengawas</span></a>
                        <ul class="collapse">
                            <li class="{{ Request::routeIs('pjUjian.pengawas.pengawas.*') ? 'active' : '' }} m-1"><a href="{{ route('pjUjian.pengawas.pengawas.index') }}">Daftar pengawas</a></li>
                            <li class="{{ Request::routeIs('pjUjian.pengawas.penugasan.*') ? 'active' : '' }} m-1"><a href="{{ route('pjUjian.pengawas.penugasan.index') }}">Penugasan</a></li>
                        </ul>
                    </li>

                    <li class="{{ Request::routeIs('pjUjian.kelengkapan.*') ? 'active' : '' }} m-1">
                        <a href="" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Kelengkapan</span></a>
                        <ul class="collapse">
                            <li class="{{ Request::routeIs('pjUjian.kelengkapan.amplop') ? 'active' : '' }} m-1"><a href="{{ route('pjUjian.kelengkapan.amplop') }}">Amplop</a></li>
                            <li class="{{ Request::routeIs('pjUjian.kelengkapan.bap') ? 'active' : '' }} m-1"><a href="{{ route('pjUjian.kelengkapan.bap') }}">BAP</a></li>
                            <li class="{{ Request::routeIs('pjUjian.kelengkapan.berkas.*') ? 'active' : '' }} m-1"><a href="{{ route('pjUjian.kelengkapan.berkas.index') }}">Soal Ujian</a></li>
                        </ul>
                    </li>

                    <li class="{{ Request::routeIs('pjUjian.susulan.*') ? 'active' : '' }} m-1">
                        <a href="" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Susulan</span></a>
                        <ul class="collapse">
                            <li class="{{ Request::routeIs('pjUjian.susulan.mahasiswa') ? 'active' : '' }} m-1"><a href="{{ route('pjUjian.susulan.mahasiswa') }}">Mahasiswa</a></li>
                            {{-- <li class="{{ Request::routeIs('pjUjian.susulan.penjadwalan.*') ? 'active' : '' }} m-1"><a href="{{ route('pjUjian.susulan.penjadwalan.index') }}">Penjadwalan</a></li>
                            <li class="{{ Request::routeIs('pjUjian.susulan.susulan.*') ? 'active' : '' }} m-1"><a href="{{ route('pjUjian.susulan.susulan.index') }}">Jadwal Susulan</a></li> --}}
                        </ul>
                    </li>

                    <li class="{{ Request::routeIs('pjUjian.pelanggaran') ? 'active' : '' }} m-1">
                        <a href="{{ route('pjUjian.pelanggaran') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Ketidakhadiran</span></a>
                    </li>

                    <li class="{{ Request::routeIs('pjUjian.activity') ? 'active' : '' }} m-1">
                        <a href="{{ route('pjUjian.activity') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Aktivitas</span></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
