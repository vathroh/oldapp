<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pengurus_kpp extends Model
{
    protected $fillable = [
        'kelurahan_id', 'ketua_kpp', 'ketua_kpp_hp', 'sekretaris_kpp',  'sekretaris_kpp_hp', 'bendahara_kpp', 'bendahara_kpp_hp',
    ];
}
