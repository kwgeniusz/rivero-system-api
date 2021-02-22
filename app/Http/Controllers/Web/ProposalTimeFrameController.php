<?php

namespace App\Http\Controllers\Web;

use DB;
use Auth;
use App\Proposal;
use App\ProposalTimeFrame;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProposalTimeFrameController extends Controller
{
    private $oProposal;
    private $oProposalTimeFrame;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oProposal              = new Proposal;
        $this->oProposalTimeFrame     = new ProposalTimeFrame;
    }

    public function index(request $request,$id) {

        $proposal = $this->oProposal->FindById($id,session('countryId'),session('companyId'));
        $propTimeFrames = $proposal[0]->timeFrame;
   
        if($request->ajax()){
             return $propTimeFrames;
                }

        // return view('module_contracts.precontracts.files', compact('propTimeFrames'));
    }
    // public function create()
    // {
    // }
    public function store(Request $request,$id) {
      
      $error = null;

      DB::beginTransaction();
      try {
    //recorre el arreglo que viene por requeste, del componente ProposalDetails y realiza una insercion de cada uno de sus elementos.
        if(!empty($request->timesList)) {
        //Vacia todos los Time Frame relacionados con la propuesta.
          $this->oProposalTimeFrame->deleteAll($id);

        foreach ($request->timesList as $key => $item) {

             $result = $this->oProposalTimeFrame->insert(
              $id,
              $item['timeId'],
              $item['timeName']);

              if($result['alertType'] == 'error'){ throw new \Exception($result['message']); }
        };
     }else{
        $this->oProposalTimeFrame->deleteAll($id);
      };//fin 1 else
 
            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return $notification = ['alertType' => 'success', 'message' => 'Time Frames Guardados'];
        } else {
            return $notification = ['alertType' => 'error', 'message' => $error];
        }

    } //function store end
} // class TimeFrame edn
