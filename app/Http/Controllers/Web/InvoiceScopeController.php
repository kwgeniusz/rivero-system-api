<?php

namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Invoice;
use App\InvoiceScope;
use Auth;

class InvoiceScopeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->oInvoice             = new Invoice;
        $this->oInvoiceScope         = new InvoiceScope;
    }

    public function store(Request $request)
    {

        //VACIA TODA LA PROPUESTA PARA LLENARLA PARA INSERTAR LAS MODIFICACIONES.
        $this->oInvoiceScope->deleteInv($request->invoiceId);

    //recorre el arreglo que viene por requeste, del componente ProposalDetails y realiza una insercion de cada uno de sus elementos.
        if(!empty($request->scopesList)) {
        foreach ($request->scopesList as $key => $item) {

             $result = $this->oInvoiceScope->insert(
              $request->invoiceId,
              $item['description']);

         $notification = array(
           'message'    => $result['message'],
           'alertType' => $result['alertType'],
          );
        };
     }else{
          $notification = array(
           'message'    => 'Alcances Guardados',
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
        $invoiceScopes = $this->oInvoiceScope->getAllByInvoice($id);

          if($request->ajax()){
                return $invoiceScopes;
            }
        return view('module_contracts.proposals.Notes', compact('invoiceScopes'));
    }

    public function destroy($id)
    {
        $result = $this->oInvoiceScope->deleteInv($id);

           $notification = array(
            'message'    => $result['message'],
            'alertType' => $result['alertType'],
        );
         return $notification;

    }
}
