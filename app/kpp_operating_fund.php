<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kpp_operating_fund extends Model
{
    protected $fillable = [
        'kelurahan_id', 'tanggal', 'sumber_dana', 'jumlah', 'inputby_id', 'editby_id',
    ];
}
