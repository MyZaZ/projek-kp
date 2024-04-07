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

    public function store(Request $request)
{
    if($request->filled('pilihan_bank')) {
        //wali membuat rekening baru
        $bankId = $request->bank_id_pengirim; // Ubah dari bank_id menjadi bank_id
        $namaRekeningPengirim = $request->nama_rekening_pengirim;
        $nomorRekeningPengirim = $request->nomor_rekening_pengirim;
        $bank = Bank::findOrFail($bankId);
        if($request->filled('simpan_data_rekening')){
            $requestDataBank = $request->validate([
                'nama_rekening_pengirim' => 'required',
                'nomor_rekening_pengirim' => 'required|numeric',
            ]);
            $waliBank = WaliBank::firstOrCreate(
                ['nomor_rekening' => $requestDataBank['nomor_rekening_pengirim'],
                'nama_rekening' => $requestDataBank['nama_rekening_pengirim'],
            ],
                [
                    'nama_rekening' => $requestDataBank['nama_rekening_pengirim'],
                    'wali_id'=>Auth::user()->id,
                    'kode' => $bank->sandi_bank,
                    'nama_bank' => $bank->nama_bank,
                ]
            );
        }
        
    } else {
        $waliBankId = $request->wali_bank_id;
        //wali memilih dri select
    }
    dd($waliBank);
}

    
}
