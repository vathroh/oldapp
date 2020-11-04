<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class personnel_evaluation_aspect extends Model
{
    protected $fillable = ['criteria_id', 'aspect', 'evaluate_to'];
}
