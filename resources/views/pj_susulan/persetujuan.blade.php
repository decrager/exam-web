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
    <div class="page-title-area mb-3">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="breadcrumbs-area clearfix">
                    <h4 class="page-title pull-left">Detail Mahasiswa yang Mengajukan</h4>
                    <ul class="breadcrumbs pull-left">
                        <li><a >Beranda</a></li>
                        <li><a >Mahasiswa</a></li>
                        <li><span>Detail</span></li>
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
                                <h4 class="header-title">Detail Mahasiswa</h4>

                                <div class="form-group">
                                    <label for="prodi" class="col-form-label">Program Studi</label>
                                    <input class="form-control" id="prodi" value="{{ $mahasiswa?->Matkul?->Semester?->Prodi?->nama_prodi }}" readonly/>
                                </div>

                                <div class="form-group">
                                    <label for="semester" class="col-form-label">Program Studi</label>
                                    <input class="form-control" id="semester" value="{{ $mahasiswa?->Matkul?->Semester?->semester }}" readonly/>
                                </div>

                                <div class="form-group">
                                    <label for="mahasiswa" class="col-form-label">Nama Mahasiswa</label>
                                    <input class="form-control" id="mahasiswa" value="{{ $mahasiswa?->Mahasiswa?->nama }}" readonly/>
                                </div>

                                <div class="form-group">
                                    <label for="nim" class="col-form-label">NIM</label>
                                    <input class="form-control" id="nim" value="{{ $mahasiswa?->Mahasiswa?->nim }}" readonly/>
                                </div>

                                <div class="form-group">
                                    <label for="prak" class="col-form-label">Kelas - Praktikum</label>
                                    <input class="form-control" id="prak" value="{{ $mahasiswa?->Mahasiswa?->Praktikum?->Kelas?->kelas }} - {{ $mahasiswa?->Mahasiswa?->Praktikum?->praktikum }}" readonly/>
                                </div>

                                <div class="form-group">
                                    <label for="matkul" class="col-form-label">Mata Kuliah</label>
                                    <input class="form-control" id="matkul" value="{{ $mahasiswa?->Matkul?->nama_matkul }}" readonly/>
                                </div>

                                <div class="form-group">
                                    <label for="matkul" class="col-form-label">Tipe Mata Kuliah</label>
                                    <input class="form-control" id="matkul" value="@if ($mahasiswa?->tipe_mk == 'K') Kuliah @elseif ($mahasiswa?->tipe_mk == 'P') Praktikum @else Responsi @endif" readonly/>
                                </div>

                                <div class="form-group">
                                    <label for="matkul" class="col-form-label">Alasan</label>
                                    <input class="form-control" id="matkul" value="@if ($mahasiswa?->alasan) {{ $mahasiswa?->alasan }} @else - @endif" readonly/>
                                </div>

                                <div class="form-group">
                                    <label for="matkul" class="col-form-label">Status</label>
                                    @if ($mahasiswa?->status == 'Belum')
                                        <h5><span class="badge bg-warning">Belum disetujui</span></h5>
                                    @elseif ($mahasiswa?->status == 'Ditolak')
                                        <h5><span class="badge bg-danger">Ditolak</span></h5>
                                    @elseif ($mahasiswa?->status == 'Disetujui')
                                        <h5><span class="badge bg-success">Disetujui</span></h5>
                                    @elseif ($mahasiswa?->status == 'Pending')
                                        <h5><span class="badge bg-secondary">Pending</span></h5>
                                    @else
                                        <h5><span class="badge bg-green">Terjadwal</span></h5>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <label for="bukti" class="col-form-label">Bukti Persetujuan</label>
                                    </div>
                                    <div class="row-cols-8">
                                        <a href="{{ asset('storage/files/syarat/'. $mahasiswa?->file) }}" target="_blank" id="bukti" class="btn btn-success mt-1"> <i class="fas fa-eye"></i>&ensp; Lihat</a>
                                    </div>
                                </div>

                                <div>
                                    @if ($mahasiswa?->status == 'Belum')
                                        <form  class="form-group" action="{{ route('pjSusulan.mahasiswa.update', $mahasiswa?->id) }}" method="POST">
                                            <div class="form-group">
                                                <label class="" for="">Tanda Tangan:</label>
                                                <br />
                                                <div id="sign"> </div>
                                                <br />
                                                <button id="clear" class="btn btn-danger btn-sm">Clear Signature</button>
                                                <textarea id="signature" name="ttd" style="display: none"></textarea>
                                            </div>

                                            @csrf
                                            @method('PUT')
                                            <div class="row">
                                                <label for="bukti" class="col-form-label">Persetujuan</label>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="catatan" placeholder="Catatan (Opsional)" name="catatan"/>
                                            </div>
                                            <div class="row-cols-">
                                                <button type="submit" class="btn btn-success" name="status" value="Disetujui" onclick="return confirm('Yakin ingin menyetujui pengajuan?')"><i class="fas fa-check" ></i>&ensp; Setujui</button>
                                                <button type="submit" class="btn btn-secondary btn-sm align-top" name="status" value="Pending" onclick="return confirm('Yakin ingin menunda pengajuan?')"><i class="fas fa-clock" ></i>&ensp; Pending</button>
                                                <button type="submit" class="btn btn-danger" name="status" value="Ditolak" onclick="return confirm('Yakin ingin menolak pengajuan?')"><i class="fas fa-xmark" ></i>&ensp; Tolak</button>
                                            </div>
                                        </form>
                                    @elseif ($mahasiswa?->status == 'Disetujui')
                                        <form  class="form-group" action="{{ route('pjSusulan.mahasiswa.update', $mahasiswa?->id) }}" method="POST">
                                            <div class="form-group">
                                                <label class="" for="">Tanda Tangan:</label>
                                                <br />
                                                <div id="sign"> </div>
                                                <br />
                                                <button id="clear" class="btn btn-danger btn-sm">Clear Signature</button>
                                                <textarea id="signature" name="ttd" style="display: none"></textarea>
                                            </div>

                                            @csrf
                                            @method('PUT')
                                            <div class="row">
                                                <label for="bukti" class="col-form-label">Persetujuan</label>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="catatan" placeholder="Catatan (Opsional)" name="catatan"/>
                                            </div>
                                            <div class="row-cols-">
                                                <button type="submit" class="btn btn-secondary btn-sm align-top" name="status" value="Pending" onclick="return confirm('Yakin ingin menunda pengajuan?')"><i class="fas fa-clock" ></i>&ensp; Pending</button>
                                                <button type="submit" class="btn btn-danger" name="status" value="Ditolak" onclick="return confirm('Yakin ingin menolak pengajuan?')"><i class="fas fa-xmark" ></i>&ensp; Tolak</button>
                                            </div>
                                        </form>
                                    @elseif ($mahasiswa?->status == 'Pending')
                                        <form  class="form-group" action="{{ route('pjSusulan.mahasiswa.update', $mahasiswa?->id) }}" method="POST">
                                            <div class="form-group">
                                                <label class="" for="">Tanda Tangan:</label>
                                                <br />
                                                <div id="sign"> </div>
                                                <br />
                                                <button id="clear" class="btn btn-danger btn-sm">Clear Signature</button>
                                                <textarea id="signature" name="ttd" style="display: none"></textarea>
                                            </div>

                                            @csrf
                                            @method('PUT')
                                            <div class="row">
                                                <label for="bukti" class="col-form-label">Persetujuan</label>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="catatan" placeholder="Catatan (Opsional)" name="catatan"/>
                                            </div>
                                            <div class="row-cols-">
                                                <button type="submit" class="btn btn-success" name="status" value="Disetujui" onclick="return confirm('Yakin ingin menyetujui pengajuan?')"><i class="fas fa-check" ></i>&ensp; Setujui</button>
                                                <button type="submit" class="btn btn-danger" name="status" value="Ditolak" onclick="return confirm('Yakin ingin menolak pengajuan?')"><i class="fas fa-xmark" ></i>&ensp; Tolak</button>
                                            </div>
                                        </form>
                                    @elseif ($mahasiswa?->status == 'Ditolak')
                                        <form class="form-group" action="{{ route('pjSusulan.mahasiswa.update', $mahasiswa?->id) }}" method="POST">
                                            <div class="form-group">
                                                <label class="" for="">Tanda Tangan:</label>
                                                <br />
                                                <div id="sign"> </div>
                                                <br />
                                                <button id="clear" class="btn btn-danger btn-sm">Clear Signature</button>
                                                <textarea id="signature" name="ttd" style="display: none"></textarea>
                                            </div>

                                            @csrf
                                            @method('PUT')
                                            <div class="row">
                                                <label for="bukti" class="col-form-label">Persetujuan</label>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="catatan" placeholder="Catatan (Opsional)" name="catatan"/>
                                            </div>
                                            <div class="row-cols-">
                                                <button type="submit" class="btn btn-success" name="status" value="Disetujui" onclick="return confirm('Yakin ingin menyetujui pengajuan?')"><i class="fas fa-check" ></i>&ensp; Setujui</button>
                                                <button type="submit" class="btn btn-secondary btn-sm align-top" name="status" value="Pending" onclick="return confirm('Yakin ingin menunda pengajuan?')"><i class="fas fa-clock" ></i>&ensp; Pending</button>
                                            </div>
                                        </form>
                                    @else
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Textual inputs end -->
                </div>
            </div>
        </div>
    </div>

    <script>
        var sign = $('#sign').signature({
            syncField: '#signature',
            syncFormat: 'PNG'
        });
        $('#clear').click(function(e) {
            e.preventDefault();
            sign.signature('clear');
            $("#signature").val('');
        });
    </script>
@endsection
