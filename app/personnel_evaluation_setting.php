<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class personnel_evaluation_setting extends Model
{
    protected $fillable = ['quarter', 'year', 'zone_location_id', 'jobTitleId', 'evaluatorGroup', 'evaluator', 'status', 'isActive'];


    public function jobTitle()
    {
        return $this->belongsTo('App\job_title', 'jobTitleId')->orderBy('sort');
    }

    public function jobDesc()
    {
        return $this->hasManyThrough(
            'App\job_desc',
            'App\job_title',
            'id',
            'job_title_id',
            'jobTitleId',
            'id'
        );
    }

    public function assessor()
    {
        return $this->hasMany('App\personnel_evaluator', 'jobId', 'jobTitleId');
    }

    public function evaluationValue()
    {
        return $this->hasMany('App\personnel_evaluation_value', 'settingId');
    }

    public function location()
    {
        return $this->belongsTo('App\zone_location', 'zone_location_id');
    }
}
