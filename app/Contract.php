<?php

namespace App;

use App;
use Auth;
use DB;
use App\Client;
use App\OfficeConfiguration;
use App\ContractStaff;
use App\Country;
use App\Office;
use App\ProjectDescription;
use App\ProjectUse;
use App\Staff;
use App\Helpers\DateHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    //traits
    use SoftDeletes;

    public $timestamps = false;

    protected $table      = 'contract';
    protected $primaryKey = 'contractId';
    //protected $dateFormat = 'Y-m-d';
    protected $fillable = ['contractId', 'contractType', 'contractNumber', 'countryId', 'officeId',
        'contractDate', 'clientId', 'siteAddress', 'projectDescriptionId', 'projectUseId', 'registryNumber',
        'startDate', 'scheduledFinishDate', 'actualFinishDate', 'deliveryDate',
        'initialComment', 'intermediateComment', 'finalComment', 'contractCost',
        'currencyId', 'contractStatus', 'dateCreated', 'lastUserId',
    ];

    /*protected $dates = ['contractDate','startDate',
    'scheduledFinishDate','actualFinishDate','deliveryDate'];
     */
     protected $dates = ['deleted_at'];
    //Status Contract
    const VACANT    = '1';
    const STARTED   = '2';
    const FINISHED  = '3';
    const CANCELLED = '4';

//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
    public function client()
    {
        return $this->belongsTo('App\Client', 'clientId','clientId');
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
    public function staff()
    {
        return $this->belongsToMany('App\Staff', 'contract_staff', 'contractId', 'staffId')->withPivot('contractStaffId');
    }
    public function currency()
    {
        return $this->hasOne('App\Currency', 'currencyId', 'currencyId');
    }
    public function payment()
    {
        return $this->hasMany('App\PaymentInvoice', 'contractId', 'contractId');
    }
//--------------------------------------------------------------------
    /** Accesores  */
//--------------------------------------------------------------------
  public function getSiteAddressAttribute()
{
   return $this->propertyNumber.' '.$this->streetName.' '.$this->streetType.' '.$this->suiteNumber.' '.$this->city.' '.$this->state.' '.$this->zipCode;
}
    // public function getContractTypeAttribute($contractType)
    // {
    //       if($contractType == 'P')
    //       {
    //          return  $contractType = "PROJECT";
    //       }else{
    //          return  $contractType = "SERVICE";
    //       }
    // }
    public function getContractCostAttribute($contractCost)
    {
        return decrypt($contractCost);
    }
    public function getContractDateAttribute($contractDate)
    {
         $oDateHelper = new DateHelper;
         $functionRs = $oDateHelper->changeDateForCountry(session('countryId'),'Accesor');
         $newDate    = $oDateHelper->$functionRs($contractDate);
        return $newDate;
    }
    // public function getStartDateAttribute($startDate)
    // {
    //      $oDateHelper = new DateHelper;
    //      $functionRs = $oDateHelper->changeDateForCountry(session('countryId'),'Accesor');
    //      $newDate    = $oDateHelper->$functionRs($startDate);
    //     return $newDate;
    // }
    // public function getScheduledFinishDateAttribute($scheduledFinishDate)
    // {
    //     $oDateHelper = new DateHelper;
    //      $functionRs = $oDateHelper->changeDateForCountry(session('countryId'),'Accesor');
    //      $newDate    = $oDateHelper->$functionRs($scheduledFinishDate);
    //     return $newDate;
    // }
    // public function getActualFinishDateAttribute($actualFinishDate)
    // {
    //      $oDateHelper = new DateHelper;
    //      $functionRs = $oDateHelper->changeDateForCountry(session('countryId'),'Accesor');
    //      $newDate    = $oDateHelper->$functionRs($actualFinishDate);
    //     return $newDate;
    // }
    // public function getDeliveryDateAttribute($deliveryDate)
    // {
    //       $oDateHelper = new DateHelper;
    //      $functionRs = $oDateHelper->changeDateForCountry(session('countryId'),'Accesor');
    //      $newDate    = $oDateHelper->$functionRs($deliveryDate);
    //     return $newDate;
    // }

    public function getContractStatusAttribute($contractStatus)
    {

        if (App::getLocale() == 'es') {
            switch ($contractStatus) {
                case 1:
                    return "VACANTE";
                    break;
                case 2:
                    return "INICIADO";
                    break;
                case 3:
                    return "FINALIZADO";
                    break;
                case 4:
                    return "SUSPENDIDO";
                    break;
            }
        } else {
            switch ($contractStatus) {
                case 1:
                    return "VACANT";
                    break;
                case 2:
                    return "STARTED";
                    break;
                case 3:
                    return "FINISHED";
                    break;
                case 4:
                    return "CANCELLED";
                    break;
            }
        }

    }
  
//--------------------------------------------------------------------
    /** Mutadores  */
//--------------------------------------------------------------------

    public function setContractCostAttribute($contractCost)
    {
        return $this->attributes['contractCost'] = encrypt($contractCost);
    }
    public function setContractDateAttribute($contractDate)
    {
         $oDateHelper = new DateHelper;
         $functionRs = $oDateHelper->changeDateForCountry(session('countryId'),'Mutador');
         $newDate    = $oDateHelper->$functionRs($contractDate);

        $this->attributes['contractDate'] = $newDate;
    }
    // public function setStartDateAttribute($startDate)
    // {
    //     $oDateHelper = new DateHelper;
    //      $functionRs = $oDateHelper->changeDateForCountry(session('countryId'),'Mutador');
    //      $newDate    = $oDateHelper->$functionRs($startDate);

    //     $this->attributes['startDate'] = $newDate;
    // }
    // public function setScheduledFinishDateAttribute($scheduledFinishDate)
    // {
    //      $oDateHelper = new DateHelper;
    //      $functionRs = $oDateHelper->changeDateForCountry(session('countryId'),'Mutador');
    //      $newDate    = $oDateHelper->$functionRs($scheduledFinishDate);

    //     $this->attributes['scheduledFinishDate'] = $newDate;
    // }
    // public function setActualFinishDateAttribute($actualFinishDate)
    // {
    //     $oDateHelper = new DateHelper;
    //      $functionRs = $oDateHelper->changeDateForCountry(session('countryId'),'Mutador');
    //      $newDate    = $oDateHelper->$functionRs($actualFinishDate);

    //     $this->attributes['actualFinishDate'] = $newDate;
    // }
    // public function setDeliveryDateAttribute($deliveryDate)
    // {
    //      $oDateHelper = new DateHelper;
    //      $functionRs = $oDateHelper->changeDateForCountry(session('countryId'),'Mutador');
    //      $newDate    = $oDateHelper->$functionRs($deliveryDate);

    //     $this->attributes['deliveryDate'] = $newDate;
    // }
//--------------------------------------------------------------------
    /** Query Scope  */
//--------------------------------------------------------------------

    // public function scopeContractNumber($query, $contractNumber)
    // {
    //     if ($contractNumber) {
    //         return $query->where('contractNumber', 'LIKE', "%$contractNumber%");
    //     }
    // }

    // public function scopeClientName($query, $clientName)
    // {
    //     if ($clientName) {
    //         $query->whereHas('client', function ($query) use ($clientName) {
    //             return $query->where('clientName', 'LIKE', "%$clientName%");
    //         });

    //     }
    // }

    // public function scopeClientPhone($query, $clientPhone)
    // {
    //     if ($clientPhone) {
    //         $query->whereHas('client', function ($query) use ($clientPhone) {
    //             return $query->where('clientPhone', 'LIKE', "%$clientPhone%");
    //         });

    //     }
    // }
    // public function scopeSiteAddress($query, $siteAddress)
    // {
    //     if ($siteAddress) {
    //         return $query->where('siteAddress', 'LIKE', "%$siteAddress%");
    //     }
    // }
    // public function scopeContractStatus($query, $contractStatus)
    // {
    //     if ($contractStatus) {
    //         return $query->where('contractStatus', 'LIKE', "%$contractStatus%");
    //     }
    // }
    // public function scopeContractDate($query, $contractDate)
    // {
    //     if ($contractDate) {
    //         return $query->where('contractDate', 'LIKE', "%$contractDate%");
    //     }
    // }

     public function scopeFilter($query, $filteredOut)
    {
        if ($filteredOut) {
            return $query->where('contractNumber', 'LIKE', "%$filteredOut%")
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
    /** Function of Models */
//--------------------------------------------------------------------
    public function getAll()
    {
        return $this->orderBy('contractNumber', 'ASC')->get();
    }
//------------------------------------
    public function getAllPaginate($number)
    {
        return $this->orderBy('contractNumber', 'ASC')->paginate($number);
    }
//------------------------------------
    public function getAllForStatus($contractStatus,$countryId,$officeId)
    {
        $result = $this->where('contractStatus', $contractStatus)
            ->where('countryId', $countryId)
            ->where('officeId', $officeId) 
            ->orderBy('contractNumber', 'ASC')
            ->get();

        return $result;
    }
//------------------------------------------
    public function getAllForTwoStatus($contractStatus1, $contractStatus2,$filteredOut,$countryId,$officeId)
    {
        $result = $this->where('countryId', $countryId)
                       ->where('officeId', $officeId) 
                       ->where(function($q) use ($contractStatus1,$contractStatus2){
                          $q->where('contractStatus', $contractStatus1)
                          ->orWhere('contractStatus', $contractStatus2);
                        })           
                      ->orderBy('contractNumber', 'DESC')
                      ->filter($filteredOut)
                      ->paginate(300);
        return $result;
    }
//------------------------------------------
    public function findById($id,$countryId,$officeId)
    {
        return $this->where('contractId', '=', $id)
                    ->where('countryId', $countryId)
                    ->where('officeId', $officeId) 
                    ->get();
    }
//------------------------------------------
    public function findByOffice($officeId)
    {
        return $this->where('officeId', '=', $officeId)->get();
    }
//------------------------------------------
    // public function findByClient($clientId)
    // {
    //     return $this->where('clientId', '=', $clientId)->get();
    // }

//------------------------------------------
    public function findSiteAddressByOffice($officeId)
    {
        $result = DB::select("SELECT DISTINCT contract.siteAddress FROM contract
                              INNER JOIN client ON contract.clientId = client.clientId
                              WHERE officeId = $officeId ");

        return $result;
    }
//------------------------------------------
    public function insertContract($countryId, $officeId, $contractType, $contractDate,
        $clientId,$propertyNumber,$streetName,$streetType,$suiteNumber,$city,$state,$zipCode,$buildingCodeId, $projectDescriptionId, $projectUseId, $initialComment, $currencyId) {

          $oConfiguration = new OfficeConfiguration();
      
          $contractNumber = $oConfiguration->retrieveContractNumber($countryId, $officeId, $contractType);
          $contractNumber++;
          $contractNumberFormat = $oConfiguration->generateContractNumberFormat($countryId, $officeId, $contractType);
                                  $oConfiguration->increaseContractNumber($countryId, $officeId, $contractType);

        $contract                      = new Contract;
        $contract->conId               = $contractNumber;
        $contract->contractType        = $contractType;
        $contract->contractNumber      = $contractNumberFormat;
        $contract->countryId           = $countryId;
        $contract->officeId            = $officeId;
        $contract->contractDate        = $contractDate;
        $contract->clientId            = $clientId;
        $contract->propertyNumber      = $propertyNumber;
        $contract->streetName          = $streetName;
        $contract->streetType          = $streetType;
        $contract->suiteNumber         = $suiteNumber;
        $contract->city                = $city;
        $contract->state               = $state;
        $contract->zipCode             = $zipCode;
        $contract->buildingCodeId         = $buildingCodeId;
        $contract->projectDescriptionId       = $projectDescriptionId;
        $contract->projectUseId       = $projectUseId;
        // $contract->registryNumber      = $registryNumber;
        // $contract->startDate           = $startDate;
        // $contract->scheduledFinishDate = $scheduledFinishDate;
        // $contract->actualFinishDate    = $actualFinishDate;
        // $contract->deliveryDate        = $deliveryDate;
        $contract->initialComment      = $initialComment;
        $contract->contractCost        = '0.00';
        $contract->currencyId        = $currencyId;
        $contract->contractStatus      = '1';
        $contract->dateCreated         = date('Y-m-d H:i:s');
        $contract->lastUserId          = Auth::user()->userId;
        $contract->save();
            

        return $contract;

    }
//------------------------------------------
    public function updateContract($contractId,$contractType, $contractDate, $clientId,$propertyNumber,$streetName,$streetType,$suiteNumber,$city,$state,$zipCode,$buildingCodeId, $projectDescriptionId, $projectUseId, $initialComment, $currencyId) {

        $contract                       = contract::find($contractId);
        $contract->contractType         = $contractType;
        // $contract->countryId           = $countryId;
        // $contract->officeId            = $officeId;
        $contract->contractDate         = $contractDate;
        $contract->clientId             = $clientId;
        $contract->propertyNumber         = $propertyNumber;
        $contract->streetName             = $streetName;
        $contract->streetType             = $streetType;
        $contract->suiteNumber            = $suiteNumber;
        $contract->city                   = $city;
        $contract->state                  = $state;
        $contract->zipCode                = $zipCode;
        $contract->buildingCodeId       = $buildingCodeId;
        $contract->projectDescriptionId = $projectDescriptionId;
        $contract->projectUseId         = $projectUseId;
        // $contract->registryNumber      = $registryNumber;
        // $contract->startDate           = $startDate;
        // $contract->scheduledFinishDate = $scheduledFinishDate;
        // $contract->actualFinishDate    = $actualFinishDate;
        // $contract->deliveryDate        = $deliveryDate;
        $contract->initialComment       = $initialComment;
        // $contract->intermediateComment = $intermediateComment;
        // $contract->finalComment        = $finalComment;
        $contract->currencyId           = $currencyId;

        $contract->save();

    }
//------------------------------------------
    public function deleteContract($contractId)
    {
        return Contract::find($contractId)
                       // ->where('countryId', $countryId)
                       // ->where('officeId', $officeId) 
                       ->delete();
        
    }
//-----------------------------------------
    //SECTIONS CONTRACTS - STAFF
    //------------------------------------------
    public function addStaff($contractId,$staffId)
    {

        $contract = Contract::find($contractId);

        $contract->staff()->attach(
            $staffId,
            [
                'dateCreated' => date('Y-m-d H:i:s'),
                'lastUserId'  => Auth::user()->userId,
            ]
        );
        return $contract->save();

    }
//------------------------------------------
    public function removeStaff($contractId,$staffId)
    {
       $contract = Contract::find($contractId);
        return $contract->staff()->detach($staffId);
    }
//------------------------------------------

    public function updateStatus($contractId, $contractStatus)
    {

        $this->where('contractId', $contractId)->update(array(
            'contractStatus' => $contractStatus,
        ));
    }
//-------------------------------------

}
