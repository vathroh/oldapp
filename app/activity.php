<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class activity extends Model
{
    protected $fillable = ['name', 'category_id', 'start_date', 'finish_date', 'break', 'updated_at', 'created_at', 'zoom_link', 'methods', 'record_link'];

    public function attendanceRecords()
    {
        return $this->hasMany('App\attendance_record');
    }

    public function participants()
    {
        return $this->hasMany('App\activity_participant');
    }

    public function category()
    {
        return $this->belongsTo('App\activities_category');
    }

    public function subjects()
    {
        return $this->hasMany('App\subject');
    }

    public function evaluation()
    {
        return $this->hasMany('App\evaluation');
    }

    public function trainingEvaluation()
    {
        return $this->hasMany('App\evaluation_question');
    }

    public function quiz()
    {
        return $this->hasMany('App\evaluation_question');
    }

    public function certificate()
    {
        return $this->hasOne('App\certificate');
    }
}
