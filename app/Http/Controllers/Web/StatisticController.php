<?php

namespace App\Http\Controllers\Web;

use App;
use App\Contract;
use App\Client;
use App\Invoice;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class StatisticController extends Controller
{
    private $oContract;
    private $oClient;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oContract        = new Contract;
        $this->oClient          = new Client;
        $this->oInvoice          = new Invoice;
    }

    public function numberOfClients(Request $request)
    {
        if(session('parentCompanyId') == 0) {
            $rs = $this->oClient->getClientByGroup(session('countryId'),session('companyId'),session('parentCompanyId'),'');
        }else{ 
            $rs = $this->oClient->getClientByCompany(session('companyId'));
         }
           return count($rs);
    }
    public function numberOfContracts()
    {
        $rs = $this->oContract->getAllForSixStatus(
            Contract::VACANT, 
            Contract::STARTED,
            Contract::READY_BUT_PENDING_PAYABLE,
            Contract::PROCESSING_PERMIT,
            Contract::WAITING_CLIENT,
            Contract::DOWNLOADING_FILES,
            $filteredOut,
            session('countryId'),
            session('companyId')
        );
           return count($rs);
    }
    public function numberOfContractsFinished(Request $request)
    {
        $rs = $this->oContract->getAllForStatus(Contract::FINISHED,'',session('countryId'),session('companyId'));
           return count($rs);
    }
    public function numberOfContractsCancelled()
    {
       $rs = $this->oContract->getAllForStatus(Contract::CANCELLED,'',session('countryId'),session('companyId'));
           return count($rs);
    }
    public function numberOfContractsbyProjectUse()
    {
         //por compañia, reporte general desde la creacion de la empresa.
       $residential   = $this->oContract->getAllByProjectUse(session('companyId'),2);
       $commercial  = $this->oContract->getAllByProjectUse(session('companyId'),1);
       $others       = $this->oContract->getAllByProjectUse(session('companyId'),3);

        return ['residential' => $residential->count(),
                'commercial'  => $commercial->count(),
                'others'      => $others->count()];
    }

     public function numberOfContractsbyStatus()
    {
       $vacant                 = $this->oContract->getAllForStatus(Contract::VACANT,'',session('countryId'),session('companyId'));
       $started                = $this->oContract->getAllForStatus(Contract::STARTED,'',session('countryId'),session('companyId'));
       $finished               = $this->oContract->getAllForStatus(Contract::FINISHED,'',session('countryId'),session('companyId'));
       $cancelled              = $this->oContract->getAllForStatus(Contract::CANCELLED,'',session('countryId'),session('companyId'));
       $readyButPendingPayable = $this->oContract->getAllForStatus(Contract::READY_BUT_PENDING_PAYABLE,'',session('countryId'),session('companyId'));
       $processingPermit       = $this->oContract->getAllForStatus(Contract::PROCESSING_PERMIT,'',session('countryId'),session('companyId'));
       $waitingClient          = $this->oContract->getAllForStatus(Contract::WAITING_CLIENT,'',session('countryId'),session('companyId'));
       $downloadingFiles       = $this->oContract->getAllForStatus(Contract::DOWNLOADING_FILES,'',session('countryId'),session('companyId'));
       $sentToOffice           = $this->oContract->getAllForStatus(Contract::SENT_TO_OFFICE,'',session('countryId'),session('companyId'));
       $inProductionQueue      = $this->oContract->getAllForStatus(Contract::IN_PRODUCTION_QUEUE,'',session('countryId'),session('companyId'));
       $sentToEngineer         = $this->oContract->getAllForStatus(Contract::SENT_TO_ENGINEER,'',session('countryId'),session('companyId'));

        return ['vacant'                  => $vacant->count(),
                'started'                 => $started->count(),
                'finished'                => $finished->count(),
                'cancelled'               => $cancelled->count(),
                'readyButPendingPayable'  => $readyButPendingPayable->count(),
                'processingPermit'        => $processingPermit->count(),
                'waitingClient'           => $waitingClient->count(),
                'downloadingFiles'        => $downloadingFiles->count(),
                'sentToOffice'            => $sentToOffice->count(),
                'inProductionQueue'       => $inProductionQueue->count(),
                'sentToEngineer'          => $sentToEngineer->count()
               ];
    }
    // public function numberOfContractsResidential()
    // {
    //    $rs = $this->oContract->getAllByProjectUse(2);
    //        return count($rs);
    // }

    // public function numberOfInvoiceOpen()
    // {
    //    $rs = $this->oInvoice->getAllByStatus(Invoice::OPEN,session('companyId'));
    //    return count($rs);
    // }
    // public function numberOfInvoiceClosed()
    // {
    //    $rs = $this->oInvoice->getAllByStatus(Invoice::CLOSED,session('companyId'));
    //    return count($rs);
    // }
        public function numberOfInvoicePaid()
    {
       $rs = $this->oInvoice->getAllByStatus(Invoice::PAID,session('companyId'));
       return count($rs);
    }
    //     public function numberOfInvoiceCancelled()
    // {
    //    $rs = $this->oInvoice->getAllByStatus(Invoice::CANCELLED,session('companyId'));
    //    return count($rs);
    // }

}