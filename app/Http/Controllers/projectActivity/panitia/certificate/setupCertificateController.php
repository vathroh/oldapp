<?php

namespace App\Http\Controllers\projectActivity\panitia\certificate;

use App\activity;
use App\certificate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class setupCertificateController extends Controller
{
    public function index()
    {
        $activities = activity::where('category_id', 1)->orderBy('id', 'desc')->get();
        return view('activities.certificate.setup.index', compact(['activities']));
    }

    public function create()
    {
        $activities = activity::where('category_id', 1)->orderBy('id', 'desc')->get();
        return view('activities.certificate.setup.create', compact(['activities']));
    }


    public function store(Request $request)
    {
        certificate::create([
            'activity_id' => $request->activity_id,
            'release_date' => "2025-03-09",
            'background' => "SERTIFIKAT_BLANKO.png",
            'name' => 'a:2:{s:9:"font-size";s:2:"34";s:10:"margin-top";s:2:"64";}',
            'as' => 'a:2:{s:9:"font-size";s:2:"24";s:10:"margin-top";s:2:"75";}',
            'activity' => 'a:3:{s:4:"text";a:3:{i:1;s:16:"PELATIHAN ONLINE";i:2;s:49:"PENGUATAN KELOMPOK PEMANFAAT DAN PEMELIHARA (KPP)";i:3;s:39:"KEPADA ASKOT BIDANG DAN TIM FASILITATOR";}s:9:"font-size";s:2:"24";s:10:"margin-top";s:2:"85";}',
            'kotaku' => 'a:3:{s:4:"text";a:2:{i:0;s:38:"NATIONAL SLUM UPGRADING PROGRAM (NSUP)";i:1;s:33:"PROGRAM KOTA TANPA KUMUH (KOTAKU)";}s:9:"font-size";s:2:"22";s:10:"margin-top";s:3:"107";}',
            'tanggal' => 'a:3:{s:4:"text";a:2:{i:0;s:33:"YANG DISELENGGARAKAN PADA TANGGAL";i:1;s:22:"12 - 15 September 2020";}s:9:"font-size";s:2:"18";s:10:"margin-top";s:3:"120";}',
            'city' => 'a:3:{s:4:"text";a:2:{i:0;s:27:"Semarang, 15 September 2020";i:1;N;}s:9:"font-size";s:2:"16";s:10:"margin-top";s:3:"136";}',
            'osp' => 'a:3:{s:4:"text";a:2:{i:0;s:49:"Oversight Service Provider (OSP) 1  Jawa Tengah 1";i:1;N;}s:9:"font-size";s:2:"14";s:10:"margin-top";s:3:"142";}',
            'signedBy' => 'a:2:{s:9:"font-size";s:2:"14";s:10:"margin-top";s:3:"166";}'
        ]);

        return redirect('/kegiatan/panitia/setup/sertifikat/');
    }


    public function destroy($id)
    {
        certificate::find($id)->delete();
        return redirect('/kegiatan/panitia/setup/sertifikat/');
    }


    public function edit($id)
    {
        $certificates = certificate::find($id);
        return view('activities.certificate.setup.show2', compact('certificates'));
    }

    public function name(Request $request, $id)
    {
        certificate::find($id)->update([
            'name' => serialize($request->name)
        ]);

        return redirect('/kegiatan/panitia/setup/sertifikat/' . $id . '/edit');
    }

    public function as(Request $request, $id)
    {
        certificate::find($id)->update([
            'as' => serialize($request->as)
        ]);
        return redirect('/kegiatan/panitia/setup/sertifikat/' . $id . '/edit');
    }

    public function activity(Request $request, $id)
    {
        certificate::find($id)->update([
            'activity' => serialize($request->activity)
        ]);
        return redirect('/kegiatan/panitia/setup/sertifikat/' . $id . '/edit');
    }

    public function kotaku(Request $request, $id)
    {
        certificate::find($id)->update([
            'kotaku' => serialize($request->kotaku)
        ]);
        return redirect('/kegiatan/panitia/setup/sertifikat/' . $id . '/edit');
    }

    public function tanggal(Request $request, $id)
    {
        certificate::find($id)->update([
            'tanggal' => serialize($request->tanggal)
        ]);
        return redirect('/kegiatan/panitia/setup/sertifikat/' . $id . '/edit');
    }

    public function osp(Request $request, $id)
    {
        certificate::find($id)->update([
            'osp' => serialize($request->osp)
        ]);
        return redirect('/kegiatan/panitia/setup/sertifikat/' . $id . '/edit');
    }

    public function city(Request $request, $id)
    {
        certificate::find($id)->update([
            'city' => serialize($request->city)
        ]);
        return redirect('/kegiatan/panitia/setup/sertifikat/' . $id . '/edit');
    }

    public function signedBy(Request $request, $id)
    {
        certificate::find($id)->update([
            'signedBy' => serialize($request->signedBy)
        ]);
        return redirect('/kegiatan/panitia/setup/sertifikat/' . $id . '/edit');
    }

    public function release_date(Request $request, $id)
    {
	certificate::find($id)->update([
		'release_date' => $request->release_date	
	]);
        return redirect('/kegiatan/panitia/setup/sertifikat/' . $id . '/edit');
    }

    public function blanko(Request $request, $id)
    {
	certificate::find($id)->update([
		'background' => $request->blanko	
	]);
        return redirect('/kegiatan/panitia/setup/sertifikat/' . $id . '/edit');
    }
}
