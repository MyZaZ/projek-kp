<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Biaya extends Model
{
    use HasFactory;
    use SearchableTrait;
    protected $guarded = [];
    protected $searchable = [

        'columns' => [
            'nama' => 10,
            'jumlah' => 10,
        ],
    
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
