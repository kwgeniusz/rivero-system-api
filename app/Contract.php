<?php

namespace App;

use App;
use Auth;
use DB;
use Carbon\Carbon;
use App\Client;
use App\CompanyConfiguration;
use App\ContractStaff;
use App\Country;
use App\Company;
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

    protected $fillable = ['contractId', 'contractType', 'contractNumber', 'countryId', 'companyId',
        'contractDate', 'clientId', 'siteAddress', 'projectDescriptionId', 'projectUseId', 'registryNumber',
        'startDate', 'scheduledFinishDate', 'actualFinishDate', 'deliveryDate',
        'initialComment', 'intermediateComment', 'finalComment', 'contractCost',
        'currencyId', 'contractStatus', 'created_at', 'lastUserId',
    ];
    
    protected $appends = ['siteAddress','contractDate','consecutiveDaysElapsed','daysToDelivery','deliveryDate'];
    protected $dates = ['deleted_at'];

    //Status Contract
    const VACANT    = '1';
    const STARTED   = '2';
    const FINISHED  = '3';
    const CANCELLED = '4';
    const READY_BUT_PENDING_PAYABLE = '5';
    const PROCESSING_PERMIT = '6';
    const WAITING_CLIENT = '7';
    const DOWNLOADING_FILES = '8';
    const SENT_TO_OFFICE = '9';
    const IN_PRODUCTION_QUEUE = '10';

// -VACANTE (VERDE)
// -INICIADO (AZUL)
// -FINALIZADO (BAUL)
// -CANCELADO (BAUL)
// -LISTO PERO PENDIENTE POR PAGAR(AMARILLO)
// -EN PROCESAMIENTO DE PERMISO (ANARANJADO)
// -ESPERANDO POR EL CLIENT (ROJO)
//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
    public function client()
    {
        return $this->belongsTo('App\Client', 'clientId','clientId');
    }
    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
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
    public function document()
    {
        return $this->hasMany('App\Document', 'contractId', 'contractId')->with('user');
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
   public function precontract()
    {
        return $this->belongsTo('App\Precontract', 'contractId');
    } 
   public function invoice()
    {
        return $this->hasMany('App\Invoice', 'contractId', 'contractId');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'userId', 'userId');
    } 
   public function contractStatusR()
    {    //aqui debo meter esta linea en una variable y hacerle un where para filtrarlo por idioma
         $relation = $this->hasMany('App\ContractStatus', 'contStatusCode','contractStatus');
         //hace el filtrado por el idioma
         //el locale cambia por el middleware que esta en localitazion,
         //esto maneja los datos por el idioma que escpga el usuario
         return $relation->where('language', App::getLocale());
    }   
//--------------------------------------------------------------------
    /** Accesores  */
//--------------------------------------------------------------------
    public function getSiteAddressAttribute()
    {
   return $this->propertyNumber.' '.$this->streetName.' '.$this->streetType.' '.$this->suiteNumber.' '.$this->city.' '.$this->state.' '.$this->zipCode;
   }
    public function getContractCostAttribute($contractCost)
    {
        return decrypt($contractCost);
    }
    public function getNumberOfDocumentsAttribute()
    {
         $previous  = $this->document->filter(function ($doc, $key) {return $doc->docType == 'previous'; });
         $processed = $this->document->filter(function ($doc, $key) {return $doc->docType == 'processed';});
         $revised   = $this->document->filter(function ($doc, $key) {return $doc->docType == 'revised';});
         $ready     = $this->document->filter(function ($doc, $key) {return $doc->docType == 'ready';}); 

          return [ 
            "previous"  => $previous->count(),
            "processed" => $processed->count(),
            "revised"   => $revised->count(),
            "ready"     => $ready->count(),
          ];
    } 
    public function getContractDateAttribute()
    {
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['contractDate'], 'UTC');
        $date->tz = session('companyTimeZone');   // ... set to the current users timezone
        return $date->format('Y-m-d H:i:s');
    }
    public function getConsecutiveDaysElapsedAttribute()
    {
         $date1 = Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['contractDate'], 'UTC');
         $date1->tz = session('companyTimeZone');
         $date2 = Carbon::now();
         $date2->tz = session('companyTimeZone');

         $difference = $date1->diffInDays($date2);
         return $difference;
    }
    public function getDaysToDeliveryAttribute()
    {
         $rs = $this->attributes['estimatedWorkDays'] - $this->consecutiveDaysElapsed;
         return $rs;
    }
    public function getDeliveryDateAttribute()
    {
         $daysToIncrement = $this->attributes['estimatedWorkDays'];
         $date1 = Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['contractDate'], 'UTC');
         $date1->tz = session('companyTimeZone');
         $date1->addDays($daysToIncrement);

         return $date1;
    }
    // public function dias(){
    //     $fecha1 = date_create($this->created_at);
    //     $fecha2 = date_create($this->canceled_at);
    //     $dias = date_diff($fecha1, $fecha2)->format('%R%a');
    //     return $dias;
    // }
//--------------------------------------------------------------------
    /** Mutadores  */
//--------------------------------------------------------------------

    public function setContractCostAttribute($contractCost)
    {
        return $this->attributes['contractCost'] = encrypt($contractCost);
    }
    public function setContractDateAttribute($contractDate)
    {
        $date = Carbon::createFromFormat('Y-m-d', $contractDate, session('companyTimeZone'));
        $date->setTimezone('UTC');
        $this->attributes['contractDate'] = $date;
    }
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
                          })
                         ->orWhereHas('projectUse', function ($query) use ($filteredOut) {
                              return $query->where('projectUseName', 'LIKE', "%$filteredOut%");
                          })
                         ->orWhereHas('invoice.projectDescription', function ($query) use ($filteredOut) {
                              return $query->where('projectDescriptionName', 'LIKE', "%$filteredOut%");
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
//--------------------------------------------------------------------
    public function getAllByProjectUse($companyId,$projectUseId)
    {
        return $this->where('projectUseId', $projectUseId)
                    ->where('companyId', $companyId) 
                    ->get();
    }
//------------------------------------
    public function getAllPaginate($number)
    {
        return $this->orderBy('contractNumber', 'ASC')->paginate($number);
    }
//------------------------------------
    public function getAllForStatus($contractStatus,$filteredOut,$countryId,$companyId)
    {
        $result = $this->with('client','buildingCode','projectUse','contractStatusR','invoice.projectDescription')
            ->where('contractStatus', $contractStatus)
            ->where('countryId', $countryId)
            ->where('companyId', $companyId) 
            ->orderBy('contractNumber', 'DESC')
            ->filter($filteredOut)
            ->get();

        return $result;
    }
//------------------------------------------
    public function getAllForSevenStatus($contractStatus1, $contractStatus2,$contractStatus3,$contractStatus4,$contractStatus5,$contractStatus6,$contractStatus7,$filteredOut,$countryId,$companyId)
    {
        $result = $this->with('client','buildingCode','projectUse','contractStatusR','invoice.projectDescription','user')
                       ->where('countryId', $countryId)
                       ->where('companyId', $companyId) 
                       ->where(function($q) use ($contractStatus1,$contractStatus2,$contractStatus3,$contractStatus4,$contractStatus5,$contractStatus6,$contractStatus7){
                          $q->where('contractStatus', $contractStatus1)
                          ->orWhere('contractStatus', $contractStatus2)
                          ->orWhere('contractStatus', $contractStatus3)
                          ->orWhere('contractStatus', $contractStatus4)
                          ->orWhere('contractStatus', $contractStatus5)
                          ->orWhere('contractStatus', $contractStatus6)
                          ->orWhere('contractStatus', $contractStatus7);
                        })           
                      ->orderBy('contractNumber', 'DESC')
                      ->filter($filteredOut)
                      ->get();
        return $result;
    }
//------------------------------------------ 
      public function getAllForTwoStatus($contractStatus1, $contractStatus2,$filteredOut,$countryId,$companyId)
    {
        $result = $this->with('client','buildingCode','projectUse','contractStatusR','invoice.projectDescription')
                       ->where('countryId', $countryId)
                       ->where('companyId', $companyId) 
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
    public function findById($id,$countryId,$companyId)
    {
        return $this->with('client','buildingCode','buildingCodeGroup','projectUse','user')
                    ->where('contractId', '=', $id)
                    ->where('countryId', $countryId)
                    ->where('companyId', $companyId) 
                    ->get();
    }
//------------------------------------------
    public function findByCompany($companyId)
    {
        return $this->where('companyId', '=', $companyId)->get();
    }
//------------------------------------------
    // public function findByClient($clientId)
    // {
    //     return $this->where('clientId', '=', $clientId)->get();
    // }

//------------------------------------------
    public function findSiteAddressByCompany($companyId)
    {
        $result = DB::select("SELECT DISTINCT contract.siteAddress FROM contract
                              INNER JOIN client ON contract.clientId = client.clientId
                              WHERE companyId = $companyId ");

        return $result;
    }
//------------------------------------------
    public function insertContract($countryId, $companyId, $contractType,$projectName, $contractDate,
        $clientId,$propertyNumber,$streetName,$streetType,$suiteNumber,$city,$state,$zipCode,$buildingCodeId, $groupId, $projectUseId,$constructionType, $initialComment, $currencyId) {

          $oConfiguration = new CompanyConfiguration();
      
          $contractNumber = $oConfiguration->retrieveContractNumber($countryId, $companyId, $contractType);
          $contractNumber++;
          $contractNumberFormat = $oConfiguration->generateContractNumberFormat($countryId, $companyId, $contractType);
                                  $oConfiguration->increaseContractNumber($countryId, $companyId, $contractType);

        $contract                      = new Contract;
        $contract->conId               = $contractNumber;
        $contract->contractType        = $contractType;
        $contract->projectName        = $projectName;
        $contract->contractNumber      = $contractNumberFormat;
        $contract->countryId           = $countryId;
        $contract->companyId            = $companyId;
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
        $contract->groupId                = $groupId;
        $contract->projectUseId           = $projectUseId;
        $contract->constructionType       = $constructionType;
        // $contract->registryNumber      = $registryNumber;
        // $contract->startDate           = $startDate;
        // $contract->scheduledFinishDate = $scheduledFinishDate;
        // $contract->actualFinishDate    = $actualFinishDate;
        // $contract->deliveryDate        = $deliveryDate;
        $contract->initialComment      = $initialComment;
        $contract->contractCost        = '0.00';
        $contract->currencyId        = $currencyId;
        $contract->contractStatus      = '1';
        $contract->created_at         = date('Y-m-d H:i:s');
        $contract->userId             = Auth::user()->userId;
        $contract->save();
            

        return $contract;

    }
//------------------------------------------
    public function updateContract($contractId,$data) {
        
        $contract                        = Contract::find($contractId);

        $contract->contractType          = !empty($data['contractType']) ? $data['contractType'] : $contract->contractType;
        $contract->projectName           = !empty($data['projectName']) ? $data['projectName'] : $contract->projectName;
        $contract->contractDate          = !empty($data['contractDate']) ? $data['contractDate'] : $contract->contractDate;
        $contract->clientId              = !empty($data['clientId']) ? $data['clientId'] : $contract->clientId;
        $contract->propertyNumber        = !empty($data['propertyNumber']) ? $data['propertyNumber'] : $contract->propertyNumber;
        $contract->streetName            = !empty($data['streetName']) ? $data['streetName'] : $contract->streetName;
        $contract->streetType            = !empty($data['streetType']) ? $data['streetType'] : $contract->streetType;
        $contract->suiteNumber           = !empty($data['suiteNumber']) ? $data['suiteNumber'] : $contract->suiteNumber;
        $contract->city                  = !empty($data['city']) ? $data['city'] : $contract->city;
        $contract->state                 = !empty($data['state']) ? $data['state'] : $contract->state;
        $contract->zipCode               = !empty($data['zipCode']) ? $data['zipCode'] : $contract->zipCode;
        $contract->buildingCodeId         = !empty($data['buildingCodeId']) ? $data['buildingCodeId'] : $contract->buildingCodeId;
        $contract->groupId                = !empty($data['groupId']) ? $data['groupId'] : $contract->groupId;
        $contract->projectUseId           = !empty($data['projectUseId']) ? $data['projectUseId'] : $contract->projectUseId;
        $contract->constructionType       = !empty($data['constructionType']) ? $data['constructionType'] : $contract->constructionType;
     // $contract->projectDescriptionId  = !empty($data['projectDescriptionId']) ? $data['contractType'] : $contract->projectDescriptionId;
        $contract->initialComment         = !empty($data['initialComment']) ? $data['initialComment'] : $contract->initialComment;
        $contract->currencyId             = !empty($data['currencyId']) ? $data['currencyId'] : $contract->currencyId;

        $contract->save();
    }
//------------------------------------------
    public function deleteContract($contractId)
    {
        return Contract::find($contractId)
                       // ->where('countryId', $countryId)
                       // ->where('companyId', $companyId) 
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
                'created_at' => date('Y-m-d H:i:s'),
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
