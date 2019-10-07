<?php

namespace App;

use App;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceDetail extends Model
{
    //traits
    // use SoftDeletes;

    public $timestamps = false;

    protected $table      = 'invoice_detail';
    protected $primaryKey = 'invDetailId';
    protected $fillable = ['invDetailId','invoiceId','serviceId','serviceName','unit','unitCost','quantity','amount'];

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

//--------------------------------------------------------------------
    /** Mutadores  */
//--------------------------------------------------------------------

    public function setContractCostAttribute($contractCost)
    {
        return $this->attributes['contractCost'] = encrypt($contractCost);
    }
   
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------

//------------------------------------
    public function getAllByInvoice($invoiceId)
    {
        $result = $this->where('invoiceId', $invoiceId)
            ->orderBy('invDetailId', 'ASC')
            ->get();

        return $result;
    }
//------------------------------------------
    public function insert($invoiceId,$serviceId,$serviceName,$unit,$unitCost,$quantity,$amount) {

     $error = null;

        DB::beginTransaction();
        try {
            //INSERTA UN RENGLON
             $invDetail                   = new InvoiceDetail;
             $invDetail->invoiceId        = $invoiceId;
             $invDetail->serviceId        = $serviceId;
             $invDetail->serviceName      = $serviceName;
             $invDetail->unit             = $unit;
             $invDetail->unitCost         = $unitCost;
             $invDetail->quantity         = $quantity;
             $invDetail->amount           = $amount;
             $invDetail->save();
            
            //REALIZA ACTUALIZACION EN FACTURA
            $oInvoice = new Invoice;
            $oInvoice->updateInvoiceTotal('+', $invoiceId, $amount);
            
            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return $result = ['alertType' => 'success', 'message' => 'Reglon Agregado Exitosamente'];
        } else {
            return $result = ['alertType' => 'error', 'message' => $error];
        }
    }
//------------------------------------------
    public function updateInv($contractId, $contractDate, $clientId,
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
    public function deleteInv($id)
    {
           $error = null;

        DB::beginTransaction();
        try {
            //BUSCAR EL RENGLON PARA SACAR SU INVOICEID y amount
             $oInvoiceDetail = InvoiceDetail::find($id);
            
            //REALIZA ACTUALIZACION EN FACTURA
            $oInvoice = new Invoice;
            $oInvoice->updateInvoiceTotal('-',$oInvoiceDetail->invoiceId, $oInvoiceDetail->amount);
            
            $oInvoiceDetail->delete();

            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return $result = ['alertType' => 'success', 'message' => 'Reglon Eliminado Exitosamente'];
        } else {
            return $result = ['alertType' => 'error', 'message' => $error];
        }
    }
//-----------------------------------------

}
