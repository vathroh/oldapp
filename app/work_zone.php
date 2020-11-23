<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class work_zone extends Model
{
    protected $fillable =['level', 'district', 'team','zone', 'allvillage_index_column' ];

    public function jobDesc()
    {
        return $this->hasMany('App\job_desc', 'work_zone_id');
    }
}
