<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BerandaOperatorController extends Controller
{
    public function index()
{   
    $data = ['name' => Auth::user()->name];
    return view('operator.beranda_index', $data);
    
}

}