<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class job_title extends Model
{
    public function user()
    {
        return $this->hasManyThrough(
            'App\User', 'App\job_desc',
            'job_title_id',
            'id',
            'id',
            'user_id'

        );
    }
    

}
