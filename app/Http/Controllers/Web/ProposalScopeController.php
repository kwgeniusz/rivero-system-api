<?php

namespace App\Http\Controllers\Web;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Proposal;
use App\ProposalScope;
use Auth;

class ProposalScopeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->oProposal             = new Proposal;
        $this->oProposalScope       = new ProposalScope;
    }
     public function index(Request $request,$id)
    {
        $proposal = $this->oProposal->FindById($id,session('countryId'),session('companyId'));
        $propScopes = $proposal[0]->scope;
   
        if($request->ajax()){
             return $propScopes;
           }
        // return view('module_contracts.proposals.Scopes', compact('proposalScopes'));
    }

    public function store(Request $request,$id)
    {
      $error = null;

      DB::beginTransaction();
      try {

    //recorre el arreglo que viene por requeste, del componente ProposalDetails y realiza una insercion de cada uno de sus elementos.
        if(!empty($request->scopesList)) {
        //Vacia toda las notas relacionadas con la propuesta.
           $this->oProposalScope->deleteAll($id);
           foreach ($request->scopesList as $key => $item) {
                $result = $this->oProposalScope->insert(
                $id,
                $item['description']);

                if($result['alertType'] == 'error'){ throw new \Exception($result['message']); }
              };
         }else{
          $this->oProposalScope->deleteAll($id);
         };//fin 1 else

            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return $notification = ['alertType' => 'success', 'message' => 'Alcances Guardados'];
        } else {
            return $notification = ['alertType' => 'error', 'message' => $error];
        }
    }


    // public function destroy($id)
    // {
    //     $result = $this->oProposalScope->deleteProp($id);

    //        $notification = array(
    //         'message'    => $result['message'],
    //         'alertType' => $result['alertType'],
    //     );
    //      return $notification;

    // }
}
