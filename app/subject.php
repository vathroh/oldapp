<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class subject extends Model
{
    protected $fillable =['activity_id', 'subject', 'date', 'start_time', 'finish_time', 'library_id', 'evaluation_sheet', 'instructor1_id', 'instructor2_id', 'add_info'];
}
