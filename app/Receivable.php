<?php

namespace App;

use App;
use DB;
use App\Helpers\DateHelper;
use App\Transaction;
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
        'targetBankId',
        'targetBankAccount',
        'datePaid',
        'status',
    ];

    //COLLECTIONS METHOD
    const CARD     = '1';
    const CASH     = '2';
    const CHECK    = '3';
    const DEPOSIT   = '4';
    const PAYPAL   = '5';
    const TRANSFER = '6';

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
//     public function getCollectMethodAttribute($collectMethod)
//     {

//         if (App::getLocale() == 'es') {
//             switch ($collectMethod) {
//                 case 1:
//                     return "EFECTIVO";
//                     break;
//                 case 2:
//                     return "CHEQUE";
//                     break;
//                 case 3:
//                     return "TARJETA";
//                     break;
//                 case 4:
//                     return "TRANSFERENCIA";
//                     break;
//                 case 5:
//                     return "PAYPAL";
//                     break;     
//                 case 6:
//                     return "DEPOSITO";
//                     break;   
//             }
//         } else {
//             switch ($collectMethod) {
//                 case 1:
//                     return "CASH";
//                     break;
//                 case 2:
//                     return "CHECK";
//                     break;
//                 case 3:
//                     return "CARD";
//                     break;
//                 case 4:
//                     return "TRANSFER";
//                     break;
//                case 5:
//                     return "PAYPAL";
//                     break; 
//                case 6:
//                     return "DEPOSIT";
//                     break;                
//             }
//         }

//     }
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
    public function bank()
    {
        return $this->belongsTo('App\Bank', 'targetBankId');
    }
    public function paymentMethod()
    {
        return $this->belongsTo('App\PaymentMethod', 'collectMethod');
    }
     public function receivableStatus()
    {
        return $this->belongsTo('App\ReceivableStatus', 'status');
    }
    public function client()
    {
        return $this->belongsTo('App\Client', 'clientId');
    } 

//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
//_ESSTE EVENTO SE USA EN LA SECCION DE CONTRATOS EN EDITAR, PARA SABER SI SE HA PAGADO
    //SI SE COMENZO A PAGAR NO SE PUEDE MODIFICAR
    public function verificarPagoCuota($contractId)
    {
        $result = $this->where('contractId', $contractId)
            ->where('status','!=' ,'1')
            ->get();

           if(count($result) == 0)
           {
             return false;
           }else{
              return true;
           }
    }
//----------------------------------------------------
     public function findById($id)
    {
        return $this->where('receivableId', '=', $id)->get();
    }
//-----------------METODO USADO EN LA IMPRESION DE LA FACTURA   
     public function getAllByInvoice($invoiceId)
    {
        //QUE SE HALLAN PROCESADO CON EXITO
        $result = $this->where('invoiceId', $invoiceId)
            ->where('status','=' ,'4')
            ->orderBy('paymentInvoiceId', 'ASC')
            ->get();

        return $result;
    }
//--------------------------------------------
    //metodo usado en modulo administrativo para mostrar clientes y la suma de cuotas deudoras de todas sus facturas,countryId
    public function clientsPending($countryId)
    { //buscar todos los clientes donde el estado No sea exitoso (4) y agrupalos para contar sus cuotas
        return $this->select('clientId', DB::raw('count(*) as cuotas'))
            ->where('status', '!=', '4') 
            ->where('countryId', '=', $countryId)
            ->groupBy('clientId')
            ->get();
    }
    //------------------------------------------
     //igual que el anterior pero este es para una sola persona, es por clientId
    public function clientPendingInfo($clientId)
    {
        return $this->select('clientId', DB::raw('count(*) as cuotas'))
            ->where('status', '!=', '4')
            ->where('clientId', '=', $clientId)
            ->groupBy('clientId')
            ->get();
    }
//------------------------------------------
    public function invoicesPendingAll($clientId)
    {
        $receivablesInvoices = $this->select('sourceReference', 'receivableId', 'amountDue', 'countryId')
            ->where('status', '!=', '4')
            ->where('clientId', '=', $clientId)
            ->orderBy('sourceReference')
            ->get();

        return $receivablesInvoices->groupBy('sourceReference');
    }
//------------------------------------------
      //muestra las cuotas pendientes de la factura
    public function sharePending($invoiceId)
    {
        return $this->where('status', '!=', '4')
            ->where('invoiceId', '=', $invoiceId)
            ->orderBy('paymentInvoiceId')
            ->get();

    }
//------------------------------------------
    //suma todas las cuotas existosas de la factura, metodo usado por modelo invoice para restar este monto del monto de la factura.
    public function sumSucceedSharesForInvoice($invoiceId)
    {
         $receivables = $this->select('amountPaid')
            ->where('status', '=', '4')
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
            ->where('status', '!=', '4')
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

//------------------------------------------
    //usado para el cobro de cuotas
    public function updateReceivable($receivableId, $amountPaid, $collectMethod, $sourceBank, $sourceBankAccount, $checkNumber, $targetBankId, $targetBankAccount, $datePaid)
    {
        $error   = null;
        $amountR = 0;

        DB::beginTransaction();

        try {
            //busca datos de la cuota que el usuario escogio
            $receivable = $this->find($receivableId);
            //trae todas las cuotas de la factura, me sirve para saber si queda (01) y determinar que es la ultima cuota.
            $invoiceShares = $this->sharePending($receivable->invoiceId);
            //suma las cuotas restantes para sacar costo de la factura
            $invoiceCost = 0;
            foreach ($invoiceShares as $share) {
                $invoiceCost += $share->amountDue;
            }

            //error: si es la ultima cuota mandame errores de montos.
            if (count($invoiceShares) == 1) {
                if ($amountPaid < $receivable->amountDue) {
                    throw new \Exception('Error: Ultima Cuota, El Monto es Insuficiente');
                } elseif ($amountPaid > $receivable->amountDue) {
                    throw new \Exception('Error: Ultima Cuota, El Monto a Cobrar es Muy Alto');
                }
                //error si lo pagado es igual o mayor que el costo del contrato.
            } elseif ($amountPaid >= $invoiceCost) {
                throw new \Exception('Error: El monto Ingresado No puede ser mayor o igual al costo Total de la Factura');
            }
            //---------comienza actualizacion del pago de cuota------------
            // $invoiceShares[1] es la cuota que le sigue a la seleccionada
            if ($collectMethod == Receivable::CARD) {
                $amountPercentaje             = $amountPaid * 0.03;
                $receivable->amountPercentaje = $amountPercentaje;
            }
            $receivable->collectMethod     = $collectMethod;
            $receivable->sourceBank        = $sourceBank;
            $receivable->sourceBankAccount = $sourceBankAccount;
            $receivable->checkNumber       = $checkNumber;
            $receivable->targetBankId      = $targetBankId;
            $receivable->targetBankAccount = $targetBankAccount;
            $receivable->datePaid          = $datePaid;
            
            //verifica si el metodo de pago tiene en el campo verificacion Y o N, Y significa que debe verificarse ese metodo de pago
            $oPaymentMethod = new PaymentMethod;
              if( $oPaymentMethod->ifIsInProcess($collectMethod) == 'Y'){
               $receivable->status          = '2';  
              }else{
               $receivable->status           = '4';
              }

              //saber el saldo de la factura y restar el monto pagado. para asi poner el balance en el recibo de pago
              $receivable->balance   = $invoiceCost - $amountPaid;

            //(insert transaction and Update BANK)... "XXXXXXXXXXXXXXXXX ACOMODAAR LA TRANSACCION SE EJECUTA SOLO CUANDO ES EXITOSAXXXX
            // $month        = explode("/", $datePaid);
            // $oTransaction = new Transaction;
            // $oTransaction->insertT(1, 'CUOTA', $datePaid, $amountPaid, $targetBankId, $receivable->sourceReference, '+', $month[1],session('countryId'),session('officeId'));


   //CUANDO EL MONTO PAGADO ES MENOR O MAYOR QUE LA CUOTA         
            //------------si lo pagado es menor que la cuota.)
            if ($amountPaid < $receivable->amountDue) {

                $amountR                = $receivable->amountDue - $amountPaid;
                // $receivable->amountDue  = $amountPaid;
                $receivable->amountPaid = $amountPaid;
                $receivable->save();

                //REALIZA ACTUALIZACION EN MONTO DE LA DEUDA DE LA PROXIMA CUOTA
            if($receivable->status == '4') {  //solo dejar actualizar la siguiente cuota si este pago es exitoso  
              $receivableNext  = Receivable::find($invoiceShares[1]->receivableId);
              $receivableNext->amountDue = $receivableNext->amountDue + $amountR;
              $receivableNext->save();
            }
                //----------si lo pagado es mayor que la cuota 
            } elseif ($amountPaid > $receivable->amountDue) {

                $amountR = $amountPaid - $receivable->amountDue;
                if ($amountR >= $invoiceShares[1]->amountDue) {
                    throw new \Exception('Error: No puede pagar Dos Cuotas simultaneamente, Monto Muy Alto');
                }
                // $receivable->amountDue  = $amountPaid;
                $receivable->amountPaid = $amountPaid;
                $receivable->save();

                  //REALIZA ACTUALIZACION EN MONTO DE LA DEUDA DE LA PROXIMA CUOTA
            if($receivable->status == '4') {  //solo dejar actualizar la siguiente cuota si este pago es exitoso  
                  $receivableNext  = Receivable::find($invoiceShares[1]->receivableId);
                  $receivableNext->amountDue = $receivableNext->amountDue - $amountR;
                  $receivableNext->save();
            }

            } elseif ($amountPaid == $receivable->amountDue) {
                // $receivable->amountDue  = $amountPaid;
                $receivable->amountPaid = $amountPaid;
                $receivable->save();
            }

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
     //METODO PARA CONFIRMAR SI LA CUOTA EN PROCESO, ES EXITOSA O DECLINADA
   public function confirmPayment($invoiceId,$receivableId,$status)
    {
        
     $amountR=0;

      DB::beginTransaction();
        try {
             $receivable = $this->find($receivableId);
             $receivable->status = $status;

             if($receivable->amountPaid < $receivable->amountDue){
                $amountR = $receivable->amountDue - $receivable->amountPaid;
             }elseif($receivable->amountPaid > $receivable->amountDue){
                $amountR = $receivable->amountPaid - $receivable->amountDue;
             }

            //trae todas las cuotas de la factura, me sirve para saber si queda (01) y determinar que es la ultima cuota.
             $invoiceShares = $this->sharePending($receivable->invoiceId);
            if($status == 4){   
              //actualiza el monto del  siguiente cuota si es exitosa (4)
                  $receivableNext  = Receivable::find($invoiceShares[1]->receivableId);
                  $receivableNext->amountDue = $receivableNext->amountDue - $amountR;
                  $receivableNext->save();
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
            ->where("status", "=", '4')
            ->where("datePaid", ">=", $date1)
            ->where("datePaid", "<=", $date2)
            ->orderBy('collectMethod', 'ASC')
            ->get();
        $result[] = $this->where("countryId", "=", $countryId)
            ->where('officeId', $officeId) 
            ->where("collectMethod", "=", '2')
            ->where("status", "=", '4')
            ->where("datePaid", ">=", $date1)
            ->where("datePaid", "<=", $date2)
            ->orderBy('collectMethod', 'ASC')
            ->get();
        $result[] = $this->where("countryId", "=", $countryId)
            ->where('officeId', $officeId) 
            ->where("collectMethod", "=", '3')
            ->where("status", "=", '4')
            ->where("datePaid", ">=", $date1)
            ->where("datePaid", "<=", $date2)
            ->orderBy('collectMethod', 'ASC')
            ->get();
        $result[] = $this->where("countryId", "=", $countryId)
            ->where('officeId', $officeId) 
            ->where("collectMethod", "=", '4')
            ->where("status", "=", '4')
            ->where("datePaid", ">=", $date1)
            ->where("datePaid", "<=", $date2)
            ->orderBy('collectMethod', 'ASC')
            ->get();
       $result[] = $this->where("countryId", "=", $countryId)
            ->where('officeId', $officeId) 
            ->where("collectMethod", "=", '5')
            ->where("status", "=", '4')
            ->where("datePaid", ">=", $date1)
            ->where("datePaid", "<=", $date2)
            ->orderBy('collectMethod', 'ASC')
            ->get();
        $result[] = $this->where("countryId", "=", $countryId)
            ->where('officeId', $officeId) 
            ->where("collectMethod", "=", '6')
            ->where("status", "=", '4')
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
