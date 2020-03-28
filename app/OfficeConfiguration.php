<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfficeConfiguration extends Model
{
    public $timestamps = false;

    protected $table      = 'office_configuration';
    protected $primaryKey = 'officeConfigId';
    protected $fillable   = [
                 'countryId',
                 'officeId',
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
    public function retrieveContractNumber($countryId, $officeId)
    {
        //    return   ($this->where('lastUserId', '=', $userId)->get())->toArray();

        $contractNumber = 0;
        $rs             = $this->where('countryId', '=', $countryId)
                               ->where('officeId', '=', $officeId)
                               ->get();

        if (!empty($rs)) {
            foreach ($rs as $rs0) {
                    $contractNumber = $rs0->contractNumber;
            }
        }

        return $contractNumber;
    }
    //--------------------------------------------------------------------
  public function generateContractNumberFormat($countryId,$officeId) {

        $contractNumber =   $this->retrieveContractNumber($countryId, $officeId);
        $contractNumber++;

        $stringLength = 8;
        $strPad       = "0";

        if ($contractNumber < 1) {
            $contractNumber = "";
        }

       $codePrefix = $this->getCodePrefix($countryId,$officeId);

        $format1 = $codePrefix;
        $format2 = substr(date('Y'), 2, 2);
        $format3 = str_pad($contractNumber, $stringLength, $strPad, STR_PAD_LEFT);

        // numero de contrato en foramto
       return $contractNumberFormat = $format1 . $format2 . $format3;
    }
    //--------------------------------------------------------------------
    public function increaseContractNumber($countryId, $officeId)
    {
            $this->where('countryId', $countryId)
                ->where('officeId', $officeId)
                ->increment('contractNumber');
    }
//--------------------------------------------------------------------
// [PRECONTRACT] NUMBER
//--------------------------------------------------------------------
    public function retrievePrecontractNumber($countryId, $officeId)
    {
        //    return   ($this->where('lastUserId', '=', $userId)->get())->toArray();

        $precontractNumber = 0;
        $rs             = $this->where('countryId', '=', $countryId)
                               ->where('officeId', '=', $officeId)
                               ->get();

        if (!empty($rs)) {
            foreach ($rs as $rs0) {
                    $precontractNumber = $rs0->precontractNumber;
            }
        }

        return $precontractNumber;
    }
    //--------------------------------------------------------------------
    public function increasePrecontractNumber($countryId, $officeId)
    {
            $this->where('countryId', $countryId)
                ->where('officeId', $officeId)
                ->increment('precontractNumber');
    }
    //--------------------------------------------------------------------
         //INVOICES NUMBER
    //-------------------------------------------------------------------
    public function retrieveInvoiceNumber($countryId,$officeId)
    {

        $invoiceNumber = 0;
        $rs             = $this->where('countryId', $countryId)
                               ->where('officeId', $officeId)
                               ->get();

            foreach ($rs as $rs0) {
                    $invoiceNumber = $rs0->invoiceNumber;
                 }
        
        return $invoiceNumber;
    }
//--------------------------------------------------------------------   
    public function increaseInvoiceNumber($countryId,$officeId)
    {
            $this->where('countryId', $countryId)
                 ->where('officeId', $officeId)
                 ->increment('invoiceNumber');
    }

 //--------------------------------------------------------------------
//PROPOSAL NUMBER
    //-------------------------------------------------------------------
    public function retrieveProposalNumber($countryId,$officeId)
    {

        $proposalNumber = 0;
        $rs             = $this->where('countryId', $countryId)
                               ->where('officeId', $officeId)
                               ->get();

            foreach ($rs as $rs0) {
                    $proposalNumber = $rs0->proposalNumber;
                 }
        
        return $proposalNumber;
    }
//--------------------------------------------------------------------   
    public function increaseProposalNumber($countryId,$officeId)
    {
            $this->where('countryId', $countryId)
                 ->where('officeId', $officeId)
                 ->increment('proposalNumber');
    }
    //--------------------------------------------------------------------

    //--------------------------------------------------------------------
       //MISCELLANEOUS FUNCTIONS
    //-------------------------------------------------
    public function getCodePrefix($countryId,$officeId){
        $rs = $this->where('countryId', $countryId)
                   ->where('officeId', $officeId)
                    ->get();
 
        return $rs[0]->codePrefix;
    }
    //-------------------------------------------------

    public function findInvoiceTaxPercent($countryId,$officeId)
    {

        $invoiceTaxPercent = 0;
        $rs             = $this->where('countryId', $countryId)
                               ->where('officeId', $officeId)
                               ->get();

            foreach ($rs as $rs0) {
                    $invoiceTaxPercent = $rs0->invoiceTaxPercent;
                 }
        
        return $invoiceTaxPercent;
    }
}