<?php

namespace App\Http\Controllers\Web;

use App\Payable;
use App\SubcontractorInvDetail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class SubcontractorPayableController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->oPayable                 = new Payable;
        $this->oSubcontractorInvDetail  = new SubcontractorInvDetail;
    }

   public function index(Request $request,$subcontId)
    {
        $payables = $this->oPayable->getAllBySubcontractor($subcontId);
      
         if($request->ajax()){
            return $payables;
          }

        return view('module_administration.subcontractors.payables', compact('subcontId'));
    }
//----------------FUNCTIONS TO INSERT ON INVOICES -------------->>>>
    public function listSubcontInvDetail(Request $request)
    { 
       $rs   = $this->oSubcontractorInvDetail->getAllByInvDetail($request->invDetailId);
       return $rs;
    }
    public function addSubcontInvDetail(Request $request)
    { 
       $rs   = $this->oSubcontractorInvDetail->insertS($request->all());
       return $rs;
    }
    public function removeSubcontInvDetail(Request $request)
    { 
       $rs   = $this->oSubcontractorInvDetail->deleteS($request->subcontInvDetailId);
       return $rs;
    }

}
