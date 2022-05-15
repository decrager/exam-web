<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use App\Models\Ujian;
use App\Models\Prodi;
use App\Models\Amplop;
use App\Models\Bap;
use App\Models\Berkas;
use App\Models\Mahasiswa;
use App\Models\Master;
use App\Models\Pelanggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Foreach_;

use function GuzzleHttp\Promise\all;

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

        $del = Berkas::all();
        foreach ($del as $del){
            $check = Berkas::whereRelation('Ujian', 'id', '=', $del->ujian_id)->get();
            if (count($check) == 0) {
                Berkas::where('ujian_id', $del->ujian_id)->delete();
                Amplop::where('ujian_id', $del->ujian_id)->delete();
                Bap::where('ujian_id', $del->ujian_id)->delete();
            }
        }

        $ujian = Ujian::all();
        $prodi = Prodi::all();
        $ruang = Ujian::select('ruang', DB::raw('count(id) as total'))->groupBy('ruang')->get();
        $pelanggaran = Pelanggaran::all();
        $master = Master::find(1);
        $count = Pelanggaran::join('mahasiswas', 'pelanggarans.mhs_id', 'mahasiswas.id')
        ->join('praktikums', 'mahasiswas.prak_id', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', 'kelas.id')
        ->join('semesters', 'kelas.semester_id', 'semesters.id')
        ->join('prodis', 'semesters.prodi_id', 'prodis.id')
        ->groupBy('mhs_id', 'mahasiswas.nim', 'mahasiswas.nama', 'praktikums.praktikum', 'kelas.kelas', 'semesters.semester', 'prodis.nama_prodi')
        ->selectRaw('mhs_id, count(*) as total, mahasiswas.nim, mahasiswas.nama, praktikums.praktikum, kelas.kelas, semesters.semester, prodis.nama_prodi')
        ->get();
        $count2 = Pelanggaran::join('mahasiswas', 'pelanggarans.mhs_id', 'mahasiswas.id')
        ->join('praktikums', 'mahasiswas.prak_id', 'praktikums.id')
        ->join('kelas', 'praktikums.kelas_id', 'kelas.id')
        ->join('semesters', 'kelas.semester_id', 'semesters.id')
        ->join('prodis', 'semesters.prodi_id', 'prodis.id')
        ->groupBy('mhs_id', 'mahasiswas.nim', 'mahasiswas.nama', 'praktikums.praktikum', 'kelas.kelas', 'semesters.semester', 'prodis.nama_prodi')
        ->selectRaw('mhs_id, count(*) as total, mahasiswas.nim, mahasiswas.nama, praktikums.praktikum, kelas.kelas, semesters.semester, prodis.nama_prodi')
        ->get();

        View::share([
            'dbUjian' => $ujian,
            'dbProdi' => $prodi,
            'dbRuang' => $ruang,
            'allPelanggaran' => $pelanggaran,
            'mhs' => $count,
            'mhs2' => $count2,
            'master' => $master,
            "title" => env('APP_NAME')
        ]);
    }
}
