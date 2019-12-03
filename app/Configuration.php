<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    public $timestamps = false;

    protected $table      = 'configuration';
    protected $primaryKey = 'configurationId';
    protected $fillable   = ['countryId', 'officeId', 'projectNumber', 'serviceNumber', 'contractNumber', 'lastUserId'];
    protected $dates      = ['dateCreated'];

    //--------------------------------------------------------------------
    //CONTRACT NUMBER
    //--------------------------------------------------------------------
    public function retrieveContractNumber($countryId, $officeId, $contractType)
    {
        //    return   ($this->where('lastUserId', '=', $userId)->get())->toArray();

        $contractNumber = 0;
        $rs             = $this->where('countryId', '=', $countryId)
            ->where('officeId', '=', $officeId)
            ->get();

        if (!empty($rs)) {
            foreach ($rs as $rs0) {
                if ($contractType == 'P') {
                    $contractNumber = $rs0->projectNumber;
                } else {
                    $contractNumber = $rs0->serviceNumber;
                }

            }
        }

        return $contractNumber;
    }
    //--------------------------------------------------------------------
  public function generateContractNumberFormat($countryId,$officeId,$contractType) {

        $contractNumber =   $this->retrieveContractNumber($countryId, $officeId, $contractType);
        $contractNumber++;

        $stringLength = 5;
        $strPad       = "0";

        if ($contractNumber < 1) {
            $contractNumber = "";
        }

       $codePrefix = $this->getCodePrefix($countryId,$officeId);
       $format1 = $codePrefix;

        $format2 = substr(date('Y'), 2, 2);

        if ($contractType == "P") {
            $format3 = "P";
        } else {
            $format3 = "S";
        }


        $format4 = str_pad($contractNumber, $stringLength, $strPad, STR_PAD_LEFT);

        // numero de contrato en foramto
       return $contractNumberFormat = $format1 . $format2 . $format3 . $format4;
    }
    //--------------------------------------------------------------------
    public function increaseContractNumber($countryId, $officeId, $contractType)
    {
        if ($contractType == 'P') {

            $this->where('countryId', $countryId)
                ->where('officeId', $officeId)
                ->increment('projectNumber');

        } else {
            $this->where('countryId', $countryId)
                ->where('officeId', $officeId)
                ->increment('serviceNumber');
        }

    }

    //--------------------------------------------------------------------
         //CLIENT NUMBER 
    //-------------------------------------------------------------------
    public function retrieveClientNumber($countryId,$officeId)
    {
        //   esta consulta esta mal , porque si coloco dos paises en tabla config.
        //abra un conflicto y no sabra cual traer del mismo pais

        $clientNumber = 0;
        $rs             = $this->where('countryId', '=', $countryId)
                               ->where('officeId', '=', $officeId)
                               ->get();

            foreach ($rs as $rs0) {
                    $clientNumber = $rs0->clientNumber;
                 }
        
        return $clientNumber;
    }
    //--------------------------------------------------------------------
     public function generateClientNumberFormat($countryId,$officeId) {
        

        $stringLength = 5;
        $strPad       = "0";

         $clientNumber = $this->retrieveClientNumber($countryId,$officeId);
         $clientNumber++;
    
        if ($clientNumber < 1) {
            $clientNumber = "";
        }
         $codePrefix = $this->getCodePrefix($countryId,$officeId);
         $format1 = $codePrefix;
         $format2 = str_pad($clientNumber, $stringLength, $strPad, STR_PAD_LEFT);
       
        // numero de contrato en foramto
        return $clientNumberFormat = $format1 . $format2;
         
      }

    //--------------------------------------------------------------------
     
    public function increaseClientNumber($countryId,$officeId)
    {
            $this->where('countryId', $countryId)
                 ->where('officeId', $officeId)
                 ->increment('clientNumber');
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
     public function generateInvoiceNumberFormat($countryId,$officeId) {
        
        $invoiceNumber =   $this->retrieveInvoiceNumber($countryId, $officeId);
        $invoiceNumber++;

        $stringLength = 5;
        $strPad       = "0";

        if ($invoiceNumber < 1) {
            $invoiceNumber = "";
        }

       $codePrefix = $this->getCodePrefix($countryId,$officeId);
       $format1 = $codePrefix;

        $format2 = substr(date('Y'), 2, 2);

        $format3 = str_pad($invoiceNumber, $stringLength, $strPad, STR_PAD_LEFT);

        // numero de contrato en foramto
       return $invoiceNumberFormat = $format1 . $format2 . $format3 ;
         
      }

    //--------------------------------------------------------------------
     
    public function increaseInvoiceNumber($countryId,$officeId)
    {
            $this->where('countryId', $countryId)
                 ->where('officeId', $officeId)
                 ->increment('invoiceNumber');
    }

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