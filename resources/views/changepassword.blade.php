@extends('layouts.app')

@section('main-content')
    <!-- header area start -->
    <div class="header-area">
        <div class="row align-items-center">
            <!-- nav and search button -->
            <div class="col-md-6 col-sm-8 clearfix">
                <div class="nav-btn pull-left">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
            <!-- profile info & task notification -->
            @include('layouts.profile')
        </div>
    </div>
    <!-- header area end -->

    <!-- page title area start -->
    {{-- <div class="page-title-area mb-5">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Change Password</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="index.html">Home</a></li>
                    <li><span>Change Password</span></li>
                </ul>
            </div>
        </div>
    </div>
</div> --}}
    <!-- page title area end -->
    <div class="main-content-inner">
        <div class="row">
            <div class="col-lg-12 col-ml-12">
                <div class="row">
                    <!-- Textual inputs start -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Ubah Password</h4>
                                <p class="text-muted font-14 mb-4">
                                    {{-- Masukkan password yang lama sebelum password yang baru --}}
                                </p>

                                <form action="{{ route('resetPassword') }}" method="POST">
                                    @csrf
                                    @foreach ($errors->all() as $error)
                                        <p class="text-danger">{{ $error }}</p>
                                    @endforeach

                                    <div class="form-group">
                                        <label for="oldPass" class="col-form-label">Password Lama <i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <input class="form-control" type="password" id="oldPass" name="oldPass" required/>
                                    </div>

                                    <div class="form-group">
                                        <label for="newPass" class="col-form-label">Password Baru <i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <input class="form-control" type="password" id="newPass" name="newPass" required/>
                                    </div>

                                    <div class="form-group">
                                        <label for="confNewPass" class="col-form-label">Konfirmasi Password
                                            Baru <i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <input class="form-control" type="password" id="confNewPass" name="confNewPass" required/>
                                    </div>

                                    <button type="submit" class="btn btn-primary text-sm bg-blue px-3 mb-3">Ubah</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Textual inputs end -->
                </div>
            </div>
        </div>
    </div>
@endsection
