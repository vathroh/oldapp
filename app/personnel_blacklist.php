<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class personnel_blacklist extends Model
{
    public function users()
    {
        return $this->hasMany('App\User');
    }
}
