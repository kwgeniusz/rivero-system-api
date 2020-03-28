<?php

namespace App;

use App\Client;
use App\Country;
use App\Office;
use App\ProjectDescription;
use App\Projectuse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\DateHelper;

class Precontract extends Model
{

    //traits
    use SoftDeletes;

    public $timestamps = false;

    protected $table      = 'pre_contract';
    protected $primaryKey = 'precontractId';
    //protected $dateFormat = 'Y-m-d';
    protected $fillable = ['precontractId', 'contractType', 'countryId', 'officeId',
        'clientId', 'siteAddress','buildingCodeId', 'projectDescriptionId', 'projectUseId', 'comment',
        'currencyId',
    ];

//--------------------------------------------------------------------
                     /** ACCESORES  **/
//--------------------------------------------------------------------
   public function getSiteAddressAttribute()
   {
   return $this->propertyNumber.' '.$this->streetName.' '.$this->streetType.' '.$this->suiteNumber.' '.$this->city.' '.$this->state.' '.$this->zipCode;
   }
   
    public function getPrecontractCostAttribute($precontractCost)
    {
        return decrypt($precontractCost);
    }
     public function getPrecontractDateAttribute($precontractDate)
    {
         $oDateHelper = new DateHelper;
         $functionRs = $oDateHelper->changeDateForCountry(session('countryId'),'Accesor');
         $newDate    = $oDateHelper->$functionRs($precontractDate);
        return $newDate;
    }
//------------------------MUTADORES--------------------------------

    public function setPrecontractCostAttribute($precontractCost)
    {
        return $this->attributes['precontractCost'] = encrypt($precontractCost);
    }
    public function setPrecontractDateAttribute($precontractDate)
    {
         $oDateHelper = new DateHelper;
         $functionRs = $oDateHelper->changeDateForCountry(session('countryId'),'Mutador');
         $newDate    = $oDateHelper->$functionRs($precontractDate);

        $this->attributes['precontractDate'] = $newDate;
    }
//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
    public function client()
    {
        return $this->belongsTo('App\Client', 'clientId');
    }
    public function buildingCode()
    {
        return $this->belongsTo('App\BuildingCode', 'buildingCodeId');
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
    public function proposal()
    {
        return $this->hasOne('App\Proposal', 'precontractId', 'precontractId');
    }

//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    //------------------------------------------
    public function getAll($countryId,$officeId)
    {
        $result = $this->where('countryId', $countryId)
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
    public function insertPrecontract($countryId, $officeId, $contractType,$precontractDate, $clientId,$propertyNumber,$streetName,$streetType,$suiteNumber,$city,$state,$zipCode, $buildingCodeId, $projectUseId,$projectDescriptionId, $comment, $currencyId) {
        
        $oConfiguration = new OfficeConfiguration();
        $preId = $oConfiguration->retrievePrecontractNumber($countryId, $officeId);
        $preId++;
                 $oConfiguration->increasePrecontractNumber($countryId, $officeId);

        $precontract                         = new Precontract;
        $precontract->preId                  = $preId;
        $precontract->countryId              = $countryId;
        $precontract->officeId               = $officeId;
        $precontract->contractType           = $contractType;
        $precontract->precontractDate        = $precontractDate;
        $precontract->clientId               = $clientId;
        $precontract->propertyNumber         = $propertyNumber;
        $precontract->streetName             = $streetName;
        $precontract->streetType             = $streetType;
        $precontract->suiteNumber            = $suiteNumber;
        $precontract->city                   = $city;
        $precontract->state                  = $state;
        $precontract->zipCode                = $zipCode;
        $precontract->buildingCodeId         = $buildingCodeId;
        $precontract->projectUseId           = $projectUseId;
        $precontract->projectDescriptionId   = $projectDescriptionId;
        $precontract->comment                = $comment;
        $precontract->precontractCost        = '0.00';
        $precontract->currencyId             = $currencyId;
        $precontract->save();

    }
//------------------------------------------
    public function updatePrecontract($precontractId, $countryId, $officeId, $contractType,$precontractDate,$clientId,$propertyNumber,$streetName,$streetType,$suiteNumber,$city,$state,$zipCode,$buildingCodeId,$projectUseId, $projectDescriptionId, $comment, $currencyId) {

        $precontract                = precontract::find($precontractId);
        $precontract->countryId     = $countryId;
        $precontract->officeId      = $officeId;
        $precontract->contractType   = $contractType;
        $precontract->precontractDate  = $precontractDate;
        $precontract->clientId      = $clientId;
         $precontract->propertyNumber         = $propertyNumber;
        $precontract->streetName             = $streetName;
        $precontract->streetType             = $streetType;
        $precontract->suiteNumber            = $suiteNumber;
        $precontract->city                   = $city;
        $precontract->state                  = $state;
        $precontract->zipCode                = $zipCode;
        $precontract->buildingCodeId = $buildingCodeId;
        $precontract->projectUseId = $projectUseId;
        $precontract->projectDescriptionId = $projectDescriptionId;
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
//------------------------------------------
    public function assignContractId($precontractId,$contractId)
    {
         $precontract                = precontract::find($precontractId);
         $precontract->contractId     = $contractId;
         $precontract->save();
    }
}
