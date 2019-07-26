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
    public function updateContractNumber($countryId, $officeId, $contractType, $contractNumber)
    {
        if ($contractType == 'P') {

            $this->where('countryId', $countryId)
                ->where('officeId', $officeId)
                ->update(array(
                    'projectNumber' => $contractNumber,
                ));

        } else {
            $this->where('countryId', $countryId)
                ->where('officeId', $officeId)
                ->update(array(
                    'serviceNumber' => $contractNumber,
                ));
        }

    }

      //--------------------------------------------------------------------
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
    public function updateClientNumber($countryId, $clientNumber)
    {
            $this->where('countryId', $countryId)
                 ->update(array(
                    'clientNumber' => $clientNumber,
                ));
    }
}