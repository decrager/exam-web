<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class mahasiswaController extends Controller
{
    public function dashboard()
    {
        return view('mahasiswa.dashboard', ["title" => env('APP_NAME')]);
    }

    public function ujian()
    {
        return view('mahasiswa.ujian', ["title" => env('APP_NAME')]);
    }

    public function pengajuanIndex()
    {
        return view('mahasiswa.pengajuan.index', ["title" => env('APP_NAME')]);
    }

    public function pengajuanForm()
    {
        return view('mahasiswa.pengajuan.form', ["title" => env('APP_NAME')]);
    }

    public function pengajuanEdit()
    {
        return view('mahasiswa.pengajuan.edit', ["title" => env('APP_NAME')]);
    }
}
