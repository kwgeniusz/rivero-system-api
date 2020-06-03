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
    public function subcontractorInvDetail()
    {
          $relation = $this->hasMany('App\SubcontractorInvDetail', 'invDetailId', 'invDetailId');
      
         return $relation->with('subcontractor');
    }

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
         if($unitCost != null) { 
        $unitCost = number_format((float)$unitCost, 2, '.', '');
    }
        return $this->attributes['unitCost'] = encrypt($unitCost);
    }
     public function setAmountAttribute($amount)
    {
          if($amount != null) { 
        $amount = number_format((float)$amount, 2, '.', '');
    }
        return $this->attributes['amount'] = encrypt($amount);
    }
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------

    public function getAllByInvoice($invoiceId)
    {
        $result = $this->where('invoiceId', $invoiceId)
            ->orderBy('itemNumber', 'ASC')
            ->get();

        return $result;
    }
//------------------------------------
        public function getWithPriceByInvoice($invoiceId)
    {
        $result = $this->with('SubcontractorInvDetail')
                       ->where('invoiceId', $invoiceId)
                       ->where('unit','!=', null)
                       ->orderBy('itemNumber', 'ASC')
                       ->get();

        return $result;
    }
//------------------------------------------
    public function insert($invoiceId,$itemNumber,$serviceId,$serviceName,$unit,$unitCost,$quantity,$amount) {

     $error = null;

        DB::beginTransaction();
        try {


              if($amount == '0.00'){
                $amount = null;
              }
            //INSERTA UN RENGLON
             $invDetail                   = new InvoiceDetail;
             $invDetail->invoiceId        = $invoiceId;
             $invDetail->itemNumber        = $itemNumber;
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
    public function deleteInv($invoiceId)
    {
           $error = null;

        DB::beginTransaction();
        try {
            //BUSCAR EL RENGLON PARA SACAR SU INVOICEID y amount
            // $oInvoiceDetail = InvoiceDetail::find($id);
            $oReceivable = new Receivable;
            $successShares=$oReceivable->shareSucceed($invoiceId);

   if($successShares->isEmpty()) { //si esta vacio(es decir no tiene pagos, permitelo eliminar),y limpia las cuotas creadas
                $oPaymentInvoice= new PaymentInvoice;     
                $invoiceShares = $oPaymentInvoice->getAllByInvoice($invoiceId);
           //remover las cuotas de la factura
              foreach ($invoiceShares as $value) {
                  $oPaymentInvoice->removePayment($value->paymentInvoiceId,$invoiceId);
              }
       //ELIMINA TODOS LOS ITEMS DE LA PROPUESTA
             InvoiceDetail::where('invoiceId',$invoiceId)->delete();
         
            // //REALIZA ACTUALIZACION EN PROPUESTA
              //BUSCO LA PROPUESTA
            $inv = Invoice::find($invoiceId);
            $oInvoice = new Invoice; 
            $oInvoice->updateInvoiceTotal('-',$inv->invoiceId, $inv->grossTotal); // RESTA TODO EL MONTO DE GROSSTOTAL PARA QUE HAGA EL DESCUENTO.

        }else{
           throw new \Exception('Error: No se puede modificar renglones se ha comenzado a pagar la factura');
        };

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
