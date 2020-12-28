<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class evaluation_question extends Model
{
    protected $fillable =['activity_id', 'for_all_subjects', 'question'];
}
