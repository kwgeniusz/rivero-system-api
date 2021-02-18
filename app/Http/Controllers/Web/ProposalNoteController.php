<?php

namespace App\Http\Controllers\Web;


use Auth;
use App\Proposal;
use App\ProposalNote;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProposalNoteController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->oProposal             = new Proposal;
        $this->oProposalNote       = new ProposalNote;
    }

     public function index(Request $request,$id)
    {
      $proposal = $this->oProposal->FindById($id,session('countryId'),session('companyId'));
      $propNotes = $proposal[0]->note;
   
        if($request->ajax()){
             return $propNotes;
           }
    }

    public function store(Request $request,$id)
    {
      $error = null;

        DB::beginTransaction();
        try {

    //recorre el arreglo que viene por request, del componente ProposalDetails y realiza una insercion de cada uno de sus elementos.
     if(!empty($request->notesList)) {
      //Vacia toda las notas relacionadas con la propuesta.
        $this->oProposalNote->deleteAll($id);
        foreach ($request->notesList as $key => $item) {
             $result = $this->oProposalNote->insert(
              $id,
              $item['noteId'],
              $item['noteName']);

          if($result['alertType'] == 'error'){ throw new \Exception($result['message']); }
        };

     }else{
        $this->oProposalNote->deleteAll($id);
      };
            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return $notification = ['alertType' => 'success', 'message' => 'Notas Guardadas'];
        } else {
            return $notification = ['alertType' => 'error', 'message' => $error];
        }

    }
}
