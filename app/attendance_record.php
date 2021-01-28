<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class attendance_record extends Model
{
    protected $fillable = ['user_id', 'activity_id', 'date'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function participants()
    {
        return $this->belongsToMany('App\activity_participant', 'user_id', 'user_id');
    }
}
