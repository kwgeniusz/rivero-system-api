<?php

namespace App;

use App\Client;
use App\Country;
use App\Office;
use App\ProjectType;
use App\ServiceType;
use Illuminate\Database\Eloquent\Model;

class Precontract extends Model
{
    public $timestamps = false;

    protected $table      = 'pre_contract';
    protected $primaryKey = 'precontractId';
    //  protected $dateFormat = 'Y-m-d';
    protected $fillable = ['precontractId', 'contractType', 'countryId', 'officeId',
        'clientId', 'siteAddress', 'projectTypeId', 'serviceTypeId', 'comment',
        'currencyName',
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
    public function projectType()
    {
        return $this->belongsTo('App\ProjectType', 'projectTypeId');
    }
    public function serviceType()
    {
        return $this->belongsTo('App\ServiceType', 'serviceTypeId');
    }
    public function office()
    {
        return $this->belongsTo('App\Office', 'officeId');
    }
    public function country()
    {
        return $this->belongsTo('App\Country', 'countryId');
    }
    public function payment()
    {
        return $this->hasMany('App\PaymentPrecontract', 'precontractId', 'precontractId');
    }

//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    //------------------------------------------
    public function getAllForType($contractType)
    {
        $result = $this->where('contractType', $contractType)
            ->orderBy('precontractId', 'ASC')
            ->get();

        return $result;
    }
//------------------------------------------
    public function findById($id)
    {
        return $this->where('precontractId', '=', $id)->get();
    }
//------------------------------------------
    public function insertPrecontract($countryId, $officeId, $contractType,
        $clientId, $siteAddress, $projectTypeId, $serviceTypeId, $comment, $currencyName) {

        $precontract                         = new Precontract;
        $precontract->contractType           = $contractType;
        $precontract->countryId              = $countryId;
        $precontract->officeId               = $officeId;
        $precontract->clientId               = $clientId;
        $precontract->siteAddress            = $siteAddress;
        $precontract->projectTypeId          = $projectTypeId;
        $precontract->serviceTypeId          = $serviceTypeId;
        $precontract->comment                = $comment;
        $precontract->precontractCost        = '0.00';
        $precontract->currencyName           = $currencyName;
        $precontract->save();

    }
//------------------------------------------
    public function updatePrecontract($precontractId, $countryId, $officeId, $clientId,
        $siteAddress, $projectTypeId, $serviceTypeId, $comment, $currencyName) {

        $precontract                = precontract::find($precontractId);
        $precontract->countryId     = $countryId;
        $precontract->officeId      = $officeId;
        $precontract->clientId      = $clientId;
        $precontract->siteAddress   = $siteAddress;
        $precontract->projectTypeId = $projectTypeId;
        $precontract->serviceTypeId = $serviceTypeId;
        $precontract->comment       = $comment;
        $precontract->currencyName  = $currencyName;
        $precontract->save();

    }
//------------------------------------------
    public function deletePrecontract($precontractId)
    {
        return $this->where('precontractId', '=', $precontractId)->delete();
    }
}
