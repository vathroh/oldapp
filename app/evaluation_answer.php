<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class evaluation_answer extends Model
{
    protected $fillable = ['evaluation_question_id', 'answer', 'true_or_false', 'scale'];
}
