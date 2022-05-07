<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class pjSusulanController extends Controller
{
    public function dashboard()
    {
        return view('pj_susulan.dashboard', ["title" => env('APP_NAME')]);
    }

    public function ketentuanIndex()
    {
        return view('pj_susulan.ketentuan.index', ["title" => env('APP_NAME')]);
    }

    public function ketentuanForm()
    {
        return view('pj_susulan.ketentuan.form', ["title" => env('APP_NAME')]);
    }

    public function ketentuanEdit()
    {
        return view('pj_susulan.ketentuan.edit', ["title" => env('APP_NAME')]);
    }
    
    public function mahasiswaIndex()
    {
        return view('pj_susulan.mahasiswa', ["title" => env('APP_NAME')]);
    }

    public function penjadwalanIndex()
    {
        return view('pj_susulan.penjadwalan.index', ["title" => env('APP_NAME')]);
    }

    public function penjadwalanForm()
    {
        return view('pj_susulan.penjadwalan.form', ["title" => env('APP_NAME')]);
    }

    public function jadwalIndex()
    {
        return view('pj_susulan.jadwal.index', ["title" => env('APP_NAME')]);
    }

    public function jadwalEdit()
    {
        return view('pj_susulan.jadwal.edit', ["title" => env('APP_NAME')]);
    }

    public function pelanggaran()
    {
        return view('pj_susulan.pelanggaran', ["title" => env('APP_NAME')]);
    }
}
