<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Symfony\Component\Console\Input\Input;

class AuthController extends Controller
{

    public function index()
    {
        return view('auth.login');
    }

    public function customLogin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/dashboard')
                ->withSuccess('Signed in');
        }

        // return redirect("login")->withSuccess('Login details are not valid');
        return Redirect::back()->withErrors(['msg' => 'Username/password yang dimasukkan salah']);
    }

    public function registration()
    {
        return view('auth.registration');
    }

    public function customRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
            'no_hp' => 'required',
        ]);


        $data = $request->all();
        // dd($data);
        $newUser = $this->create($data);

        auth()->login($newUser);

        // dd(Auth::user()->name);
        return redirect("/dashboard")->withSuccess('You have signed-in');
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'no_hp' => $data['no_hp'],
            'password' => Hash::make($data['password'])
        ]);
    }

    public function dashboard()
    {
        if (Auth::check()) {
            return view('dashboard');
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();

        return Redirect('/');
    }

    public function profile()
    {

        $user = User::find(Auth::user()->id);
        return view('profile', ['user' => $user]);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'password' => 'required|confirmed|min:6',
            // 'no_hp' => 'required',
        ]);

        $request->merge([
            'password' => Hash::make($request->password),
        ]);

        $user = User::find(Auth::user()->id);
        $user->fill($request->all())->save();

        return Redirect::back()->with(['message' => 'Berhasil meng-update data user']);
    }
}
