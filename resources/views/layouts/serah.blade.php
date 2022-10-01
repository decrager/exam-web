<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF | SERAH TERIMA</title>
    <style type="text/css">
        .garis_tepi1 {
             border: 2px solid black;
        }
        body { 
            font-family: Arial; 
        }
       
    </style>
</head>
<table border="0" align="right">
    <tr>
        <td style="text-indent:-50px;"><font size="2">FRM/SV/UJN/002</font></td>
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
        <td><center><b>
            <font size="3">BUKTI TANDA TERIMA BERKAS UJIAN</font></b><br>        
            </center>
        </td>
    </tr>
</table>
<br>
<body>
    <table align="left">
        <tr style="text-indent: 60px;">
            <td width="500px">
                <font size="3">Sudah diterima berkas ujian @if ($master->isuas == 1) <s>UTS</s>/UAS @else UTS/<s>UAS</s> @endif T.A. {{ $master->thn_ajaran }} :</font>
            </td>
        </tr>
    </table>
    <table>
        <tr style="text-indent: 100px;">
            <td width="320px"><font size="3">Hari &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp;  &nbsp; : {{ $hari }}</font></td>
            <td width="180px" style="text-indent: 10px;"><font size="3">Jam  &nbsp; &nbsp; &nbsp;: {{ $jam }}</font></td>
            <td width="200px" style="text-indent: 10px;">
                <font size="3">
                    @if ($master->smt_akademik == 1)
                        Semester : [1/3/5]
                    @else
                        @if ($semester == 2)
                            Semester : [2/<s>4</s>/<s>6</s>]
                        @elseif ($semester == 4)
                            Semester : [<s>2</s>/4/<s>6</s>]
                        @else
                            Semester : [<s>2</s>/<s>4</s>/6]
                        @endif
                    @endif
                </font>
            </td>
        </tr>
        <tr style="text-indent: 100px;">
            <td colspan="3"><font size="3">Tgl/Bln/Thn &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : {{ date('d/m/Y', strtotime($tanggal)) }}</font> </td>
        </tr>
        <tr style="text-indent: 100px;">
            <td colspan="2"><font size="3">Program Studi &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : {{ $nama_prodi }}</font> </td>
            <td width="200px" style="text-indent: 10px;">
                <font size="3">
                Kelas &nbsp; &nbsp; :
                <?php $hasil = 0; $true = 0;?>
                @for ($i = 0; $i < count($listKelas); $i++)
                    @for ($j = 0; $j < count($kelas); $j++)
                        @if ($listKelas[$i]->kelas == $kelas[$j]->kelas)
                            [{{ $listKelas[$i]->kelas }}]
                            <?php $true = $listKelas[$i]->kelas ?>
                        @else
                            <?php $hasil = $kelas[$j]->kelas?>
                        @endif
                    @endfor
                    @if ($listKelas[$i]->kelas != $hasil)
                        @if ($true != $listKelas[$i]->kelas)
                            [<s>{{ $listKelas[$i]->kelas }}</s>]
                        @endif
                    @endif
                @endfor
                </font>
            </td>
        </tr>
        <tr style="text-indent: 100px;">
            <td colspan="3"><font size="3">Mata kuliah &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : {{ $matkul }}</font> </td>
        </tr>
        <tr style="text-indent: 100px;">
            <td colspan="3"><font size="3">Jumlah Berkas Ujian &nbsp; &nbsp; &nbsp; : {{ $jml_berkas }}</font> </td>
        </tr>
        <br>
    </table>
    <br>
    <br>
    <br>
    <br>
    
    <table align="right">
        <tr style="text-indent: -50px;"> 
            <td>Bogor, {{ $tglbln }}</td>
        </tr>
    </table>
    <table align="left" >
        <tr style="text-indent: 120px;"> 
            <td width="350px">Yang Menyerahkan, </td>
            <td width="330px" style="text-indent: 160px;">Yang Menerima, </td>
        </tr>
    </table>
    <table align="left" >
        <tr style="text-indent: 120px;"> 
            <td width="350px" style="text-indent: 120px;"><img src="{{ public_path('storage/images/ttd/' . $ttd_penyerah) }}" alt="TTD Penyerah"></td>
            <td width="330px" style="text-indent: 160px;"><img src="{{ public_path('storage/images/ttd/' . $ttd_penerima) }}" alt="TTD Penerima"></td>
        </tr>
    </table>
    <table align="left">
        <tr style="text-indent: 110px;">
            <td width="330px" align="center" style="text-indent: -10px;">({{ $nama_serah }})</td> 
            <td width="330px" align="center" style="text-indent: 160px;">({{ $nama_terima }})</td> 
        </tr> 
    </table>
</body>
<br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

<footer>
    <table align="center" border="1" cellspacing="0">
        <tr>
            <td width="300px" style="text-indent: 100px;">No. Revisi : 00</td>
            <td width="80px" style="text-indent: 15px;">Hal: 1/1</td>
            <td width="300px" style="text-indent: 40px;">Tanggal Berlaku : 9 Oktober 2020</td>
        </tr>
    </table>
</footer>
</html>