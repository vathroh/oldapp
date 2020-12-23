<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class google_file extends Model
{
    protected $fillable = ['file_id', 'folder_id', 'file_name'];
    public function evaluationFile()
    {
        return $this->belongsTo('App\personnel_evaluation_upload', 'file_name', 'file_name');
    }
}
