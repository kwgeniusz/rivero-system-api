<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CountryConfiguration extends Model
{
    public $timestamps = false;

    protected $table      = 'country_configuration';
    protected $primaryKey = 'countryConfigId';
    protected $fillable   = [
                            'countryConfigId',
                            'countryId',
                            'language',
                            'format_date',
                            'clientNumber'
                            ];
    protected $dates      = ['dateCreated'];


    //--------------------------------------------------------------------
         //CLIENT NUMBER 
    //-------------------------------------------------------------------
    public function retrieveClientNumber($countryId)
    {
        //   esta consulta esta mal , porque si coloco dos paises en tabla config.
        //abra un conflicto y no sabra cual traer del mismo pais

        $clientNumber = 0;
        $rs           = $this->where('countryId', '=', $countryId)->get();

            foreach ($rs as $rs0) {
                    $clientNumber = $rs0->clientNumber;
                 }
        
        return $clientNumber;
    }
    //--------------------------------------------------------------------
     public function generateClientNumberFormat($countryId) {
        

        $stringLength = 8;
        $strPad       = "0";

         $clientNumber = $this->retrieveClientNumber($countryId);
         $clientNumber++;
    
        if ($clientNumber < 1) {
            $clientNumber = "";
        }
         $codePrefix = $this->getCodePrefix($countryId);
         $format1 = $codePrefix;
         $format2 = str_pad($clientNumber, $stringLength, $strPad, STR_PAD_LEFT);
       
        // numero de contrato en foramto
        return $clientNumberFormat = $format1 . $format2;
         
      }

    //--------------------------------------------------------------------
     
    public function increaseClientNumber($countryId)
    {
            $this->where('countryId', $countryId)
                 ->increment('clientNumber');
    }

    //--------------------------------------------------------------------
       //MISCELLANEOUS FUNCTIONS
    //-------------------------------------------------
    public function getCodePrefix($countryId){
        $rs = $this->where('countryId', $countryId)
                    ->get();
 
        return $rs[0]->codePrefix;
    }
}