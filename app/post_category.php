<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class post_category extends Model
{
    protected $fillable = ['post_id', 'category_id'];
}
