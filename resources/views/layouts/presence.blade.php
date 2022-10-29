<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF | ABSEN</title>
    
    <style type="text/css">
        @font-face {
            font-family: 'Arial';
            src: url({{ asset('fonts/Arial.ttf') }});
        }

        .garis_tepi1 {
             border: 2px solid black;
        }
        
        body {
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>
<table border="0" align="center">
    <tr>
    <td><img src="{{ public_path('images/icon/IPB.png') }}" width="80px"> </td>
    <td><center>
        <font size="3">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET DAN TEKNOLOGI</font><BR>
        <font size="3">INSTITUT PERTANIAN BOGOR</font><BR>
        <font size="3"><b>SEKOLAH VOKASI</b></font><BR>
        <font size="2">Kampus IPB Cilibende, Jl. Kumbang No.14 Bogor 16151</font><BR>
        <font size="2">Telp. /Fax. (0251) 83480007/8376845</font></center>
    </td>
    </tr>
    <tr>
        <td colspan="3"><b><hr color='black'></b></td>
    </tr>

</table>
<br>
<table align="center">
    <tr>
        <td><center>
            <font size="3">DAFTAR HADIR</font><br>
            <font size="3">PENGAWAS UJIAN @if ($master->isuas == 1)
                AKHIR
            @else
            TENGAH
            @endif SEMESTER @if ($master->smt_akademik == 1)
                GANJIL
            @else
                GENAP
            @endif TA {{ $master->thn_ajaran }}</font>
            </center>
        </td>
    </tr>
    <tr style="text-indent: 150px;">
        <td>
            <font size="3">Tanggal/Bulan/Tahun : {{ $tbt }}</font><br>
        </td>
    </tr>
    <tr style="text-indent: 155px;">
        <td><font size="3">Pukul &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: {{ $time }}</font><br></td>
    </tr>
</table>
<body>
    <table class="" cellspacing="0" border="1" align="center">
        <tr>
            <td align="center" width="10px">No</td>
            <td align="center" width="150px">Nama</td>
            <td align="center" width="10px">PNS (GOL)</td>
            <td align="center">NON PNS</td>
            <td align="center" >Program Studi</td>
            <td align="center" width="150px">Mata Kuliah</td>
            <td align="center" width="20px">Ruang</td>
            <td align="center">Tanda Tangan</td>
        </tr>
        @foreach ($pengawas as $pengawas)
        <tr>
            <td align="center" width="10px">{{ $loop->iteration }}</td>
            <td align="center" width="150px">{{ $pengawas->nama }}</td>
            @if ($pengawas->pns == 'PNS')
            <td align="center" width="10px"><div style="font-family: DejaVu Sans, sans-serif;">✔</div></td>
            <td align="center">-</td>
            @else
            <td align="center" width="10px">-</td>
            <td align="center"><div style="font-family: DejaVu Sans, sans-serif;">✔</div></td>
            @endif
            <td align="center">{{ $pengawas->nama_prodi }}</td>
            <td align="center" width="150px">{{ $pengawas->nama_matkul }}</td>
            <td align="center" width="20px">{{ $pengawas->ruang }}</td>
            <td align="center"><img src="{{ public_path('storage/images/ttd/' . $pengawas->presensi) }}" alt="Hadir" width="50px"></td>
        </tr>
        @endforeach
    </table>
    <br>
    <table align="right">
        <tr>
            <td>Bogor, {{ $tglbln }}</td>
        </tr>
        <tr>
            <td>PJ Lokasi {{ $lokasi }}</td> 
        </tr>
        <tr>
            <img src="{{ public_path('storage/images/ttd/' . $ttd) }}" alt="TTD">
        </tr>
        <tr>
            <td>({{ $nama }})</td> 
        </tr> 
    </table>
</body>
</html>