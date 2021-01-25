<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class subject extends Model
{
    protected $fillable = ['activity_id', 'subject', 'date', 'start_time', 'finish_time', 'library_id', 'evaluation_sheet', 'instructor1_id', 'instructor2_id', 'add_info'];

    public function activity()
    {
        return $this->belongsTo('App\activity');
    }

    public function pemandu1()
    {
        return $this->belongsTo('App\User', 'instructor1_id');
    }

    public function pemandu2()
    {
        return $this->belongsTo('App\User', 'instructor2_id');
    }

    public function library()
    {
        return $this->hasOne('App\library', 'id', 'library_id');
    }

    public function evaluation()
    {
        return $this->hasMany('App\evaluation');
    }
}
