<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class evaluation extends Model
{
    protected $fillable = ['user_id', 'activity_id', 'subject_id', 'question_id', 'answer_id'];
}
