<?php

namespace App;

use App\Scopes\jobDescScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphPivot;


class job_desc extends Model
//class job_desc extends MorphPivot
{
    protected $fillable = ['user_id', 'work_zone_id', 'job_title_id'];
    protected static function boot()

    {
        parent::boot();
        static::addGlobalScope(new jobDescScope);
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function areaKerja()
    {
        return $this->belongsTo('App\work_zone', 'work_zone_id');
    }

    public function posisi()
    {
        return $this->belongsTo('App\job_title', 'job_title_id');
    }

    public function yangDievaluasi()
    {
        return $this->belongsTo('App\personnel_evaluation_value', 'user_id', 'userId');
    }

    public function kabupaten()
    {
        return $this->hasManyThrough(
            'App\allvillage',
            'App\work_zone',
            'id',
            'KD_KAB',
            'work_zone_id',
            'district'
        );
    }

    public function evaluator()
    {
        return $this->hasMany(
            'App\personnel_evaluator',
            'evaluator',
            'job_title_id'
        );
    }
}
