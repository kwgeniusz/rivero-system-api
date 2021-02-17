<?php

namespace App\Http\Controllers\Web;

use Auth;
use App\Proposal;
use App\ProposalTerm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProposalTermController extends Controller
{
    private $oProposal;
    private $oProposalTerm;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oProposal              = new Proposal;
        $this->oProposalTerm     = new ProposalTerm;
    }

    public function index(request $request,$id) {

        $proposal = $this->oProposal->FindById($id,session('countryId'),session('companyId'));
        $propTerm = $proposal[0]->term;
   
        if($request->ajax()){
             return $propTerm;
                }

        // return view('module_contracts.precontracts.files', compact('propTerm'));
    }
    // public function create()
    // {
    // }
    public function store(Request $request,$id) {
      
      $error = null;

      DB::beginTransaction();
      try {

    //recorre el arreglo que viene por requeste, del componente ProposalDetails y realiza una insercion de cada uno de sus elementos.
        if(!empty($request->termsList)) {
      //Vacia todos los terminos relacionados con la propuesta.
        $this->oProposalTerm->deleteAll($id);

        foreach ($request->termsList as $key => $item) {
             $result = $this->oProposalTerm->insert(
              $id,
              $item['termId'],
              $item['termName']);

            if($result['alertType'] == 'error'){ throw new \Exception($result['message']); }
        };
     }else{
        $this->oProposalTerm->deleteAll($id);
      };//fin 1 else
            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return $notification = ['alertType' => 'success', 'message' => 'Terminos Guardados'];
        } else {
            return $notification = ['alertType' => 'error', 'message' => $error];
        }
    } //function store end

} //class Term edn
