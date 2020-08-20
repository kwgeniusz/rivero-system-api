<?php

namespace App\Http\Controllers\Report\Pdf;

use App\Receivable;
use App\Client;
use App\Proposal;
use App\ProposalDetail;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Barryvdh\DomPDF\Facade as PDF;

class ProposalControllerPDF extends Controller
{
    private $oReceivable;
    private $oClient;
    private $oInvoice;
    private $oInvoiceDetail;  
    private $oProposal;
    private $oProposalDetail;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oReceivable  = new Receivable;
        $this->oClient      = new Client;
        $this->oProposal     = new Proposal;
        $this->oProposalDetail = new ProposalDetail;
    }


  public function printProposal(Request $request)
{
   $pdf = app('dompdf.wrapper');

        $date             = Carbon::now();
        $company           = DB::table('company')->where('companyId', session('companyId'))->get();
        $proposal         = $this->oProposal->findById($request->id,session('countryId'),session('companyId'));
        $proposalsDetails = $this->oProposalDetail->getAllByProposal($request->id);
        $client           = $this->oClient->findById($proposal[0]->clientId,session('countryId'));
        
        if($proposal[0]->precontract){
           $moneySymbol = $proposal[0]->precontract->currency->currencySymbol;
           $modelId = $proposal[0]->precontract->preId;
           $modelType = 'precontract';
           $modelTypeView = 'Precontract';
        }else{
           $moneySymbol = $proposal[0]->contract->currency->currencySymbol;
           $modelId = $proposal[0]->contract->contractNumber;
           $modelType = 'contract';
           $modelTypeView = 'Contract';

        }

      //dispara error si cuotas son mayores que el monto neto de la propuesta para que el usuario ajuste cuotas.
       $paymentSum = 0;
        foreach ($proposal[0]->paymentProposal as $paymentProposal) {
            $paymentSum += $paymentProposal->amount;
        }

       if($paymentSum > $proposal[0]->netTotal){
                $notification = array(
                    'message'    => 'Error: Las cuotas no corresponden con el precio de la propuesta, debe ajustar cuotas.',
                    'alert-type' => 'error',
                );
             return redirect()->back()->with($notification);
         }
        //si no tiene renglones la propuesta disparar error
        elseif ($proposalsDetails->isEmpty()) {
            // return view('module_administration.reportincomeexpenses.error');
                 $notification = array(
                    'message'    => 'Error: Debe llenar renglones de Propuesta',
                    'alert-type' => 'error',
                );
             return redirect()->back()->with($notification);
        } else {

            $data = [
                 'date'  => $date,
                 'company'  => $company,
                 'proposal'  => $proposal,
                 'proposalsDetails'  => $proposalsDetails,
                 'client'  => $client,
                 'moneySymbol'  => $moneySymbol,
                 'modelId' => $modelId,
                 'modelType' => $modelType,
                 'modelTypeView' => $modelTypeView,
                      ];


       return PDF::loadView('module_administration.reports.printProposal', $data)->stream('P - '.$proposal[0]->$modelType->siteAddress.'.pdf');
        } //end else
    } //end printProposal 

    
}//end class
