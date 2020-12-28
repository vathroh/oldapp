<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class google_folder extends Model
{
    protected $fillable = ['kode_folder', 'parent_folder', 'id_folder', 'nama_folder', 'path_folder'];
}
