<?php

namespace App\Http\Controllers;

use App\Exports\LogExport;
use App\Exports\PengawasExport;
use Carbon\Carbon;
use App\Models\Bap;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Prodi;
use App\Models\Ujian;
use App\Models\Amplop;
use App\Models\Master;
use App\Models\Matkul;
use App\Models\Pengawas;
use App\Models\Semester;
use App\Models\Mahasiswa;
use App\Models\Penugasan;
use App\Models\Praktikum;
use Illuminate\Http\Request;
use App\Models\LogActivities;
use Illuminate\Support\Facades\DB;
use App\Exports\UjianExport;
use App\Models\Ruangan;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use function PHPUnit\Framework\isEmpty;

class dataController extends Controller
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

        return view('user_data.dashboard', [
            "dbUjian" => $ujian->get()
        ]);
    }

    public function ujian()
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

        return view('user_data.ujian', [
            "ujian" => $ujian->get(),
            "ujians" => $ujian->get()
        ]);
    }

    public function export(){
        $this->Activity(' mengeksport jadwal ujian ke excel');
        return Excel::download(new UjianExport, 'dataujian.xlsx');
    }

    public function mahasiswaIndex()
    {
        $mahasiswa = Mahasiswa::join('praktikums', 'mahasiswas.prak_id', '=', 'praktikums.id')
            ->join('kelas', 'praktikums.kelas_id', '=', 'kelas.id')
            ->join('semesters', 'kelas.semester_id', '=', 'semesters.id')
            ->join('prodis', 'semesters.prodi_id', '=', 'prodis.id')
            ->filter(request(['dbProdi', 'dbSemester', 'dbPraktikum', 'dbKelas']));

        return view('user_data.mahasiswa.index', [
            "mahasiswa" => $mahasiswa->get()
        ]);
    }

    public function mahasiswaForm()
    {
        return view('user_data.mahasiswa.form');
    }

    public function mahasiswaEdit($id)
    {
        return view('user_data.mahasiswa.edit', ["mahasiswa" => Mahasiswa::find($id)]);
    }

    public function mahasiswaCreate(Request $request)
    {
        $request->validate([
            'praktikum' => 'required',
            'nama' => 'required',
            'nim' => 'required',
            'email' => 'required'
        ]);

        $pengguna = new User;
        $pengguna->name = $request->nama;
        $pengguna->email = $request->email;
        $pengguna->role = 'mahasiswa';
        $pengguna->password = '$2a$12$73YbJpbhMa8vVwroP8Ke0ODNYu1jjlALYK1xzrXFGVDbIYEk1KhZK';
        $pengguna->save();

        $late = User::orderBy('id', 'DESC')->take(1)->get();
        foreach ($late as $iduser) {
            $latest = $iduser->id;
        }

        $mahasiswa = new Mahasiswa;
        $mahasiswa->prak_id = $request->praktikum;
        $mahasiswa->user_id = $latest;
        $mahasiswa->nama = $request->nama;
        $mahasiswa->nim = $request->nim;
        $mahasiswa->email = $request->email;
        $mahasiswa->save();

        $this->Activity(' menambahkan data mahasiswa ' . $request->nama);
        return redirect()->route('data.mahasiswa.view')->with('success', 'Data mahasiswa berhasil ditambahkan!');
    }

    public function mahasiswaUpdate(Request $request, $id)
    {
        $request->validate([
            'praktikum' => 'required',
            'nama' => 'required',
            'nim' => 'required',
            'email' => 'required'
        ]);

        $mahasiswa = Mahasiswa::find($id);
        $pengguna = User::where('id', $mahasiswa->user_id);

        $mahasiswa->update([
            'prak_id' => $request->praktikum,
            'nama' => $request->nama,
            'nim' => $request->nim,
            'email' => $request->email
        ]);

        $pengguna->update([
            'name' => $request->nama,
            'email' => $request->email
        ]);

        $this->Activity(' memperbarui data mahasiswa ' . $request->nama);
        return redirect()->route('data.mahasiswa.view')->with('success', 'Data mahasiswa berhasil diubah!');
    }

    public function mahasiswaDestroy($id)
    {
        $mahasiswa = Mahasiswa::find($id);
        $this->Activity(' menghapus data mahasiswa ' . $mahasiswa->nama);
        User::where('id', $mahasiswa->user_id)->delete();
        $mahasiswa->delete();
        return redirect()->route('data.mahasiswa.view')->with('success', 'Data mahasiswa berhasil dihapus!');
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

        return view('user_data.bap', [
            "bap" => $ujian->get()
        ]);
    }

    public function bapUpdate($id)
    {
        $bap = Bap::find($id);

        if ($bap->print == 'Belum')
        {
            $bap->update(['print' => 'Sudah']);
            $this->Activity(' memperbarui status Print pada BAP menjadi Sudah diprint');
        } else {
            $bap->update(['print' => 'Belum']);
            $this->Activity(' memperbarui status Print pada BAP menjadi Belum diprint');
        }

        return redirect()->route('data.ketersediaan.bap')->with('success', 'Status Print BAP berhasil diubah!');
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

        return view('user_data.amplop', [
            "amplop" => $ujian->get()
        ]);
    }

    public function amplopUpdate($id)
    {
        $amplop = Amplop::find($id);

        if ($amplop->print == 'Belum')
        {
            $amplop->update(['print' => 'Sudah']);
            $this->Activity(' memperbarui status Print pada Amplop menjadi Sudah diprint');
        } else {
            $amplop->update(['print' => 'Belum']);
            $this->Activity(' memperbarui status Print pada Amplop menjadi Belum diprint');
        }

        return redirect()->route('data.ketersediaan.amplop')->with('success', 'Status Print Amplop berhasil diubah!');
    }

    public function penggunaIndex()
    {
        $pengguna = User::where('role', '!=', 'mahasiswa')->where('role', '!=', 'superadmin')->get();

        return view('user_data.pengguna.index', [
            "pengguna" => $pengguna
        ]);
    }

    public function penggunaForm()
    {
        return view('user_data.pengguna.form', [
        ]);
    }

    public function penggunaEdit($id)
    {
        return view('user_data.pengguna.edit', [
            "pengguna" => User::find($id)
        ]);
    }

    public function penggunaCreate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
            'lokasi' => 'nullable'
        ]);

        $pengguna = new User;
        $pengguna->name = $request->name;
        $pengguna->email = $request->email;
        $pengguna->role = $request->role;
        $pengguna->lokasi = $request->lokasi;
        $pengguna->password = '$2a$12$73YbJpbhMa8vVwroP8Ke0ODNYu1jjlALYK1xzrXFGVDbIYEk1KhZK';
        $pengguna->save();

        $this->Activity(' menambahkan pengguna baru dengan nama ' . $request->name);
        return redirect()->route('data.pengguna.index')->with('success', 'Data pengguna berhasil ditambah!');
    }

    public function penggunaUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
            'lokasi' => 'nullable'
        ]);

        $pengguna = User::find($id);
        $pengguna->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'lokasi' => $request->lokasi,
        ]);

        $this->Activity(' memperbarui pengguna dengan nama ' . $request->name);
        return redirect()->route('data.pengguna.index')->with('success', 'Data pengguna berhasil diubah!');
    }

    public function penggunaDestroy($id)
    {   
        $user = User::find($id);
        $this->Activity(' menghapus pengguna dengan nama ' . $user->name);
        $user->delete();
        return redirect()->route('data.pengguna.index')->with('success', 'Data pengguna berhasil dihapus!');
    }

    public function pelanggaran()
    {
        return view('user_data.pelanggaran');
    }

    public function prodiIndex()
    {
        return view('user_data.prodi.index', ['prodi' => Prodi::all()]);
    }

    public function prodiForm()
    {
        return view('user_data.prodi.form');
    }

    public function prodiEdit($id)
    {
        return view('user_data.prodi.edit', ['prodi' => Prodi::find($id)]);
    }

    public function prodiCreate(Request $request)
    {
        $request->validate([
            'kode_prodi' => 'required',
            'nama_prodi' => 'required'
        ]);

        $prodi = new Prodi;
        $prodi->nama_prodi = $request->nama_prodi;
        $prodi->kode_prodi = $request->kode_prodi;
        $prodi->save();

        $this->Activity(' menambahkan data Program Studi baru dengan nama ' . $request->nama_prodi);
        return redirect()->route('data.akademik.prodi.index')->with('success', 'Data Program Studi baru berhasil ditambahkan');
    }

    public function prodiUpdate(Request $request, $id)
    {
        $request->validate([
            'kode_prodi' => 'required',
            'nama_prodi' => 'required'
        ]);

        $prodi = Prodi::find($id);
        $prodi->update([
            'kode_prodi' => $request->kode_prodi,
            'nama_prodi' => $request->nama_prodi
        ]);

        $this->Activity(' memperbarui data Program Studi dengan nama ' . $request->nama_prodi);
        return redirect()->route('data.akademik.prodi.index')->with('success', 'Data Program Studi berhasil diperbarui');
    }

    public function prodiDestroy($id)
    {
        $prodi = Prodi::find($id);
        $this->Activity(' menghapus data Program Studi dengan nama ' . $prodi->nama_prodi);
        $prodi->delete();
        return redirect()->route('data.akademik.prodi.index')->with('success', 'Data Program Studi berhasil dihapus');
    }

    public function semesterIndex()
    {
        return view('user_data.semester.index', ['semester' => Semester::all()]);
    }

    public function semesterForm()
    {
        return view('user_data.semester.form');
    }

    public function semesterEdit($id)
    {
        return view('user_data.semester.edit', ['semester' => Semester::find($id)]);
    }

    public function semesterCreate(Request $request)
    {
        $request->validate([
            'prodi_id' => 'required',
            'semester' => 'required'
        ]);

        $semester = new Semester;
        $semester->prodi_id = $request->prodi_id;
        $semester->semester = $request->semester;
        $semester->save();

        $this->Activity(' menambahkan data Semester');
        return redirect()->route('data.akademik.semester.index')->with('success', 'Data semester baru berhasil ditambahkan!');
    }

    public function semesterUpdate(Request $request, $id)
    {
        $request->validate([
            'prodi_id' => 'required',
            'semester' => 'required'
        ]);

        $semester = Semester::find($id);
        $semester->update([
            'prodi_id' => $request->prodi_id,
            'semester' => $request->semester
        ]);

        $this->Activity(' memperbarui data Semester');
        return redirect()->route('data.akademik.semester.index')->with('success', 'Data semester berhasil diperbarui!');
    }

    public function semesterDestroy($id)
    {
        $semester = Semester::find($id);
        $this->Activity(' menghapus data Semester');
        $semester->delete();
        return redirect()->route('data.akademik.semester.index')->with('success', 'Data semester berhasil dihapus!');
    }

    public function kelasIndex()
    {
        return view('user_data.kelas.index', ['kelas' => Kelas::all()]);
    }
    
    public function kelasForm()
    {
        return view('user_data.kelas.form');
    }

    public function kelasEdit($id)
    {
        return view('user_data.kelas.edit', ['kelas' => Kelas::find($id)]);
    }

    public function kelasCreate(Request $request)
    {
        $request->validate([
            'semester' => 'required',
            'kelas' => 'required',
            'jml_mhs' => 'required'
        ]);

        $kelas = new Kelas;
        $kelas->semester_id = $request->semester;
        $kelas->kelas = $request->kelas;
        $kelas->jml_mhs = $request->jml_mhs;
        $kelas->save();

        $this->Activity(' menambahkan data Kelas');
        return redirect()->route('data.akademik.kelas.index')->with('success', 'Kelas baru berhasil ditambahkan!');
    }

    public function kelasUpdate(Request $request, $id)
    {
        $request->validate([
            'semester' => 'required',
            'kelas' => 'required',
            'jml_mhs' => 'required'
        ]);

        $kelas = Kelas::find($id);
        $kelas->update([
            'semester_id' => $request->semester,
            'kelas' => $request->kelas,
            'jml_mhs' => $request->jml_mhs,
        ]);

        $this->Activity(' memperbarui data Kelas');
        return redirect()->route('data.akademik.kelas.index')->with('success', 'Kelas berhasil diperbarui!');
    }

    public function kelasDestroy($id)
    {
        $kelas = Kelas::find($id);
        $this->Activity(' menghapus data Kelas');
        $kelas->delete();
        return redirect()->route('data.akademik.kelas.index')->with('success', 'Kelas berhasil dihapus!');
    }

    public function praktikumIndex()
    {
        return view('user_data.praktikum.index', ['praktikum' => Praktikum::all()]);
    }

    public function praktikumForm()
    {
        return view('user_data.praktikum.form');
    }

    public function praktikumEdit($id)
    {
        return view('user_data.praktikum.edit', ['praktikum' => Praktikum::find($id)]);
    }

    public function praktikumCreate(Request $request)
    {
        $request->validate([
            'kelas' => 'required',
            'praktikum' => 'required',
            'jml_mhs' => 'required'
        ]);

        $praktikum = new Praktikum;
        $praktikum->kelas_id = $request->kelas;
        $praktikum->praktikum = $request->praktikum;
        $praktikum->jml_mhs = $request->jml_mhs;
        $praktikum->save();

        $this->Activity(' menambahkan data Praktikum');
        return redirect()->route('data.akademik.praktikum.index')->with('success', 'Praktikum baru berhasil ditambahkan!');
    }

    public function praktikumUpdate(Request $request, $id)
    {
        $request->validate([
            'kelas' => 'required',
            'praktikum' => 'required',
            'jml_mhs' => 'required'
        ]);

        $praktikum = Praktikum::find($id);
        $praktikum->update([
            'kelas_id' => $request->kelas,
            'praktikum' => $request->praktikum,
            'jml_mhs' => $request->jml_mhs
        ]);

        $this->Activity(' memperbarui data Praktikum');
        return redirect()->route('data.akademik.praktikum.index')->with('success', 'Praktikum berhasil diperbarui!');
    }

    public function praktikumDestroy($id)
    {
        $praktikum = Praktikum::find($id);
        $this->Activity(' menghapus data Praktikum');
        $praktikum->delete();
        return redirect()->route('data.akademik.praktikum.index')->with('success', 'Praktikum berhasil dihapus!');
    }

    public function matkulIndex()
    {
        return view('user_data.matkul.index', ['matkul' => Matkul::all()]);
    }

    public function matkulForm()
    {
        return view('user_data.matkul.form');
    }

    public function matkulEdit($id)
    {
        return view('user_data.matkul.edit', ['matkul' => Matkul::find($id)]);
    }

    public function matkulCreate(Request $request)
    {
        $request->validate([
            'semester' => 'required',
            'kode_matkul' => 'required',
            'nama_matkul' => 'required',
            'sks' => 'required',
            'sks_kul' => 'required',
            'sks_prak' => 'required'
        ]);

        $matkul = new Matkul;
        $matkul->semester_id = $request->semester;
        $matkul->kode_matkul = $request->kode_matkul;
        $matkul->nama_matkul = $request->nama_matkul;
        $matkul->sks = $request->sks;
        $matkul->sks_kul = $request->sks_kul;
        $matkul->sks_prak = $request->sks_prak;
        $matkul->save();

        $this->Activity(' menambahkan data Mata Kuliah ' . $request->nama_matkul);
        return redirect()->route('data.akademik.matkul.index')->with('success', 'Mata Kuliah baru berhasil ditambahkan!');
    }

    public function matkulUpdate(Request $request, $id)
    {
        $request->validate([
            'semester' => 'required',
            'kode_matkul' => 'required',
            'nama_matkul' => 'required',
            'sks' => 'required',
            'sks_kul' => 'required',
            'sks_prak' => 'required'
        ]);

        $matkul = Matkul::find($id);
        $matkul->update([
            'semester_id' => $request->semester,
            'kode_matkul' => $request->kode_matkul,
            'nama_matkul' => $request->nama_matkul,
            'sks' => $request->sks,
            'sks_kul' => $request->sks_kul,
            'sks_prak' => $request->sks_prak
        ]);

        $this->Activity(' memperbarui data Mata Kuliah ' . $request->nama_matkul);
        return redirect()->route('data.akademik.matkul.index')->with('success', 'Mata Kuliah berhasil diperbarui!');
    }

    public function matkulDestroy($id)
    {
        $matkul = Matkul::find($id);
        $this->Activity(' memperbarui data Mata Kuliah ' . $matkul->nama_matkul);
        $matkul->delete();
        return redirect()->route('data.akademik.matkul.index')->with('success', 'Mata Kuliah berhasil dihapus!');
    }

    public function periodeIndex()
    {
        return view('user_data.periode.index', ['master' => Master::find(1)]);
    }

    public function periodeEdit($id)
    {
        return view('user_data.periode.edit', ['master' => Master::find($id)]);
    }

    public function periodeUpdate(Request $request, $id)
    {
        $request->validate([
            'thn_ajaran' => 'required',
            'smt_akademik' => 'required',
            'isuas' => 'required',
            'periode_mulai' => 'required',
            'periode_akhir' => 'required'
        ]);

        $master = Master::find($id);
        $master->update([
            'thn_ajaran' => $request->thn_ajaran,
            'smt_akademik' => $request->smt_akademik,
            'isuas' => $request->isuas,
            'periode_mulai' => $request->periode_mulai,
            'periode_akhir' => $request->periode_akhir,
        ]);

        $this->Activity(' memperbarui data Periode');
        return redirect()->route('data.periode.index')->with('success', 'Data Periode berhasil diperbarui!');
    }

    public function logActivity()
    {
        $log = LogActivities::Filter(Request(['tanggal']))->latest()->take(300)->get();
        return view('user_data.log', ['activity' => $log]);
    }

    public function logExport()
    {
        $this->Activity(' mengeksport catatan aktivitas ke excel');
        return Excel::download(new LogExport, 'LogActivities.xlsx');
    }

    public function pengawasPresensi()
    {
        $dataTanggalMulai = Master::first();
        $dataTanggalSelesai = Master::first();

        $from = $dataTanggalMulai->periode_mulai;
        $to = $dataTanggalSelesai->periode_akhir;

        $penugasan = Penugasan::join('pengawas', 'penugasans.pengawas_id', 'pengawas.id')
        ->join('ujians', 'penugasans.ujian_id', '=', 'ujians.id')
        ->join('matkuls', 'ujians.matkul_id', '=', 'matkuls.id')
        ->join('semesters AS a', 'matkuls.semester_id', '=', 'a.id')
        ->join('praktikums', 'ujians.prak_id', '=', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', '=', 'kelas.id')
        ->join('semesters AS b', 'kelas.semester_id', '=', 'b.id')
        ->join('prodis', 'b.prodi_id', '=', 'prodis.id')
        ->select('ujians.*', 'matkuls.*', 'b.*', 'praktikums.*', 'kelas.*', 'prodis.*', 'pengawas.*', 'penugasans.*')
        ->whereBetween('ujians.tanggal', [$from, $to])
        ->filter(request(['dbProdi', 'dbMatkul']));

        return view('user_data.pengawas', ['penugasan' => $penugasan->get()]);
    }

    public function pengawasIndex()
    {
        return view('user_data.pengawas.index', ['pengawas' => Pengawas::all()]);
    }

    public function pengawasForm()
    {
        return view('user_data.pengawas.form');
    }

    public function pengawasEdit($id)
    {
        return view('user_data.pengawas.edit', ['pengawas' => Pengawas::find($id)]);
    }

    public function pengawasCreate(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nik' => 'required',
            'pns' => 'required',
            'bank' => 'required',
            'norek' => 'required',
            'tlp' => 'required'
        ]);

        Pengawas::create($request->all());

        $this->Activity(' menambahkan data pengawas ' . $request->nama);
        return redirect()->route('data.pengawas.data.index')->with('success', 'Data pengawas baru berhasil ditambahkan!');
    }

    public function pengawasUpdate(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'nik' => 'required',
            'pns' => 'required',
            'bank' => 'required',
            'norek' => 'required',
            'tlp' => 'required'
        ]);

        Pengawas::find($id)->update($request->all());

        $this->Activity(' memperbarui data pengawas ' . $request->nama);
        return redirect()->route('data.pengawas.data.index')->with('success', 'Data pengawas berhasil diperbarui!');
    }

    public function pengawasDestroy($id)
    {
        $pengawas = Pengawas::find($id);
        $this->Activity(' menghapus data pengawas ' . $pengawas->nama);
        $pengawas->delete();
        return redirect()->route('data.pengawas.data.index')->with('success', 'Data pengawas baru berhasil dihapus!');
    }

    public function pengawasRecap()
    {
        $dataTanggalMulai = Master::first();
        $dataTanggalSelesai = Master::first();

        $from = $dataTanggalMulai->periode_mulai;
        $to = $dataTanggalSelesai->periode_akhir;

        $pengawas = Penugasan::join('pengawas', 'penugasans.pengawas_id', 'pengawas.id')
        ->join('ujians', 'penugasans.ujian_id', 'ujians.id')
        ->groupBy('pengawas_id', 'pengawas.nama', 'pengawas.nik', 'pengawas.pns', 'pengawas.bank', 'pengawas.norek')
        ->whereBetween('ujians.tanggal', [$from, $to])
        ->selectRaw('pengawas_id, pengawas.nama, pengawas.nik, pengawas.pns, pengawas.bank, pengawas.norek, count(*) as total')
        ->get();

        return view('user_data.pengawas.recap', compact('pengawas'));
    }

    public function pengawasExport(){
        $this->Activity(' mengeksport rekapitulasi pengawas ke excel');
        return Excel::download(new PengawasExport, 'pengawas.xlsx');
    }

    public function ruanganIndex()
    {
        $lokasi = Ruangan::all();
        return view('user_data.ruangan.index', compact('lokasi'));
    }

    public function ruanganForm()
    {
        return view('user_data.ruangan.form');
    }

    public function ruanganEdit($id)
    {
        $lokasi = Ruangan::find($id);
        return view('user_data.ruangan.edit', compact('lokasi'));
    }

    public function ruanganCreate(Request $request)
    {
        $request->validate([
            'lokasi' => 'required',
            'ruangan' => 'required'
        ]);

        $lokasi = new Ruangan;
        $lokasi->lokasi = $request->lokasi;
        $lokasi->ruangan = $request->ruangan;
        $lokasi->save();

        $this->Activity(' menambahkan data lokasi ' . $request->lokasi . ' dan ruangan ' . $request->ruangan);
        return redirect()->route('data.ruangan.index')->with('success', 'Berhasil menambahkan data ruangan baru');
    }

    public function ruanganUpdate(Request $request, $id)
    {
        $request->validate([
            'lokasi' => 'required',
            'ruangan' => 'required'
        ]);

        $lokasi = Ruangan::find($id);
        $lokasi->update($request->all());
        $this->Activity(' memperbarui data lokasi ' . $request->lokasi . ' dan ruangan ' . $request->ruangan);
        return redirect()->route('data.ruangan.index')->with('success', 'Berhasil memperbarui data ruangan');
    }

    public function ruanganDestroy($id)
    {
        $lokasi = Ruangan::find($id);
        $this->Activity(' menghapus data lokasi ' . $lokasi->lokasi . ' dan ruangan ' . $lokasi->ruangan);
        $lokasi->delete();
        return redirect()->route('data.ruangan.index')->with('success', 'Berhasil menghapus data ruangan');
    }
}