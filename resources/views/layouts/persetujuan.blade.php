<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keterangan Pelaksanaan Ujian Susulan</title>
    <style>
        .garis_tepi1 {
                border: 2px solid black;
        }
        
        @font-face {
            font-family: 'Arial';
            src: url('{{ asset('fonts/Arial.ttf') }}');
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>

<body>
    <center><h4 style="margin-top: 50px;">SURAT PELAKSANAAN UJIAN SUSULAN</h4></center>
    <br>
    <p>Dengan ini mahasiswa atas nama:</p>
    <br>
    <table border="0">
        <tr>
            <td width="120px">Nama</td>
            <td>:</td>
            <td>{{ $susulan->Mahasiswa->nama }}</td>
        </tr>
        <tr>
            <td width="120px">NIM</td>
            <td>:</td>
            <td>{{ $susulan->Mahasiswa->nim }}</td>
        </tr>
        <tr>
            <td width="120px">Program Studi</td>
            <td>:</td>
            <td>{{ $susulan->Mahasiswa->Praktikum->Kelas->Semester->Prodi->nama_prodi }}</td>
        </tr>
    </table>
    <br>
    <br>
    <p style="text-justify: auto;">Bahwa mahasiswa tersebut sudah memenuhi persyaratan untuk mengikuti ujian susulan. Oleh karena itu, kepada Bapak/ibu Koordinator Mata Kuliah berkenan untuk dapat memberikan pelaksanaan ujian susulan pada Mata kuliah sebagai berikut:
    </p>
    <br>
    <table align="center" border="1" cellspacing="0">
            <tr align="center">
                <td width="50px"><b>No</b></td>
                <td width="100px"><b>Kode MK</b></td>
                <td width="450px"><b>Mata Kuliah</b></td>
            </tr>
            <tr>
                <td width="50px">&nbsp;1</td>
                <td width="100px">&nbsp;{{ $susulan->Matkul->kode_matkul }}</td>
                <td width="450px">&nbsp;{{ $susulan->Matkul->nama_matkul }}</td> 
            </tr>
    </table>
    <br>
    <p>Demikian surat ini dibuat, Atas perhatian dan kerjasamanya, diucapkan terima kasih.</p>
    <br>
    <br>
    <table border="0">
        <tr style="text-indent: 505px;"> 
            <td width="700px">Bogor, {{ $tglbln }}</td>
        </tr>
    </table>
    <table border="0" align="left" >
        <tr> 
            <td width="150px">Yang Bersangkutan, </td>
            <td width="50px">Mengetahui, </td>
            <td width="50px">Menyetujui,</td>
        </tr>
        <tr> 
            <td width="250px"> </td>
            <td width="250px">PJ Susulan </td>
            <td width="180px">Dosen MK </td>
        </tr>
    </table>
    <table border="0">
        <tr style="text-indent: 255px;"> 
            <td width="700px"><img src="{{ public_path('storage/images/ttd/' . $ttd) }}" alt=""></td>
        </tr>
    </table>
    <table border="0" align="left">
        <tr>
            <td width="250px">({{ $susulan->Mahasiswa->nama }})</td> 
            <td width="250px">({{ $pj }})</td> 
            <td width="180px">(........................................)</td> 
        </tr> 
    </table>
</body>
</html>