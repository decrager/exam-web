<div class="col-sm-6 clearfix">
    <div class="user-profile pull-right">
        <img class="user-thumb mr-3" src="{{ asset('images/author/user.png') }}" alt="avatar" width="20px" />
        <h4 class="user-name dropdown-toggle" data-toggle="dropdown">
            {{ auth()->user()->name }} | {{ auth()->user()->role }}<i class="fa fa-angle-down"></i>
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
