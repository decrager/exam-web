<?php

namespace App\Http\Controllers;

use App\Models\Amplop;
use App\Models\Bap;
use App\Models\Kelas;
use App\Models\Ujian;
use App\Models\Mahasiswa;
use App\Models\Master;
use App\Models\Matkul;
use App\Models\Praktikum;
use App\Models\Prodi;
use App\Models\Semester;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\isEmpty;

class dataController extends Controller
{
    public function dashboard(Request $request)
    {
        if (isEmpty($request)) {
            $ujian = Ujian::all();
        } else {
            $prodi = $request->prodi;
            $semester = $request->semester;
            $matkul = $request->matkul;
            $kelas = $request->kelas;
            $praktikum = $request->praktikum;
            $tanggal = $request->tanggal;
            $ruang = $request->ruang;

            $ujian = $this->filter($prodi, $semester, $matkul, $kelas, $praktikum, $tanggal, $ruang);
            $ujian->get();
        }

        return view('user_data.dashboard', [
            "ujian" => $ujian
        ]);
    }

    public function mahasiswaIndex(Request $request)
    {
        if (isEmpty($request))
        {
            $mahasiswa = Mahasiswa::all();
        } else {
            $mahasiswa = Mahasiswa::join('praktikums', 'ujians.prak_id', '=', 'praktikums.id')
            ->join('kelas', 'praktikums.kelas_id', '=', 'kelas.id')
            ->join('semesters', 'kelas.semester_id', '=', 'semesters.id')
            ->join('prodis', 'semesters.prodi_id', '=', 'prodis.id');

            if ($request->prodi) {
                $mahasiswa->where('prodis.nama_prodi', 'like', '%' . $request->prodi . '%');
                if ($request->semester) {
                    $mahasiswa->where('semesters.semester', 'like', '%' . $request->semester . '%');
                    if ($request->kelas) {
                        $mahasiswa->where('kelas.kelas', 'like', '%' . $request->kelas . '%');
                        if ($request->praktikum) {
                            $mahasiswa->where('praktikums.praktikum', 'like', '%' . $request->praktikum . '%');
                        }
                    }
                }
            }

            $mahasiswa->get();
        }

        return view('user_data.mahasiswa.index', [
            "mahasiswa" => $mahasiswa
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

        return redirect()->route('data.mahasiswa.view')->with('success', 'Data mahasiswa berhasil diubah!');
    }

    public function mahasiswaDestroy($id)
    {
        $mahasiswa = Mahasiswa::find($id);
        User::where('id', $mahasiswa->user_id)->delete();
        $mahasiswa->delete();
        return redirect()->route('data.mahasiswa.view')->with('success', 'Data mahasiswa berhasil dihapus!');
    }

    public function bap(Request $request)
    {
        if (isEmpty($request)) {
            $ujian = Ujian::all();
        } else {
            $prodi = $request->prodi;
            $semester = $request->semester;
            $matkul = $request->matkul;
            $kelas = $request->kelas;
            $praktikum = $request->praktikum;
            $tanggal = $request->tanggal;
            $ruang = $request->ruang;

            $ujian = $this->filter($prodi, $semester, $matkul, $kelas, $praktikum, $tanggal, $ruang);
            $ujian->get();
        }

        return view('user_data.bap', [
            "bap" => $ujian
        ]);
    }

    public function bapUpdate($id)
    {
        $bap = Bap::find($id);

        if ($bap->print == 'Belum')
        {
            $bap->update(['print' => 'Sudah']);
        } else {
            $bap->update(['print' => 'Belum']);
        }

        return redirect()->route('data.ketersediaan.bap')->with('success', 'Status Print BAP berhasil diubah!');
    }

    public function amplop(Request $request)
    {
        if (isEmpty($request)) {
            $ujian = Ujian::all();
        } else {
            $prodi = $request->prodi;
            $semester = $request->semester;
            $matkul = $request->matkul;
            $kelas = $request->kelas;
            $praktikum = $request->praktikum;
            $tanggal = $request->tanggal;
            $ruang = $request->ruang;

            $ujian = $this->filter($prodi, $semester, $matkul, $kelas, $praktikum, $tanggal, $ruang);
            $ujian->get();
        }

        return view('user_data.amplop', [
            "amplop" => $ujian
        ]);
    }

    public function amplopUpdate($id)
    {
        $amplop = Amplop::find($id);

        if ($amplop->print == 'Belum')
        {
            $amplop->update(['print' => 'Sudah']);
        } else {
            $amplop->update(['print' => 'Belum']);
        }

        return redirect()->route('data.ketersediaan.amplop')->with('success', 'Status Print Amplop berhasil diubah!');
    }

    public function penggunaIndex()
    {
        $pengguna = User::where('role', '!=', 'mahasiswa')->get();

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

        return redirect()->route('data.pengguna.index')->with('success', 'Data pengguna berhasil diubah!');
    }

    public function penggunaDestroy($id)
    {   
        User::find($id)->delete();
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

        return redirect()->route('data.akademik.prodi.index')->with('success', 'Data Program Studi berhasil diperbarui');
    }

    public function prodiDestroy($id)
    {
        Prodi::find($id)->delete();
        return redirect()->route('data.akademik.prodi.index')->with('success', 'Data Program Studi berhasil dihapus');
    }

    public function  semesterIndex()
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

        return redirect()->route('data.akademik.semester.index')->with('success', 'Data semester berhasil diperbarui!');
    }

    public function semesterDestroy($id)
    {
        Semester::find($id)->delete();
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

        return redirect()->route('data.akademik.kelas.index')->with('success', 'Kelas berhasil diperbarui!');
    }

    public function kelasDestroy($id)
    {
        Kelas::find($id)->delete();
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

        return redirect()->route('data.akademik.praktikum.index')->with('success', 'Praktikum berhasil diperbarui!');
    }

    public function praktikumDestroy($id)
    {
        Praktikum::find($id)->delete();
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

        return redirect()->route('data.akademik.matkul.index')->with('success', 'Mata Kuliah berhasil diperbarui!');
    }

    public function matkulDestroy($id)
    {
        Matkul::find($id)->delete();
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

        return redirect()->route('data.periode.index')->with('success', 'Data Periode berhasil diperbarui!');
    }
}
