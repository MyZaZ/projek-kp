<?php

namespace App\Models;

use App\Traits\HasFormatrupiah;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


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
    switch ($this->status) {
        case 'lunas':
            $buttonClass = 'badge bg-label-success me-1';
            $statusText = 'Sudah dibayar';
            break;
        case 'angsur':
            $buttonClass = 'badge bg-label-warning me-1';
            $statusText = 'Angsur';
            break;
        case 'baru':
            $buttonClass = 'badge bg-label-danger me-1';
            $statusText = 'Belum dibayar';
            break;
        default:
            $buttonClass = 'btn-secondary'; // Or any other color you want for default case
            $statusText = $this->status;
    }

    return [
        'buttonClass' => $buttonClass,
        'statusText' => $statusText
    ];
}

    
    public function scopeWaliSiswa($q)
    {
    return $q->whereIn('siswa_id', Auth::user()->siswa->pluck('id'));
    }
    


}
