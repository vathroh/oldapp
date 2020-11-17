<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class job_desc extends Model
{
    protected $fillable = ['user_id', 'work_zone_id', 'job_title_id'];

 	public function Users()
	{
    	return $this->hasOne('App\Users');
	}   

    public function jobTitle()
    {
        return $this->belongsTo('App/job_title', 'id');
    }
}
