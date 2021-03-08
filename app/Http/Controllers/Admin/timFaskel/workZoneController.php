<?php

namespace App\Http\Controllers\Admin\timFaskel;

use App\allvillage;
use App\Http\Controllers\Controller;
use App\kabupaten;
use App\work_zone;
use Illuminate\Http\Request;

class workZoneController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $workZones = work_zone::where('level', 'Tim Faskel')->orWhere('zone_level_id', '4')->orderBy('year', 'desc')->paginate(10);
        return view('admin.workZone.tim_faskel.index', compact('workZones'));
    }


    public function show($id)
    {
        $workZone = work_zone::find($id);
        return view('admin.workZone.tim_faskel.show', compact('workZone'));
    }


    public function create()
    {
        $districts = kabupaten::all();
        return view('admin.workZone.tim_faskel.create', compact(['districts']));
    }


    public function edit($id)
    {
        $districts = kabupaten::all();
        $workZone = work_zone::find($id);
        $subdistricts = allvillage::where('KD_KAB', $workZone->district)->get();
        return view('admin.workZone.tim_faskel.edit', compact(['districts', 'workZone', 'subdistricts']));
    }


    public function store(Request $request)
    {
        $district = kabupaten::find($request->district)->kode_kab;

        $zones = [];
        foreach ($request->zones as $key => $zone) {
            $zones[$key] = allvillage::find($zone)->KD_KEL;
        }
        $zonesimplode = implode(', ', $zones);

        $workzone = work_zone::create([
            'team' => $request->team,
            'zone_level_id' => $request->zone_level_id,
            'level' => $request->level,
            'district' => $district,
            'district_id' => $request->district,
            'year' => $request->year,
            'zone' => $zonesimplode,
            'allvillage_index_column' => $request->index
        ]);
        $workzone->villages()->sync($request->zones);

        return redirect("/admin/areakerja/timfaskel");
    }


    public function update(Request $request, $id)
    {
        $workzone = work_zone::find($id);
        $district = kabupaten::find($request->district)->kode_kab;
        $zones = [];
        foreach ($request->zones as $key => $zone) {
            $zones[$key] = allvillage::find($zone)->KD_KEL;
        }
        $zonesimplode = implode(', ', $zones);
        $workzone->update([
            'team' => $request->team,
            'zone_level_id' => $request->zone_level_id,
            'level' => $request->level,
            'district' => $district,
            'district_id' => $request->district,
            'year' => $request->year,
            'zone' => $zonesimplode,
            'allvillage_index_column' => $request->index
        ]);

        $workzone->villages()->sync($request->zones);

        return redirect("/admin/areakerja/timfaskel");
    }
}
