<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class data_pengecekan_fisik extends Model
{
    protected $fillable = ['kelurahan_id', 'tanggal', 'keterangan', 'foto_pengecekan_fisik', 'inputby_id', 'editby_id',];
}
