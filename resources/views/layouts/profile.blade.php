<div class="col-sm-6 clearfix">
    <div class="user-profile pull-right">
        <img class="user-thumb mr-3" src="{{ asset('images/author/user.png') }}" alt="avatar" width="20px" />
        <h4 class="user-name dropdown-toggle" data-toggle="dropdown">
            @if (auth()->user()->role == 'data')
                <?php $role = 'Data & Akademik' ?>
            @elseif (auth()->user()->role == 'pj_ujian')
                <?php $role = 'PJ Ujian' ?>
            @elseif (auth()->user()->role == 'prodi')
                <?php $role = 'Program Studi' ?>
            @elseif (auth()->user()->role == 'pj_lokasi')
                @if (auth()->user()->lokasi == 'CA & Lab Kom')
                <?php $role = 'PJ Lokasi CA & Lab Kom' ?>
                @elseif (auth()->user()->lokasi == 'CB & Lab Kom')
                <?php $role = 'PJ Lokasi CB & Lab Kom' ?>
                @elseif (auth()->user()->lokasi == 'BS B01-06')
                <?php $role = 'PJ Lokasi BS B01-06' ?>
                @elseif (auth()->user()->lokasi == 'BS B07-10')
                <?php $role = 'PJ Lokasi BS B07-10' ?>
                @elseif (auth()->user()->lokasi == 'BS KIMBOTFIS')
                <?php $role = 'PJ Lokasi BS KIMBOTFIS' ?>
                @elseif (auth()->user()->lokasi == 'BS P01-03')
                <?php $role = 'PJ Lokasi BS P01-03' ?>
                @elseif (auth()->user()->lokasi == 'Sukabumi')
                <?php $role = 'PJ Lokasi Sukabumi' ?>
                @elseif (auth()->user()->lokasi == 'Online')
                <?php $role = 'PJ Lokasi Online' ?>
                @endif
            @elseif (auth()->user()->role == 'berkas')
                <?php $role = 'Berkas' ?>
            @elseif (auth()->user()->role == 'assisten')
                <?php $role = 'Asisten Perlokasi' ?>
            @elseif (auth()->user()->role == 'pj_susulan')
                <?php $role = 'PJ Susulan' ?>
            @elseif (auth()->user()->role == 'supervisor')
                <?php $role = 'Supervisor' ?>
            @elseif (auth()->user()->role == 'pj_online')
                <?php $role = 'PJ Online' ?>
            @elseif (auth()->user()->role == 'pj_labkom')
                <?php $role = 'PJ Lab Komputer' ?>
            @elseif (auth()->user()->role == 'superadmin')
                <?php $role = 'Superadmin' ?>
            @elseif (auth()->user()->role == 'mahasiswa')
                <?php $role = 'Mahasiswa' ?>
            @elseif (auth()->user()->role == 'pengawas')
                <?php $role = 'Pengawas' ?>
            @endif
            {{ auth()->user()->name }} | {{ $role }}<i class="fa fa-angle-down"></i>
        </h4>
        <div class="dropdown-menu">
            <form action="{{ route('resetView') }}" method="GET">
                <button type="submit" class="dropdown-item">Ubah Password</button>
            </form>
            {{-- <button class="dropdown-item">Ubah Password</button>
            <a class="dropdown-item" href="{{ route('resetPassword') }}">Ubah Password</a> --}}
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="dropdown-item">Keluar</button>
            </form>
        </div>
    </div>
</div>
