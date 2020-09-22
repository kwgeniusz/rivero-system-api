<?php

namespace App\Http\Controllers\Web;

use Auth;
use App;
use ZipArchive;
use App\Document;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    private $oDocument;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oDocument        = new Document;
    }

    // public function edit($id)
    // {

    // }

    // public function update(Request $request, $id)
    // {

    // }

   public function deleteMultiple(Request $request)
   {
         foreach ($request->checkedFiles as $key => $file) {
            // Storage::delete($file['docUrl']);
            $this->oDocument->deleteF($file['docUrl'],$file['docId']);
          }

       return response('Archivos Eliminados', 200)->header('Content-Type', 'text/plain');
   }

   public function download($id)
   {
        $doc = $this->oDocument->findById($id);
           return response()->download('storage/'.$doc[0]->docUrl, $doc[0]->docName);
    }

   public function downloadZip(Request $request)
   {
     $data = json_decode($request->checkedFiles,true);
      // dd($data);

        $zipName = Auth::user()->userName.'.zip';
        $zip = new \ZipArchive;

        if ($zip->open($zipName, ZipArchive::CREATE) === TRUE) {  

         foreach ($data as $file) {
            // dd($data);
               $zip->addFile('storage/'.$file['docUrl'],$file['docName']);        
          }        
               $zip->close();       
        }
    
     $headers = array(
        'content-description: File Transfer',
        'content-type: application/octet-stream',
        'content-disposition: attachment; filename="' . $zipName . '"',
        'content-length: ' . filesize($zipName),
        'content-encoding: none'
      );

        $filetopath=$zipName;

        if(file_exists($filetopath)){
           return response()->download($filetopath, $zipName, $headers)->deleteFileAfterSend(true);
        }

        return ['status'=>'Esto Da un Error'];
    }
   
//-------QUERYS ASINCRONIOUS-----------------//
    // public function getFiles($id,$type)
    // {
    //     $rs  = $this->oDocument->getAllForContractAndType($id,$type);
    //     return json_encode($rs);
    // }
    // public function getForCompany($companyId)
    // {

    //     $listContracts            = $this->oContract->FindByCompany($companyId);
    //     $listContractsSiteAddress = $this->oContract->findSiteAddressByCompany($companyId);
    //     $listClientName           = $this->oClient->FindNameByCompany($companyId);
    //     $listClientPhone          = $this->oClient->FindPhoneByCompany($companyId);

    //     json_encode($listContracts);
    //     json_encode($listContractsSiteAddress);
    //     json_encode($listClientName);
    //     json_encode($listClientPhone);
    //     $allList = [$listContracts, $listClientName, $listClientPhone, $listContractsSiteAddress];

    //     return json_encode($allList);
    // }

}
