<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kpp_pertemuan extends Model
{
        protected $fillable = [
        'kelurahan_id', 'tanggal', 'pokok_bahasan', 'keterangan', 'foto', 'inputby_id',
    ];
}
