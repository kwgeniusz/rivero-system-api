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
       //VACIA TODA LA PROPUESTA PARA LLENARLA PARA INSERTAR LAS MODIFICACIONES.
        $this->oProposalNote->deleteAll($id);

    //recorre el arreglo que viene por requeste, del componente ProposalDetails y realiza una insercion de cada uno de sus elementos.
        if(!empty($request->notesList)) {
        foreach ($request->notesList as $key => $item) {

             $result = $this->oProposalNote->insert(
              $id,
              $item['noteId'],
              $item['noteName']);

         $notification = array(
           'message'    => $result['message'],
           'alertType' => $result['alertType'],
          );
        };
     }else{
          $notification = array(
           'message'    => 'Notas Guardadas',
          'alertType' => 'success',
        );
      };//fin 1 else

      //envia siempre la notificacion para saber que if fue cumplido 
         if($request->ajax()){
                return $notification;
            }
    }

    // public function destroy($id)
    // {
    //     $result = $this->oProposalNote->deleteAll($id);

    //        $notification = array(
    //         'message'    => $result['message'],
    //         'alertType' => $result['alertType'],
    //     );
    //      return $notification;

    // }
}
