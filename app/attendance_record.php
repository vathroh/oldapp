<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class attendance_record extends Model
{
    protected $fillable = ['user_id', 'activity_id'];
}
