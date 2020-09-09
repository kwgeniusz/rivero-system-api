<?php

namespace App\Http\Controllers\Web;

use Auth;
use ZipArchive;
use App\Precontract;
use App\Document;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PrecontractFileController extends Controller
{
    private $oPrecontract;
    private $oDocument;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oPrecontract     = new Precontract;
        $this->oDocument        = new Document;
    }

    public function index(request $request,$id)
    {
        $precontract = $this->oPrecontract->FindById($id,session('countryId'),session('companyId'));

        if($request->ajax()){
             return $precontract[0]->document;
                }

        return view('module_contracts.precontracts.files', compact('precontract'));
    }

    public function create()
    {


    }

    public function store(Request $request,$id)
    {
      $rs = $this->oDocument->insertF($request->file,'precontract',$id,$request->typeDoc);
    
       if ($rs->status() == 200) {
          return response('Insercion Exitosa', 200)->header('Content-Type', 'text/plain');
        } else {
           return response($rs->content(), 500)->header('Content-Type', 'text/plain');
        } 
    }

    public function edit($id)
    {
      
      
    }

    public function update(ContractRequest $request, $id)
    {

   
    }
    public function show(Request $request,$id)
    {

    }
    public function destroy($id)
    {
         foreach ($request->checkedFiles as $key => $file) {
            Storage::delete($file['docUrl']);
            $this->oDocument->deleteF($file['docUrl'],$file['docId']);
          }

       return response('Archivos Eliminados', 200)->header('Content-Type', 'text/plain');

    }
    
 public function fileDownloadByUnit(Request $request)
   {
        $doc = $this->oDocument->findById($request->docId);
           return response()->download('storage/'.$doc[0]->docUrl, $doc[0]->docName);
    }

 public function fileDownload(Request $request)
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

/* -----------OPTIONS------------- */

//---------------FILES-----------------------//
    // public function files($id)
    // {
    //     $contract = $this->oContract->FindById($id,session('countryId'),session('companyId'));

    //     return view('module_contracts.contracts.files', compact('contract'));
    // }
    // public function fileAdd(Request $request)
    // {

    //      $rs = $this->oDocument->insertF($request->file,'contract',$request->contractId,$request->typeDoc);

    //    if ($rs->status() == 200) {
    //       return response('Insercion Exitosa', 200)->header('Content-Type', 'text/plain');
    //     } else {
    //        return response($rs->content(), 500)->header('Content-Type', 'text/plain');
    //     } 
    // }

  //  public function fileDelete(Request $request)
  // {
  //        foreach ($request->checkedFiles as $key => $file) {
  //           Storage::delete($file['docUrl']);
  //           $this->oDocument->deleteF($file['docUrl'],$file['docId']);
  //         }

  //      return response('Archivos Eliminados', 200)->header('Content-Type', 'text/plain');
  //  }
   
//-------QUERYS ASINCRONIOUS-----------------//
    // public function getFiles($id,$type)
    // {
    //     $rs  = $this->oDocument->getAllForContractAndType($id,$type);
    //     return json_encode($rs);
    // }

}
