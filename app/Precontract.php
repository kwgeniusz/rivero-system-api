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
    public function buildingCode()
    {
        return $this->belongsTo('App\BuildingCode', 'buildingCodeId');
    }
    public function buildingCodeGroup()
    {
        return $this->belongsTo('App\BuildingCodeGroup', 'groupId');
    }
    public function client()
    {
        return $this->belongsTo('App\Client', 'clientId');
    }
    public function company()
    {
        return $this->belongsTo('App\Company', 'companyId');
    }
    public function country()
    {
        return $this->belongsTo('App\Country', 'countryId');
    }
    public function contract()
    {
        return $this->hasOne('App\Contract', 'contractId');
    }
    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }
    public function currency()
    {
        return $this->hasOne('App\Currency', 'currencyId', 'currencyId');
    }
    public function document()
    {
        return $this->hasMany('App\Document', 'precontractId', 'precontractId')->with('user');
    }
    
    public function projectUse()
    {
        return $this->belongsTo('App\ProjectUse', 'projectUseId');
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
    public function insertPrecontract($countryId, $companyId, $contractType,$projectName,$precontractDate, $clientId,$propertyNumber,$streetName,$streetType,$suiteNumber,$city,$state,$zipCode,$projectUseId, $comment, $currencyId) {
        
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
        // $precontract->buildingCodeId         = $buildingCodeId;
        // $precontract->groupId                = $groupId;
        $precontract->projectUseId           = $projectUseId;
        // $precontract->constructionType       = $constructionType;
        $precontract->comment                = $comment;
        $precontract->precontractCost        = '0.00';
        $precontract->currencyId             = $currencyId;
        $precontract->save();

    }
//------------------------------------------
    public function updatePrecontract($precontractId,$data) {
        
    
        
        $precontract                        = precontract::find($precontractId);

        $precontract->contractType          = !empty($data['contractType']) ? $data['contractType'] : $precontract->contractType;
        $precontract->projectName           = !empty($data['projectName']) ? $data['projectName'] : $precontract->projectName;
        $precontract->precontractDate       = !empty($data['precontractDate']) ? $data['precontractDate'] : $precontract->precontractDate;
        $precontract->clientId              = !empty($data['clientId']) ? $data['clientId'] : $precontract->clientId;
        $precontract->propertyNumber        = !empty($data['propertyNumber']) ? $data['propertyNumber'] : $precontract->propertyNumber;
        $precontract->streetName            = !empty($data['streetName']) ? $data['streetName'] : $precontract->streetName;
        $precontract->streetType            = !empty($data['streetType']) ? $data['streetType'] : $precontract->streetType;
        $precontract->suiteNumber           = !empty($data['suiteNumber']) ? $data['suiteNumber'] : $precontract->suiteNumber;
        $precontract->city                  = !empty($data['city']) ? $data['city'] : $precontract->city;
        $precontract->state                 = !empty($data['state']) ? $data['state'] : $precontract->state;
        $precontract->zipCode               = !empty($data['zipCode']) ? $data['zipCode'] : $precontract->zipCode;
        $precontract->buildingCodeId         = !empty($data['buildingCodeId']) ? $data['buildingCodeId'] : $precontract->buildingCodeId;
        $precontract->groupId                = !empty($data['groupId']) ? $data['groupId'] : $precontract->groupId;
        $precontract->projectUseId           = !empty($data['projectUseId']) ? $data['projectUseId'] : $precontract->projectUseId;
        $precontract->constructionType       = !empty($data['constructionType']) ? $data['constructionType'] : $precontract->constructionType;
        // $precontract->projectDescriptionId             = !empty($data['projectDescriptionId']) ? $data['contractType'] : $precontract->projectDescriptionId;
        $precontract->comment                   = !empty($data['comment']) ? $data['comment'] : $precontract->comment;
        $precontract->currencyId              = !empty($data['currencyId']) ? $data['currencyId'] : $precontract->currencyId;

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
