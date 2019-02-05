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
}
