<?php

namespace App;

use App;
use App\Client;
use App\Configuration;
use App\ContractStaff;
use App\Country;
use App\Office;
use App\ProjectDescription;
use App\ProjectUse;
use App\Staff;
use Auth;
use DB;
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
    /**
    public function getContractCostAttribute($cost) {
    if(empty($cost))
    return $cost = null;

    return number_format($cost, 2, ',', '.');
    }
     */

    public function getContractCostAttribute($contractCost)
    {
        return decrypt($contractCost);
    }
    public function getContractDateAttribute($contractDate)
    {
        if (empty($contractDate)) {
            return $contractDate = null;
        }

        return $newDate = date("d/m/Y", strtotime($contractDate));
    }
    public function getStartDateAttribute($startDate)
    {
        if (empty($startDate)) {
            return $startDate = null;
        }

        return $newDate = date("d/m/Y", strtotime($startDate));
    }
    public function getScheduledFinishDateAttribute($scheduledFinishDate)
    {
        if (empty($scheduledFinishDate)) {
            return $scheduledFinishDate = null;
        }

        return $newDate = date("d/m/Y", strtotime($scheduledFinishDate));
    }
    public function getActualFinishDateAttribute($actualFinishDate)
    {
        if (empty($actualFinishDate)) {
            return $actualFinishDate = null;
        }

        return $newDate = date("d/m/Y", strtotime($actualFinishDate));
    }
    public function getDeliveryDateAttribute($deliveryDate)
    {
        if (empty($deliveryDate)) {
            return $deliveryDate = null;
        }

        return $newDate = date("d/m/Y", strtotime($deliveryDate));
    }

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
        if (empty($contractDate)) {
            return $contractDate = null;
        }
        $partes                           = explode("/", $contractDate);
        $arreglo                          = array($partes[2], $partes[1], $partes[0]);
        $date                             = implode("-", $arreglo);
        $this->attributes['contractDate'] = $date;
    }
    public function setStartDateAttribute($startDate)
    {
        if (empty($startDate)) {
            return $startDate = null;
        }
        $partes                        = explode("/", $startDate);
        $arreglo                       = array($partes[2], $partes[1], $partes[0]);
        $date                          = implode("-", $arreglo);
        $this->attributes['startDate'] = $date;
    }
    public function setScheduledFinishDateAttribute($scheduledFinishDate)
    {
        if (empty($scheduledFinishDate)) {
            return $scheduledFinishDate = null;
        }
        $partes                                  = explode("/", $scheduledFinishDate);
        $arreglo                                 = array($partes[2], $partes[1], $partes[0]);
        $date                                    = implode("-", $arreglo);
        $this->attributes['scheduledFinishDate'] = $date;
    }
    public function setActualFinishDateAttribute($actualFinishDate)
    {
        if (empty($actualFinishDate)) {
            return $actualFinishDate = null;
        }
        $partes                               = explode("/", $actualFinishDate);
        $arreglo                              = array($partes[2], $partes[1], $partes[0]);
        $date                                 = implode("-", $arreglo);
        $this->attributes['actualFinishDate'] = $date;
    }
    public function setDeliveryDateAttribute($deliveryDate)
    {
        if (empty($deliveryDate)) {
            return $deliveryDate = null;
        }
        $partes                           = explode("/", $deliveryDate);
        $arreglo                          = array($partes[2], $partes[1], $partes[0]);
        $date                             = implode("-", $arreglo);
        $this->attributes['deliveryDate'] = $date;
    }
//--------------------------------------------------------------------
    /** Query Scope  */
//--------------------------------------------------------------------

    public function scopeContractNumber($query, $contractNumber)
    {
        if ($contractNumber) {
            return $query->where('contractNumber', 'LIKE', "%$contractNumber%");
        }
    }

    public function scopeClientName($query, $clientName)
    {
        if ($clientName) {
            $query->whereHas('client', function ($query) use ($clientName) {
                return $query->where('clientName', 'LIKE', "%$clientName%");
            });

        }
    }

    public function scopeClientPhone($query, $clientPhone)
    {
        if ($clientPhone) {
            $query->whereHas('client', function ($query) use ($clientPhone) {
                return $query->where('clientPhone', 'LIKE', "%$clientPhone%");
            });

        }
    }
    public function scopeSiteAddress($query, $siteAddress)
    {
        if ($siteAddress) {
            return $query->where('siteAddress', 'LIKE', "%$siteAddress%");
        }
    }
    public function scopeContractStatus($query, $contractStatus)
    {
        if ($contractStatus) {
            return $query->where('contractStatus', 'LIKE', "%$contractStatus%");
        }
    }
    public function scopeContractDate($query, $contractDate)
    {
        if ($contractDate) {
            return $query->where('contractDate', 'LIKE', "%$contractDate%");
        }
    }

     public function scopeFilter($query, $filteredOut)
    {
        if ($filteredOut) {
            return $query->where('contractNumber', 'LIKE', "%$filteredOut%")
                         ->orWhere('siteAddress', 'LIKE', "%$filteredOut%")
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
    public function getAllForTwoStatus($contractStatus1, $contractStatus2, $contractType,$filteredOut,$countryId,$officeId)
    {
        $result = $this->where('contractType', $contractType)
                       ->where('countryId', $countryId)
                       ->where('officeId', $officeId) 
                       ->where(function($q) use ($contractStatus1,$contractStatus2){
                          $q->where('contractStatus', $contractStatus1)
                          ->orWhere('contractStatus', $contractStatus2);
                        })           
                      ->orderBy('contractNumber', 'ASC')
                      ->filter($filteredOut)
                      ->paginate(100);
        return $result;
    }
 //------------------------------------   
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
        return $this->where('OfficeId', '=', $officeId)->get();
    }
//------------------------------------------
    public function findByClient($clientId)
    {
        return $this->where('clientId', '=', $clientId)->get();
    }
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
        $clientId, $siteAddress, $projectDescriptionId, $projectUseId, $registryNumber, $startDate, $scheduledFinishDate, $actualFinishDate, $deliveryDate, $initialComment, $currencyId) {

          $oConfiguration = new Configuration();
      
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
        $contract->siteAddress         = $siteAddress;
        $contract->projectDescriptionId       = $projectDescriptionId;
        $contract->projectUseId       = $projectUseId;
        $contract->registryNumber      = $registryNumber;
        $contract->startDate           = $startDate;
        $contract->scheduledFinishDate = $scheduledFinishDate;
        $contract->actualFinishDate    = $actualFinishDate;
        $contract->deliveryDate        = $deliveryDate;
        $contract->initialComment      = $initialComment;
        $contract->contractCost        = '0.00';
        $contract->currencyId        = $currencyId;
        $contract->contractStatus      = '1';
        $contract->dateCreated         = date('Y-m-d H:i:s');
        $contract->lastUserId          = Auth::user()->userId;
        $contract->save();

        return $contract->contractId;

    }
//------------------------------------------
    public function updateContract($contractId, $contractDate, $clientId,
        $siteAddress, $projectDescriptionId, $projectUseId, $registryNumber, $startDate, $scheduledFinishDate,
        $actualFinishDate, $deliveryDate, $initialComment, $intermediateComment, $finalComment, $currencyId) {

        $contract                      = contract::find($contractId);
        // $contract->countryId           = $countryId;
        // $contract->officeId            = $officeId;
        $contract->contractDate        = $contractDate;
        $contract->clientId            = $clientId;
        $contract->siteAddress         = $siteAddress;
        $contract->projectDescriptionId       = $projectDescriptionId;
        $contract->projectUseId       = $projectUseId;
        $contract->registryNumber      = $registryNumber;
        $contract->startDate           = $startDate;
        $contract->scheduledFinishDate = $scheduledFinishDate;
        $contract->actualFinishDate    = $actualFinishDate;
        $contract->deliveryDate        = $deliveryDate;
        $contract->initialComment      = $initialComment;
        $contract->intermediateComment = $intermediateComment;
        $contract->finalComment        = $finalComment;
        $contract->currencyId          = $currencyId;

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
    public function aggStaff($staffId, $contractId)
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
    public function removeStaff($id)
    {

        return ContractStaff::where('contractStaffId', '=', $id)->delete();
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
