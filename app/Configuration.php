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

        $oCountry = new Country;
        $contractNumber =   $this->retrieveContractNumber($countryId, $officeId, $contractType);
        $contractNumber++;

        $stringLength = 5;
        $strPad       = "0";

        if ($contractNumber < 1) {
            $contractNumber = "";
        }

        $format1 = substr(date('Y'), 2, 2);
        if ($contractType == "P") {
            $format2 = "-PC-";
        } else {
            $format2 = "-S-";
        }

         $abbreviation = $oCountry->getAbbreviation($countryId);
         $format3 = $abbreviation."-";

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
       // CLIENTES
    //---------------------
    public function retrieveClientNumber($countryId)
    {
        //   esta consulta esta mal , porque si coloco dos paises en tabla config.
        //abra un conflicto y no sabra cual traer del mismo pais

        $contractNumber = 0;
        $rs             = $this->where('countryId', '=', $countryId)
                               ->get();

            foreach ($rs as $rs0) {
                    $contractNumber = $rs0->clientNumber;
                 }
        
        return $contractNumber;
    }
    //--------------------------------------------------------------------
     public function generateClientNumberFormat($countryId) {
        
        $oCountry = new Country();
        $stringLength = 5;
        $strPad       = "0";

         $clientNumber = $this->retrieveClientNumber($countryId);
         $clientNumber++;
    
        if ($clientNumber < 1) {
            $clientNumber = "";
        }
         $abbreviation = $oCountry->getAbbreviation($countryId);
         $format1 = $abbreviation;
         $format2 = "-CU-";
         $format3 = str_pad($clientNumber, $stringLength, $strPad, STR_PAD_LEFT);
       
        // numero de contrato en foramto
        return $clientNumberFormat = $format1 . $format2 . $format3 ;
         
      }

    //--------------------------------------------------------------------
     
    public function increaseClientNumber($countryId)
    {
            $this->where('countryId', $countryId)
                 ->increment('clientNumber');
    }

   //--------------------------------------------------------------------
       // INVOICES
      //--------------------------------------------------------------------
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
        
        $stringLength = 5;
        $strPad       = "0";

         $invoiceNumber = $this->retrieveInvoiceNumber($countryId,$officeId);
         $invoiceNumber++;

        if ($invoiceNumber < 1) {
            $invoiceNumber = "";
        }

         $format3 = str_pad($invoiceNumber, $stringLength, $strPad, STR_PAD_LEFT);
       
        // numero de contrato en foramto
        return $invoiceNumberFormat = $format3 ;
         
      }

    //--------------------------------------------------------------------
     
    public function increaseInvoiceNumber($countryId,$officeId)
    {
            $this->where('countryId', $countryId)
                 ->where('officeId', $officeId)
                 ->increment('invoiceNumber');
    }
}