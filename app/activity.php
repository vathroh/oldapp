<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class activity extends Model
{
    protected $fillable = ['name', 'category_id', 'start_date', 'finish_date', 'updated_at', 'created_at'];

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
}
