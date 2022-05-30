<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF | ABSEN</title>
    <style>
        .garis_tepi1 {
             border: 2px solid black;
        }
        html,body{
        height:297mm;
        width:210mm;
        }
    </style>
</head>
<table border="0" align="center">
    <tr>
    <td><img src="{{ asset('images/icon/IPB.png') }}"> </td>
    <td><center>
        <font size="3">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET DAN TEKNOLOGI</font><BR>
        <font size="3">INSTITUT PERTANIAN BOGOR</font><BR>
        <font size="3"><b>SEKOLAH VOKASI</b></font><BR>
        <font size="1">Kampus IPB Cilibende, Jl. Kumbang No.14 Bogor 16151</font><BR>
        <font size="1">Telp. /Fax. (0251) 83480007/8376845</font></center>
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
            <font size="3">PENGAWAS UJIAN {{ $lokasi }} SEMESTER @if ($master->smt_akademik == 1)
                Ganjil
            @else
                Genap
            @endif TA 20 {{ $master->thn_ajaran }}</font>
            </center>
        </td>
    </tr>
    <tr style="text-indent: 150px;">
        <td>
            <font size="3">Tanggal/Bulan/Tahun : {{ $tbt }}</font><br>
        </td>
    </tr>
    <tr style="text-indent: 150px;">
        <td><font size="3">Pukul &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;: {{ $time }}</font><br></td>
    </tr>
</table>
<body>
    {{-- <button><a href="">pdf absen</a></button>
    <button><a href="">pdf serah terima</a></button> --}}
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
            <td align="center" width="10px">&check;</td>
            <td align="center">-</td>
            @else
            <td align="center" width="10px">-</td>
            <td align="center">&check;</td>
            @endif
            <td align="center">{{ $pengawas->nama_prodi }}</td>
            <td align="center" width="150px">{{ $pengawas->nama_matkul }}</td>
            <td align="center" width="20px">{{ $pengawas->ruang }}</td>
            <td align="center">&check;</td>
        </tr>
        @endforeach
    </table>
    <br>
    <table align="center">
        <tr style="text-indent: 400px;">
            <td>Bogor, {{ $tglbln }}</td>
        </tr>
        <tr style="text-indent: 400px;">
            <td>PJ Lokasi {{ $nama }}</td> 
        </tr>

    </table>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <table align="center">
        <tr style="text-indent: 400px;">
            <td>({{ $nama }})</td> 
        </tr> 
    </table>
</body>
</html>