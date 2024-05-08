<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class BerandaWaliController extends Controller
{
    public function index()
{   
   $data = [
    'name' => Auth::user()->name
];

return view('wali.beranda_index', $data);
    
}

}
