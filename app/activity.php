<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class activity extends Model
{
    protected $fillable = ['name', 'category_id', 'start_date', 'finish_date', 'updated_at', 'created_at'];
}
