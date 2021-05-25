<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scopes\jobDescScope;

class work_zone extends Model
{
    protected $fillable = ['zone_level_id', 'zone_location_id', 'level', 'district', 'district_id', 'team', 'zone', 'year', 'allvillage_index_column'];

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
        return $this->hasOne('App\allvillage', 'KD_KAB', 'district');
    }

    public function district()
    {
        return $this->hasOne('App\kabupaten', 'district_id');
    }

    public function districts()
    {
        return $this->morphedByMany('App\kabupaten', 'work_zonable');
    }

    public function villages()
    {
        return $this->morphedByMany('App\allvillage', 'work_zonable');
    }

    public function zone_location()
    {
	    return $this->hasOne('App\zone_location','id', 'zone_location_id');
    }
}
