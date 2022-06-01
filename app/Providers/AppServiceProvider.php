<?php

namespace App\Providers;

use DateTime;
use DatePeriod;
use DateInterval;
use Carbon\Carbon;
use App\Models\Bap;
use App\Models\Kelas;
use App\Models\Prodi;
use App\Models\Ujian;
use App\Models\Amplop;
use App\Models\Berkas;
use App\Models\Master;
use App\Models\Matkul;
use App\Models\Ruangan;
use App\Models\Semester;
use App\Models\Mahasiswa;
use App\Models\Praktikum;
use App\Models\Pelanggaran;
use App\Models\Penugasan;
use Illuminate\Http\Request;

use PhpParser\Node\Stmt\Foreach_;
use Illuminate\Support\Facades\DB;
use function GuzzleHttp\Promise\all;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');

        // $del = Berkas::all();
        // foreach ($del as $del){
        //     $check = Berkas::whereRelation('Ujian', 'id', '=', $del->ujian_id)->get();
        //     if (count($check) == 0) {
        //         Berkas::where('ujian_id', $del->ujian_id)->delete();
        //         Amplop::where('ujian_id', $del->ujian_id)->delete();
        //         Bap::where('ujian_id', $del->ujian_id)->delete();
        //     }
        // }

        $dataTanggalMulai = Master::first();
        $dataTanggalSelesai = Master::first();

        $from = $dataTanggalMulai->periode_mulai;
        $to = $dataTanggalSelesai->periode_akhir;

        $now = Carbon::now()->toDateString();
        $totalPelanggaran = Pelanggaran::selectRaw('count(*) as total')->get();
        $totalUjian = Ujian::selectRaw('count(*) as total')->where('tanggal', '2022-06-08')->get();
        $totalKehadiran = Penugasan::join('ujians', 'penugasans.ujian_id', 'ujians.id')
        ->selectRaw('count(*) as total')->where('ujians.tanggal', '2022-06-08')->where('presensi' ,'!=', null)->get();   

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

        // $ujian = Ujian::all()->whereBetween('tanggal', [$from, $to]);
        $prodi = Prodi::all();
        $semester = Semester::select('semester', DB::raw('count(*) as total'))->groupBy('semester')->get();
        $kelas = Kelas::select('kelas', DB::raw('count(*) as total'))->groupBy('kelas')->get();
        $praktikum = Praktikum::select('praktikum', DB::raw('count(*) as total'))->groupBy('praktikum')->get();
        $matkul = Matkul::select('nama_matkul', DB::raw('count(*) as total'))->groupBy('nama_matkul')->get();
        $ruang = Ruangan::all();
        $lokasi = Ruangan::selectRaw('lokasi, count(*) as total')->groupBy('lokasi')->get();
        $pelanggaran = Pelanggaran::join('mahasiswas', 'pelanggarans.mhs_id', 'mahasiswas.id')
        ->join('praktikums', 'mahasiswas.prak_id', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', 'kelas.id')
        ->join('semesters', 'kelas.semester_id', 'semesters.id')
        ->join('prodis', 'semesters.prodi_id', 'prodis.id')
        ->join('ujians', 'pelanggarans.ujian_id', 'ujians.id')
        ->join('matkuls', 'ujians.matkul_id', 'matkuls.id')
        ->select('matkuls.*', 'ujians.*', 'prodis.*', 'semesters.*', 'kelas.*', 'praktikums.*', 'mahasiswas.*', 'pelanggarans.*')
        ->whereBetween('ujians.tanggal', [$from, $to])
        ->orderBy('pelanggarans.updated_at', 'DESC')->get();
        $master = Master::find(1);
        $count = Pelanggaran::join('mahasiswas', 'pelanggarans.mhs_id', 'mahasiswas.id')
        ->join('praktikums', 'mahasiswas.prak_id', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', 'kelas.id')
        ->join('semesters', 'kelas.semester_id', 'semesters.id')
        ->join('prodis', 'semesters.prodi_id', 'prodis.id')
        ->join('ujians', 'pelanggarans.ujian_id', 'ujians.id')
        ->groupBy('mhs_id', 'mahasiswas.nim', 'mahasiswas.nama', 'praktikums.praktikum', 'kelas.kelas', 'semesters.semester', 'prodis.nama_prodi')
        ->whereBetween('ujians.tanggal', [$from, $to])
        ->selectRaw('mhs_id, count(*) as total, mahasiswas.nim, mahasiswas.nama, praktikums.praktikum, kelas.kelas, semesters.semester, prodis.nama_prodi')
        ->get();

        View::share([
            // 'dbUjian' => $ujian,
            'dbProdi' => $prodi,
            'dbSemester' => $semester,
            'dbRuang' => $ruang,
            'dbLokasi' => $lokasi,
            'dbKelas' => $kelas,
            'dbPraktikum' => $praktikum,
            'dbMatkul' => $matkul,
            'allPelanggaran' => $pelanggaran,
            'mhs' => $count,
            'mhs2' => $count,
            'master' => $master,
            'data' => $data,
            'label' => $label,
            'totalPelanggaran' => $totalPelanggaran,
            'totalUjian' => $totalUjian,
            'totalKehadiran' => $totalKehadiran,
            'title' => 'SV | MINDY'
        ]);
    }
}
