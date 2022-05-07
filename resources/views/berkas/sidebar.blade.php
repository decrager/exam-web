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
        <a href="{{ route('berkasDashboard') }}" class="text-dark text-center d-block"
            >Aplikasi Ujian SV IPB</a
        >
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">    
                    <li class="{{ Request::routeIs('berkasDashboard') ? 'active' : '' }}">
                        <a href="{{ route('berkasDashboard') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Beranda</span></a>
                    </li>

                    <li class="{{ Request::routeIs('berkas.rekapitulasi.*') ? 'active' : '' }}">
                        <a href="" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Rekapitulasi</span></a>
                        <ul class="collapse">
                            <li class="{{ Request::routeIs('berkas.rekapitulasi.mahasiswa') ? 'active' : '' }}"><a href="{{ route('berkas.rekapitulasi.mahasiswa') }}">Mahasiswa</a></li>
                            <li class="{{ Request::routeIs('berkas.rekapitulasi.matkul') ? 'active' : '' }}"><a href="{{ route('berkas.rekapitulasi.matkul') }}">Mata Kuliah</a></li>
                        </ul>
                    </li>

                    <li class="{{ Request::routeIs('berkas.kelengkapan.*') ? 'active' : '' }}">
                        <a href="" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Kelengkapan</span></a>
                        <ul class="collapse">
                            <li class="{{ Request::routeIs('berkas.kelengkapan.amplop') ? 'active' : '' }}"><a href="{{ route('berkas.kelengkapan.amplop') }}">Amplop</a></li>
                            <li class="{{ Request::routeIs('berkas.kelengkapan.bap') ? 'active' : '' }}"><a href="{{ route('berkas.kelengkapan.bap') }}">BAP</a></li>
                            <li class="{{ Request::routeIs('berkas.kelengkapan.berkas') ? 'active' : '' }}"><a href="{{ route('berkas.kelengkapan.berkas') }}">Soal Ujian</a></li>
                        </ul>
                    </li>

                    <li class="{{ Request::routeIs('berkas.pelanggaran') ? 'active' : '' }}">
                        <a href="{{ route('berkas.pelanggaran') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Pelanggaran</span></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
