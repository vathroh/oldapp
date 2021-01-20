<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class personnel_evaluator extends Model
{
    protected $fillable = ['jobId', 'evaluator'];

    public function user()
    {
        return $this->hasManyThrough(
            'App\User',
            'App\job_desc',
            'job_title_id',
            'id',
            'jobId',
            'user_id'

        );
    }

    public function evaluatorsUser()
    {
        return $this->hasOneThrough(
            'App\User',
            'App\job_desc',
            'job_title_id',
            'id',
            'evaluator',
            'user_id'

        );
    }


    public function value()
    {
        return $this->hasManyThrough(
            'App\personnel_evaluation_value',
            'App\personnel_evaluation_setting',
            'jobTitleId',
            'settingId',
            'jobId',
            'id'
        );
    }

    public function setting()
    {
        return $this->hasMany('App\personnel_evaluation_setting', 'jobTitleId', 'jobId');
    }

    public function jabatanPenilai()
    {
        return $this->belongsTo('App\job_title', 'evaluator');
    }

    public function jabatanYangDinilai()
    {
        return $this->belongsTo('App\job_title', 'jobId');
    }

    public function personil()
    {
        return $this->hasOne('App\User', 'id', 'evaluator');
    }
}
