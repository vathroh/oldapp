<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class library extends Model
{
   protected $fillable = ['subject', 'description', 'category_id', 'link', 'file'];
}
