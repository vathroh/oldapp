<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class activities_category extends Model
{
    protected $fillable = ['name', 'category_id', 'updated_at', 'created_at'];
}
