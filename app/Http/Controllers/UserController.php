<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
    }
    public function create()
    {
    }
    public function store(Request $request)
    {
    }
    public function show(User $user)
    {
    }
    public function edit(User $user)
    {
    }
    public function update(Request $request, User $user)
    {
    }
    public function destroy(User $user)
    {
    }
    public function login()
    {
        return view('pages.admin');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect("/");
    }
    public function authenticate(Request $request){
        $ceredentials = $request->validate([
            "username"=>'required',
            "password"=>'required',
        ]);
        if(Auth::attempt($ceredentials)){
            $request->session()->regenerate();
            return redirect()->intended('/donation');
        }
        return back()->withErrors(["error"=>'gagal']);
    }
}
