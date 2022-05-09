<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class pjLokasiController extends Controller
{
    public function dashboard()
    {
        return view('pj_lokasi.dashboard', ["title" => env('APP_NAME')]);
    }

    public function pengawasIndex()
    {
        return view('pj_lokasi.pengawas.index', ["title" => env('APP_NAME')]);
    }

    public function pengawasEdit()
    {
        return view('pj_lokasi.pengawas.edit', ["title" => env('APP_NAME')]);
    }

    public function absensiIndex()
    {
        return view('pj_lokasi.absensi.index', ["title" => env('APP_NAME')]);
    }

    public function absensiForm()
    {
        return view('pj_lokasi.absensi.form', ["title" => env('APP_NAME')]);
    }

    public function soalIndex()
    {
        return view('pj_lokasi.soal.index', ["title" => env('APP_NAME')]);
    }

    public function soalForm()
    {
        return view('pj_lokasi.soal.form', ["title" => env('APP_NAME')]);
    }

    public function pelanggaranIndex()
    {
        return view('pj_lokasi.pelanggaran.index', ["title" => env('APP_NAME')]);
    }

    public function pelanggaranForm()
    {
        return view('pj_lokasi.pelanggaran.form', ["title" => env('APP_NAME')]);
    }

    public function pelanggaranEdit()
    {
        return view('pj_lokasi.pelanggaran.edit', ["title" => env('APP_NAME')]);
    }
}
