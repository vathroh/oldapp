<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class personnel_evaluation_value extends Model
{
    protected $fillable = ['settingId', 'userId', 'team', 'content', 'issue', 'recommendation'];

    public function user()
    {
       return $this->belongsTo('App\User', 'userId');
    }

    public function jobDesc()
    {
        return $this->belongsTo('App\job_desc', 'userId', 'user_id');
    }

    public function areaKerja()
    {
        return $this->hasManyThrough(
            'App\work_zone', 'App\job_desc',
            'user_id', // foreign key on job_desc 
            'id', //foreign key on work_zone 
            'userId', // local key on user 
            'work_zone_id' //localkey on  job_desc 
        );
    }

    public function evaluationSetting()
    {
       return $this->belongsTo('App\personnel_evaluation_setting', 'settingId'); 
    }

    public function evaluationUpload()
    {
        return $this->hasMany('App\personnel_evaluation_upload');
    } 
}
