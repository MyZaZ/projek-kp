<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
{
    // Periksa peran atau akses pengguna yang sedang login
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->akses == 'operator') {
            // Jika pengguna adalah operator, arahkan ke 'operator.beranda'
            return redirect()->route('operator.beranda');
        } elseif ($user->akses == 'wali') {
            // Jika pengguna adalah wali, arahkan ke 'wali.beranda'
            return redirect()->route('wali.beranda');
        }
    }
    
    // Jika tidak ada informasi autentikasi atau peran yang cocok, arahkan ke beranda biasa
    return view('login');
}
}
