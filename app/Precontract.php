<?php

namespace App;

use App\Client;
use App\Country;
use App\Office;
use App\ProjectDescription;
use App\Projectuse;
use Illuminate\Database\Eloquent\Model;

class Precontract extends Model
{
    public $timestamps = false;

    protected $table      = 'pre_contract';
    protected $primaryKey = 'precontractId';
    //protected $dateFormat = 'Y-m-d';
    protected $fillable = ['precontractId', 'contractType', 'countryId', 'officeId',
        'clientId', 'siteAddress', 'projectDescriptionId', 'projectUseId', 'comment',
        'currencyId',
    ];

//--------------------------------------------------------------------
                     /** ACCESORES  **/
//--------------------------------------------------------------------

    public function getPrecontractCostAttribute($precontractCost)
    {
        return decrypt($precontractCost);
    }
//------------------------MUTADORES--------------------------------

    public function setPrecontractCostAttribute($precontractCost)
    {
        return $this->attributes['precontractCost'] = encrypt($precontractCost);
    }

//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
    public function client()
    {
        return $this->belongsTo('App\Client', 'clientId');
    }
    public function projectDescription()
    {
        return $this->belongsTo('App\ProjectDescription', 'projectDescriptionId');
    }
    public function projectUse()
    {
        return $this->belongsTo('App\ProjectUse', 'projectUseId');
    }
    public function office()
    {
        return $this->belongsTo('App\Office', 'officeId');
    }
    public function country()
    {
        return $this->belongsTo('App\Country', 'countryId');
    }
      public function currency()
    {
        return $this->hasOne('App\Currency', 'currencyId', 'currencyId');
    }
    public function payment()
    {
        return $this->hasMany('App\PaymentPrecontract', 'precontractId', 'precontractId');
    }

//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    //------------------------------------------
    public function getAllForType($contractType,$countryId,$officeId)
    {
        $result = $this->where('contractType', $contractType)
            ->where('countryId', $countryId)
            ->where('officeId', $officeId) 
            ->orderBy('precontractId', 'ASC')
            ->get();

        return $result;
    }
//------------------------------------------
    public function findById($id,$countryId,$officeId)
    {
        return $this->where('precontractId', '=', $id)
                     ->where('countryId', $countryId)
                     ->where('officeId', $officeId) 
                     ->get();
    }
//------------------------------------------
    public function insertPrecontract($countryId, $officeId, $contractType,
        $clientId, $siteAddress, $projectDescriptionId, $projectUseId, $comment, $currencyId) {

        $precontract                         = new Precontract;
        $precontract->contractType           = $contractType;
        $precontract->countryId              = $countryId;
        $precontract->officeId               = $officeId;
        $precontract->clientId               = $clientId;
        $precontract->siteAddress            = $siteAddress;
        $precontract->projectDescriptionId          = $projectDescriptionId;
        $precontract->projectUseId          = $projectUseId;
        $precontract->comment                = $comment;
        $precontract->precontractCost        = '0.00';
        $precontract->currencyId           = $currencyId;
        $precontract->save();

    }
//------------------------------------------
    public function updatePrecontract($precontractId, $countryId, $officeId, $clientId,
        $siteAddress, $projectDescriptionId, $projectUseId, $comment, $currencyId) {

        $precontract                = precontract::find($precontractId);
        $precontract->countryId     = $countryId;
        $precontract->officeId      = $officeId;
        $precontract->clientId      = $clientId;
        $precontract->siteAddress   = $siteAddress;
        $precontract->projectDescriptionId = $projectDescriptionId;
        $precontract->projectUseId = $projectUseId;
        $precontract->comment       = $comment;
        $precontract->currencyId  = $currencyId;
        $precontract->save();

    }
//------------------------------------------
    public function deletePrecontract($precontractId,$countryId,$officeId)
    {
        return $this->where('precontractId', '=', $precontractId)
                    ->where('countryId', $countryId)
                    ->where('officeId', $officeId) 
                    ->delete();
    }
}
