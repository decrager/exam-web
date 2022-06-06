<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Bap;
use App\Models\Kelas;
use App\Models\Prodi;
use App\Models\Ujian;
use App\Models\Amplop;
use App\Models\Berkas;
use App\Models\Master;
use App\Models\Matkul;
use App\Models\Semester;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isEmpty;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Storage;

class berkasController extends Controller
{
    public function dashboard()
    {
        $now = Carbon::now()->toDateString();
        
        $ujian = Ujian::join('matkuls', 'ujians.matkul_id', '=', 'matkuls.id')
        ->join('semesters AS a', 'matkuls.semester_id', '=', 'a.id')
        ->join('praktikums', 'ujians.prak_id', '=', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', '=', 'kelas.id')
        ->join('semesters AS b', 'kelas.semester_id', '=', 'b.id')
        ->join('prodis', 'b.prodi_id', '=', 'prodis.id')
        ->join('amplops', 'amplops.ujian_id', '=', 'ujians.id')
        ->join('baps', 'baps.ujian_id', '=', 'ujians.id')
        ->join('berkas', 'berkas.ujian_id', '=', 'ujians.id');
        
        if (request(['dbProdi', 'dbSemester', 'dbPraktikum', 'dbKelas', 'dbMatkul', 'dbRuang'])) {
            $ujian->filter(request(['dbProdi', 'dbSemester', 'dbPraktikum', 'dbKelas', 'dbMatkul', 'dbRuang']));
        }

        if (request(['dbTanggal'])) {
            $ujian->filter(request(['dbTanggal']));
        } else {
            $ujian->where('ujians.tanggal', $now);
        }

        return view('berkas.dashboard', [
            "dbUjian" => $ujian->get()
        ]);
    }
    
    public function amplop()
    {
        $dataTanggalMulai = Master::first();
        $dataTanggalSelesai = Master::first();

        $from = $dataTanggalMulai->periode_mulai;
        $to = $dataTanggalSelesai->periode_akhir;

        $ujian = Ujian::join('matkuls', 'ujians.matkul_id', '=', 'matkuls.id')
        ->join('semesters AS a', 'matkuls.semester_id', '=', 'a.id')
        ->join('praktikums', 'ujians.prak_id', '=', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', '=', 'kelas.id')
        ->join('semesters AS b', 'kelas.semester_id', '=', 'b.id')
        ->join('prodis', 'b.prodi_id', '=', 'prodis.id')
        ->join('amplops', 'amplops.ujian_id', '=', 'ujians.id')
        ->join('baps', 'baps.ujian_id', '=', 'ujians.id')
        ->join('berkas', 'berkas.ujian_id', '=', 'ujians.id')
        ->whereBetween('ujians.tanggal', [$from, $to])
        ->filter(request(['dbProdi', 'dbSemester', 'dbPraktikum', 'dbKelas', 'dbMatkul', 'dbTanggal', 'dbRuang']));

        return view('berkas.amplop', [
            "amplop" => $ujian->get()
        ]);
    }

    public function amplopUpdate($id)
    {
        $amplop = Amplop::find($id);

        if ($amplop->pengambilan == 'Belum')
        {
            $amplop->update(['pengambilan' => 'Sudah']);
            $this->Activity(' memperbarui status Pengambilan pada Amplop menjadi Sudah diambil');
        } else {
            $amplop->update(['pengambilan' => 'Belum']);
            $this->Activity(' memperbarui status Pengambilan pada Amplop menjadi Belum diambil');
        }

        return redirect()->route('berkas.kelengkapan.amplop')->with('success', 'Status pengambilan Amplop berhasil diubah!');
    }

    public function bap()
    {
        $dataTanggalMulai = Master::first();
        $dataTanggalSelesai = Master::first();

        $from = $dataTanggalMulai->periode_mulai;
        $to = $dataTanggalSelesai->periode_akhir;

        $ujian = Ujian::join('matkuls', 'ujians.matkul_id', '=', 'matkuls.id')
        ->join('semesters AS a', 'matkuls.semester_id', '=', 'a.id')
        ->join('praktikums', 'ujians.prak_id', '=', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', '=', 'kelas.id')
        ->join('semesters AS b', 'kelas.semester_id', '=', 'b.id')
        ->join('prodis', 'b.prodi_id', '=', 'prodis.id')
        ->join('amplops', 'amplops.ujian_id', '=', 'ujians.id')
        ->join('baps', 'baps.ujian_id', '=', 'ujians.id')
        ->join('berkas', 'berkas.ujian_id', '=', 'ujians.id')
        ->whereBetween('ujians.tanggal', [$from, $to])
        ->filter(request(['dbProdi', 'dbSemester', 'dbPraktikum', 'dbKelas', 'dbMatkul', 'dbTanggal', 'dbRuang']));

        return view('berkas.bap', [
            "bap" => $ujian->get()
        ]);
    }

    public function bapUpdate($id)
    {
        $bap = Bap::find($id);

        if ($bap->pengambilan == 'Belum')
        {
            $bap->update(['pengambilan' => 'Sudah']);
            $this->Activity(' memperbarui status Pengambilan pada BAP menjadi Sudah diambil');
        } else {
            $bap->update(['pengambilan' => 'Belum']);
            $this->Activity(' memperbarui status Pengambilan pada BAP menjadi Belum diambil');
        }

        return redirect()->route('berkas.kelengkapan.bap')->with('success', 'Status pengambilan BAP berhasil diubah!');
    }

    public function berkas()
    {
        $dataTanggalMulai = Master::first();
        $dataTanggalSelesai = Master::first();

        $from = $dataTanggalMulai->periode_mulai;
        $to = $dataTanggalSelesai->periode_akhir;

        $ujian = Ujian::join('matkuls', 'ujians.matkul_id', '=', 'matkuls.id')
        ->join('semesters AS a', 'matkuls.semester_id', '=', 'a.id')
        ->join('praktikums', 'ujians.prak_id', '=', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', '=', 'kelas.id')
        ->join('semesters AS b', 'kelas.semester_id', '=', 'b.id')
        ->join('prodis', 'b.prodi_id', '=', 'prodis.id')
        ->join('amplops', 'amplops.ujian_id', '=', 'ujians.id')
        ->join('baps', 'baps.ujian_id', '=', 'ujians.id')
        ->join('berkas', 'berkas.ujian_id', '=', 'ujians.id')
        ->whereBetween('ujians.tanggal', [$from, $to])
        ->filter(request(['dbProdi', 'dbSemester', 'dbPraktikum', 'dbKelas', 'dbMatkul', 'dbTanggal', 'dbRuang']));

        return view('berkas.berkas', [
            "berkas" => $ujian->get()
        ]);
    }

    public function berkasFotokopi($id)
    {
        $berkas = Berkas::find($id);

        if ($berkas->fotokopi == 'Belum')
        {
            $berkas->update(['fotokopi' => 'Sudah difotokopi']);
            $this->Activity(' memperbarui status Fotokopi pada Soal Ujian menjadi Sudah difotokopi');
        } elseif ($berkas->fotokopi == 'Sudah difotokopi') {
            $berkas->update(['fotokopi' => 'Sudah']);    
            $this->Activity(' memperbarui status Fotokopi pada Soal Ujian menjadi Sudah diambil');
        } else {
            $berkas->update(['fotokopi' => 'Belum']);
            $this->Activity(' memperbarui status Fotokopi pada Soal Ujian menjadi Belum difotokopi');
        }

        return redirect()->route('berkas.kelengkapan.berkas.index')->with('success', 'Status Fotokopi Berkas berhasil diubah!');
    }

    public function berkasLengkap($id)
    {
        $berkas = Berkas::find($id);

        if ($berkas->lengkap == 'Belum')
        {
            $berkas->update(['lengkap' => 'Sudah']);
            $this->Activity(' memperbarui status Lengkap pada Soal Ujian menjadi Sudah lengkap');
        } else {
            $berkas->update(['lengkap' => 'Belum']);
            $this->Activity(' memperbarui status Lengkap pada Soal Ujian menjadi Belum lengkap');
        }

        return redirect()->route('berkas.kelengkapan.berkas.index')->with('success', 'Status Kelengkapan Berkas berhasil diubah!');
    }

    public function berkasSerahTerima($id)
    {
        $berkas = Berkas::find($id);

        if ($berkas->serah_terima == 'Belum')
        {
            $berkas->update(['serah_terima' => 'Sudah']);
            $this->Activity(' memperbarui status Serah Terima pada Soal Ujian menjadi Sudah diserahkan');
        } else {
            $berkas->update(['serah_terima' => 'Belum']);
            $this->Activity(' memperbarui status Serah Terima pada Soal Ujian menjadi Belum diserahkan');
        }

        return redirect()->route('berkas.kelengkapan.berkas.index')->with('success', 'Status Serah Terima Berkas berhasil diubah!');
    }

    public function ttd()
    {
        $tglbln = Carbon::now()->translatedFormat('d F Y');
        $tglblnthn = Carbon::now()->format('d/m/Y');
        $hari = Carbon::now()->translatedFormat('l');
        $jam = Carbon::now()->format('H:i');

        return view('berkas.ttd', [
            'master' => Master::find(1),
            'tglbln' => $tglbln,
            'tglblnthn' => $tglblnthn,
            'hari' => $hari,
            'jam' => $jam
        ]);
    }

    public function soal()
    {
        $dataTanggalMulai = Master::first();
        $dataTanggalSelesai = Master::first();

        $from = $dataTanggalMulai->periode_mulai;
        $to = $dataTanggalSelesai->periode_akhir;

        $ujian = Ujian::join('matkuls', 'ujians.matkul_id', '=', 'matkuls.id')
        ->join('semesters AS a', 'matkuls.semester_id', '=', 'a.id')
        ->join('praktikums', 'ujians.prak_id', '=', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', '=', 'kelas.id')
        ->join('semesters AS b', 'kelas.semester_id', '=', 'b.id')
        ->join('prodis', 'b.prodi_id', '=', 'prodis.id')
        ->groupBy('ujians.tanggal', 'ujians.tipe_mk', 'ujians.perbanyak', 'prodis.nama_prodi', 'b.semester', 'matkuls.nama_matkul')
        ->selectRaw('ujians.tanggal, prodis.nama_prodi, b.semester, matkuls.nama_matkul, ujians.tipe_mk, ujians.perbanyak, count(praktikums.jml_mhs) * 3 + SUM(praktikums.jml_mhs) AS jumlah')
        ->whereBetween('ujians.tanggal', [$from, $to])
        ->filter(request(['dbProdi', 'dbSemester', 'dbMatkul', 'dbTanggal']))
        ->get();

        return view('berkas.soal', [
            "soal" => $ujian
        ]);
    }

    public function pelanggaran()
    {
        return view('berkas.pelanggaran');
    }

    public function SerahTerima(Request $request)
    {
        $destination1 = 'images/ttd/ttd_penyerah.png';
        $destination2 = 'images/ttd/ttd_penerima.png';
        if ($destination1 AND $destination2) {
            Storage::delete($destination1);
            Storage::delete($destination2);
        }
        
        $folderPath = Storage::path('images/ttd/');
        $image1 = explode(";base64,", $request->ttd_penyerah);
        $image_base1 = base64_decode($image1[1]);
        $fileName1 = 'ttd_penyerah.png';
        $file1 = $folderPath . $fileName1;
        file_put_contents($file1, $image_base1);

        $image2 = explode(";base64,", $request->ttd_penerima);
        $image_base2 = base64_decode($image2[1]);
        $fileName2 = 'ttd_penerima.png';
        $file2 = $folderPath . $fileName2;
        file_put_contents($file2, $image_base2);
        
        DB::beginTransaction();

        $kelas = array();
        for ($i = 0; $i < count($request->kelas); $i++) {
            $kelas[] = Kelas::where('id', $request->kelas[$i])->select('kelas')->first();
        }

        $prodi = Prodi::where('id', $request->prodi)->select('nama_prodi')->first();
        $semester = Semester::where('id', $request->semester)->select('semester')->first();
        $matkul = Matkul::where('id', $request->ttdMatkul)->select('nama_matkul')->first();
        $listKelas = Kelas::where('semester_id', $request->semester)->select('kelas')->get();

        $data = [
            'master' => Master::find(1),
            'thn_ajaran' => $request->thn_ajaran,
            'nama_prodi' => $prodi->nama_prodi,
            'semester' =>$semester->semester,
            'matkul' => $matkul->nama_matkul,
            'kelas' => $kelas,
            'hari' => $request->hari,
            'jam' => $request->jam,
            'tanggal' => $request->tanggal,
            'tglbln' => $request->tglbln,
            'jml_berkas' => $request->jml_berkas,
            'nama_serah' => $request->nama_serah,
            'nama_terima' => $request->nama_terima,
            'ttd_penyerah' => $fileName1,
            'ttd_penerima' => $fileName2,
            'listKelas' => $listKelas
        ];

        $pdf = PDF::loadView('layouts.serah', $data);
        $pdfName = time(). '_Serah_Terima.pdf';
        // return $pdf->stream('serah_terima.pdf');
        Storage::put('files/pdf/' . $pdfName, $pdf->output());

        for ($i = 0; $i < count($request->kelas); $i++) {
            Berkas::join('ujians', 'berkas.ujian_id', 'ujians.id')
            ->join('praktikums', 'ujians.prak_id', 'praktikums.id')
            ->join('kelas', 'praktikums.kelas_id', 'kelas.id')
            ->join('matkuls', 'ujians.matkul_id', 'matkuls.id')
            ->where('kelas.id', $request->kelas[$i])
            ->where('matkuls.id', $request->ttdMatkul)
            ->update([
                'serah_terima' => 'Sudah',
                'file' => $pdfName
            ]);
        }
        $this->Activity(' melakukan serah terima berkas');
        DB::commit();

        return redirect()->route('berkas.kelengkapan.berkas.index')->with('success', 'Berkas Serah Terima berhasil ditanda tangani!');
    }

    public function SerahTerimaDestroy($id)
    {
        DB::beginTransaction();
        $fileName = Berkas::where('ujian_id', $id)->select('file')->first();

        $destination = 'files/pdf/' . $fileName->file;
        if ($destination) {
            Storage::delete($destination);
        }

        Berkas::where('file', $fileName->file)->update([
            'serah_terima' => 'Belum',
            'file' => null
        ]);
        $this->Activity(' menghapus serah terima berkas');
        DB::commit();
        
        return redirect()->route('berkas.kelengkapan.berkas.index')->with('success', 'Berkas Serah Terima berhasil dihapus!');
    }
}