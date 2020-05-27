<?php

namespace App;

use Auth;
use DB;
use App\Helpers\DateHelper;
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
    public function receivable()
    {
        return $this->hasOne('App\Receivable', 'paymentInvoiceId');
    }

//------------------------ACCESORES--------------------------------
    public function getAmountAttribute($amount)
    {
         return decrypt($this->attributes['amount']);
    }
    public function getPaymentDateAttribute($paymentDate)
    {
         $oDateHelper = new DateHelper;
         $functionRs = $oDateHelper->changeDateForCountry(session('countryId'),'Accesor');
         $newDate    = $oDateHelper->$functionRs($paymentDate);
        return $newDate;
    }
//------------------------MUTADORES--------------------------------

    public function setAmountAttribute($amount){
            $amount = number_format((float)$amount, 2, '.', '');
            return $this->attributes['amount'] = encrypt($amount);
     }
    public function setPaymentDateAttribute($paymentDate)
    {
         $oDateHelper = new DateHelper;
         $functionRs = $oDateHelper->changeDateForCountry(session('countryId'),'Mutador');
         $newDate    = $oDateHelper->$functionRs($paymentDate);

        $this->attributes['paymentDate'] = $newDate;
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

            $receivables =  Receivable::where('invoiceId', $invoiceId)->get();
      
           //suma todas las cuotas y luego el monto que ingrese por formulario
          //para saber si esto es mayor que el monto de la factura
            foreach ($receivables as  $payment) {
                $acum = $acum + $payment->amountDue ;
            }
                $acum = $acum + $amount ;
           
              if ( $acum > $invoice[0]->netTotal)
              {
                throw new \Exception("Error: El total de Cuotas no debe sobrepasar el Monto de Factura.");
              }

            DB::table('invoice')->where('invoiceId', $invoiceId)->increment('pQuantity');  

            //INSERTA PAGO
            $payment              = new PaymentInvoice;
            $payment->invoiceId   = $invoiceId;
            $payment->amount      = $amount;
            $payment->paymentDate = $paymentDate;
            $payment->dateCreated = date('Y-m-d H:i:s');
            $payment->lastUserId  = Auth::user()->userId;
            $payment->save();

            //INSERTAR A CUENTA POR COBRAR
            $receivable                    = new Receivable;
            $receivable->officeId          = $payment->invoice->officeId;
            $receivable->countryId         = $payment->invoice->countryId;
            $receivable->clientId          = $payment->invoice->clientId;
            $receivable->invoiceId         = $payment->invoiceId;
            $receivable->paymentInvoiceId  = $payment->paymentInvoiceId;
            $receivable->amountDue         = $amount;
            $receivable->amountPaid        = '0.00'; //es necesario colocarlos en 0.00 para que que se inserten encriptados
            $receivable->percent           = '0';
            $receivable->amountPercentaje  = '0.00';
            $receivable->balance           = '0.00';      
            $receivable->recStatusCode     = '1';     
            $receivable->userId            = Auth::user()->userId;     
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
    public function removePayment($id,$invoiceId)
    {
        $error = null;

        DB::beginTransaction();
        try {
            $result = DB::table('receivable')->where('paymentInvoiceId', $id)->value('recStatusCode');

            if ($result != '1') {
                throw new \Exception('Error: La Cuota no se puede eliminar, se esta procesando o ya se pago');
            } else {
                //ELIMINAR PAGO
                $this->where('paymentInvoiceId', '=', $id)->delete();
                //DESCONTAR ESA CUOTA
                DB::table('invoice')->where('invoiceId', $invoiceId)->decrement('pQuantity');  
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
