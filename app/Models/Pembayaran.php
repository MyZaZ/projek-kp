<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $dates = ['tanggal_bayar'];
    protected $with = ['user','tagihan'];
    protected $append = ['status_konfirmasi'];

    public function getStatusKonfirmasiAttribute()
    {
        return $this->attributes['tanggal_konfirmasi'] == null ? 'Belum Dikonfirmasi' : 'Sudah Dikonfirmasi';
    }
    /**
     * Get the user that owns the Pembayaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tagihan(): BelongsTo
    {
        return $this->belongsTo(Tagihan::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::creating(function ($tagihan) {
            $tagihan->user_id = auth()->user()->id;
        });

        static::updating(function ($tagihan) {
            $tagihan->user_id = auth()->user()->id;
        });
    }
    public function wali(): BelongsTo
    {
        return $this->belongsTo(User::class, 'wali_id');
    }

    /**
     * Get the user that owns the Pembayaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function PembayaranRekening(): BelongsTo
    {
        return $this->belongsTo(PembayaranRekening::class, 'bank_id');
    }

    /**
     * Get the user that owns the Pembayaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function WaliBank(): BelongsTo
    {
        return $this->belongsTo(WaliBank::class);
    }
    
}



