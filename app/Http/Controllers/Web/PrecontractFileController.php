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

    // public function create()
    // {


    // }

    public function store(Request $request,$id)
    {
      $rs = $this->oDocument->insertF($request->file,'precontract',$id,$request->typeDoc);
    
       if ($rs->status() == 200) {
          return response('Insercion Exitosa', 200)->header('Content-Type', 'text/plain');
        } else {
           return response($rs->content(), 500)->header('Content-Type', 'text/plain');
        } 
    }

    // public function edit($id)
    // {
      
      
    // }

    // public function update(ContractRequest $request, $id)
    // {

   
    // }
    // public function show(Request $request,$id)
    // {

    // }

}
