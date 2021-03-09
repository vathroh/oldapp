<?php

namespace App\Http\Controllers\Admin;

use App\allvillage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\kabupaten;
use App\work_zone;

class workZoneController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $workZones = work_zone::orderBy('year', 'desc')->paginate(10);
        return view('admin.workZone.index', compact('workZones'));
    }


    public function create()
    {
        $districts = kabupaten::all();
        return view('admin.workZone.create', compact(['districts']));
    }

    public function edit($id)
    {
        $districts = kabupaten::all();
        $workZone = work_zone::find($id);
        return view('admin.workZone.edit', compact(['districts', 'workZone']));
    }


    public function show($id)
    {
        $workZone = work_zone::find($id);
        return view('admin.workZone.show', compact('workZone'));
    }


    public function store(Request $request)
    {
        $district = kabupaten::find($request->district)->kode_kab;

        if ($request->level == "Tim Faskel" || $request->level == "Kelurahan") {
            $zones = [];
            foreach ($request->zones as $key => $zone) {
                $zones[$key] = allvillage::find($zone)->KD_KEL;
            }
            $zonesimplode = implode(', ', $zones);
        } else {
            $zones = [];
            foreach ($request->zones as $key => $zone) {
                $zones[$key] = kabupaten::find($zone)->kode_kab;
            }
            $zonesimplode = implode(', ', $zones);
        }

        $workzone = work_zone::create([
            'team' => $request->team,
            'level' => $request->level,
            'district' => $district,
            'district_id' => $request->district,
            'year' => $request->year,
            'zone' => $zonesimplode,
            'allvillage_index_column' => $request->index
        ]);

        if ($request->level == "Tim Faskel" || $request->level == "Kelurahan") {
            $workzone->villages()->sync($request->zones);
        } else {
            $workzone->districts()->sync($request->zones);
        }

        return redirect("/admin/areakerja");
    }


    public function update(Request $request, $id)
    {
        $workzone = work_zone::find($id);

        $workzone->update([
            'team' => $request->team
        ]);

        if ($request->level == "Tim Faskel" || $request->level == "Kelurahan") {
            $workzone->villages()->sync($request->zones);
        } else {
            $workzone->districts()->sync($request->zones);
        }
        return redirect("/admin/areakerja");
    }


    public function destroy($id)
    {
        work_zone::find($id)->delete();
        return redirect("/admin/areakerja");
    }


    public function ajaxKabupaten()
    {
        $districts = kabupaten::all();
        return response()->json($districts);
    }


    public function ajaxKecamatan(Request $request)
    {
        $district_id = kabupaten::find($request->kode_kab)->kode_kab;
        $subdistricts = allvillage::distinct('KD_KEC')->where('KD_KAB', $district_id)->select('KD_KEC', 'NAMA_KEC')->get();
        return response()->json($subdistricts);
    }


    public function ajaxKelurahan(Request $request)
    {
        $villages = allvillage::distinct('KD_KEC')->where('KD_KEC', $request->kode_kec)->get();
        return response()->json($villages);
    }
}
