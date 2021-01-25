<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class evaluation extends Model
{
    protected $fillable = ['user_id', 'activity_id', 'subject_id', 'question_id', 'answer_id'];

    public function materi()
    {
        return $this->belongsTo('App\subject', 'subject_id');
    }
}
