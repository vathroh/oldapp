<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['kode_dokumen', 'nama_dokumen', 'link', 'file_size'];
}
