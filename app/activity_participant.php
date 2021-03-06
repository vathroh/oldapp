<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class activity_participant extends Model
{
    protected $fillable = ['activity_id', 'user_id', 'role'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function attendanceRecords()
    {
        return $this->hasMany('App\attendance_record', 'user_id');
    }

    public function activity()
    {
        return $this->belongsTo('App\activity');
    }
    
    public function job_desc()
    {
		return $this->hasOne('App\job_desc', 'user_id', 'user_id');
	}
}
