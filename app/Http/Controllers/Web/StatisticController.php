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

    public function numberOfClients()
    {
        $rs = $this->oClient->getAll(session('countryId'));
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
    public function numberOfContractsFinished()
    {
        $rs = $this->oContract->getAllForStatus(Contract::FINISHED,'',session('countryId'),session('companyId'));
           return count($rs);
    }
    public function numberOfContractsCancelled()
    {
       $rs = $this->oContract->getAllForStatus(Contract::CANCELLED,'',session('countryId'),session('companyId'));
           return count($rs);
    }
    public function numberOfContractsCommercial()
    {
       $rs = $this->oContract->getAllByProjectUse(1);
           return count($rs);
    }
    public function numberOfContractsResidential()
    {
       $rs = $this->oContract->getAllByProjectUse(2);
           return count($rs);
    }

    public function numberOfInvoiceOpen()
    {
       $rs = $this->oInvoice->getAllByStatus(Invoice::OPEN,session('companyId'));
       return count($rs);
    }
    public function numberOfInvoiceClosed()
    {
       $rs = $this->oInvoice->getAllByStatus(Invoice::CLOSED,session('companyId'));
       return count($rs);
    }
        public function numberOfInvoicePaid()
    {
       $rs = $this->oInvoice->getAllByStatus(Invoice::PAID,session('companyId'));
       return count($rs);
    }
        public function numberOfInvoiceCancelled()
    {
       $rs = $this->oInvoice->getAllByStatus(Invoice::CANCELLED,session('companyId'));
       return count($rs);
    }

}