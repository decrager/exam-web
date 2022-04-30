<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class dataController extends Controller
{
    public function dashboard()
    {
        return view('user_data.dashboard', ["title" => "Beranda"]);
    }

    public function mahasiswaIndex()
    {
        return view('user_data.mahasiswa.index', ["title" => "Mahasiswa"]);
    }

    public function mahasiswaInputView()
    {
        return view('user_data.mahasiswa.input', ["title" => "Mahasiswa"]);
    }

    public function bap()
    {
        return view('user_data.bap', ["title" => "BAP"]);
    }

    public function amplop()
    {
        return view('user_data.amplop', ["title" => "Amplop"]);
    }

    public function berkas()
    {
        return view('user_data.berkas', ["title" => "Berkas"]);
    }
}
