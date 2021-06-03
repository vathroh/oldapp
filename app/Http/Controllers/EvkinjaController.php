<?php

namespace App\Http\Controllers;

use App\job_desc;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\personnel_evaluator;
use App\personnel_evaluation_value;
use App\personnel_evaluation_setting;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TimeController;

class EvkinjaController extends Controller
{

    public function users(){
        return new UserController;
    }


    public function zone(){
        return new ZoneController;
    }


    public function users_now(){
        return $this->users()->users_at(2, (3*$this->this_quarter()), $this->this_year());
    }


    public function user_now($user_id){
        return $this->users_now()->where('user_id', $user_id)->first();
    }


    public function time(){
        return new TimeController;
    }


    public function this_quarter(){
        $q = $this->time()->this_quarter();
        $month = $this->time()->this_month();

        if($month % 3 > 0)
        {
            $quarter = $q-1;
        }else{
            $quarter = $q;
        }

        if($quarter == 0)
        {
            return 4;
        }

        return $quarter;
    }


    public function this_year(){
        $month = $this->time()->this_month();
        $year = $this->time()->this_year();

        if($month < 3)
        {
            $year = $year-1;
        }

        return $year;
    }


    public function all_setting_now(){
        return personnel_evaluation_setting::where('quarter' ,$this->this_quarter())->where('year', $this->this_year())->get();
    }


    public function all_setting_at($quarter, $year){
        return personnel_evaluation_setting::where('quarter' ,$quarter)->where('year', $year)->get();
    }


    public function setting_by_job_title_now($jobTitleId){
        return $this->all_setting_now()->where('jobTitleId', $jobTitleId);
    }


    public function setting_by_job_title_at($jobTitleId, $quarter, $year){
        return $this->all_setting_at($quarter, $year)->where('jobTitleId', $jobTitleId);
    }


    public function my_setting_now($jobTitleId, $zoneLocationId){
        return $this->all_setting_now()->where('jobTitleId', $jobTitleId, )->where('zone_location_id', $zoneLocationId)->first();
    }


    public function my_setting_at($jobTitleId, $zoneLocationId, $quarter, $year){
        return $this->all_setting_at($quarter, $year)->where('jobTitleId', $jobTitleId, )->where('zone_location_id', $zoneLocationId)->first();
    }


    public function all_being_assessed_users_at($quarter, $year){
        $jobTitleIds = $this->all_setting_at($quarter, $year)->pluck('jobTitleId');
        $users = $this->users()->users_at(2, (3*$quarter), $year);
        
        return $users->whereIn('job_title_id', $jobTitleIds);
    }


    public function being_assessed_users_by_job_title_at($jobTitleId, $quarter, $year)
    {
        return $this->all_being_assessed_users_at($quarter, $year)->where('job_title_id', $jobTitleId);
    }


    public function all_being_assessed_users_now()
    {
        $jobTitleIds = $this->all_setting_now()->pluck('jobTitleId');
        $users = $this->users_now();
        
        return $users->whereIn('job_title_id', $jobTitleIds);
    }


    public function being_assessed_users_by_job_title_now($jobTitleId)
    {
        return $this->all_being_assessed_users_now()->where('job_title_id', $jobTitleId);
    }


    public function is_being_assessed_at($user_id, $quarter, $year)
    {
        $jobTitleId =  $this->user_now($user_id)['job_title_id'];
        $zoneLocationId = $this->user_now($user_id)['location_id'];

        if($this->my_setting_at($jobTitleId, $zoneLocationId, $quarter, $year) ){
            $response = ['is_being_assessed_now' => true];
        }else{
            $response = ['is_being_assessed_now' => false];
        }

        return $response;
    }


    public function is_being_assessed_now($user_id, $quarter, $year)
    {
        $jobTitleId =  $this->user_now($user_id)['job_title_id'];
        $zoneLocationId = $this->user_now($user_id)['location_id'];

        if($this->my_setting_now($jobTitleId, $zoneLocationId) ){
            $response = ['is_being_assessed_now' => true];
        }else{
            $response = ['is_being_assessed_now' => false];
        }

        return $response;
    }

    public function assessors(){
        $array = array_unique(personnel_evaluator::pluck('evaluator')->toArray());
        $assessor_id = array_values(Arr::sort(Arr::flatten($array)));

        return $this->users()->users_at(2, (3*$this->this_quarter()), $this->this_year())->whereIn('job_title_id', $assessor_id); 
    }


    public function is_assessor($user_id){

        $assessors =  personnel_evaluator::where('evaluator', $this->user_now($user_id)['job_title_id'])->get();

        if($assessors->count()){
            $response = true;
        }else{
            $response = false;
        }

        return $response;
    }


    public function all_values_now()
    {
        $settingIds = $this->all_setting_now()->pluck('id');
        return personnel_evaluation_value::whereIn('settingId', $settingIds)->get();
    }


    public function all_values_at($quarter, $year)
    {
        $settingIds = $this->all_setting_at($quarter, $year)->pluck('id');
        return personnel_evaluation_value::whereIn('settingId', $settingIds)->get();
    }


    public function values_by_job_title_now($jobTitleId){
        $settingIds = $this->setting_by_job_title_now($jobTitleId)->pluck('id');
        return $this->all_values_now()->whereIn('settingId', $settingIds);
    }


    public function values_by_job_title_at($jobTitleId, $quarter, $year){
        $settingIds = $this->setting_by_job_title_at($jobTitleId, $quarter, $year)->pluck('id');
        return $this->all_values_at($quarter, $year)->whereIn('settingId', $settingIds);
    }       


    public function my_value_now($user_id){
        return $this->all_values_now()->where('userId', $user_id)->first();
    }


    public function being_assessed_by_me($user_id)
    {
        $myZoneDistricts = $this->zone()->my_zone_now($user_id)['wilayah']->pluck('kode_kab');
        $jobTitleId = $this->users()->user_now($user_id)['job_title_id'];
        $jobTitleIdAssessedByMe = personnel_evaluator::where('evaluator', $jobTitleId)->pluck('jobId');

        return $this->users()->users_at(2, (3*$this->this_quarter()), $this->this_year())->whereIn('job_title_id', $jobTitleIdAssessedByMe)->whereIn('kode_kab', $myZoneDistricts);
    }

    public function test()
    {
        return $this->is_assessor(50);
    }
}
