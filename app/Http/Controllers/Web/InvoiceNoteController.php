<?php

namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contract;
use App\Invoice;
use App\InvoiceNote;
use Auth;

class InvoiceNoteController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->Contract             = new Contract;
        $this->oInvoice             = new Invoice;
        $this->oInvoiceNote         = new InvoiceNote;
    }



    public function store(Request $request)
    {

        //VACIA TODA LA PROPUESTA PARA LLENARLA PARA INSERTAR LAS MODIFICACIONES.
        $this->oInvoiceNote->deleteInv($request->invoiceId);

    //recorre el arreglo que viene por requeste, del componente ProposalDetails y realiza una insercion de cada uno de sus elementos.
        if(!empty($request->notesList)) {
        foreach ($request->notesList as $key => $item) {

             $result = $this->oInvoiceNote->insert(
              $request->invoiceId,
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

     public function show(Request $request,$id)
    {
        $invoiceNotes = $this->oInvoiceNote->getAllByInvoice($id);

          if($request->ajax()){
                return $invoiceNotes;
            }
        return view('module_contracts.proposals.Notes', compact('invoiceNotes'));
    }

    public function destroy($id)
    {
        $result = $this->oInvoiceNote->deleteInv($id);

           $notification = array(
            'message'    => $result['message'],
            'alertType' => $result['alertType'],
        );
         return $notification;

    }
}
