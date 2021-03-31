<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class certificate extends Model
{
    protected $fillable = ['background', 'release_date', 'activity_id', 'name', 'as', 'activity', 'kotaku', 'tanggal', 'city', 'osp', 'signedBy'];

    public function activities()
    {
        return $this->belongsTo('App\activity', 'activity_id');
    }
}
