<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Tagihan;
use App\Http\Requests\StorePembayaranRequest;
use App\Http\Requests\UpdatePembayaranRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $models = Pembayaran::latest();
        
        if ($request->filled('bulan') && $request->filled('tahun')) {
            $models->whereMonth('tanggal_konfirmasi', $request->bulan)
                ->whereYear('tanggal_konfirmasi', $request->tahun);
        }

        if ($request->filled('status_konfirmasi')) {
            if ($request->status_konfirmasi == 'sudah_dikonfirmasi') {
                $models->whereNotNull('tanggal_konfirmasi');
            } elseif ($request->status_konfirmasi == 'belum_dikonfirmasi') {
                $models->whereNull('tanggal_konfirmasi');
            }
        }

        $models = $models->paginate(50);

        return view('operator.pembayaran_index', ['models' => $models]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePembayaranRequest $request)
    {
        $requestData = $request->validated();
        //$requestData['status_konfirmasi'] = 'sudah';
        $requestData['tanggal_konfirmasi'] = now();
        $requestData['metode_pembayaran'] = 'manual';
        $tagihan = Tagihan::findOrFail($requestData['tagihan_id']);
        $requestData['wali_id'] = $tagihan->siswa->wali_id ?? 0;
        
        // Hitung total jumlah yang telah dibayar
        $total_dibayar = Pembayaran::where('tagihan_id', $requestData['tagihan_id'])->sum('jumlah_dibayar');
        
        // Hitung sisa tagihan setelah pembayaran
        $sisa_tagihan = $tagihan->tagihanDetails->sum('jumlah_biaya') - $total_dibayar;

        if ($requestData['jumlah_dibayar'] >= $sisa_tagihan) {
            // Jika jumlah yang dibayar lebih dari atau sama dengan sisa tagihan,
            // atur status tagihan menjadi 'lunas'
            $tagihan->status = 'lunas';
        } else {
            // Jika jumlah yang dibayar kurang dari sisa tagihan,
            // atur status tagihan menjadi 'angsur'
            $tagihan->status = 'angsur';
        }

        $tagihan->save();

        Pembayaran::create($requestData);

        flash('Pembayaran berhasil disimpan')->success();
        return back();
    }


    /**
     * Display the specified resource.
     */

    public function show(Pembayaran $pembayaran)
    {
        // Pastikan bahwa pengguna telah melakukan autentikasi sebelum melanjutkan
        if (Auth::check()) {
            // Menggunakan instance dari user yang sedang masuk
            $user = Auth::user();

            // Cek apakah notifikasi yang dimaksud dimiliki oleh pengguna yang sedang masuk
            $notification = $user->unreadNotifications()->where('id', request('id'))->first();

            // Periksa apakah notifikasi ditemukan
            if ($notification) {
                // Tandai notifikasi sebagai sudah dibaca
                $notification->markAsRead();
            }
        }

        // Setelah menandai notifikasi sebagai sudah dibaca, lanjutkan ke tampilan pembayaran
        return view('operator.pembayaran_show', [
            'model' => $pembayaran,
            'route' => ['pembayaran.update', $pembayaran->id]
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pembayaran $pembayaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pembayaran $pembayaran)
{
    //$pembayaran->status_konfirmasi = 'sudah';
    $pembayaran->tanggal_konfirmasi = now();
    $pembayaran->user_id = auth()->user()->id;
    $pembayaran->save();

    // Hitung total jumlah yang telah dibayar
    $total_dibayar = Pembayaran::where('tagihan_id', $pembayaran->tagihan_id)->sum('jumlah_dibayar');
    
    // Temukan tagihan yang sesuai dengan pembayaran
    $tagihan = Tagihan::findOrFail($pembayaran->tagihan_id);

    // Hitung total tagihan
    $total_tagihan = $tagihan->tagihanDetails->sum('jumlah_biaya');

    // Hitung sisa tagihan setelah pembayaran
    $sisa_tagihan = $total_tagihan - $total_dibayar;

    if ($sisa_tagihan <= 0) {
        // Jika sisa tagihan kurang dari atau sama dengan 0,
        // atur status tagihan menjadi 'lunas'
        $tagihan->status = 'lunas';
    } else {
        // Jika sisa tagihan lebih dari 0,
        // atur status tagihan menjadi 'angsur'
        $tagihan->status = 'angsur';
    }

    $tagihan->save();

    flash('Data Pembayaran Berhasil Di Konfirmasi')->success();
    return back();
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
{
    $pembayaran = Pembayaran::findOrFail($id);
    $pembayaran->delete();
    flash('Data pembayaran berhasil dihapus')->success();
    return back();
}
}
