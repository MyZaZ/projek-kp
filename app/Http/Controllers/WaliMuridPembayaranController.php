<?php

namespace App\Http\Controllers;
use App\Models\PembayaranRekening;
use App\Models\Tagihan;
use Illuminate\Http\Request;

class WaliMuridPembayaranController extends Controller
{
    public function create(Request  $request) 
    {
        $tagihan = Tagihan::where('id', $request->tagihan_id)->first();
        $bankSekolah = PembayaranRekening::findOrFail($request->bank_sekolah_id);
        
    }
}
