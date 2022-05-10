<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use App\Models\Ujian;
use App\Models\Prodi;
use App\Models\Kelas;
use App\Models\Praktikum;
use App\Models\Matkul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

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
    public function boot(Request $request)
    {
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');

        $ujian = Ujian::all();
        $prodi = Prodi::all();
        $ruang = Ujian::select('ruang', DB::raw('count(id) as total'))->groupBy('ruang')->get();

        View::share([
            'dbUjian' => $ujian,
            'dbProdi' => $prodi,
            'dbRuang' => $ruang
        ]);
    }
}
