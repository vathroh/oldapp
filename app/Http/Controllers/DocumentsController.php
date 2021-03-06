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
use App\Image;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\List_;
use Illuminate\Support\Facades\Storage;
use SebastianBergmann\Environment\Console;

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

    public function upload()
    {
        $images = Image::latest()->get();
        return view('document.upload', compact('images'));
    }

    public function years()
    {
        $years = tahun::orderBy('tahun', 'ASC')->get();
        return response()->json($years);
    }

    public function kabupaten()
    {
        $regencies = kabupaten::all();
        return response()->json($regencies);
    }



    public function uploaddoc(Request $request)
    {
        // Folder kabupaten
        $titik = "-";
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

        $parent_folder_path = google_folder::where('kode_folder', $parent_folder_code)->get('path_folder')[0]['path_folder'];
        $new_folder_path = $parent_folder_path . '/' . $new_folder_name;
        $saved_folder_id = google_folder::where('path_folder', $new_folder_path)->get('id_folder')[0]['id_folder'];

        $request->validate([
            'file_name.*' => 'required|mimes:pdf',
        ]);

        if ($request->hasFile('file_name')) {
            $images = $request->file('file_name');
            foreach ($images as $image) {
                $originalFileName = $image->getClientOriginalName();
                $fileExtension = $image->getClientOriginalExtension();
                $fileNameOnly = pathinfo($originalFileName, PATHINFO_FILENAME);
                $fileName = str_slug($fileNameOnly) . "-" . time() . "." . $fileExtension;

                Storage::disk('google')->putFileAs($saved_folder_id, $image, $fileName);
            }
        }


        return response()->json([
            'uploaded' => true,
            'nama file' => $fileName,
            'ekstensi' => $fileExtension,
        ]);
    }

    protected function uploadFiles($request, $saved_folder_id)
    {

        $uploadedImages = [];
        if ($request->hasFile('file_name')) {
            $images = $request->file('file_name');
            foreach ($images as $image) {
                // $uploadedImages[] = $this->uploadFile($image, $saved_folder_id);
                $originalFileName = $image->getClientOriginalName();
                $fileExtension = $image->getClientOriginalExtension();
                $fileNameOnly = pathinfo($originalFileName, PATHINFO_FILENAME);
                $fileName = str_slug($fileNameOnly) . "-" . time() . "." . $fileExtension;

                $uploadedFileName =  Storage::disk('google')->putFileAs($saved_folder_id, $image, $fileName);
                return [$uploadedFileName, $fileNameOnly];
            }
        }
        return $uploadedImages;
    }

    protected function uploadFile($image, $saved_folder_id)
    {


        $originalFileName = $image->getClientOriginalName();
        $fileExtension = $image->getClientOriginalExtension();
        $fileNameOnly = pathinfo($originalFileName, PATHINFO_FILENAME);
        $fileName = str_slug($fileNameOnly) . "-" . time() . "." . $fileExtension;

        $uploadedFileName =  Storage::disk('google')->putFileAs($saved_folder_id, $image, $fileName);
        return [$uploadedFileName, $fileNameOnly];
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
        // $titik = $request->TitikFoto;
        
        // Folder kabupaten
        $tahun = $request->tahunFOTO;
        $parent_folder_code =  $tahun;
        $new_folder_code=$tahun.$request->foto_kabupaten;
        $new_folder_name = $request->foto_kabupaten . ' ' . village::where('KD_KAB', $request->foto_kabupaten)->get('NAMA_KAB')[0]['NAMA_KAB'];
        // Create and Save Google Drive Folder Kabupaten
        $newGoogleFolder = new FolderInfo;
        $newGoogleFolder->CreateAndSaveGoogleDriveFolder($parent_folder_code,  $new_folder_name, $new_folder_code);



        // Kelurahan
        $parent_folder_code = $tahun.$request->foto_kabupaten;
        $new_folder_code = $tahun.$request->foto_kelurahan;
        $new_folder_name = $request->foto_kelurahan . ' ' . village::where('KD_KEL', $request->foto_kelurahan)->get('NAMA_DESA')[0]['NAMA_DESA'];
        //Create and Save Google Drive Folder Kelurahan
        $newGoogleFolder = new FolderInfo;
        $newGoogleFolder->CreateAndSaveGoogleDriveFolder($parent_folder_code,  $new_folder_name, $new_folder_code);

        //Create DOK PERSIAPAN / KSM folder
        $parent_folder_code = $tahun.$request->foto_kelurahan;
        $i = intval($request->jenisDokumenFoto);
        $jenisDokumenFoto = jenisfoto::where('parent', $i)->get('JenisFoto')[0]['JenisFoto'];

        if ($i<=3) {
            $fileName = $jenisDokumenFoto . ' ' . $new_folder_name;
            $new_folder_name = 'DOK PERSIAPAN';
            $new_folder_code = $tahun.$request->foto_kelurahan.$new_folder_name;

            $newGoogleFolder = new FolderInfo;
            $newGoogleFolder->CreateAndSaveGoogleDriveFolder($parent_folder_code,  $new_folder_name, $new_folder_code);
            
            // Create MP2K, Pelatihan KSM, OJT Folder
            $parent_folder_code = $new_folder_code;
            $new_folder_name = $jenisDokumenFoto;
            $new_folder_code = $tahun.$request->foto_kelurahan.$new_folder_name;

            $newGoogleFolder = new FolderInfo;
            $newGoogleFolder->CreateAndSaveGoogleDriveFolder($parent_folder_code,  $new_folder_name, $new_folder_code);

            // Save File
            $KodeKegiatan = $request->foto_kegiatan;
            $files = $request->file('file_foto');
            $JenisDokumen = $jenisDokumenFoto;
            $Kodeksm = $request->foto_ksm;
            $kd_kel = $request->foto_kelurahan;
            $kd_kab = $request->foto_kabupaten;
            $tipedokumen = 'IMAGE';
            $titik="-";

            $SaveFile = new DocInfo;
            $SaveFile->SaveFile($tahun, $KodeKegiatan, $files, $fileName, $JenisDokumen, $Kodeksm, $kd_kel, $kd_kab, $new_folder_name, $parent_folder_code, $tipedokumen, $titik);


        } else {

            //create KSM Folder
            $new_folder_name = ksm::where('KD_KSM', $request->foto_ksm)->get('NAMA_KSM')[0]['NAMA_KSM'];
            $new_folder_code = $request->foto_ksm;

            $newGoogleFolder = new FolderInfo;
            $newGoogleFolder->CreateAndSaveGoogleDriveFolder($parent_folder_code,  $new_folder_name, $new_folder_code);

             // Create KEGIATAN KSM
            $parent_folder_code = $request->foto_ksm;
            $new_folder_code = $request->foto_kegiatan;
            $new_folder_name = kegiatanksm::where('KD_KEGIATAN', $request->foto_kegiatan)->get('KEGIATAN')[0]['KEGIATAN'] . ' ' . kegiatanksm::where('KD_KEGIATAN', $request->foto_kegiatan)->get('RTRW')[0]['RTRW'];
            //Create and Save Google Drive Folder KEGIATAN KSM
            $newGoogleFolder = new FolderInfo;
            $newGoogleFolder->CreateAndSaveGoogleDriveFolder($parent_folder_code,  $new_folder_name, $new_folder_code);

            // Create TITIK
            $parent_folder_code = $request->foto_kegiatan;
            $new_folder_code = $parent_folder_code . $request->TitikFoto;
            $new_folder_name = $request->TitikFoto;
            //Create and Save Google Drive Folder TITIK
            $newGoogleFolder = new FolderInfo;
            $newGoogleFolder->CreateAndSaveGoogleDriveFolder($parent_folder_code,  $new_folder_name, $new_folder_code);


            // Save File
            $fileName =  $jenisDokumenFoto . ' ' . kegiatanksm::where('KD_KEGIATAN', $request->foto_kegiatan)->get('KEGIATAN')[0]['KEGIATAN'] . ' ' . kegiatanksm::where('KD_KEGIATAN', $request->foto_kegiatan)->get('RTRW')[0]['RTRW'] . ' ' . $request->foto_ksm;

            $KodeKegiatan = $request->foto_kegiatan;
            $kd_kel = $request->foto_kelurahan;
            $kd_kab = $request->foto_kabupaten;
            $files = $request->file('file_foto');
            $Kodeksm = $request->foto_ksm;
            $JenisDokumen = $jenisDokumenFoto;
            $tipedokumen = 'IMAGE';
            $titik = $request->TitikFoto;

            $SaveFile = new DocInfo;
            $SaveFile->SaveFile($tahun, $KodeKegiatan, $files, $fileName, $JenisDokumen, $Kodeksm, $kd_kel, $kd_kab, $new_folder_name, $parent_folder_code, $tipedokumen, $titik);

        }

        return redirect('/doc')->with('status', 'Foto sudah diupload.');
        
    }

    public function store(Request $request)
    {
        // Folder kabupaten
        $titik = "-";
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
        $SaveFile->SafeFile($KodeKegiatan, $files, $fileName, $JenisDokumen,  $Kodeksm, $kd_kel, $kd_kab, $new_folder_name, $parent_folder_code, $tipedokumen, $titik);

        return redirect('/table')->with('status', 'Dokumen sudah diupload.');
    }

    public function bkm()
    {
        return view('document.upload');
    }

    public function storeKSM(Request $request)
    {

        // Folder kabupaten
        $titik = "-";
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
        $SaveFile->SafeFile($KodeKegiatan, $files, $fileName, $JenisDokumen, $Kodeksm, $kd_kel, $kd_kab, $new_folder_name, $parent_folder_code, $tipedokumen, $titik);
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
    public function tambahtahun(){
        $doc= Document::all();

        $document = new document;
        $document->folder_id = $saved_folder_id;
        $document->file_id = $file_id;
        $document->file_name = $newFileName;
        $document->file_extension =  $fileExtension;
        $document->tipe_dokumen =  $tipedokumen;
        $document->jenis_dokumen =  $JenisDokumen;
        $document->uploaded_by = $user;
        $document->scope = '-';
        $document->titik = $titik;
        $document->kode_kegiatan = $KodeKegiatan;
        $document->kode_ksm = $Kodeksm;
        $document->kode_kel = $kd_kel;
        $document->kode_kab = $kd_kab;
        $document->nama_desa = $nama_desa;
        $document->nama_kab = $nama_kabupaten;
        $document->Comments = '-';
        $document->path = $new_folder_path;
        $document->link = 'https://drive.google.com/file/d/' . $file_id . '/view';
        $document->save();

    }
}
