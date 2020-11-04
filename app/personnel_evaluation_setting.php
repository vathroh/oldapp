<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class personnel_evaluation_setting extends Model
{
    protected $fillable = ['quarter', 'year', 'jobTitleId', 'evaluatorGroup', 'evaluator', 'status'];
}
