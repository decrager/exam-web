<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class berkasController extends Controller
{
    public function dashboard()
    {
        return view('berkas.dashboard', ["title" => env('APP_NAME')]);
    }

    public function mahasiswa()
    {
        return view('berkas.mahasiswa', ["title" => env('APP_NAME')]);
    }

    public function matkul()
    {
        return view('berkas.matkul', ["title" => env('APP_NAME')]);
    }

    public function amplop()
    {
        return view('berkas.amplop', ["title" => env('APP_NAME')]);
    }

    public function bap()
    {
        return view('berkas.bap', ["title" => env('APP_NAME')]);
    }

    public function berkas()
    {
        return view('berkas.berkas', ["title" => env('APP_NAME')]);
    }

    public function pelanggaran()
    {
        return view('berkas.pelanggaran', ["title" => env('APP_NAME')]);
    }
}
