<?php

namespace App\Http\Controllers;
use App\Models\PembayaranRekening;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class WaliMuridPembayaranController extends Controller
{
    public function create(Request  $request) 
    {
        $data['tagihan'] = Tagihan::where('id', $request->tagihan_id)->first();
        $data['bankSekolah'] = PembayaranRekening::findOrFail($request->bank_sekolah_id);
        $data['model'] = new Pembayaran();
        $data['method'] = 'POST';
        $data['route'] = 'wali.pembayaran.store';
        $data['listBank'] = PembayaranRekening::pluck('nama_bank','id');
        if ($request->bank_sekolah_id != '') {
            $data['bankYangDipilih'] = PembayaranRekening::findOrFail($request->bank_sekolah_id);
        }
        return view('wali.pembayaran_form',$data);
    }
}
