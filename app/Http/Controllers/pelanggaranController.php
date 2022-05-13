<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Models\Pelanggaran; 
use App\Models\Ujian; 
use App\Http\Controllers\DB;
use Carbon\Carbon;
use function PHPUnit\Framework\isEmpty;

class pelanggaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Pelanggaran::orderBy('created_at', 'desc')
              ->get();
        // $count = Pelanggaran::groupBy('mhs_id')
        // ->selectRaw('mhs_id, count(*) as total')
        // ->get();
        // $joinTable = Pelanggaran::join('mahasiswas', 'pelanggarans.mhs_id', 'mahasiswas.id')
        // ->select('pelanggarans.id', 'mahasiswas.nama')
        // ->get();

        // $mahasiswa = Mahasiswa::join('praktikums', 'mahasiswas.prak_id', 'praktikums.id')
        // ->join('kelas', 'praktikums.kelas_id', 'kelas.id')
        // ->join('semesters', 'kelas.semester_id', 'semesters.id')
        // ->join('prodis', 'semesters.prodi_id', 'prodis.id')
        // ->selectRaw('pelanggarans.mhs_id, mahasiswas.nama, mahasiswas.nim, prodis.nama_prodi, semesters.semester, praktikums.praktikum, kelas.kelas')
        // ->get();

        // $pelanggaran = Pelanggaran::join('mahasiswas', 'pelanggarans.mhs_id', 'mahasiswas.id')
        // ->join('ujians', 'pelanggarans.ujian_id', 'ujians.id')
        // ->get();
              
        // dd($count);
        return view('pj_lokasi.pelanggaran.index',compact(['data']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ujian = Ujian::all()->pluck('id');
        $today = Carbon::today()->toDateString();
        return view('pj_lokasi.pelanggaran.form', [
            'ujians' => Ujian::all(),
            // ->where('tanggal', $today),
            'mahasiswas' => Mahasiswa::all()
          ]);
    }

    /**{{  }}
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $request;
        $validatedData = $request->validate([
            'ujian_id' => 'required',
            'mhs_id' => 'required',
            'pelanggaran' => 'required',
        ]);
  
        Category::create($validatedData);
        return redirect('/pj_lokasi/pelanggaran/crud')->with('success', 'Data has been successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pelanggaran = Pelanggaran::find($id);
        $ujian = Ujian::all();
        $mahasiswa = Mahasiswa::all();
        return view('pj_lokasi.pelanggaran.form', compact( 'pelanggaran',
        'ujian','mahasiswa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pelanggaran = Pelanggaran::find($id);
        $pelanggaran->update($request->except('_token', 'submit'));
        return redirect('/pj_lokasi/pelanggaran/crud')->with('success', 'Data has been successfully updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pelanggaran = Pelanggaran::find($id);
        $pelanggaran->delete();
        return redirect('/pj_lokasi/pelanggaran/crud')->with('success', 'Data has been successfully deleted');
    }
}