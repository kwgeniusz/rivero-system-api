<?php

namespace App;

use App;
use App\Client;
use App\Configuration;
use App\ContractStaff;
use App\Country;
use App\Office;
use App\Staff;
use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{

    public $timestamps = false;

    protected $table      = 'contract';
    protected $primaryKey = 'contractId';
    //  protected $dateFormat = 'Y-m-d';
    protected $fillable = ['contractId', 'contractType', 'contractNumber', 'countryId', 'officeId',
        'contractDate', 'clientId', 'siteAddress', 'contractDescription', 'registryNumber',
        'startDate', 'scheduledFinishDate', 'actualFinishDate', 'deliveryDate',
        'initialComment', 'intermediateComment', 'finalComment', 'contractCost',
        'currencyName', 'contractStatus', 'dateCreated', 'lastUserId',
    ];

    /*protected $dates = ['contractDate','startDate',
    'scheduledFinishDate','actualFinishDate','deliveryDate'];
     */
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
//--------------------------------------------------------------------
    /** Accesores y Mutadores */
//--------------------------------------------------------------------
    /**
    public function getContractCostAttribute($cost) {
    if(empty($cost))
    return $cost = null;

    return number_format($cost, 2, ',', '.');
    }
     */
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
    /** Query Scopes **/

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

//--------------------------------------------------------------------

//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    public function getAll()
    {
        return $this->orderBy('contractId', 'ASC')->get();
    }
//------------------------------------
    public function getAllPaginate($number)
    {
        return $this->orderBy('contractId', 'ASC')->paginate($number);
    }
//------------------------------------
    public function getAllForStatus($contractStatus)
    {
        $result = $this->where('contractStatus', $contractStatus)
            ->orderBy('contractId', 'ASC')
            ->get();

        return $result;
    }
//------------------------------------------
    public function getAllForTwoStatus($contractStatus1, $contractStatus2, $contractType)
    {
        $result = $this->where('contractType', $contractType)
            ->where('contractStatus', $contractStatus1)
            ->orWhere('contractStatus', $contractStatus2)
            ->orderBy('contractId', 'ASC')
            ->get();

        return $result;
    }
//------------------------------------------
    public function findById($id)
    {
        return $this->where('contractId', '=', $id)->get();
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
        $clientId, $siteAddress, $contractDescription, $registryNumber, $startDate, $scheduledFinishDate,
        $actualFinishDate, $deliveryDate, $initialComment, $contractCost, $currencyName) {

        $oConfiguration = new Configuration();
        // get contract number
        $contractNumber = $oConfiguration->retrieveContractNumber($countryId, $officeId, $contractType);
        // increment contract number
        $contractNumber++;
        // update contract number
        $oConfiguration->updateContractNumber($countryId, $officeId, $contractType, $contractNumber);

        // make contract number format
        $stringLength = 7;
        $strPad       = "0";

        if ($contractNumber < 1) {
            $contractNumber = "";
        }

        $format1 = substr(date('Y'), 2, 2);
        if ($contractType == "P") {
            $format2 = "PC-";
        } else {
            $format2 = "S-";
        }
        $format3 = str_pad($contractNumber, $stringLength, $strPad, STR_PAD_LEFT);

        // numero de contrato en foramto
        $contractNumberFormat = $format1 . $format2 . $format3;

        $contract                      = new Contract;
        $contract->contractType        = $contractType;
        $contract->contractNumber      = $contractNumberFormat;
        $contract->countryId           = $countryId;
        $contract->officeId            = $officeId;
        $contract->contractDate        = $contractDate;
        $contract->clientId            = $clientId;
        $contract->siteAddress         = $siteAddress;
        $contract->contractDescription = $contractDescription;
        $contract->registryNumber      = $registryNumber;
        $contract->startDate           = $startDate;
        $contract->scheduledFinishDate = $scheduledFinishDate;
        $contract->actualFinishDate    = $actualFinishDate;
        $contract->deliveryDate        = $deliveryDate;
        $contract->initialComment      = $initialComment;
        $contract->contractCost        = $contractCost;
        $contract->currencyName        = $currencyName;
        $contract->contractStatus      = '1';
        $contract->dateCreated         = date('Y-m-d H:i:s');
        $contract->lastUserId          = Auth::user()->userId;
        $contract->save();

    }
//------------------------------------------
    public function updateContract($contractId, $contractNumber, $clientId,
        $siteAddress, $contractDescription, $registryNumber, $startDate, $scheduledFinishDate,
        $actualFinishDate, $initialComment, $contractCost, $currencyName) {

        $this->where('contractId', $contractId)->update(array(
            'contractNumber'      => $contractNumber,
            'clientId'            => $clientId,
            'siteAddress'         => $siteAddress,
            'contractDescription' => $contractDescription,
            'registryNumber'      => $registryNumber,
            'startDate'           => $startDate,
            'scheduledFinishDate' => $scheduledFinishDate,
            'actualFinishDate'    => $actualFinishDate,
            'initialComment'      => $initialComment,
            'contractCost'        => $contractCost,
            'currencyName'        => $currencyName,
        ));
    }
//------------------------------------------
    public function deleteContract($contractId)
    {
        return $this->where('contractId', '=', $contractId)->delete();
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
        $contract->save();

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
