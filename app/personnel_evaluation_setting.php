<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class personnel_evaluation_setting extends Model
{
    protected $fillable = ['quarter', 'year', 'jobTitleId', 'evaluatorGroup', 'evaluator', 'status'];


    public function jobTitle()
    {
        return $this->belongsTo('App\job_title', 'jobTitleId');
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
}
