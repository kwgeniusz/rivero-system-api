<?php

namespace App\Http\Controllers\Web\Intercompany\Export;

use Auth;
use App;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\DateHelper;
use App\Precontract;
use App\Proposal;
use App\ProposalDetail;
use App\Contract;
use App\Invoice;
use App\InvoiceDetail;
use App\CompanyConfiguration;
use App\ProjectDescription;

class InvoiceExportController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->oPrecontract           = new Precontract;
        $this->oProposal              = new Proposal;
        $this->oProposalDetail         = new ProposalDetail;
        $this->oContract              = new Contract;
        $this->oInvoice               = new Invoice;
        $this->oInvoiceDetail         = new InvoiceDetail;
        $this->oCompanyConfiguration  = new CompanyConfiguration;
        $this->oProjectDescription    = new Projectdescription;
    }

    public function sendData(Request $request)
    {
 
        $contract = $this->oContract->findById($request->id,session('countryId'),session('companyId'));
        $paymentConditions = $this->oPaymentCondition->getAllByLanguage(session('countryId'));
        $projectDescriptions = $this->oProjectDescription->getAll();

        $invId = $this->oCompanyConfiguration->retrieveInvoiceNumber(session('countryId'),session('companyId'));
        $invId++;
        $invoiceTaxPercent   = $this->oCompanyConfiguration->findInvoiceTaxPercent(session('countryId'),session('companyId'));


        return view('module_contracts.invoices.create', compact('contract','paymentConditions','invId','invoiceTaxPercent','projectDescriptions'));
    }

}

