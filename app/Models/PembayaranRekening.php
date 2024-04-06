<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class PembayaranRekening extends Model
{
    use HasFactory;
    use SearchableTrait;
    
    protected $table = 'pembayaran_rekenings';

    protected $searchable = [
        'columns' => [
            'nama_bank' => 10,
            'nomor_rekening' => 10,
            'atas_nama' => 10,
        ],
    ];

    protected $fillable = [
        'nama_bank',
        'nomor_rekening',
        'atas_nama',
        // Tambahkan field lain yang ingin Anda masukkan ke dalam fillable di sini
    ];

    public function user()
    {
        // Mengasumsikan ada foreign key bernama user_id dalam tabel PembayaranRekening
        return $this->belongsTo(User::class); // Pastikan penulisan 'User' di sini diawali huruf besar
    }
}
