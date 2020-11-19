<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class allvillage extends Model
{
    public function jobDesc()
    {
        return $this->hasManyThrough(
            'App\job_desc', 'App\work_zone',
            'district',
            'work_zone_id',
            'KD_KAB',
            'id'
        );
    } 





}
