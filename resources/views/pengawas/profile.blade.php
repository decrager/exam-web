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
                                @if (session()->has('success'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                <h4 class="header-title">Profil</h4>
                                <p class="text-muted font-14 mb-4">
                                    {{-- Masukkan password yang lama sebelum password yang baru --}}
                                </p>

                                <form action="{{ route('pengawas.profile.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    @foreach ($errors->all() as $error)
                                        <p class="text-danger">{{ $error }}</p>
                                    @endforeach

                                    <div class="form-group">
                                        <label for="oldPass" class="col-form-label">Nama Pengawas<i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <input class="form-control" type="text" name="nama" value="{{ $profil->name }}" required/>
                                    </div>

                                    <div class="form-group">
                                        <label for="newPass" class="col-form-label">NIK Pengawas<i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <input class="form-control" type="text" name="nik" value="{{ $profil->Pengawas->nik }}" required/>
                                    </div>

                                    <div class="form-group">
                                        <label for="newPass" class="col-form-label">Email/Username <b>(Yang digunakan untuk Login)</b><i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <input class="form-control" type="text" name="email" value="{{ $profil->email }}" required/>
                                    </div>

                                    <div class="form-group">
                                        <label for="newPass" class="col-form-label">Status Kepegawaian <i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <select class="custom-select" name="pns" required>
                                            <option value="">Pilih Status Kepegawaian</option>
                                            <option value="PNS" {{ $profil->Pengawas->pns == 'PNS' ? 'selected' : '' }}>PNS</option>
                                            <option value="Non PNS" {{ $profil->Pengawas->pns == 'Non PNS' ? 'selected' : '' }}>Non PNS</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="newPass" class="col-form-label">Bank <i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <select class="custom-select" name="bank" required>
                                            <option value="">Pilih Bank</option>
                                            <option value="BNI" {{ $profil->Pengawas->bank == 'BNI' ? 'selected' : '' }}>BNI</option>
                                            <option value="BRI" {{ $profil->Pengawas->bank == 'BRI' ? 'selected' : '' }}>BRI</option>
                                            <option value="Mandiri" {{ $profil->Pengawas->bank == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="newPass" class="col-form-label">Nomor Rekening <i class="fas fa-star-of-life fa-2xs" style="color: red"></i></label>
                                        <input class="form-control" type="text" name="norek" value="{{ $profil->Pengawas->norek }}" required/>
                                    </div>

                                    <div class="form-group">
                                        <label for="newPass" class="col-form-label">Nomor Telepon</label>
                                        <input class="form-control" type="text" name="tlp" value="{{ $profil->Pengawas->tlp }}" required/>
                                    </div>

                                    <input type="text" name="user_id" value="{{ $profil->id }}" hidden>
                                    <input type="text" name="pengawas_id" value="{{ $profil->Pengawas->id }}" hidden>
                                    <button type="submit" class="btn btn-primary" onclick="return confirm('Yakin data yang diubah sudah benar?')">Ubah & Simpan</button>
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
