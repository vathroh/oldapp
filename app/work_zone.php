<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class work_zone extends Model
{
    protected $fillable = ['level', 'district', 'team', 'zone', 'allvillage_index_column'];

    public function jobDesc()
    {
        return $this->hasMany('App\job_desc', 'work_zone_id');
    }

    public function user()
    {
        return $this->hasManyThrough(
            'App\User',
            'App\job_desc',
            'work_zone_id',
            'id',
            'id',
            'user_id'
        );
    }

    public function kabupaten()
    {
        return $this->hasOne('App\allvillage', 'KD_KAB');
    }
}
