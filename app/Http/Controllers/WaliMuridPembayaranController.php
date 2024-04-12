<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;
use App\Models\PembayaranRekening;
use App\Notifications\PembayaranNotification;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use App\Models\Bank;
use App\Models\WaliBank;
use App\Models\User;
use Carbon\Carbon;
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
    if($request->wali_bank_id == '' && $request->nomor_rekening_pengirim == ''){
        flash('silahkan pilih bank pengirim')->error();
        return back();
    }
    
    if($request->nama_rekening_pengirim !='' && $request->nomor_rekening_pengirim !='') {
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
        $waliBank = WaliBank::findOrFail($waliBankId);
        
    }

    $jumlahDibayar = str_replace('.', '', $request->jumlah_dibayar);
 
    // Mencari pembayaran terakhir dengan nominal yang sama
    $pembayaranTerakhir = Pembayaran::where('jumlah_dibayar', $jumlahDibayar)
    ->where('tagihan_id', $request->tagihan_id)
    ->latest('created_at')
    ->first();

    if ($pembayaranTerakhir) {
    // Menghitung waktu antara pembayaran terakhir dan pembayaran saat ini
    $waktuTerakhir = Carbon::parse($pembayaranTerakhir->created_at);
    $waktuSekarang = Carbon::now();
    $perbedaanWaktu = $waktuTerakhir->diffInMinutes($waktuSekarang);

    // Batas waktu antara pembayaran yang sama (misalnya, 5 menit)
    $batasWaktu = 5;

    if ($perbedaanWaktu < $batasWaktu) {
        $sisaWaktu = $batasWaktu - $perbedaanWaktu;
        $pesan = "Data Pembayaran ini sudah ada, dan akan segera dikonfirmasi oleh Operator. Untuk melakukan pembayaran dengan nominal yang sama, mohon tunggu selama $sisaWaktu menit.";
        flash($pesan);
        return back();
    }
    }

    $request->validate([
        'tanggal_bayar' => 'required',
        'jumlah_dibayar' => 'required',
        'bukti_bayar' => 'required|image:jpeg,png,jpg,gif,svg|max:5000',
    ]);
    $buktiBayar = $request->file('bukti_bayar')->store('public');
    $dataPembayaran = [
        'bank_id' => $request->bank_id,
        'wali_bank_id' => $waliBank->id,
        'tagihan_id' => $request->tagihan_id,
        'wali_id' => auth()->user()->id,
        'tanggal_bayar' => $request->tanggal_bayar,
        //'status_konfirmasi' => 'belum',
        'jumlah_dibayar' => $jumlahDibayar,
        'bukti_bayar' => $buktiBayar,
        'metode_pembayaran' => 'transfer',
        'user_id' => 0,
    ];
    DB::beginTransaction ();
    try {
            $pembayaran = Pembayaran::create($dataPembayaran);
            $userOperator = User::where('akses','operator')->get();
            DB::commit();
    } catch (\Throwable $th) {
            DB::rollback();
            flash('Gagal Menyimpan data pembayaran,' + $th->getMessage)->error();
            return back();
    }
    
    Notification::send($userOperator, new PembayaranNotification($pembayaran));
    flash('Pembayaran berhasil disimpan dan akan segera di konfirmasi oleh operator.')->success();
    return back();
}

    
}
