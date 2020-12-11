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

    protected $appends = ['amountDue','balance'];

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
    const STATELESS     = '1';
    const SUCCESS   = '2';
    // const PROCESS     = '2';
    // const DECLINED    = '3';

//------------ACCESORES-----------------//
    public function getAmountDueAttribute($amountDue)
    {
       return decrypt($this->attributes['amountDue']);
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
//-------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    public function getAllBySubcontractor($subcontId)
    {
        //consulta que traer relaciones desde tabla payable hasta contratc, y tiene una comparacion dentro de la relacion
        //subcontratos
        $result = $this->with('subcontInvDetail.subcontractor','subcontInvDetail.invoice','subcontInvDetail.invoice.contract')
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
        $payable->amountDue          = $amountDue;
        $payable->balance            = $amountDue;
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
// $invoice->shareSucceed->sum('amountPaid')
        try {
            //busca datos de la cuota que el usuario escogio 
              $total = 0;
              foreach ($payables as $index => $item) {

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
                  //resta el balance de la cuota menos el monto pagado por formulario.
                  $total = $item['balance'] - $item['amountPaid'];

                  $payable = $this->find($item['payableId']);
                  $payable->balance = $total;
                   if($total == 0){
                     $payable->payStatusCode = Payable::SUCCESS;
                   }
                  $payable->save();

                 $oTransactionType = new TransactionType;
                 $transactionType = $oTransactionType->findByOfficeAndCode(session('companyId'),$item['subcont_inv_detail']['subcontractor']['typeForm1099']);


            $oTransaction = new Transaction;
            $rs1 = $oTransaction->insertT(
              session('countryId'),
              session('companyId'),
              $transactionType[0]->transactionTypeId,
              $item['subcont_inv_detail']['subcontractor']['name'],
              $payMethodId,
              $payMethodDetails,
              $item['reason'],
              date('m/d/Y'),
              $item['amountPaid'],
              '-',
              $cashboxId,
              $accountId,
              $payable,
              Auth::user()->userId);



              if($rs1['alert'] == 'error') {
                throw new \Exception($rs1['msj']);
               };

            } //cierre del foreach

            //---------comienza actualizacion del pago de cuota------------
            // $invoiceShares[1] es la cuota que le sigue a la seleccionada
        
            
      
            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return $result = ['alert' => 'success', 'msj' => 'Pago Realizado Exitosamente'];
        } else {
            return $result = ['alert' => 'error', 'msj' => $error];
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
            return $result = ['alert' => 'info', 'msj' => 'Cliente Eliminado'];
        } else {
            return $result = ['alert' => 'error', 'msj' => 'No se Puede Eliminar porque este registro tiene relacion con otros datos.'];
        }
    }  
}
