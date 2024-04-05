<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Tagihan;
use App\Http\Requests\StorePembayaranRequest;
use App\Http\Requests\UpdatePembayaranRequest;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $requestData['status_konfirmasi'] = 'sudah';
        $requestData['metode_pembayaran'] = 'manual';
        $tagihan = Tagihan::findOrFail($requestData['tagihan_id']);
        
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
        //
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
    public function update(UpdatePembayaranRequest $request, Pembayaran $pembayaran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pembayaran $pembayaran)
    {
        //
    }
}
