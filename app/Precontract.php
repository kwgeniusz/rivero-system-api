<?php

namespace App;

use App\Client;
use App\Country;
use App\Company;
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
    protected $fillable = ['precontractId', 'contractType', 'countryId', 'companyId',
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
    /** Query Scope  */
//--------------------------------------------------------------------

     public function scopeFilter($query, $filteredOut)
    {
        if ($filteredOut) {
            return $query->where('precontractId', 'LIKE', "%$filteredOut%")
                         ->orWhere('propertyNumber', 'LIKE', "%$filteredOut%")
                         ->orWhere('streetName', 'LIKE', "%$filteredOut%")
                         ->orWhere('streetType', 'LIKE', "%$filteredOut%")
                         ->orWhere('suiteNumber', 'LIKE', "%$filteredOut%")
                         ->orWhere('city', 'LIKE', "%$filteredOut%")
                         ->orWhere('state', 'LIKE', "%$filteredOut%")
                         ->orWhere('zipCode', 'LIKE', "%$filteredOut%")
                         ->orWhereHas('client', function ($query) use ($filteredOut) {
                              return $query->where('clientCode', 'LIKE', "%$filteredOut%");
                          })
                         ->orWhereHas('client', function ($query) use ($filteredOut) {
                              return $query->where('clientName', 'LIKE', "%$filteredOut%");
                          });
        }
    }
   
//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
    public function client()
    {
        return $this->belongsTo('App\Client', 'clientId');
    }
    public function document()
    {
        return $this->hasMany('App\Document', 'precontractId', 'precontractId')->with('user');
    }
    public function buildingCode()
    {
        return $this->belongsTo('App\BuildingCode', 'buildingCodeId');
    }
       public function buildingCodeGroup()
    {
        return $this->belongsTo('App\BuildingCodeGroup', 'groupId');
    }
    public function projectUse()
    {
        return $this->belongsTo('App\ProjectUse', 'projectUseId');
    }
    public function company()
    {
        return $this->belongsTo('App\Company', 'companyId');
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
        return $this->hasMany('App\Proposal', 'precontractId', 'precontractId');
    }

//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    //------------------------------------------
    public function getAll($countryId,$companyId,$filteredOut)
    {
        $result = $this->with('client','buildingCode','projectUse','proposal.projectDescription')
            ->where('countryId', $countryId)
            ->where('companyId', $companyId) 
            ->orderBy('precontractId', 'DESC')
            ->filter($filteredOut)
            ->get();

        return $result;
    }
//------------------------------------------
    public function findById($id,$countryId,$companyId)
    {
        return $this->where('precontractId', '=', $id)
                     ->where('countryId', $countryId)
                     ->where('companyId', $companyId) 
                     ->get();
    }
//------------------------------------------
    public function insertPrecontract($countryId, $companyId, $contractType,$projectName,$precontractDate, $clientId,$propertyNumber,$streetName,$streetType,$suiteNumber,$city,$state,$zipCode, $buildingCodeId,$groupId, $projectUseId,$constructionType, $comment, $currencyId) {
        
        $oConfiguration = new CompanyConfiguration();
        $preId = $oConfiguration->retrievePrecontractNumber($countryId, $companyId);
        $preId++;
                 $oConfiguration->increasePrecontractNumber($countryId, $companyId);

        $precontract                         = new Precontract;
        $precontract->preId                  = $preId;
        $precontract->countryId              = $countryId;
        $precontract->companyId               = $companyId;
        $precontract->contractType           = $contractType;
        $precontract->projectName           = $projectName;
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
        $precontract->groupId                = $groupId;
        $precontract->projectUseId           = $projectUseId;
        $precontract->constructionType       = $constructionType;
        // $precontract->projectDescriptionId   = $projectDescriptionId;
        $precontract->comment                = $comment;
        $precontract->precontractCost        = '0.00';
        $precontract->currencyId             = $currencyId;
        $precontract->save();

    }
//------------------------------------------
    public function updatePrecontract($precontractId, $countryId, $companyId,$contractType,$projectName,$precontractDate,$clientId,$propertyNumber,$streetName,$streetType,$suiteNumber,$city,$state,$zipCode,$buildingCodeId,$groupId, $projectUseId,$constructionType, $comment, $currencyId) {

        $precontract                        = precontract::find($precontractId);
        $precontract->countryId             = $countryId;
        $precontract->companyId              = $companyId;
        $precontract->contractType          = $contractType;
        $precontract->projectName           = $projectName;
        $precontract->precontractDate       = $precontractDate;
        $precontract->clientId              = $clientId;
        $precontract->propertyNumber        = $propertyNumber;
        $precontract->streetName            = $streetName;
        $precontract->streetType            = $streetType;
        $precontract->suiteNumber           = $suiteNumber;
        $precontract->city                  = $city;
        $precontract->state                 = $state;
        $precontract->zipCode               = $zipCode;
        $precontract->buildingCodeId         = $buildingCodeId;
        $precontract->groupId                = $groupId;
        $precontract->projectUseId           = $projectUseId;
        $precontract->constructionType       = $constructionType;
        // $precontract->projectDescriptionId             = $projectDescriptionId;
        $precontract->comment                   = $comment;
        $precontract->currencyId              = $currencyId;
        $precontract->save();

    }
//------------------------------------------
    public function deletePrecontract($precontractId,$countryId,$companyId)
    {
        return $this->where('precontractId', '=', $precontractId)
                    ->where('countryId', $countryId)
                    ->where('companyId', $companyId) 
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
