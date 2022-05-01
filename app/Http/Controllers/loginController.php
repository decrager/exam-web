<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Rules\MatchOldPassword;

class loginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $role = Auth::user()->role;
            return redirect()->intended('/'.$role);
        }

        return back()->with('loginError', 'Email atau Password salah');
        dd('Berhasil Login!');
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    }

    public function resetPassword()
    {
        return view('changepassword', ["title" => "Ubah Password"]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'oldPass' => ['required', new MatchOldPassword],
            'newPass' => ['required'],
            'confNewPass' => ['required', 'same:newPass'],
        ]);

        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->newPass)]);

        $role = Auth::user()->role;
        return redirect('/'.$role);
    }
}
