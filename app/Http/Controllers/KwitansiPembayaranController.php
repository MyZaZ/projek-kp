<?php

namespace App\Http\Controllers;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class KwitansiPembayaranController extends Controller
{
    public function show($id)
    {   
        
        $pembayaran = Pembayaran::findOrFail($id);
        
        $tagihan = $pembayaran->first()->tagihan;
        $siswa = $tagihan->first()->SISWA;
        return view('operator.kwitansi_pembayaran_index',[
            'pembayaran' => $pembayaran,
            'siswa' => $siswa
        ]);
    }
}
