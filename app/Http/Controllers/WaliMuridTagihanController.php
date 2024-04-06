<?php

namespace App\Http\Controllers;
use App\Models\Tagihan;
use App\Models\PembayaranRekening;
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

    public function show($id)
    {
        $tagihan = Tagihan::find($id);
        $bankSekolah = PembayaranRekening::all();
        $siswa = $tagihan->siswa; // Dapatkan data siswa yang terkait dengan tagihan
        return view('wali.tagihan_show', compact('tagihan', 'siswa','bankSekolah'));
    }
    
}
