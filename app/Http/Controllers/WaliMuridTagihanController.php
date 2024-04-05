<?php

namespace App\Http\Controllers;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WaliMuridTagihanController extends Controller
{
    public function index()
    {
        $siswa = Auth::user()->siswa->pluck('id');
        $data['tagihan'] = Tagihan::whereIn('siswa_id', $siswa)->get();
        return view('wali.tagihan_index', $data);
    }
}
