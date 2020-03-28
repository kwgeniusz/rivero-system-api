<?php

namespace App\Http\Controllers\Web;


use Auth;
use App;
use App\OfficeConfiguration;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Precontract;
use App\Proposal;
use App\ProposalDetail;
use App\PaymentProposal;
use App\PaymentCondition;
use App\Http\Requests\PaymentRequest;

class ProposalController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->oOfficeConfiguration     = new OfficeConfiguration;
        // $this->oReceivable        = new Receivable;
        $this->oPrecontract       = new Precontract;
        $this->oProposal          = new Proposal;
        $this->oProposalDetail    = new ProposalDetail;
        $this->oPaymentProposal    = new PaymentProposal;
        $this->oPaymentCondition  = new PaymentCondition;

    }

    public function index(Request $request)
    {
        $precontract = $this->oPrecontract->findById($request->id,session('countryId'),session('officeId'));
        $proposals = $this->oProposal->getAllByPrecontract($request->id);

        return view('module_contracts.proposals.index', compact('proposals','precontract'));
    }

    public function create(Request $request)
    {
 
        $precontract = $this->oPrecontract->findById($request->id,session('countryId'),session('officeId'));
        $paymentConditions = $this->oPaymentCondition->getAllByLanguage();
        $invoiceTaxPercent   = $this->oOfficeConfiguration->findInvoiceTaxPercent(session('countryId'),session('officeId'));

        $propId = $this->oOfficeConfiguration->retrieveProposalNumber(session('countryId'),session('officeId'));
        $propId++;


        return view('module_contracts.proposals.create', compact('propId','precontract','paymentConditions','invoiceTaxPercent'));
    }

    public function store(Request $request)
    {
           $this->validate($request, [
                'invoiceDate' => 'required',
                'invoiceTaxPercent' => 'required',
           ]);
 
          $precontract = $this->oPrecontract->findById($request->precontractId,session('countryId'),session('officeId'));


          $proposalId  =   $this->oProposal->insertProp(
                      $precontract[0]->countryId,
                      $precontract[0]->officeId,
                      $precontract[0]->precontractId,
                      $precontract[0]->clientId,
                      $request->invoiceDate,
                      $request->invoiceTaxPercent,
                      $request->paymentConditionId, 
                      '1');

        $notification = array(
            'message'    => 'Propuesta Creada, Agrege Renglones',
            'alert-type' => 'success',
        );

        return redirect()->route('proposalsDetails.index',['id' => $proposalId])
            ->with($notification);
    }

     public function edit($id)
    {    
        $proposal = $this->oProposal->findById($id,session('countryId'),session('officeId'));
        $paymentConditions = $this->oPaymentCondition->getAllByLanguage();

         return view('module_contracts.proposals.edit', compact('proposal','paymentConditions'));
    }

    public function update(Request $request, $id)
    {

        $this->oProposal->updateProposal(
            $id,
            $request->paymentConditionId,
            $request->invoiceDate,
            $request->invoiceTaxPercent
        );

        $notification = array(
            'message'    => 'Datos Principales de Propuesta Modificados Exitosamente',
            'alert-type' => 'info',
        );
        
        return redirect()->route('proposals.index',['id' => $request->precontractId])
            ->with($notification);
    }

    public function show(Request $request,$id)
    {
        $proposal = $this->oProposal->findById($id,session('countryId'),session('officeId'));

          if($request->ajax()){
                return $proposal;
            }
        return view('module_contracts.proposals.show', compact('proposal'));
    }
      public function destroy($id)
    {
        $proposal = $this->oProposal->findById($id,session('countryId'),session('officeId'));
        
        $this->oProposal->deleteProposal($id);

          $notification = array(
            'message'    => 'Propuesta Eliminada',
            'alert-type' => 'info',
        );

         return redirect()->route('proposals.index',['id' => $proposal[0]->precontractId])
            ->with($notification);

    }

//---------------NOTES-----------------------//
    //  public function notes(Request $request)
    // {
    //     $proposal = $this->oProposal->FindById($request->proposalId,session('countryId'),session('officeId'));
         
    //        if($request->ajax()){
    //             return $proposal[0]->note;
    //         }
    //     // return view('module_contracts.contracts.staff', compact('contract', 'staffs'));

    // }
    // public function notesAdd(Request $request)
    // {

    //     $result = $this->oProposal->addNote(
    //         $request->proposalId,
    //         $request->noteId
    //     );

    //     $notification = array(
    //         'message'    => 'Nota Agregada a propuesta',
    //         'alertType' => 'info',
    //     );

    //      if($request->ajax()){
    //             return $notification;
    //         }
    // }

    // public function notesRemove(Request $request,$proposalId,$noteId)
    // {

    //     $this->oProposal->removeNote($proposalId,$noteId);
        
    //     $notification = array(
    //         'message'    => 'Nota Eliminada de propuesta',
    //         'alertType' => 'info',
    //     );
    //        if($request->ajax()){
    //             return $notification;
    //         }
    // }


//---------------PAYMENTS-----------------------//

    public function payments($id)
    {

        $proposal         = $this->oProposal->findById($id,session('countryId'),session('officeId'));
        $proposalDetails  = $this->oProposalDetail->getAllByProposal($id);
        $payments        = $this->oPaymentProposal->getAllByProposal($id);

        return view('module_contracts.proposals.payment', compact('proposal','proposalDetails', 'payments'));

    }

    public function paymentsAdd(PaymentRequest $request)
    {

        $result = $this->oPaymentProposal->addPayment(
            $request->proposalId,
            $request->amount,
            $request->paymentDate
        );

        $notification = array(
            'message'    => $result['msj'],
            'alert-type' => $result['alert'],
        );
        
        return redirect()->route('proposals.payments', ['id' => $request->proposalId])
            ->with($notification);

    }
    public function paymentsRemove($id, $proposalId)
    {

        $result = $this->oPaymentProposal->removePayment($id,$proposalId);

        $notification = array(
            'message'    => $result['msj'],
            'alert-type' => $result['alert'],
        );

        return redirect()->route('proposals.payments', ['id' => $proposalId])
            ->with($notification);
    }
}
