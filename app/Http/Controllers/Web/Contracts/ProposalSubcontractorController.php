<?php

namespace App\Http\Controllers\Web\Contracts;

use App\Proposal;
use App\Models\Contracts\SubcontractorPropDetail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class ProposalSubcontractorController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->oProposal                 = new Proposal;
        $this->oSubcontractorPropDetail   = new SubcontractorPropDetail;
    }

   public function index(Request $request, $id)
    { 

        $proposal = $this->oProposal->findById($id,session('countryId'),session('companyId'));
      
         if($request->ajax()){
            return $proposal;
          }

        return view('module_contracts.precontracts.proposals.subcontractors', compact('proposal'));
    }
//----------------FUNCTIONS TO INSERT ON INVOICES -------------->>>>
    public function listSubcontInvDetail(Request $request)
    { 
       $rs   = $this->oSubcontractorPropDetail->getAllByInvDetail($request->invDetailId);
       return $rs;
    }
    public function addSubcontInvDetail(Request $request)
    { 
       $rs   = $this->oSubcontractorPropDetail->insertS($request->all());
       return $rs;
    }
    public function removeSubcontInvDetail(Request $request)
    { 
       $rs   = $this->oSubcontractorPropDetail->deleteS($request->subcontInvDetailId);
       return $rs;
    }

}
