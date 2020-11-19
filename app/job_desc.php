<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphPivot;


class job_desc extends Model
//class job_desc extends MorphPivot
{
    protected $fillable = ['user_id', 'work_zone_id', 'job_title_id'];

	 	public function user()
		{
    		return $this->belongsTo('App\User');
		}   

    public function areaKerja()
    {
        return $this->belongsTo('App\work_zone');
    }

    public function posisi()
    {
        return $this->belongsTo('App\job_title', 'job_title_id');
    }

		public function kabupaten()
    {
        return $this->hasManyThrough(
            'App\allvillage', 'App\work_zone',
            'id',
            'KD_KAB',
            'work_zone_id',
            'district'
        );
		} 
}
