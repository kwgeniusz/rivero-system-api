<?php

namespace App;

use App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceDetail extends Model
{
    //traits
    use SoftDeletes;

    public $timestamps = false;

    protected $table      = 'invoice_detail';
    protected $primaryKey = 'invDetailId';
    protected $fillable = ['invDetailId','invoiceId','serviceId','serviceName','unit','unitCost','quantity','amount'];

     protected $dates = ['deleted_at'];


//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------

//--------------------------------------------------------------------
    /** Accesores  */
//--------------------------------------------------------------------
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
    public function getAllByInvoice($invoiceId)
    {
        $result = $this->where('invoiceId', $invoiceId)
            ->orderBy('invDetailId', 'ASC')
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
        $clientId, $siteAddress, $projectTypeId, $serviceTypeId, $registryNumber, $startDate, $scheduledFinishDate, $actualFinishDate, $deliveryDate, $initialComment, $currencyName) {

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
        $contract->projectTypeId       = $projectTypeId;
        $contract->serviceTypeId       = $serviceTypeId;
        $contract->registryNumber      = $registryNumber;
        $contract->startDate           = $startDate;
        $contract->scheduledFinishDate = $scheduledFinishDate;
        $contract->actualFinishDate    = $actualFinishDate;
        $contract->deliveryDate        = $deliveryDate;
        $contract->initialComment      = $initialComment;
        $contract->contractCost        = '0.00';
        $contract->currencyName        = $currencyName;
        $contract->contractStatus      = '1';
        $contract->dateCreated         = date('Y-m-d H:i:s');
        $contract->lastUserId          = Auth::user()->userId;
        $contract->save();

        return $contract->contractId;

    }
//------------------------------------------
    public function updateContract($contractId, $contractDate, $clientId,
        $siteAddress, $projectTypeId, $serviceTypeId, $registryNumber, $startDate, $scheduledFinishDate,
        $actualFinishDate, $deliveryDate, $initialComment, $intermediateComment, $finalComment, $currencyName) {

        $contract                      = contract::find($contractId);
        // $contract->countryId           = $countryId;
        // $contract->officeId            = $officeId;
        $contract->contractDate        = $contractDate;
        $contract->clientId            = $clientId;
        $contract->siteAddress         = $siteAddress;
        $contract->projectTypeId       = $projectTypeId;
        $contract->serviceTypeId       = $serviceTypeId;
        $contract->registryNumber      = $registryNumber;
        $contract->startDate           = $startDate;
        $contract->scheduledFinishDate = $scheduledFinishDate;
        $contract->actualFinishDate    = $actualFinishDate;
        $contract->deliveryDate        = $deliveryDate;
        $contract->initialComment      = $initialComment;
        $contract->intermediateComment = $intermediateComment;
        $contract->finalComment        = $finalComment;
        $contract->currencyName        = $currencyName;

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
