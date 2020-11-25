<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class activity_participant extends Model
{
    protected $fillable = ['activity_id', 'user_id', 'role'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
