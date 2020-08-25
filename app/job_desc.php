<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class job_desc extends Model
{
    protected $fillable = ['user_id', 'work_zone_id', 'job_title_id', ];
}
