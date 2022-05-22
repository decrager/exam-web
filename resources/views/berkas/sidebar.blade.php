<div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo my-1 d-flex justify-content-center">
            <a href="{{ route('berkasDashboard') }}"><img
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
                    <li class="{{ Request::routeIs('berkasDashboard') ? 'active' : '' }} m-1">
                        <a href="{{ route('berkasDashboard') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Beranda</span></a>
                    </li>

                    {{-- <li class="{{ Request::routeIs('berkas.rekapitulasi.*') ? 'active' : '' }} m-1">
                        <a href="" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Rekapitulasi</span></a>
                        <ul class="collapse">
                            <li class="{{ Request::routeIs('berkas.rekapitulasi.mahasiswa') ? 'active' : '' }} m-1"><a href="{{ route('berkas.rekapitulasi.mahasiswa') }}">Mahasiswa</a></li>
                            <li class="{{ Request::routeIs('berkas.rekapitulasi.matkul') ? 'active' : '' }} m-1"><a href="{{ route('berkas.rekapitulasi.matkul') }}">Mata Kuliah</a></li>
                        </ul>
                    </li> --}}

                    <li class="{{ Request::routeIs('berkas.soal') ? 'active' : '' }} m-1">
                        <a href="{{ route('berkas.soal') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Data Berkas</span></a>
                    </li>

                    <li class="{{ Request::routeIs('berkas.kelengkapan.*') ? 'active' : '' }} m-1">
                        <a href="" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Kelengkapan</span></a>
                        <ul class="collapse">
                            <li class="{{ Request::routeIs('berkas.kelengkapan.amplop') ? 'active' : '' }} m-1"><a href="{{ route('berkas.kelengkapan.amplop') }}">Amplop</a></li>
                            <li class="{{ Request::routeIs('berkas.kelengkapan.bap') ? 'active' : '' }} m-1"><a href="{{ route('berkas.kelengkapan.bap') }}">BAP</a></li>
                            <li class="{{ Request::routeIs('berkas.kelengkapan.berkas.*') ? 'active' : '' }} m-1"><a href="{{ route('berkas.kelengkapan.berkas.index') }}">Soal Ujian</a></li>
                        </ul>
                    </li>

                    <li class="{{ Request::routeIs('berkas.pelanggaran') ? 'active' : '' }} m-1">
                        <a href="{{ route('berkas.pelanggaran') }}" aria-expanded="true"><i class="fa fa-align-left"></i>
                            <span>Pelanggaran</span></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
