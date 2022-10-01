<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF | ABSEN</title>
    
    <style type="text/css">
        /* @font-face {
            font-family: Arial;
            src: url({{ public_path('fonts/Arial.ttf') }});
        } */

        .garis_tepi1 {
             border: 2px solid black;
        }
        
        /* body {
            font-family: Arial !important;
        } */
    </style>
</head>
<table border="0" align="right">
    <tr>
        <td style="text-indent: 0px;"><font size="2">FRM/DPD/UJN/001</font></td>
    </tr>
</table>

<table border="0" align="center">
    <tr>
    <td><img src="{{ public_path('images/icon/IPB.png') }}" width="80px"> </td>
    <td style="font-family: Arial;"><center>
        <font size="3">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET DAN TEKNOLOGI</font><BR>
        <font size="3">INSTITUT PERTANIAN BOGOR</font><BR>
        <font size="3"><b>SEKOLAH VOKASI</b></font><BR>
        <font size="2">Kampus IPB Cilibende, Jl. Kumbang No.14 Bogor 16151</font><BR>
        <font size="2">Telp. /Fax. (0251) 83480007/8376845</font></center>
    </td>
    </tr>
    <tr>
        <td colspan="4"><b><hr color='black'></b></td>
    </tr>

</table>
<table align="center">
    <tr>
        <td><center>
            <font size="3"><b>SEMESTER {{ $ujian->Matkul->Semester->semester }} TAHUN AKADEMIK {{ $master->thn_ajaran }}</b></font><br>
            </center>
        </td>
    </tr>
</table>

<table style="border: 1px solid black; width: 640px" align="center">
    {{-- <tr>
        <td colspan="4"><b><hr color='black'></b></td>
    </tr> --}}
    <tr>
        <td>
            <center>
                <font size="3"><b>DAFTAR HADIR UJIAN @if ($master->isuas == 1)
                    AKHIR
                @else
                TENGAH
                @endif SEMESTER @if ($master->smt_akademik == 1)
                    GANJIL
                @else
                    GENAP
                @endif</font></b><br>
                <font size="3"><b>PROGRAM STUDI : {{ $ujian->Matkul->Semester->Prodi->nama_prodi }}</font></b><br>
                <font size="3"><b>Kelas : {{ $ujian->Praktikum->Kelas->kelas }} / Kelompok : {{ $ujian->Praktikum->praktikum }}</font></b><br>
                <font size="3"><b>Mata Kuliah : {{ $ujian->Matkul->nama_matkul }}</font></b><br>
            </center>
        </td>
    </tr>
    {{-- <tr>
        <td colspan="4"><b><hr color='black'></b></td>
    </tr> --}}
</table>

<table align="center">
    <tr>
        <td colspan="5"><font size="3"></font><center><b>Tanggal</b></center></td>
    </tr>
    <tr>
        <td><font size="3"><b>Waktu Ujian</b></font></td>
        <td><font size="3" width=""><b>: {{ $ujian->hari }}</b></font></td>
        <td><font size="3"><center><b>{{ $ujian->tanggal }}</b></center></font></td>
        <td align="right" width="100px"><font size="3"><b>Jam</b></font></td>
        <td><font size="3" width="100px"><b>: {{ $ujian->jam_mulai }} - {{ $ujian->jam_selesai }}</b></font></td>
    </tr>
    <tr>
        <td><font size="3"><b>Koordinator</b></font></td>
        <td><font size="3"><b>: </b></font></td>
        <td width="250px"><font size="3"><b></b></font></td>
        <td align="right" width="100px"><font size="3"><b>Ruang</b></font></td>
        <td><font size="3" width="100px"><b>: {{ $ujian->ruang }}</b></font></td>
    </tr>
    <tr>
        <td><font size="3"><b>Pengawas</b></font></td>
        <td colspan="2"><font size="3"><b>: 1. {{ $pengawas1 }}</b></font></td>
        <td colspan="2" align="right"><font size="3"><b>
            @if ($pengawas2)
                2. {{ $pengawas2 }}
            @elseif ($pengawas2 == "0")
                2. _______________
            @endif
        </b></font></td>
    </tr>
</table>

<body>
    <table class="" cellspacing="0" align="center" style="margin-bottom: 10px; margin-top: 10px">
        <tr style="border-top: 2px solid black; border-bottom: 2px solid black">
            <td align="center" width="30px"><b>No</b></td>
            <td width="300px"><b>Nama Mahasiswa</b></td>
            <td width="150px"><b>NIM</b></td>
            <td width="150px"><b>Kehadiran</b></td>
        </tr>
        @foreach ($mahasiswas as $mahasiswa)
            <tr>
                <td align="center" width="10px">{{ $loop->iteration }}</td>
                <td width="300px">{{ $mahasiswa->nama }}</td>
                <td width="150px">{{ $mahasiswa->nim }}</td>
                <td width="150px">
                    @if ($mahasiswa->kehadiran == "Hadir")
                        Hadir
                    @else
                        Tidak Hadir
                    @endif
                </td>
            </tr>
        @endforeach
        <tr style="border-top: 2px solid black">
            <td colspan="4"></td>
        </tr>
    </table>

    <table align="center">
        <tr>
            <td colspan="3" align="center" width="650px">Tanda Tangan Pengawas</td>
        </tr>
        <tr>
            <td align="center"><img src="{{ asset('images/ttd/' . $ttd1) }}" alt="TTD"></td>
            <td></td>
            @if ($ttd2 == "0")
                <td align="center"><img src="{{ asset('images/ttd/' . $ttd2) }}" alt="TTD"></td>
            @else
                <td align="center"></td>
            @endif
        </tr>
        <tr>
            <td align="center">({{ $pengawas1 }})</td>
            <td></td>
            <td align="center">(
                @if ($pengawas2)
                    {{ $pengawas2 }}
                @elseif ($pengawas2 == "0")
                    _______________
                @endif
                )</td>
        </tr>
    </table>
</body>
</html>