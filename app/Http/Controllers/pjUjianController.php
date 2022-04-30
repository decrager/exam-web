<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class pjUjianController extends Controller
{
    public function dashboard()
    {
        return view('pj_ujian.dashboard', ["title" => "Beranda"]);
    }
}
