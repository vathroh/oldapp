<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class infrastruktures_maintenance extends Model
{
    protected $fillable = ['kelurahan_id', 'tanggal_mulai', 'tanggal_selesai', 'sumber_dana', 'jumlah', 'foto_sebelum_perbaikan', 'foto_perbaikan', 'foto_sesudah_perbaikan', 'inputby_id', 'editby_id'];
}
