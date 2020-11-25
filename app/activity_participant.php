<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class activity_participant extends Model
{
    protected $fillable = ['activity_id', 'user_id', 'role'];

    public function user()
    {
        return $this->hasMany('App\User', 'user_id' );

    }

    public function attendanceRecords()
    {
        return $this->belongsToMany('App\attendance_record', 'user_id', 'user_id');
    }
}
