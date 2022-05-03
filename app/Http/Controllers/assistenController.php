<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class assistenController extends Controller
{
    public function dashboard()
    {
        return view('assisten.dashboard', ["title" => env('APP_NAME')]);
    }

    public function berkas()
    {
        return view('assisten.berkas', ["title" => env('APP_NAME')]);
    }

    public function pelanggaran()
    {
        return view('assisten.pelanggaran', ["title" => env('APP_NAME')]);
    }
}
