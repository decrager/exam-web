<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Carbon\Carbon;

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
        return view('changepassword');
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

    public function requestReset(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        return $validate;

        $user = User::where('email', $request->email);
        $user->update([
            'password' => '$2a$12$73YbJpbhMa8vVwroP8Ke0ODNYu1jjlALYK1xzrXFGVDbIYEk1KhZK' 
        ]);

        // $token = \Str::random(64);
        // \DB::table('password_resets')->insert([
        //     'email' => $request->email,
        //     'token' => $token,
        //     'created_at' => Carbon::now()
        // ]);

        // $action_link = route('password.reset', ['token' => $token, 'email' => $request->email]);
        // $body = "Kami menerima permintaan untuk mereset password anda untuk <b>MINDY</b> dengan email " . $request->email . ". Anda bisa mereset password dengan mengklik link di bawah";
        // \Mail::send('email-forgot', ['action_link' => $action_link, 'body' => $body], function($message) use ($request){
        //     $message->from('noreply@apps.ipb.ac.id', 'MINDY');
        //     $message->to($request->email, 'Pengguna')->subject('Permintaan Reset Password');
        // });

        return view('login')->with('success', 'Kami telah mengubah password anda menjadi 1-8');
    }
}
