<?php

namespace App\Models;

use App\Traits\HasFormatrupiah;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;
    use HasFormatrupiah;

    protected $guarded = [];
    protected $dates = ['tanggal_tagihan'];
    protected $with = ['user','siswa','tagihanDetails'];

    protected $casts = [
        'tanggal_tagihan' => 'date:Y-m-d',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
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

    public function tagihanDetails(): Hasmany 

    {
        return $this->hasMany(tagihanDetail::class);
    }

    /**
     * Get all of the comments for the Tagihan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pembayaran(): HasMany
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function getStatusTagihanWali()
    {
        if($this->status == 'baru'){
            return 'Belum dibayar';
        }
        if($this->status == 'lunas'){
            return 'Sudah dibayar';
        
        }
            return $this->status;
    }
}
