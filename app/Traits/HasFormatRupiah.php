<?php

namespace App\Traits;


trait HasFormatRupiah
{
    function formatRupiah($filled, $prefix = null)
    {
        $prefix = $prefix ? $prefix : 'Rp. ';
        $nominal = $this->attributes[$filled];
        return $prefix . number_format($nominal, 0, ',','.');
    }

}

?>