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
  
    protected $appends = ['unitCost','amount'];
//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------

//--------------------------------------------------------------------
    /** Accesores  */
//--------------------------------------------------------------------
    public function getUnitCostAttribute($unitCost)
    {
       return decrypt($this->attributes['unitCost']);
    }
    public function getAmountAttribute($amount)
    {
       return decrypt($this->attributes['amount']);
    }
//--------------------------------------------------------------------
    /** Mutadores  */
//--------------------------------------------------------------------

    public function setUnitCostAttribute($unitCost)
    {
        return $this->attributes['unitCost'] = encrypt($unitCost);
    }
     public function setAmountAttribute($amount)
    {
        return $this->attributes['amount'] = encrypt($amount);
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
