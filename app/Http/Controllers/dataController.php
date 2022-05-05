<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class dataController extends Controller
{
    public function dashboard()
    {
        return view('user_data.dashboard', ["title" => env('APP_NAME')]);
    }

    public function mahasiswaIndex()
    {
        return view('user_data.mahasiswa.index', ["title" => env('APP_NAME')]);
    }

    public function mahasiswaForm()
    {
        return view('user_data.mahasiswa.form', ["title" => env('APP_NAME')]);
    }

    public function mahasiswaEdit()
    {
        return view('user_data.mahasiswa.edit', ["title" => env('APP_NAME')]);
    }

    public function bap()
    {
        return view('user_data.bap', ["title" => env('APP_NAME')]);
    }

    public function amplop()
    {
        return view('user_data.amplop', ["title" => env('APP_NAME')]);
    }

    public function penggunaIndex()
    {
        return view('user_data.pengguna.index', ["title" => env('APP_NAME')]);
    }

    public function penggunaForm()
    {
        return view('user_data.pengguna.form', ["title" => env('APP_NAME')]);
    }

    public function penggunaEdit()
    {
        return view('user_data.pengguna.edit', ["title" => env('APP_NAME')]);
    }

    public function berkas()
    {
        return view('user_data.berkas', ["title" => env('APP_NAME')]);
    }

    public function ttd()
    {
        return view('user_data.ttd', ["title" => env('APP_NAME')]);
    }

    public function pelanggaran()
    {
        return view('user_data.pelanggaran', ["title" => env('APP_NAME')]);
    }
}
