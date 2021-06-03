<?php

namespace App\Http\Controllers;

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use App\work_zone;

class ZoneController extends Controller
{
    public function personnels()
    {
        return new UserController;
    }

    public function zone($work_zone_id)
    {
        $workZone = work_zone::find($work_zone_id);
        $zone = [];

        if($workZone->level == "Korkot" || "Askot Mandiri"){
            $zone['wilayah'] = $workZone->districts;
        }elseif($workZone->level == "OSP"){
            $zone['wilayah'] = $workZone->districts;
        }elseif($workZone->level == "Tim Faskel"){
            $zone['wilayah'] = $workZone->villages;
        }

        return $zone;
    }

    public function my_zone_now($user_id)
    {
        $work_zone = work_zone::find($this->personnels()->user_now($user_id)['work_zone_id'] ?? null);

        if($work_zone != null){
            $work_zone_id = $work_zone->id;
            return $zone = $this->zone($work_zone_id);
        }else{
            return null;
        }

    }


    public function my_zone_at($user_id, $day, $month, $year)
    {
        $work_zone = work_zone::find($this->personnels()->user_at($user_id, $day, $month, $year)['work_zone_id'] ?? null);

        if($work_zone != null){
            $work_zone_id = $work_zone->id;
            return $zone = $this->zone($work_zone_id);
        }else{
            return null;
        }

    }


    public function my_sub_zone($user_id)
    {
        $kode_kabs = collect($this->my_zone_now($user_id)['wilayah'])->pluck('kode_kab');
        $workZones = work_zone::whereIn('district', $kode_kabs)->get();
        return $workZones;
    }

    public function this_year()
    {
        $year = \Carbon\carbon::now()->year;

        if(\Carbon\carbon::now()->month <= 3){
            $year = $year-1;
        }

        return $year;
    }


    public function test()
    {
        return $this->this_year();
    }
}
