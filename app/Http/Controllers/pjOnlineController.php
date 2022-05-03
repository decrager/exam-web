<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class pjOnlineController extends Controller
{
    public function dashboard()
    {
        return view('pj_online.dashboard', ["title" => env('APP_NAME')]);
    }

    public function ujian()
    {
        return view('pj_online.ujian', ["title" => env('APP_NAME')]);
    }

    public function pelanggaranIndex()
    {
        return view('pj_online.pelanggaran.index', ["title" => env('APP_NAME')]);
    }

    public function pelanggaranForm()
    {
        return view('pj_online.pelanggaran.form', ["title" => env('APP_NAME')]);
    }

    public function pelanggaranEdit()
    {
        return view('pj_online.pelanggaran.edit', ["title" => env('APP_NAME')]);
    }
}
