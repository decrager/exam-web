<?php

namespace App\Http\Controllers;

use App\Models\Amplop;
use App\Models\Bap;
use App\Models\Ujian;
use App\Models\Mahasiswa;
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
        return view('user_data.prodi.index');
    }

    public function prodiForm()
    {
        return view('user_data.prodi.form');
    }

    public function prodiEdit($id)
    {
        return view('user_data.prodi.edit');
    }

    public function  semesterIndex()
    {
        return view('user_data.prodi.index');
    }

    public function semesterForm()
    {
        return view('user_data.prodi.form');
    }

    public function semesterEdit($id)
    {
        return view('user_data.prodi.edit');
    }

    public function kelasIndex()
    {
        return view('user_data.kelas.index');
    }
    
    public function kelasForm()
    {
        return view('user_data.kelas.form');
    }

    public function kelasEdit()
    {
        return view('user_data.kelas.edit');
    }

    public function praktikumIndex()
    {
        return view('user_data.praktikum.index');
    }

    public function praktikumForm()
    {
        return view('user_data.praktikum.form');
    }

    public function praktikumEdit()
    {
        return view('user_data.praktikum.edit');
    }

    public function matkulIndex()
    {
        return view('user_data.matkul.index');
    }

    public function matkulForm()
    {
        return view('user_data.matkul.form');
    }

    public function matkulEdit()
    {
        return view('user_data.matkul.edit');
    }

    public function periodeIndex()
    {
        return view('user_data.periode.index');
    }

    public function periodeEdit()
    {
        return view('user_data.periode.edit');
    }
}
