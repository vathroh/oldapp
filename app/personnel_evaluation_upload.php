<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class personnel_evaluation_upload extends Model
{
    protected $fillable = ['path', 'file_name', 'personnel_evaluation_value_id','personnel_evaluation_criteria_id','personnel_evaluation_aspect_id', 'google_folder', 'parent_folder'];

    public function evaluationValue()
    {
        return $this->belongsTo('App\personnel_evaluation_value', 'personnel_evaluation_value_id');
    }
    
    public function google()
    {
		return $this->hasOne('App\google_file', 'file_name', 'file_name');
	}
}
