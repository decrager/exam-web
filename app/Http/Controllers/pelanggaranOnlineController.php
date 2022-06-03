<?php

namespace App\Http\Controllers;

use DateTime;
use DatePeriod;
use DateInterval;
use Carbon\Carbon;
use App\Models\Master;
use App\Models\Ujian; 
use App\Models\Mahasiswa;
use App\Http\Controllers\DB;
use App\Models\Pelanggaran; 
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class pelanggaranOnlineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataPelanggaran = Pelanggaran::orderBy('created_at', 'desc')->get();
        $dataTanggalMulai = Master::first();
        $dataTanggalSelesai = Master::selectRaw('DATE_ADD(periode_akhir, INTERVAL 1 DAY) AS periode_akhir')->first();

        $from = $dataTanggalMulai->periode_mulai;
        $to = $dataTanggalSelesai->periode_akhir;

        $period = new DatePeriod( new DateTime($from), new DateInterval('P1D'), new DateTime($to));
        $dbData = [];

        foreach($period as $date){
            $range[$date->format("Y-m-d")] = 0;
        };

        $data = Pelanggaran::join('ujians', 'pelanggarans.ujian_id', 'ujians.id')
            ->selectRaw('tanggal, count(pelanggarans.id) as total_pelanggaran')
            ->whereDate('tanggal', '>=', date($from).' 00:00:00')
            ->whereDate('tanggal', '<=', date($to).' 00:00:00')
            ->groupBy('tanggal')
            ->get();

        foreach($data as $val){
            $dbData[$val->tanggal] = $val->total_pelanggaran;
        }

        $data = array_replace($range, $dbData);
        $label =  array_keys($data);
        $data = array_values($data);
        
        return view('pj_online.pelanggaran.index', [
            'label' => $label,
            'data' => $data
          ], compact(['dataPelanggaran']));
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
        return view('pj_online.pelanggaran.form', [
            'ujians' => Ujian::all(),
            // ->where('tanggal', $today),
            'mahasiswas' => Mahasiswa::all()
          ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $validatedData = $request->validate([
            'ujian_id' => 'required',
            'mhs_id' => 'required',
            'pelanggaran' => 'required',
        ]);
  
        Pelanggaran::create($validatedData);
        $mahasiswa = Mahasiswa::find($request->mhs_id);
        $this->Activity(' menambahkan data pelanggaran untuk ' . $mahasiswa->nama);
        return redirect('/pj_online/pelanggaran')->with('success', 'Data has been successfully added');
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
    public function edit(Pelanggaran $pelanggaran)
    {
        return view('pj_online.pelanggaran.edit', [
            'pelanggarans' => $pelanggaran,
            'ujians' => Ujian::all(),
            'mahasiswas' => Mahasiswa::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pelanggaran $pelanggaran)
    {
        $validatedData = $request->validate([
            'ujian_id' => 'required',
            'mhs_id' => 'required',
            'pelanggaran' => 'required',
        ]);

        Pelanggaran::where('id', $pelanggaran->id)
        ->update($validatedData);

        $mahasiswa = Mahasiswa::find($request->mhs_id);
        $this->Activity(' memperbarui data pelanggaran untuk ' . $mahasiswa->nama);
        return redirect('/pj_online/pelanggaran')->with('success', 'Data has been successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pelanggaran $pelanggaran)
    {
        $mahasiswa = Mahasiswa::find($pelanggaran->mhs_id);
        $this->Activity(' menghapus data pelanggaran untuk ' . $mahasiswa->nama);
        Pelanggaran::destroy($pelanggaran->id);
        return redirect('/pj_online/pelanggaran/')->with('success', 'Data has been successfully deleted');
    }
}
