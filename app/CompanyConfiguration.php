<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyConfiguration extends Model
{
    public $timestamps = false;

    protected $table      = 'company_configuration';
    protected $primaryKey = 'companyConfigId';
    protected $fillable   = [
                 'countryId',
                 'companyId',
                 'codePrefix',
                 'currencyId',
                 'contractNumber',
                 'precontractNumber',
                 'proposalNumber',
                 'invoiceNumber',
                 'invoiceTaxPercent',
                 'dateCreated',
                 'lastUserId',
    ];
    protected $dates      = ['dateCreated'];
//--------------------------------------------------------------------
//CONTRACT NUMBER
//--------------------------------------------------------------------
    public function retrieveContractNumber($countryId, $companyId)
    {
        //    return   ($this->where('lastUserId', '=', $userId)->get())->toArray();

        $contractNumber = 0;
        $rs             = $this->where('countryId', '=', $countryId)
                               ->where('companyId', '=', $companyId)
                               ->get();

        if (!empty($rs)) {
            foreach ($rs as $rs0) {
                    $contractNumber = $rs0->contractNumber;
            }
        }

        return $contractNumber;
    }
    //--------------------------------------------------------------------
  public function generateContractNumberFormat($countryId,$companyId) {

        $contractNumber =   $this->retrieveContractNumber($countryId, $companyId);
        $contractNumber++;

        $stringLength = 8;
        $strPad       = "0";

        if ($contractNumber < 1) {
            $contractNumber = "";
        }

       $codePrefix = $this->getCodePrefix($countryId,$companyId);

        $format1 = $codePrefix;
        $format2 = substr(date('Y'), 2, 2);
        $format3 = str_pad($contractNumber, $stringLength, $strPad, STR_PAD_LEFT);

        // numero de contrato en foramto
       return $contractNumberFormat = $format1 . $format2 . $format3;
    }
    //--------------------------------------------------------------------
    public function increaseContractNumber($countryId, $companyId)
    {
            $this->where('countryId', $countryId)
                ->where('companyId', $companyId)
                ->increment('contractNumber');
    }
//--------------------------------------------------------------------
// [PRECONTRACT] NUMBER
//--------------------------------------------------------------------
    public function retrievePrecontractNumber($countryId, $companyId)
    {
        //    return   ($this->where('lastUserId', '=', $userId)->get())->toArray();

        $precontractNumber = 0;
        $rs             = $this->where('countryId', '=', $countryId)
                               ->where('companyId', '=', $companyId)
                               ->get();

        if (!empty($rs)) {
            foreach ($rs as $rs0) {
                    $precontractNumber = $rs0->precontractNumber;
            }
        }

        return $precontractNumber;
    }
    //--------------------------------------------------------------------
    public function increasePrecontractNumber($countryId, $companyId)
    {
            $this->where('countryId', $countryId)
                ->where('companyId', $companyId)
                ->increment('precontractNumber');
    }
    //--------------------------------------------------------------------
         //INVOICES NUMBER
    //-------------------------------------------------------------------
    public function retrieveInvoiceNumber($countryId,$companyId)
    {

        $invoiceNumber = 0;
        $rs             = $this->where('countryId', $countryId)
                               ->where('companyId', $companyId)
                               ->get();

            foreach ($rs as $rs0) {
                    $invoiceNumber = $rs0->invoiceNumber;
                 }
        
        return $invoiceNumber;
    }
//--------------------------------------------------------------------   
    public function increaseInvoiceNumber($countryId,$companyId)
    {
            $this->where('countryId', $countryId)
                 ->where('companyId', $companyId)
                 ->increment('invoiceNumber');
    }

 //--------------------------------------------------------------------
//PROPOSAL NUMBER
    //-------------------------------------------------------------------
    public function retrieveProposalNumber($countryId,$companyId)
    {

        $proposalNumber = 0;
        $rs             = $this->where('countryId', $countryId)
                               ->where('companyId', $companyId)
                               ->get();

            foreach ($rs as $rs0) {
                    $proposalNumber = $rs0->proposalNumber;
                 }
        
        return $proposalNumber;
    }
//--------------------------------------------------------------------   
    public function increaseProposalNumber($countryId,$companyId)
    {
            $this->where('countryId', $countryId)
                 ->where('companyId', $companyId)
                 ->increment('proposalNumber');
    }
    //--------------------------------------------------------------------

    //--------------------------------------------------------------------
       //MISCELLANEOUS FUNCTIONS
    //-------------------------------------------------
    public function getCodePrefix($countryId,$companyId){
        $rs = $this->where('countryId', $countryId)
                   ->where('companyId', $companyId)
                    ->get();
 
        return $rs[0]->codePrefix;
    }
    //-------------------------------------------------

    public function findInvoiceTaxPercent($countryId,$companyId)
    {

        $invoiceTaxPercent = 0;
        $rs             = $this->where('countryId', $countryId)
                               ->where('companyId', $companyId)
                               ->get();

            foreach ($rs as $rs0) {
                    $invoiceTaxPercent = $rs0->invoiceTaxPercent;
                 }
        
        return $invoiceTaxPercent;
    }
}