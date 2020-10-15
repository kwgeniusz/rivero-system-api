<?php

namespace App;

use App;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleNoteDetail extends Model
{
    //traits
    // use SoftDeletes;

    public $timestamps = false;

    protected $table      = 'sale_note_detail';
    protected $primaryKey = 'invDetailId';
    protected $fillable = ['salNoteDetId','salNoteId','itemNumber','serviceId','unit','unitCost','quantity','amount'];
  
    protected $appends = ['unitCost','amount'];
//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
    // public function subcontractorInvDetail()
    // {
    //       $relation = $this->hasMany('App\SubcontractorInvDetail', 'invDetailId', 'invDetailId');
      
    //      return $relation->with('subcontractor');
    // }
    public function invoice()
    {
          return $this->hasOne('App\Invoice', 'invoiceId', 'invoiceId');
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
        $result = $this->with('subcontractorInvDetail')
            ->where('invoiceId', $invoiceId)
            ->orderBy('itemNumber', 'ASC')
            ->get();

        return $result;
    }
//------------------------------------
        public function getWithPriceByInvoice($invoiceId)
    {
        $result = $this->with('subcontractorInvDetail')
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


            //Buscar alguna cuota pagada en essta factura.
            $oReceivable = new Receivable;
            $successShares=$oReceivable->shareSucceed($invoiceId);

   if($successShares->isEmpty()) { //si esta vacio(es decir no tiene pagos, permitelo eliminar),y limpia las cuotas creadas

          //Eliminar las cuentas por pagar de los invoices details
            $invDetails=$this->getAllByInvoice($invoiceId);
            foreach ($invDetails as $invDetail) {
                 $oSub = new SubcontractorInvDetail;
                 $oSub->deleteS($invDetail->subcontractorInvDetail);
             }
            
           //Eiminar las cuotas con payables
                $oPaymentInvoice= new PaymentInvoice;     
                $invoiceShares = $oPaymentInvoice->getAllByInvoice($invoiceId);

              foreach ($invoiceShares as $value) {
                  $oPaymentInvoice->removePayment($value->paymentInvoiceId,$invoiceId);
              }
       //eliminar items de la factura
             InvoiceDetail::where('invoiceId',$invoiceId)->delete();
         
      //REALIZA ACTUALIZACION EN PROPUESTA
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
