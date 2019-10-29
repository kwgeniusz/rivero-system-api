<?php

namespace App;

use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;

class PaymentInvoice extends Model
{
    protected $table      = 'payment_invoice';
    protected $primaryKey = 'paymentInvoiceId';
    public $timestamps    = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'paymentInvoiceId',
        'invoiceId',
        'amount',
        'paymentDate',
        'dateCreated',
        'lastUserId',
    ];


//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
    public function invoice()
    {
        return $this->belongsTo('App\Invoice', 'invoiceId');
    }

//------------------------ACCESORES--------------------------------
    public function getAmountAttribute($amount)
    {
        return decrypt($amount);
    }
    public function getPaymentDateAttribute($paymentDate)
    {
        if (empty($paymentDate)) {
            return $paymentDate = null;
        }

        return $newDate = date("d/m/Y", strtotime($paymentDate));
    }
//------------------------MUTADORES--------------------------------

    public function setAmountAttribute($amount){
            return $this->attributes['amount'] = encrypt($amount);
     }
    public function setPaymentDateAttribute($paymentDate)
    {
        if (empty($paymentDate)) {
            return $paymentDate = null;
        }
        $partes                          = explode("/", $paymentDate);
        $arreglo                         = array($partes[2], $partes[1], $partes[0]);
        $date                            = implode("-", $arreglo);
        $this->attributes['paymentDate'] = $date;
    }
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    public function getAllByInvoice($invoiceId)
    {
        $result = $this->where('invoiceId', $invoiceId)
            ->orderBy('paymentInvoiceId', 'ASC')
            ->get();

        return $result;
    }
    public function addPayment($invoiceId, $amount, $paymentDate)
    {
        $error = null;

        DB::beginTransaction();
        try {
            $acum = 0;
            $invoice  = Invoice::where('invoiceId', $invoiceId)->get();
            $payments =  $this->where('invoiceId', $invoiceId)->get();

           //suma todas las cuotas y luego el monto que ingrese por formulario
            foreach ($payments as  $payment) {
                $acum = $acum + $payment->amount ;
            }
                $acum = $acum + $amount ;
            //para saber si esto es mayor que el monto de la factura
              if ( $acum > $invoice[0]->netTotal)
              {
                throw new \Exception("Error: El total de Cuotas no debe sobrepasar el Monto de Factura.");
              }

            DB::table('invoice')->increment('pQuantity');  

            //INSERTA PAGO
            $payment              = new PaymentInvoice;
            $payment->invoiceId   = $invoiceId;
            $payment->amount      = number_format((float)$amount, 2, '.', '');;
            $payment->paymentDate = $paymentDate;
            $payment->dateCreated = date('Y-m-d H:i:s');
            $payment->lastUserId  = Auth::user()->userId;
            $payment->save();

            //INSERTAR A CUENTA POR COBRAR
            $receivable                    = new Receivable;
            $receivable->officeId          = $payment->invoice->officeId;
            $receivable->countryId         = $payment->invoice->countryId;
            $receivable->clientId          = $payment->invoice->clientId;
            $receivable->invoiceId         =  $payment->invoiceId;
            $receivable->paymentInvoiceId  = $payment->paymentInvoiceId;
            $receivable->sourceReference   = $payment->invoice->invoiceNumber;
            $receivable->amountDue         = number_format((float)$amount, 2, '.', '');
            $receivable->amountPaid        = '0.00';
            $receivable->amountPercentaje  = '0.00';        
            $receivable->save();

            // //REALIZA ACTUALIZACION EN ContractCost (ESTO HIRA AL CERRAR FACTURAS)
            // $contract                      = Contract::find($contractId);
            // $contract->contractCost = $contract->contractCost + $amount;
            // $contract->save();

            //(anterior)$rs = DB::table('contract')->where('contractId', $contractId)->increment('contractCost', $amount); NOTA: FUE QUITADO POR QUE PARA ACTUALIZAR CON ENCRIPTACION NECESITO ELOQUENT

            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return $result = ['alert' => 'success', 'msj' => 'Cuota Agregado Exitosamente'];
        } else {
            return $result = ['alert' => 'error', 'msj' => $error];
        }

    }
//------------------------------------------
    public function removePayment($id)
    {
        $error = null;

        DB::beginTransaction();
        try {
            $result = DB::table('receivable')->where('paymentInvoiceId', $id)->value('pending');

            if ($result == 'N') {
                throw new \Exception('Error: La Cuota Ya se Cobro, No se puede eliminar');
            } else {
                DB::table('invoice')->decrement('pQuantity');  
                //ELIMINAR PAGO
                $this->where('paymentInvoiceId', '=', $id)->delete();
                //ELIMINAR DE CUENTA POR COBRAR
                $rs = DB::table('receivable')->where('paymentInvoiceId', $id)->delete();
                //REALIZA ACTUALIZACION EN CONTRACTCOST
                // $contract                      = Contract::find($contractId);
                // $contract->contractCost = $contract->contractCost - $amount;
                // $contract->save();

                $success = true;
                DB::commit();
            }
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return $result = ['alert' => 'info', 'msj' => 'Cuota Eliminada'];
        } else {
            return $result = ['alert' => 'error', 'msj' => $error];
        }
    }

}
