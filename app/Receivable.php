<?php

namespace App;

use App;
use DB;
use Auth;
use App\Helpers\DateHelper;
use App\Transaction;
use App\TransactionType;

use Illuminate\Database\Eloquent\Model;

class Receivable extends Model
{

    protected $table      = 'receivable';
    protected $primaryKey = 'receivableId';
    public $timestamps    = false;

    protected $appends = ['amountDue','amountPaid','amountPercentaje'];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'receivableId',
        'countryId',
        'contractId',
        'clientId',
        'sourceReference',
        'amountDue',
        'amountPaid',
        'amountpercentaje',
        'balance',  
        'collectMethod',
        'sourceBank',
        'sourceBankAccount',
        'checkNumber',
        'accountId',
        'datePaid',
        'recStatusCode',
    ];
    //RECEIVABLE STATUS
    const STATELESS     = '1';
    const PROCESS     = '2';
    const DECLINED    = '3';
    const SUCCESS   = '4';

    // //COLLECTIONS METHOD
    const DEBIT_CARD     = '1';
    // const CASH     = '2';
    // const CHECK    = '3';
    // const DEPOSIT   = '4';
    // const PAYPAL   = '5';
    // const TRANSFER = '6';
    const CREDIT_CARD     = '10';

//------------ACCESORES-----------------//
    public function getAmountDueAttribute($amountDue)
    {
       return decrypt($this->attributes['amountDue']);
    }
    public function getAmountPaidAttribute($amountPaid)
    {
        return decrypt($this->attributes['amountPaid']);
    }
    public function getAmountPercentajeAttribute($amountPercentaje)
    {
       return decrypt($this->attributes['amountPercentaje']);
    }
    public function getBalanceAttribute($balance)
    {
       return decrypt($this->attributes['balance']);
    }
    public function getDatePaidAttribute($datePaid)
    {
         $oDateHelper = new DateHelper;
         $functionRs = $oDateHelper->changeDateForCountry(session('countryId'),'Accesor');
         $newDate    = $oDateHelper->$functionRs($datePaid);
        return $newDate;
    }

// //------------MUTADORES-----------------//
    public function setAmountDueAttribute($amountDue)
    { 
        $amountDue = number_format((float)$amountDue, 2, '.', '');
        return $this->attributes['amountDue'] = encrypt($amountDue);
    } 
    public function setAmountPaidAttribute($amountPaid)
    {
        $amountPaid = number_format((float)$amountPaid, 2, '.', '');
        return $this->attributes['amountPaid'] = encrypt($amountPaid);
    } 
    public function setAmountPercentajeAttribute($amountPercentaje)
    {
        $amountPercentaje = number_format((float)$amountPercentaje, 2, '.', '');
        return $this->attributes['amountPercentaje'] = encrypt($amountPercentaje);
    } 
    public function setBalanceAttribute($balance)
    {
        $balance = number_format((float)$balance, 2, '.', '');
        return $this->attributes['balance'] = encrypt($balance);
    } 
    public function setDatePaidAttribute($datePaid)
    {
        $oDateHelper = new DateHelper;
         $functionRs = $oDateHelper->changeDateForCountry(session('countryId'),'Mutador');
         $newDate    = $oDateHelper->$functionRs($datePaid);

        $this->attributes['datePaid'] = $newDate;
    }
//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
    public function account()
    {
        return $this->belongsTo('App\Account', 'accountId');
    }
    public function paymentMethod()
    {
        return $this->belongsTo('App\PaymentMethod', 'collectMethod','payMethodId');
    }
    public function client()
    {
        return $this->belongsTo('App\Client', 'clientId');
    } 
   public function invoice()
    {
        return $this->belongsTo('App\Invoice', 'invoiceId');
    } 
  public function receivableStatus()
    {    //aqui debo meter esta linea en una variable y hacerle un where para filtrarlo por idioma
         $relation = $this->hasMany('App\ReceivableStatus', 'recStatusCode','recStatusCode');
         //hace el filtrado por el idioma
         //el locale cambia por el middleware que esta en localitazion,
         //esto maneja los datos por el idioma que escpga el usuario
         return $relation->where('language',session('countryLanguage'));
    }
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
//_ESSTE EVENTO SE USA EN LA SECCION DE CONTRATOS EN EDITAR, PARA SABER SI SE HA PAGADO
    //SI SE COMENZO A PAGAR NO SE PUEDE MODIFICAR
    // public function verificarPagoCuota($contractId)
    // {
    //     $result = $this->where('contractId', $contractId)
    //         ->where('recStatusCode','!=' ,Receivable::STATELESS)
    //         ->get();

    //        if(count($result) == 0)
    //        {
    //          return false;
    //        }else{
    //           return true;
    //        }
    // }
//----------------------------------------------------
     public function findById($id)
    {
        return $this->where('receivableId', '=', $id)->get();
    }
//-----------------METODO USADO EN LA IMPRESION DE LA FACTURA   
     public function getAllByInvoice($invoiceId)
    {   // ojo parece que esta repetida mas abajo,revisar si esta en alguna parte del codigo
        //QUE SE HALLAN PROCESADO CON EXITO
        $result = $this->where('invoiceId', $invoiceId)
            ->where('recStatusCode','=' ,Receivable::SUCCESS)
            ->orderBy('paymentInvoiceId', 'ASC')
            ->get();

        return $result;
    }
//--------------------------------------------
    //metodo usado en modulo administrativo para mostrar clientes y la suma de cuotas deudoras de todas sus facturas,countryId
    public function clientsPending($countryId)
    { //buscar todos los clientes donde el estado No sea exitoso (4) y agrupalos para contar sus cuotas
        return $this->select('clientId', DB::raw('count(*) as cuotas'))
            ->where('recStatusCode', '!=', Receivable::SUCCESS) 
            ->where('countryId', '=', $countryId)
            ->groupBy('clientId')
            ->get();
    }
    //------------------------------------------
     //igual que el anterior pero este es para una sola persona, es por clientId
    public function clientPendingInfo($clientId)
    {
        return $this->select('clientId', DB::raw('count(*) as cuotas'))
            ->where('recStatusCode', '!=', Receivable::SUCCESS)
            ->where('clientId', '=', $clientId)
            ->groupBy('clientId')
            ->get();
    }
//------------------------------------------
    public function invoicesPendingAll($clientId)
    {
        $receivablesInvoices = $this->select('receivableId','invoiceId','amountDue', 'countryId','recStatusCode')
            ->where('recStatusCode', '!=', Receivable::SUCCESS)
            ->where('clientId', '=', $clientId)
            ->orderBy('receivableId')
            ->get();

        return $receivablesInvoices->groupBy('invoiceId');
    }
//------------------------------------------
      //muestra las cuotas pendientes de la factura
    public function sharePending($invoiceId)
    {
        return $this->where('recStatusCode', '!=', Receivable::SUCCESS)
            ->where('invoiceId', '=', $invoiceId)
            ->orderBy('paymentInvoiceId')
            ->get();

    }
//------------------------------------------
      //muestra las cuotas pagadas de la factura
    public function shareSucceed($invoiceId)
    {
        return $this->where('recStatusCode', '=', Receivable::SUCCESS)
            ->where('invoiceId', '=', $invoiceId)
            ->orderBy('paymentInvoiceId')
            ->get();

    }
//------------------------------------------
    //suma todas las cuotas existosas de la factura, metodo usado por modelo invoice para restar este monto del monto de la factura.
    public function sumSucceedSharesForInvoice($invoiceId)
    {
         $receivables = $this->select('amountPaid')
            ->where('recStatusCode', '=', Receivable::SUCCESS)
            ->where('invoiceId', '=', $invoiceId)
            ->get();
          
        $acum=0;
          foreach ($receivables as $key => $receivable) {
             $acum += $receivable->amountPaid;
          }
          return $acum;
    }

//------------------------------------------
        //esta funcion me permite saber cual es la cuota de la factura que corresponde pagar 
    public function currentShare($invoiceId)
    {
         $receivables = $this->select('paymentInvoiceId')
            ->where('invoiceId', '=', $invoiceId)
            ->where('recStatusCode', '!=', Receivable::SUCCESS)
            ->orderBy('paymentInvoiceId')
            ->first();

        if($receivables == null){
            return null;
        }

            return $receivables->paymentInvoiceId;
    }
//   //------------------------------------------
//   public function getDueTotal($clientId)
//     {
//          $amounts = $this->select('amountDue')
//             ->where('pending', '=', 'Y')
//             ->where('clientId', '=', $clientId)
//             ->get();

   
//          $amounts->map(function ($amount) {
//              $amount->dueTotal =+ $amount->amountDue;
        
//             });
          
//     }
// //--------------------------------------------
//     public function amountTotalContract($contractId)
//     {
//         return $this->select(DB::raw("SUM(amountDue) as amountTotal"))
//             ->where('contractId', '=', $contractId)
//             ->get();

//     }
    //busca todas la cuotas de una factura por dos estados, nacio 
    //para en proceso y pagadas
    public function getAllByInvoiceAndTwoStatus($status1,$status2,$invoiceId)
    {
        return $this->where('recStatusCode', '!=', Receivable::PROCESS)
              ->where('recStatusCode', '!=', Receivable::SUCCESS)
            ->where('invoiceId', '=', $invoiceId)
            ->orderBy('paymentInvoiceId')
            ->get();

    }
//------------------------------------------
    //usado para el cobro de cuotas
    public function updateReceivable($receivableId, $amountPaid, $collectMethod, $sourceBank, $sourceBankAccount, $checkNumber,$cashboxId, $accountId,$percent,$amountPercent,$datePaid,$userId)
    {
        $error   = null;
        $amountR = 0;

        DB::beginTransaction();

        try {
            //busca datos de la cuota que el usuario escogio
            $receivable = $this->find($receivableId);
            //trae todas las cuotas creadas por el usuario, me sirve para saber si queda (01) y determinar que es la ultima cuota.
            $invoiceShares = $this->sharePending($receivable->invoiceId);
            //suma todas las cuotas creadas para la factura de receivable 
            $totalSumCuotas = 0;
            foreach ($invoiceShares as $share) {
                $totalSumCuotas += $share->amountDue;
            }
            //error: si es la ultima cuota mandame errores de montos.
            if (count($invoiceShares) == 1) {
                if ($amountPaid < $receivable->amountDue) {
                    throw new \Exception('Error: Unica Cuota, El Monto es Insuficiente');
                } elseif ($amountPaid > $receivable->amountDue) {
                    throw new \Exception('Error: Unica Cuota, El Monto a Cobrar es Muy Alto');
                }
                //error si lo pagado es igual o mayor que la suma de las cuotas.
            } elseif ($amountPaid >= $totalSumCuotas) {
                throw new \Exception('Error: El monto Ingresado No puede ser mayor o igual al Total de la suma de las cuotas');
            }
            //---------comienza actualizacion del pago de cuota------------
            // $invoiceShares[1] es la cuota que le sigue a la seleccionada
            if ($collectMethod == Receivable::DEBIT_CARD || $collectMethod == Receivable::CREDIT_CARD) {
                $receivable->percent =  $percent;
                $receivable->amountPercentaje =  $amountPercent;
            }
            $receivable->collectMethod     = $collectMethod;
            $receivable->sourceBank        = $sourceBank;
            $receivable->sourceBankAccount = $sourceBankAccount;
            $receivable->checkNumber       = $checkNumber;
            $receivable->cashboxId         = $cashboxId;
            $receivable->accountId         = $accountId;
            $receivable->datePaid          = $datePaid;
            $receivable->userId            = $userId;
            
       //verifica si el metodo de pago tiene en el campo verificacion Y o N, Y significa que debe verificarse ese metodo de pago
            $oPaymentMethod = new PaymentMethod;
              if( $oPaymentMethod->ifIsInProcess($collectMethod) == 'Y'){
               $receivable->recStatusCode          = Receivable::PROCESS;  
              }else{
               $receivable->recStatusCode           = Receivable::SUCCESS;
            //(insert transaction and Update BANK)... SOLO CUANDO ES EXITOSA INSERTA
               // $oDateHelper = new DateHelper;
               // $functionRs = $oDateHelper->changeDateForCountry(session('countryId'),'Mutador');
               // $newDate    = $oDateHelper->$functionRs($datePaid);
               // $month        = explode("-", $newDate);
                       
                       //PARA SABER EL NUMERO DE LA CUOTA QUE CORRESPONDE
                     $sharesSucceed = $this->shareSucceed($receivable->invoiceId);
                     $paymentNumber = count($sharesSucceed)+1;
                     $paymentNumber = "PAYMENT #".$paymentNumber;

               $oTransaction = new Transaction;
               $transactionRs1 = '';
               $transactionRs2 = '';
               $oTransactionType = new TransactionType;
               $collection = $oTransactionType->findByOfficeAndCode(session('officeId'),'INCOME_INVOICE');
               $fee        = $oTransactionType->findByOfficeAndCode(session('officeId'),'FEE');

               $transactionRs1 = $oTransaction->insertT(session('countryId'),session('officeId'), $collection[0]->transactionTypeId,$receivable->invoice->contract->contractNumber ,$collectMethod,'', $paymentNumber, $datePaid, $amountPaid,'+',$cashboxId, $accountId, $receivable->invoiceId,$userId);
               
              if($transactionRs1['alert'] == 'error') {
                throw new \Exception($transactionRs1['msj']);
               };
               //SI ES UN PAGO EXITOSO SIN VERIFICACION Y EL METODO DE PAGO ES POR TARJETA AGREGAR LA TRANSACCION CONVENIENCE FEE
            if ($collectMethod == Receivable::DEBIT_CARD || $collectMethod == Receivable::CREDIT_CARD) {

                 $transactionRs2 = $oTransaction->insertT(session('countryId'),session('officeId'), $fee[0]->transactionTypeId,$receivable->invoice->contract->contractNumber ,$collectMethod,'', $paymentNumber.' - CONVENIENCE FEE', $datePaid, $amountPercent,'+', $cashboxId, $accountId, $receivable->invoiceId,$userId);
               
              if($transactionRs2['alert'] == 'error') {
                throw new \Exception($transactionRs2['msj']);
               };
             } //cierre de if transactionRs2
       }//CIERRE DEL ELSE METODO ES UN PAGO EXITOSO SIN VERIFICACION
            //balance de la factura saldo que falta por pagar si es cero se cambia el status de la factura a pagada(4)
             $oInvoice       = new Invoice;
             $invoiceBalance = $oInvoice->getBalance($receivable->invoiceId);
             $invoiceBalance = $invoiceBalance - $amountPaid;
             $receivable->balance = $invoiceBalance;//ASIGNO EL BALANCE A LA CUOTA SE HACE SIEMPRE CADA VEZ QUE SEA EXITOSA,PROCESADA O DECLINADA

            if($receivable->recStatusCode == Receivable::SUCCESS and $invoiceBalance == 0){
                  $oInvoice->changeStatus($receivable->invoiceId, Invoice::PAID);
            }else{
                  $oInvoice->changeStatus($receivable->invoiceId, Invoice::CLOSED);
            }
           
//CUANDO EL MONTO PAGADO ES MENOR O MAYOR QUE LA CUOTA         
      //------------si lo pagado es menor que la cuota.)
            if ($amountPaid < $receivable->amountDue) {
                $amountR                = $receivable->amountDue - $amountPaid;
                $receivable->amountPaid = $amountPaid;
                 //REALIZA ACTUALIZACION EN MONTO DE LA DEUDA DE LA PROXIMA CUOTA
                 if($receivable->recStatusCode == Receivable::SUCCESS) {  //solo dejar actualizar la siguiente cuota si este pago es exitoso
                   $receivableCurrent  = Receivable::find($invoiceShares[0]->receivableId);
                   $receivableCurrent->amountDue = $amountPaid;
                   $receivableCurrent->save();
                   $receivableNext  = Receivable::find($invoiceShares[1]->receivableId);
                   $receivableNext->amountDue = $receivableNext->amountDue + $amountR;
                   $receivableNext->save();
                 }
    //----------si lo pagado es mayor que la cuota 
            }elseif ($amountPaid > $receivable->amountDue) {

                $amountR = $amountPaid - $receivable->amountDue;
                if ($amountR >= $invoiceShares[1]->amountDue) {
                    throw new \Exception('Error: No puede pagar Dos Cuotas simultaneamente, Monto Muy Alto');
                }
                $receivable->amountPaid = $amountPaid;
                  //REALIZA ACTUALIZACION EN MONTO DE LA DEUDA DE LA PROXIMA CUOTA
                 if($receivable->recStatusCode == Receivable::SUCCESS) {  //solo dejar actualizar la siguiente cuota si este pago es exitoso  
                   $receivableCurrent  = Receivable::find($invoiceShares[0]->receivableId);
                   $receivableCurrent->amountDue = $amountPaid;
                   $receivableCurrent->save();
                   $receivableNext  = Receivable::find($invoiceShares[1]->receivableId);
                   $receivableNext->amountDue = $receivableNext->amountDue - $amountR;
                   $receivableNext->save();
                 }
            } elseif ($amountPaid == $receivable->amountDue) {
                $receivable->amountPaid = $amountPaid;
            }
        
            $receivable->save();

            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return $result = ['alert' => 'success', 'msj' => 'Cobro realizado Con Exito'];
        } else {
            return $result = ['alert' => 'error', 'msj' => $error];
        }

    }
//------------------------------------------
     //METODO PARA CONFIRMAR SI LA CUOTA EN ES EXITOSA O DECLINADA
   public function confirmPayment($invoiceId,$receivableId,$status)
    {
     $amountR=0;
      DB::beginTransaction();
        try {
             $receivable = $this->find($receivableId);
             $receivable->recStatusCode = $status;

             $invoiceShares = $this->sharePending($receivable->invoiceId);

             //FALTA AGREGAR LA TRANSACCION EN ESTE CASO Y EL CAMBIO DEL ESTADO DE LA FACTURA CUANDO ES PAGADA

    if($status == Receivable::SUCCESS) {    //solo dejar actualizar la siguiente cuota si este pago es exitoso
    //agregar la transaccion de la cuota exitosa
               // $oDateHelper = new DateHelper;
               // $functionRs = $oDateHelper->changeDateForCountry(session('countryId'),'Mutador');
               // $newDate    = $oDateHelper->$functionRs($receivable->datePaid);
               // $month        = explode("-", $newDate);

                     $sharesSucceed = $this->shareSucceed($receivable->invoiceId);
                     $paymentNumber = count($sharesSucceed)+1;
                     $paymentNumber = "PAYMENT #".$paymentNumber;

               $oTransaction = new Transaction;
               $transactionRs1 = '';
               $transactionRs2 = '';

               $oTransactionType = new TransactionType;
               $collection = $oTransactionType->findByOfficeAndCode(session('officeId'),'INCOME_INVOICE');
               $fee        = $oTransactionType->findByOfficeAndCode(session('officeId'),'FEE');

               $transactionRs1 = $oTransaction->insertT(session('countryId'),session('officeId'), $collection[0]->transactionTypeId,$receivable->invoice->contract->contractNumber ,$receivable->collectMethod,'', $paymentNumber, $receivable->datePaid, $receivable->amountPaid,'+',$receivable->cashboxId, $receivable->accountId, $receivable->invoiceId, Auth::user()->userId);

                    if($transactionRs1['alert'] == 'error') {
                        throw new \Exception($transactionRs['msj']);
                    };

                //SI ES UN PAGO EXITOSO SIN VERIFICACION Y EL METODO DE PAGO ES POR TARJETA AGREGAR LA TRANSACCION CONVENIENCE FEE (OJO REVISAR )
     if ($receivable->collectMethod == Receivable::DEBIT_CARD || $receivable->collectMethod == Receivable::CREDIT_CARD) {
             $transactionRs2 = $oTransaction->insertT(session('countryId'),session('officeId'), $fee[0]->transactionTypeId,$receivable->invoice->contract->contractNumber ,$receivable->collectMethod,'', $paymentNumber.' - CONVENIENCE FEE', $datePaid, $receivable->amountPercent,'+',$receivable->cashboxId, $receivable->accountId, $receivable->invoiceId, Auth::user()->userId);

                     if($transactionRs2['alert'] == 'error') {
                       throw new \Exception($transactionRs['msj']);
                     };
             }
    
  
    //si sobra dinero de este pago agregalo o descuentalo de la cuota siguiente.      
      if (count($invoiceShares) > 1) {//si sigue una cuota despues de la que estoy cobrando
             if($receivable->amountPaid < $receivable->amountDue){
                $amountR = $receivable->amountDue - $receivable->amountPaid;
                
                $receivableCurrent  = Receivable::find($invoiceShares[0]->receivableId);
                $receivableCurrent->amountDue = $receivable->amountPaid;
                $receivableCurrent->save();
                $receivableNext  = Receivable::find($invoiceShares[1]->receivableId);
                $receivableNext->amountDue = $receivableNext->amountDue + $amountR;
                $receivableNext->save();

             }elseif($receivable->amountPaid > $receivable->amountDue){
                $amountR = $receivable->amountPaid - $receivable->amountDue;

                $receivableCurrent  = Receivable::find($invoiceShares[0]->receivableId);
                $receivableCurrent->amountDue = $receivable->amountPaid;
                $receivableCurrent->save();
                $receivableNext  = Receivable::find($invoiceShares[1]->receivableId);
                $receivableNext->amountDue = $receivableNext->amountDue - $amountR;
                $receivableNext->save();
             }
        }
        //balance de la factura saldo que falta por pagar si es cero se cambia el status de la factura a pagada(4)
             $oInvoice       = new Invoice;
             $invoiceBalance = $oInvoice->getBalance($receivable->invoiceId);
             $invoiceBalance = $invoiceBalance -  $receivable->amountPaid;
             $receivable->balance = $invoiceBalance;
             
             if($invoiceBalance == 0){
                   $oInvoice->changeStatus($receivable->invoiceId, Invoice::PAID);
              }
    }//FIN DEL if($status == 4) 


            $receivable->save();
            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }   

        if ($success) {
            return $result = ['alert' => 'success', 'msj' => 'Operacion Realizada'];
        } else {
            return $result = ['alert' => 'error', 'msj' => $error];
        }

    }   
//------------------------------------------
    public function collections($countryId,$officeId, $date1, $date2)
    {

        $result[] = $this->where('countryId', $countryId)
            ->where('officeId', $officeId) 
            ->where("collectMethod", "=", '1')
            ->where("status", "=", Receivable::SUCCESS)
            ->where("datePaid", ">=", $date1)
            ->where("datePaid", "<=", $date2)
            ->orderBy('collectMethod', 'ASC')
            ->get();
        $result[] = $this->where("countryId", "=", $countryId)
            ->where('officeId', $officeId) 
            ->where("collectMethod", "=", '2')
            ->where("status", "=", Receivable::SUCCESS)
            ->where("datePaid", ">=", $date1)
            ->where("datePaid", "<=", $date2)
            ->orderBy('collectMethod', 'ASC')
            ->get();
        $result[] = $this->where("countryId", "=", $countryId)
            ->where('officeId', $officeId) 
            ->where("collectMethod", "=", '3')
            ->where("status", "=", Receivable::SUCCESS)
            ->where("datePaid", ">=", $date1)
            ->where("datePaid", "<=", $date2)
            ->orderBy('collectMethod', 'ASC')
            ->get();
        $result[] = $this->where("countryId", "=", $countryId)
            ->where('officeId', $officeId) 
            ->where("collectMethod", "=", '4')
            ->where("status", "=", Receivable::SUCCESS)
            ->where("datePaid", ">=", $date1)
            ->where("datePaid", "<=", $date2)
            ->orderBy('collectMethod', 'ASC')
            ->get();
       $result[] = $this->where("countryId", "=", $countryId)
            ->where('officeId', $officeId) 
            ->where("collectMethod", "=", '5')
            ->where("status", "=", Receivable::SUCCESS)
            ->where("datePaid", ">=", $date1)
            ->where("datePaid", "<=", $date2)
            ->orderBy('collectMethod', 'ASC')
            ->get();
        $result[] = $this->where("countryId", "=", $countryId)
            ->where('officeId', $officeId) 
            ->where("collectMethod", "=", '6')
            ->where("status", "=", Receivable::SUCCESS)
            ->where("datePaid", ">=", $date1)
            ->where("datePaid", "<=", $date2)
            ->orderBy('collectMethod', 'ASC')
            ->get();     
        //filtrando para eliminar resultados vacios del arreglo()
        $results = array_filter($result, function ($array) {
            foreach ($array as $value) {
                if ($value == []) {
                    return false;
                } else {
                    return true;
                }
            }
        });

        return $results;
    }
}
