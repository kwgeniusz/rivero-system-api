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
    /** Relations */
//--------------------------------------------------------------------
    public function company()
    {
        return $this->belongTo('App\Company', 'companyId', 'companyId');
    }
//--------------------------------------------------------------------
         //CLIENT NUMBER 
//-------------------------------------------------------------------

    public function retrieveClientNumber($companyId,$parentCompanyId)
    {
     
        //   esta consulta esta mal , porque si coloco dos paises en tabla config.
        //abra un conflicto y no sabra cual traer del mismo pais

         $clientNumber = 0;

        if($parentCompanyId == 0 ) {
           $rs = $this->where('companyId', '=', $companyId)->get(); 
         } else {
           $rs = $this->where('companyId', '=', $parentCompanyId)->get();
         } 

         $clientNumber = $rs[0]->clientNumber;
         $clientNumber++;

        return $clientNumber;
    }
//--------------------------------------------------------------------
     public function generateClientNumberFormat($companyId,$parentCompanyId) {
  
        $stringLength = 8;
        $strPad       = "0";

         $clientNumber = $this->retrieveClientNumber($companyId,$parentCompanyId);
    
        if ($clientNumber < 1) {
            $clientNumber = "";
        }
         $codePrefix = $this->getCodePrefixClient($companyId,$parentCompanyId);
         $format1 = $codePrefix;
         $format2 = str_pad($clientNumber, $stringLength, $strPad, STR_PAD_LEFT);
       
        // numero de contrato en foramto
        return $clientNumberFormat = $format1 . $format2;
         
      }

    //---------------------------------------------------------------------
    public function increaseClientNumber($companyId,$parentCompanyId)
    {
        if($parentCompanyId == 0 ) {
            $this->where('companyId', $companyId)->increment('clientNumber');
         } else {
            $this->where('companyId', $parentCompanyId)->increment('clientNumber');
         } 
    }
//---------------------------------------------------------------------------
//CONTRACT NUMBER
//---------------------------------------------------------------------------
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

       $codePrefix = $this->getCodePrefixContract($companyId);

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

//---------------------------------------------------------------------------
   // CREDIT NOTE NUMBER
//---------------------------------------------------------------------------
    public function retrieveCreditNoteNumber($countryId, $companyId)
    {
        $creditNoteNumber = 0;
        $rs             = $this->where('countryId', '=', $countryId)
                               ->where('companyId', '=', $companyId)
                               ->get();

        return $rs[0]->creditNoteNumber;
    }
    //--------------------------------------------------------------------
    public function increaseCreditNoteNumber($countryId, $companyId)
    {
            $this->where('countryId', $countryId)
                ->where('companyId', $companyId)
                ->increment('creditNoteNumber');
    }
//---------------------------------------------------------------------------
   // DEBIT NOTE NUMBER
//---------------------------------------------------------------------------
    public function retrieveDebitNoteNumber($countryId, $companyId)
    {
        $debitNoteNumber = 0;
        $rs             = $this->where('countryId', '=', $countryId)
                               ->where('companyId', '=', $companyId)
                               ->get();

        return $rs[0]->debitNoteNumber;
    }
    //--------------------------------------------------------------------
    public function increaseDebitNoteNumber($countryId, $companyId)
    {
            $this->where('countryId', $countryId)
                 ->where('companyId', $companyId)
                ->increment('debitNoteNumber');
    }
//---------------------------------------------------------------------------
   // ACCOUNTING - ENTRY NUMBER
//---------------------------------------------------------------------------
    public function retrieveEntryNumber($countryId, $companyId)
    {
        //    return   ($this->where('lastUserId', '=', $userId)->get())->toArray();

        $entryNumber = 0;
        $rs             = $this->where('countryId', '=', $countryId)
                               ->where('companyId', '=', $companyId)
                               ->get();

        if (!empty($rs)) {
            foreach ($rs as $rs0) {
                    $entryNumber = $rs0->accEntryNumber;
            }
        }

        return $entryNumber;
    }
    //--------------------------------------------------------------------
    public function increaseEntryNumber($countryId, $companyId)
    {
            $this->where('countryId', $countryId)
                ->where('companyId', $companyId)
                ->increment('accEntryNumber');
    }    
//--------------------------------------------------------------------
       //MISCELLANEOUS FUNCTIONS
//-------------------------------------------------
    public function getCodePrefixContract($companyId){
        $rs = $this->where('companyId', $companyId)
                    ->get();
 
        return $rs[0]->codePrefixContract;
    }
    //----------------------------------------------------------------------
    public function getCodePrefixClient($companyId,$parentCompanyId){

         if($parentCompanyId == 0 ) {
           $rs = $this->where('companyId', $companyId)->get();
         } else {
           $rs = $this->where('companyId', $parentCompanyId)->get();
         } 
 
        return $rs[0]->codePrefixClient;
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