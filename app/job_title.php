<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class job_title extends Model
{
    public function user()
    {
        return $this->hasManyThrough(
            'App\User',
            'App\job_desc',
            'job_title_id',
            'id',
            'id',
            'user_id'

        );
    }

    public function evaluationSetting()
    {
        return $this->hasMany('App\personnel_evaluation_setting', 'jobTitleId');
    }

    public function jobDesc()
    {
        return $this->hasMany('App\job_desc');
    }
    
    public function zone_level()
    {
		return $this->belongsTo('App\zone_level');
	}
}
