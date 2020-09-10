<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class post extends Model
{
    protected $fillable = [ 'slug', 'title', 'body', 'keyword', 'published', 'publish_date', 'user_id'];
}
