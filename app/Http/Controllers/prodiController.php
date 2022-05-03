<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class prodiController extends Controller
{
    public function dashboard()
    {
        return view('prodi.dashboard', ["title" => env('APP_NAME')]);
    }

    public function ujianIndex()
    {
        return view('prodi.ujian.index', ["title" => env('APP_NAME')]);
    }

    public function ujianForm()
    {
        return view('prodi.ujian.form', ["title" => env('APP_NAME')]);
    }

    public function ujianEdit()
    {
        return view('prodi.ujian.edit', ["title" => env('APP_NAME')]);
    }

    public function pengawasList()
    {
        return view('prodi.daftar_pengawas', ["title" => env('APP_NAME')]);
    }

    public function penugasanIndex()
    {
        return view('prodi.penugasan.index', ["title" => env('APP_NAME')]);
    }

    public function penugasanForm()
    {
        return view('prodi.penugasan.form', ["title" => env('APP_NAME')]);
    }

    public function penugasanEdit()
    {
        return view('prodi.penugasan.edit', ["title" => env('APP_NAME')]);
    }

    public function berkas()
    {
        return view('prodi.berkas', ["title" => env('APP_NAME')]);
    }

    public function pelanggaran()
    {
        return view('prodi.pelanggaran', ["title" => env('APP_NAME')]);
    }
}
