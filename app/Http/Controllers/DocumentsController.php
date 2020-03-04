<?php

namespace App\Http\Controllers;

use App\CustomFunctions\DocInfo;
use App\CustomFunctions\FolderInfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Document;
use App\google_folder;
use App\jenisDokumen;
use App\kabupaten;
use App\village;
use App\ksm;
use App\tahun;
use App\jenisfoto;
use App\kegiatanksm;

class DocumentsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documents = DB::table('documents')
            ->where('tipe_dokumen', 'IMAGE')
            ->orderByDesc('updated_at')
            ->paginate(9);
        $google_folders = google_folder::all();
        $kelurahan = village::all();
        return view('document.index', compact(['documents', 'kelurahan', 'google_folders']));
        // $documents1 = DB::table('documents')->where('tipe_dokumen', 'PDF')->count();
        // return $documents1;
    }

    public function table()
    {
        $documents = DB::table('documents')
            ->where('tipe_dokumen', 'PDF')
            ->orderByDesc('updated_at')
            ->paginate(12);
        $google_folders = google_folder::all();
        return view('document.table', compact(['documents', 'google_folders']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kabupaten = kabupaten::all();
        $villages = village::all();
        $tahun = tahun::all();
        return view('document.create', compact(['kabupaten', 'tahun']));
    }

    public function foto()
    {
        $kabupaten = kabupaten::all();
        $villages = village::all();
        $tahun = tahun::all();
        return view('document.foto', compact(['kabupaten', 'tahun']));
    }

    public function ksm()
    {
        $kabupaten = kabupaten::all();
        $villages = village::all();
        $tahun = tahun::all();
        return view('document.ksm', compact(['kabupaten', 'tahun']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function storeFoto(Request $request)
    {
        // Folder kabupaten
        $tahun = $request->tahunFOTO;
        $parent_folder_code =  $tahun;
        $new_folder_request = $request->foto_kabupaten;
        $new_folder_name = $new_folder_request . ' ' . village::where('KD_KAB', $new_folder_request)->get('NAMA_KAB')[0]['NAMA_KAB'];
        //Create and Save Google Drive Folder Kabupaten
        $newGoogleFolder = new FolderInfo;
        $newGoogleFolder->CreateAndSaveGoogleDriveFolder($parent_folder_code,  $new_folder_name, $new_folder_request);

        // Kelurahan
        $parent_folder_code .= $request->foto_kabupaten;
        $new_folder_request = $request->foto_kelurahan;
        $new_folder_name = $new_folder_request . ' ' . village::where('KD_KEL', $request->foto_kelurahan)->get('NAMA_DESA')[0]['NAMA_DESA'];
        //Create and Save Google Drive Folder Kelurahan
        $newGoogleFolder = new FolderInfo;
        $newGoogleFolder->CreateAndSaveGoogleDriveFolder($parent_folder_code,  $new_folder_name, $new_folder_request);

        //Create DOK PERSIAPAN / KSM folder
        $parent_folder_code .= $request->foto_kelurahan;
        $i = intval($request->jenisDokumenFoto);
        $jenisDokumenFoto = jenisfoto::where('parent', $i)->get('JenisFoto')[0]['JenisFoto'];
        for ($i = 1; $i <= 3; $i++) {
            $fileName = $jenisDokumenFoto . ' KSM ' . $new_folder_name . ' KEL ';
            $new_folder_name = 'DOK PERSIAPAN';
            $new_folder_request = $new_folder_name;
        }
        for ($i = 4; $i <= 10; $i++) {
            $fileName =  $jenisDokumenFoto . ' ' . $request->TitikFoto . ' ' . $request->foto_kegiatan . ' KSM ' . $new_folder_name . ' KEL ';
            $new_folder_name = ksm::where('KD_KSM', $request->foto_ksm)->get('NAMA_KSM')[0]['NAMA_KSM'];
            $new_folder_request = $request->foto_ksm;
        }
        $newGoogleFolder = new FolderInfo;
        $newGoogleFolder->CreateAndSaveGoogleDriveFolder($parent_folder_code,  $new_folder_name, $new_folder_request);

        // Create KEGIATAN KSM
        $parent_folder_code .= $new_folder_request;
        $new_folder_request = kegiatanksm::where('KD_KEGIATAN', $request->foto_kegiatan)->get('KEGIATAN')[0]['KEGIATAN'] . ' ' . kegiatanksm::where('KD_KEGIATAN', $request->foto_kegiatan)->get('RTRW')[0]['RTRW'];
        $new_folder_name = $new_folder_request;
        //Create and Save Google Drive Folder KEGIATAN KSM
        $newGoogleFolder = new FolderInfo;
        $newGoogleFolder->CreateAndSaveGoogleDriveFolder($parent_folder_code,  $new_folder_name, $new_folder_request);


        // Create TITIK
        $parent_folder_code .= $new_folder_request;
        $new_folder_request = $request->TitikFoto;
        $new_folder_name = $new_folder_request;
        //Create and Save Google Drive Folder TITIK
        $newGoogleFolder = new FolderInfo;
        $newGoogleFolder->CreateAndSaveGoogleDriveFolder($parent_folder_code,  $new_folder_name, $new_folder_request);


        // Save File
        $KodeKegiatan = $request->foto_ksm . $request->foto_kegiatan;
        $kd_kel = $request->foto_kelurahan;
        $kd_kab = $request->foto_kabupaten;
        $files = $request->file('file_foto');
        $Kodeksm = "";
        $JenisDokumen = $jenisDokumenFoto;
        $tipedokumen = 'IMAGE';
        $SaveFile = new DocInfo;
        $SaveFile->SafeFile($KodeKegiatan, $files, $fileName, $JenisDokumen, $Kodeksm, $kd_kel, $kd_kab, $new_folder_name, $parent_folder_code, $tipedokumen);

        return redirect('/doc')->with('status', 'Foto sudah diupload.');
    }

    public function store(Request $request)
    {
        // Folder kabupaten
        $parent_folder_code = $request->tahunBKM;
        $new_folder_request = $request->kabupaten;
        $new_folder_name = $new_folder_request . ' ' . village::where('KD_KAB', $new_folder_request)->get('NAMA_KAB')[0]['NAMA_KAB'];
        //Create and Save Google Drive Folder Kabupaten
        $newGoogleFolder = new FolderInfo;
        $newGoogleFolder->CreateAndSaveGoogleDriveFolder($parent_folder_code,  $new_folder_name, $new_folder_request);

        // Kelurahan
        $parent_folder_code .= $request->kabupaten;
        $new_folder_request = $request->kelurahan;
        $new_folder_name = $new_folder_request . ' ' . village::where('KD_KEL', $request->kelurahan)->get('NAMA_DESA')[0]['NAMA_DESA'];
        //Create and Save Google Drive Folder Kelurahan
        $newGoogleFolder = new FolderInfo;
        $newGoogleFolder->CreateAndSaveGoogleDriveFolder($parent_folder_code,  $new_folder_name, $new_folder_request);

        //Create PENCAIRAN / PERENCANAAN folder
        $JenisDokumen = $request->jenisDokumen;
        $parent_folder_code .= $request->kelurahan;
        $new_folder_code = $parent_folder_code;
        // Create and Save PENCAIRAN / PERENCANAAN folder
        $newGoogleFolder = new FolderInfo;
        $newGoogleFolder->CreateAndSavePencairanPerencanaanFolder($parent_folder_code, $JenisDokumen, $new_folder_code);

        //Save File
        $kd_kel = $request->kelurahan;
        $kd_kab = $request->kabupaten;
        $files = $request->file('file');
        $new_folder_name = jenisDokumen::where('jenisDokumen', $JenisDokumen)->get('nama_folder')[0]['nama_folder'];
        $fileName = $JenisDokumen . ' ';
        $tipedokumen = 'PDF';
        $Kodeksm = "-";
        $KodeKegiatan = $request->kelurahan . $JenisDokumen;
        $SaveFile = new DocInfo;
        $SaveFile->SafeFile($KodeKegiatan, $files, $fileName, $JenisDokumen,  $Kodeksm, $kd_kel, $kd_kab, $new_folder_name, $parent_folder_code, $tipedokumen);

        return redirect('/table')->with('status', 'Dokumen sudah diupload.');
    }

    public function storeKSM(Request $request)
    {
        // Folder kabupaten
        $tahun = $request->tahunKSM;
        $parent_folder_code = $request->tahunKSM;
        $new_folder_request = $request->ksm_kabupaten;
        $new_folder_name = $new_folder_request . ' ' . village::where('KD_KAB', $new_folder_request)->get('NAMA_KAB')[0]['NAMA_KAB'];
        //Create and Save Google Drive Folder Kabupaten
        $newGoogleFolder = new FolderInfo;
        $newGoogleFolder->CreateAndSaveGoogleDriveFolder($parent_folder_code,  $new_folder_name, $new_folder_request);

        // Kelurahan
        $parent_folder_code .= $request->ksm_kabupaten;
        $new_folder_request = $request->ksm_kelurahan;
        $new_folder_name = $new_folder_request . ' ' . village::where('KD_KEL', $request->ksm_kelurahan)->get('NAMA_DESA')[0]['NAMA_DESA'];
        //Create and Save Google Drive Folder Kelurahan
        $newGoogleFolder = new FolderInfo;
        $newGoogleFolder->CreateAndSaveGoogleDriveFolder($parent_folder_code,  $new_folder_name, $new_folder_request);

        // KSM
        $parent_folder_code .= $request->ksm_kelurahan;
        $new_folder_request = $request->ksm_ksm;
        $new_folder_name = $new_folder_request;
        $nama_ksm = $new_folder_request;
        //Create and Save Google Drive Folder KSM
        $newGoogleFolder = new FolderInfo;
        $newGoogleFolder->CreateAndSaveGoogleDriveFolder($parent_folder_code,  $new_folder_name, $new_folder_request);

        //Create KEGIATAN KSM folder
        $noDokumen = $request->jenisDokumen_ksm;
        $parent_folder_code .= $request->ksm_ksm;
        $new_folder_name = jenisDokumen::where('NO', $noDokumen)->get('nama_folder')[0]['nama_folder'];
        $new_folder_request = $new_folder_name;
        $newGoogleFolder = new FolderInfo;
        $newGoogleFolder->CreateAndSaveGoogleDriveFolder($parent_folder_code,  $new_folder_name, $new_folder_request);

        //Save File
        $kd_kel = $request->ksm_kelurahan;
        $kd_kab = $request->ksm_kabupaten;
        $files = $request->file('file_ksm');
        $JenisDokumen = jenisDokumen::where('NO', $noDokumen)->get('JenisDokumen')[0]['JenisDokumen'];
        $itemDokumen = $request->macamDokumen_ksm . ' ';
        $fileName = $itemDokumen . $JenisDokumen . ' KSM ' . $nama_ksm;
        $tipedokumen = 'PDF';
        $SaveFile = new DocInfo;
        $Kodeksm = $request->ksm_ksm;
        $KodeKegiatan = $request->ksm_ksm . $JenisDokumen;
        $SaveFile->SafeFile($KodeKegiatan, $files, $fileName, $JenisDokumen, $Kodeksm, $kd_kel, $kd_kab, $new_folder_name, $parent_folder_code, $tipedokumen);
        // ==================================================== Selesai =============================================== //
        return redirect('/table')->with('status', 'Dokumen sudah diupload.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {

        // return $document;
        // return view('document.folder', compact('document'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {
        return $request;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        //
    }
}
