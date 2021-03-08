<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kabupaten extends Model
{
    protected $table = 'kabupaten';

    public function work_zone()
    {
        return $this->morphToMany('App\work_zone', 'work_zonable');
    }
}
