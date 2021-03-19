<?php

namespace App;

use App;
use DB;
use Auth;
use App\Transaction;
use App\Helpers\DateHelper;

use Illuminate\Database\Eloquent\Model;

class Payable extends Model
{

    protected $table      = 'payable';
    protected $primaryKey = 'payableId';
    public $timestamps    = false;

    protected $appends = ['amountDue','acumAmountPaid','balance'];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
       'payableId',
       'countryId',
       'companyId',
       'amountDue',
       'balance',
       'subcontInvDetailId',
       'userId',
       'payStatusCode'
    ];
    //RECEIVABLE STATUS
    const STATELESS      = '1';
    const SUCCESS        = '2';
    // const PROCESS     = '2';
    // const DECLINED    = '3';

//------------ACCESORES-----------------//
    public function getAmountDueAttribute($amountDue)
    {
       return decrypt($this->attributes['amountDue']);
    }
    public function getAcumAmountPaidAttribute($acumAmountPaid)
    {
       return decrypt($this->attributes['acumAmountPaid']);
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
    public function setAcumAmountPaidAttribute($acumAmountPaid)
    { 
        $acumAmountPaid = number_format((float)$acumAmountPaid, 2, '.', '');
        return $this->attributes['acumAmountPaid'] = encrypt($acumAmountPaid);
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
  public function subcontInvDetail()
    {
        return $this->hasOne('App\SubcontractorInvDetail', 'subcontInvDetailId', 'subcontInvDetailId');
    }
  public function invoiceDetail()
    {
        return $this->hasOne('App\InvoiceDetail', 'invDetailId', 'invDetailId');
    }  
  public function transaction()
    {
        return $this->belongsToMany('App\Transaction','transaction_payable','payableId', 'transactionId')->withPivot('amountPaid', 'reason');
    }  
//-------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    public function getAllBySubcontractor($subcontId)
    {
        //consulta que traer relaciones desde tabla payable hasta contratc, y tiene una comparacion dentro de la relacion
        //subcontratos
        $result = $this->with('subcontInvDetail.subcontractor','subcontInvDetail.invoice','subcontInvDetail.invoice.contract','transaction')
            ->whereHas('subcontInvDetail.subcontractor',function($q) use ($subcontId){
                $q->where('subcontId',$subcontId);
            })->where('payStatusCode','=',Payable::STATELESS)
              ->orderBy('payableId', 'DESC')
              ->get();
       
        return $result;
    }
      public function insertP($subcontInvDetailId,$amountDue)
    {
        $payable                     = new Payable;
        $payable->countryId          = session('countryId');
        $payable->companyId          = session('companyId');
        $payable->amountDue         = $amountDue;
        $payable->balance           = $amountDue;
        $payable->amountPaid           = $amountDue;
        $payable->subcontInvDetailId = $subcontInvDetailId;
        $payable->userId             = Auth::user()->userId;
        $payable->save();
        return $payable;
  }

  //usado para el cobro de cuotas
    public function addPay($payables,$payMethodId,$payMethodDetails,$cashboxId,$accountId)
    {
        $error   = null;
        DB::beginTransaction();
        try {

        $subcontractor = Subcontractor::findOrFail($payables[0]['subcont_inv_detail']['subcontractor']['subcontId']);
        //sumar amountPaid
          $amountPaidAcum = 0;
           foreach ($payables as $index => $item) {
             $amountPaidAcum += $item['amountPaid'];
            }
  
            $oTransactionType = new TransactionType;
            $transactionType = $oTransactionType->findByOfficeAndCode(session('companyId'),$subcontractor->typeForm1099);

            $oTransaction = new Transaction;
            $rs1 = $oTransaction->insertT(
              session('countryId'),
              session('companyId'),
              $transactionType[0]->transactionTypeId,
              $subcontractor->name,
              $payMethodId,
              $payMethodDetails,
              'NINGUNA RAZON',
              date('Y-m-d'),
              $amountPaidAcum,
              '-',
              $cashboxId,
              $accountId,
              $subcontractor,
              Auth::user()->userId);

              if($rs1['alert'] == 'error') {
                throw new \Exception($rs1['message']);
               }; 
          
            //busca datos de la cuota que el usuario escogio 
              $total = 0;
              $acumAmountPaid = 0;
              foreach ($payables as $index => $item) {
                //verificacion de errores de cada cuota
                  $index++;
                   if($item['reason'] == '') {
                    throw new \Exception('Error: Debe Escribir un Motivo en la cuota # '.$index);
                   };
                  if($item['amountPaid'] == 0) {
                    throw new \Exception('Error: Debe ingresar un monto a Pagar en la cuota # '.$index);
                   };
                  if($item['amountPaid'] > $item['balance']) {
                    throw new \Exception('Error: El monto pagado es mayor que el saldo, ingrese uno menor en la cuota # '.$index);
                  };
                  //acumula el saldo pagado
                //   $amountPaidAcum += $item['amountPaid'];
                  //resta el balance de la cuota menos el monto pagado por formulario.
                  $acumAmountPaid = $item['acumAmountPaid'] + $item['amountPaid'];
                  $total          = $item['balance']        - $item['amountPaid'];

                  $payable = $this->find($item['payableId']);
                  $payable->acumAmountPaid = $acumAmountPaid;
                  $payable->balance = $total;
                   if($total == 0){
                     $payable->payStatusCode = Payable::SUCCESS;
                   }
                  $payable->save();

            //asignar a la transaccion - los pagos realizados de cuentas por pagar
               $transaction  = Transaction::findOrfail($rs1['transactionId']);

               $transaction->payable()->attach($payable->payableId, 
                ['amountPaid' => number_format((float)$item['amountPaid'], 2, '.', ''),
                'reason'      => $item['reason']
                ]);

            } //cierre del foreach

            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return $result = ['alert' => 'success', 'message' => 'Pago Realizado Exitosamente'];
        } else {
            return $result = ['alert' => 'error', 'message' => $error];
        }

    }

   public function deleteBySubcont($subcontInvDetailId)
    {
        try {
          $this->where('subcontInvDetailId', '=', $subcontInvDetailId)
               ->delete();
               
            $success = true;
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
        }

        if ($success) {
            return $result = ['alert' => 'info', 'message' => 'Cliente Eliminado'];
        } else {
            return $result = ['alert' => 'error', 'message' => 'No se Puede Eliminar porque este registro tiene relacion con otros datos.'];
        }
    }  
}
