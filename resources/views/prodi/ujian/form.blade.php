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
<div class="page-title-area mb-5">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Tambah Jadwal Ujian</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="">Beranda</a></li>
                    <li><a href=""><span>Jadwal Ujian</span></a></li>
                    <li><span>Tambah Jadwal Ujian</span></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- page title area end -->
<div class="main-content-inner">
    <div class="row">
        <div class="col-lg-12 col-ml-12">
            <div class="row">
                <!-- Textual inputs start -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Textual inputs</h4>
                            <p class="text-muted font-14 mb-4">
                                Lorem ipsum dolor sit amet.
                            </p>
                            <div class="form-group">
                                <label for="example-text-input" class="col-form-label"
                                    >Text</label
                                >
                                <input
                                    class="form-control"
                                    type="text"
                                    value="Value"
                                    id="example-text-input"
                                />
                            </div>
                            <div class="form-group">
                                <label for="example-email-input" class="col-form-label"
                                    >Email</label
                                >
                                <input
                                    class="form-control"
                                    type="email"
                                    value="name@example.com"
                                    id="example-email-input"
                                />
                            </div>
                            <div class="form-group">
                                <label for="example-tel-input" class="col-form-label"
                                    >Telephone</label
                                >
                                <input
                                    class="form-control"
                                    type="tel"
                                    value="+880-1233456789"
                                    id="example-tel-input"
                                />
                            </div>
                            <div class="form-group">
                                <label
                                    for="example-datetime-local-input"
                                    class="col-form-label"
                                    >Date and time</label
                                >
                                <input
                                    class="form-control"
                                    type="datetime-local"
                                    value="2018-07-19T15:30:00"
                                    id="example-datetime-local-input"
                                />
                            </div>
                            <div class="form-group">
                                <label for="example-date-input" class="col-form-label"
                                    >Date</label
                                >
                                <input
                                    class="form-control"
                                    type="date"
                                    value="2018-03-05"
                                    id="example-date-input"
                                />
                            </div>
                            <div class="form-group">
                                <label for="example-month-input" class="col-form-label"
                                    >Month</label
                                >
                                <input
                                    class="form-control"
                                    type="month"
                                    value="2018-05"
                                    id="example-month-input"
                                />
                            </div>
                            <div class="form-group">
                                <label for="example-time-input" class="col-form-label"
                                    >Time</label
                                >
                                <input
                                    class="form-control"
                                    type="time"
                                    value="13:45:00"
                                    id="example-time-input"
                                />
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Select</label>
                                <select class="form-control">
                                    <option>Select</option>
                                    <option>Large select</option>
                                    <option>Small select</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Custom Select</label>
                                <select class="custom-select">
                                    <option selected="selected">
                                        Open this select menu
                                    </option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Textual inputs end -->
            </div>
        </div>
        <!-- Custom file input start -->
        <div class="col-12">
            <div class="card mt-5">
                <div class="card-body">
                    <h4 class="header-title">Custom file input</h4>
                    <form action="#">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Upload</span>
                            </div>
                            <div class="custom-file">
                                <input
                                    type="file"
                                    class="custom-file-input"
                                    id="inputGroupFile01"
                                />
                                <label class="custom-file-label" for="inputGroupFile01"
                                    >Choose file</label
                                >
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <div class="custom-file">
                                <input
                                    type="file"
                                    class="custom-file-input"
                                    id="inputGroupFile02"
                                />
                                <label class="custom-file-label" for="inputGroupFile02"
                                    >Choose file</label
                                >
                            </div>
                            <div class="input-group-append">
                                <span class="input-group-text">Upload</span>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary" type="button">
                                    Button
                                </button>
                            </div>
                            <div class="custom-file">
                                <input
                                    type="file"
                                    class="custom-file-input"
                                    id="inputGroupFile03"
                                />
                                <label class="custom-file-label" for="inputGroupFile03"
                                    >Choose file</label
                                >
                            </div>
                        </div>
                        <div class="input-group">
                            <div class="custom-file">
                                <input
                                    type="file"
                                    class="custom-file-input"
                                    id="inputGroupFile04"
                                />
                                <label class="custom-file-label" for="inputGroupFile04"
                                    >Choose file</label
                                >
                            </div>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button">
                                    Button
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Custom file input end -->
    </div>
</div>
@endsection