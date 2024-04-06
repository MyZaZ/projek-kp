<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\PembayaranRekening;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use App\Models\Bank;
use App\Models\WaliBank;
use Illuminate\Http\Request;

class WaliMuridPembayaranController extends Controller
{
    public function create(Request $request) 
    {
        $data['walibank'] = WaliBank::where('wali_id', Auth::user()->id)->get()->pluck('nama_bank_full', 'id');
        $data['tagihan'] = Tagihan::where('id', $request->tagihan_id)->first();
        $data['bankSekolah'] = PembayaranRekening::findOrFail($request->bank_sekolah_id);
        $data['model'] = new Pembayaran();
        $data['method'] = 'POST';
        $data['route'] = 'wali.pembayaran.store';
        $data['listBank'] = PembayaranRekening::pluck('nama_bank','id');
        $data['listBankWali'] = Bank::pluck('nama_bank','id');
        $data['url'] = route('wali.pembayaran.create'); // Ganti 'your.route.name' dengan nama rute yang sesuai
        if ($request->bank_sekolah_id != '') {
            $data['bankYangDipilih'] = PembayaranRekening::findOrFail($request->bank_sekolah_id);
        }
        return view('wali.pembayaran_form', $data);
    }
    
}
