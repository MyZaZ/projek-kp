<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\PembayaranRekening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WaliMuridTagihanController extends Controller
{
    public function index()
    {   $data = [
        'tagihan' => Tagihan::WaliSiswa()->get()
    ];
        return view('wali.tagihan_index', $data);
    }

    public function show($id)
    {
        $tagihan = Tagihan::WaliSiswa()->findOrFail($id);
        $bankSekolah = PembayaranRekening::all();
        $siswa = $tagihan->siswa;
        $wali = $siswa->wali;
        return view('wali.tagihan_show', compact('tagihan', 'siswa','bankSekolah','wali'));
    }
    
}
