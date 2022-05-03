<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class pjLokasiController extends Controller
{
    public function dashboard()
    {
        return view('pj_lokasi.dashboard', ["title" => env('APP_NAME')]);
    }

    public function pengawasList()
    {
        return view('pj_lokasi.daftar_pengawas', ["title" => env('APP_NAME')]);
    }

    public function penugasanIndex()
    {
        return view('pj_lokasi.penugasan.index', ["title" => env('APP_NAME')]);
    }

    public function penugasanForm()
    {
        return view('pj_lokasi.penugasan.form', ["title" => env('APP_NAME')]);
    }

    public function penugasanEdit()
    {
        return view('pj_lokasi.penugasan.edit', ["title" => env('APP_NAME')]);
    }

    public function absensiIndex()
    {
        return view('pj_lokasi.absensi.index', ["title" => env('APP_NAME')]);
    }

    public function absensiForm()
    {
        return view('pj_lokasi.absensi.form', ["title" => env('APP_NAME')]);
    }

    public function berkas()
    {
        return view('pj_lokasi.berkas', ["title" => env('APP_NAME')]);
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
