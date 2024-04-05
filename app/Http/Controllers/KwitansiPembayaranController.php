<?php

namespace App\Http\Controllers;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class KwitansiPembayaranController extends Controller
{
    public function show($id)
{   
    // Mengambil pembayaran berdasarkan id
    $pembayaran = Pembayaran::findOrFail($id);
    
    // Mengambil tagihan_id dari pembayaran yang ditemukan
    $tagihan_id = $pembayaran->tagihan_id;
    
    // Menghitung total pembayaran berdasarkan tagihan_id
    $total_pembayaran = Pembayaran::where('tagihan_id', $tagihan_id)->sum('jumlah_dibayar');
    
    // Mengambil siswa yang terkait dengan tagihan
    $siswa = $pembayaran->tagihan->siswa;
    
    // Mengirim data ke view
    return view('operator.kwitansi_pembayaran_index', [
        'pembayaran' => $pembayaran,
        'total_pembayaran' => $total_pembayaran,
        'siswa' => $siswa
    ]);
}
}
