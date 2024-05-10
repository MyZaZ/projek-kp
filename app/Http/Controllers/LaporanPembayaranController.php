<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Tagihan;
class LaporanPembayaranController extends Controller
{
    public function index(Request $request)
    {
        $pembayaran = Pembayaran::query();

        if ($request->filled('bulan')) {
            $pembayaran->whereMonth('tanggal_bayar', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $pembayaran->whereYear('tanggal_bayar', $request->tahun);
        }

        if ($request->filled('status_konfirmasi')) {
            if ($request->status_konfirmasi == 'sudah_dikonfirmasi') {
                $pembayaran->whereNotNull('tanggal_konfirmasi');
            } elseif ($request->status_konfirmasi == 'belum_dikonfirmasi') {
                $pembayaran->whereNull('tanggal_konfirmasi');
            }
        }

        if ($request->filled('jurusan')) {
            $pembayaran->whereHas('tagihan.siswa', function ($q) use ($request) {
                $q->where('jurusan', $request->jurusan);
            });
        }

        if ($request->filled('angkatan')) {
            $pembayaran->whereHas('tagihan.siswa', function ($q) use ($request) {
                $q->where('angkatan', $request->angkatan);
            });
        }

        $pembayaran = $pembayaran->get();

        return view('operator.laporanpembayaran_index', compact('pembayaran'));
    }
}
