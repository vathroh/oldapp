<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class personnel_evaluation_value extends Model
{
    protected $fillable = ['settingId', 'userId', 'team', 'content', 'issue', 'recommendation'];
}
