<?php

namespace App\Http\Controllers\Admin\korkot;

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
        $workZones = work_zone::where('level', 'Korkot')->orWhere('zone_level_id', 2)->orderBy('year', 'desc')->paginate(10);
        return view('admin.workZone.korkot.index', compact('workZones'));
    }


    public function create()
    {
        $districts = kabupaten::all();
        return view('admin.workZone.korkot.create', compact(['districts']));
    }

    public function edit($id)
    {
        $districts = kabupaten::all();
        $workZone = work_zone::find($id);
        return view('admin.workZone.korkot.edit', compact(['districts', 'workZone']));
    }


    public function show($id)
    {
        $workZone = work_zone::find($id);
        return view('admin.workZone.korkot.show', compact('workZone'));
    }


    public function store(Request $request)
    {
        $district = kabupaten::find($request->district)->kode_kab;
        $zones = [];
        foreach ($request->zones as $key => $zone) {
            $zones[$key] = kabupaten::find($zone)->kode_kab;
        }
        $zonesimplode = implode(', ', $zones);

        $workzone = work_zone::create([
            'team' => $request->team,
            'level' => $request->level,
            'zone_level_id' => $request->zone_level_id,
            'district' => $district,
            'district_id' => $request->district,
            'year' => $request->year,
            'zone' => $zonesimplode,
            'allvillage_index_column' => $request->index
        ]);
        $workzone->districts()->sync($request->zones);
        return redirect('/admin/areakerja/korkot');
    }


    public function update(Request $request, $id)
    {
        $workzone = work_zone::find($id);
        $district = kabupaten::find($request->district)->kode_kab;
        $zones = [];
        foreach ($request->zones as $key => $zone) {
            $zones[$key] = kabupaten::find($zone)->kode_kab;
        }
        $zonesimplode = implode(', ', $zones);

        $workzone->update([
            'team' => $request->team,
            'level' => $request->level,
            'zone_level_id' => $request->zone_level_id,
            'district' => $district,
            'district_id' => $request->district,
            'year' => $request->year,
            'zone' => $zonesimplode,
            'allvillage_index_column' => $request->index
        ]);
        $workzone->districts()->sync($request->zones);
        return redirect('/admin/areakerja/korkot');
    }


    public function destroy($id)
    {
        work_zone::find($id)->delete();
        return redirect("/admin/areakerja/korkot");
    }
}
