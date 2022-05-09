<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class pjUjianController extends Controller
{
    public function dashboard()
    {
        return view('pj_ujian.dashboard', ["title" => env('APP_NAME')]);
    }

    public function ujianIndex()
    {
        return view('pj_ujian.ujian.index', ["title" => env('APP_NAME')]);
    }

    public function ujianForm()
    {
        return view('pj_ujian.ujian.form', ["title" => env('APP_NAME')]);
    }

    public function ujianEdit()
    {
        return view('pj_ujian.ujian.edit', ["title" => env('APP_NAME')]);
    }

    public function pengawasIndex()
    {
        return view('pj_ujian.pengawas.index', ["title" => env('APP_NAME')]);
    }

    public function pengawasEdit()
    {
        return view('pj_ujian.pengawas.edit', ["title" => env('APP_NAME')]);
    }

    public function penugasanIndex()
    {
        return view('pj_ujian.penugasan.index', ["title" => env('APP_NAME')]);
    }

    public function penugasanForm()
    {
        return view('pj_ujian.penugasan.form', ["title" => env('APP_NAME')]);
    }

    public function amplop()
    {
        return view('pj_ujian.amplop', ["title" => env('APP_NAME')]);
    }

    public function bap()
    {
        return view('pj_ujian.bap', ["title" => env('APP_NAME')]);
    }

    public function berkas()
    {
        return view('pj_ujian.berkas', ["title" => env('APP_NAME')]);
    }

    public function susulan()
    {
        return view('pj_ujian.susulan', ["title" => env('APP_NAME')]);
    }

    public function pelanggaran()
    {
        return view('pj_ujian.pelanggaran', ["title" => env('APP_NAME')]);
    }
}
