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

    public function mahasiswaInputView()
    {
        return view('user_data.mahasiswa.form', ["title" => env('APP_NAME')]);
    }

    public function bap()
    {
        return view('user_data.bap', ["title" => env('APP_NAME')]);
    }

    public function amplop()
    {
        return view('user_data.amplop', ["title" => env('APP_NAME')]);
    }

    public function berkas()
    {
        return view('user_data.berkas', ["title" => env('APP_NAME')]);
    }

    public function pelanggaran()
    {
        return view('user_data.pelanggaran', ["title" => env('APP_NAME')]);
    }
}
