<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class supervisorController extends Controller
{
    public function dashboard()
    {
        return view('supervisor.dashboard', ["title" => env('APP_NAME')]);
    }

    public function ujian()
    {
        return view('supervisor.ujian', ["title" => env('APP_NAME')]);
    }

    public function susulan()
    {
        return view('supervisor.susulan', ["title" => env('APP_NAME')]);
    }

    public function mhs_susulan()
    {
        return view('supervisor.mhs_susulan', ["title" => env('APP_NAME')]);
    }

    public function pengawas()
    {
        return view('supervisor.pengawas', ["title" => env('APP_NAME')]);
    }

    public function mahasiswa()
    {
        return view('supervisor.mahasiswa', ["title" => env('APP_NAME')]);
    }

    public function matkul()
    {
        return view('supervisor.matkul', ["title" => env('APP_NAME')]);
    }

    public function amplop()
    {
        return view('supervisor.amplop', ["title" => env('APP_NAME')]);
    }

    public function bap()
    {
        return view('supervisor.bap', ["title" => env('APP_NAME')]);
    }

    public function berkas()
    {
        return view('supervisor.berkas', ["title" => env('APP_NAME')]);
    }

    public function pengguna()
    {
        return view('supervisor.pengguna', ["title" => env('APP_NAME')]);
    }

    public function pelanggaran()
    {
        return view('supervisor.pelanggaran', ["title" => env('APP_NAME')]);
    }
}
