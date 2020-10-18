<?php

namespace App;


use DB;
use App\Helpers\DateHelper;
use App\TransactionType;
use App\SaleNote;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public $timestamps = false;

    protected $table      = 'transaction';
    protected $primaryKey = 'transactionId';
    //  protected $dateFormat = 'Y-m-d';
    protected $fillable = [ 
               'transactionId',
               'countryId',
               'companyId',
               'transactionTypeId',
               'description',
               'payMethodId',
               'payMethodDetails',
               'reason',
               'transactionDate',
               'amount',
               'sign',
               'bankId',
               'invoiceId',
               'deleted_at'];

    //--------------------------------------------------------------------
               /** RELATIONS */
    //--------------------------------------------------------------------
    public function transactionType()
    {
        return $this->belongsTo('App\TransactionType', 'transactionTypeId', 'transactionTypeId');
    }
    public function document()
    {
        return $this->hasOne('App\Document', 'transactionId', 'transactionId');
    }
     public function paymentMethod()
    {
        return $this->belongsTo('App\PaymentMethod', 'payMethodId', 'payMethodId');
    }
    public function account()
    {
        return $this->belongsTo('App\Account', 'accountId', 'accountId');
    }
    public function cashbox()
    {
        return $this->hasOne('App\Cashbox', 'cashboxId', 'cashboxId');
    }
     public function invoice()
    {
        return $this->belongsTo('App\Invoice', 'invoiceId', 'invoiceId');
    }
     public function user()
    {
        return $this->belongsTo('App\User', 'userId', 'userId');
    }
    //--------------------------------------------------------------------
               /** ACCESORES **/
   //--------------------------------------------------------------------
    public function getAmountAttribute($amount)
    {
        return decrypt($amount);
    }
    public function getTransactionDateAttribute($transactionDate)
    {
         $oDateHelper = new DateHelper;
         $functionRs = $oDateHelper->changeDateForCountry(session('countryId'),'Accesor');
         $newDate    = $oDateHelper->$functionRs($transactionDate);
        return $newDate;
    }

    // ------------MUTADORES-----------------//
    public function setAmountAttribute($amount)
    {
         $amount = number_format((float)$amount, 2, '.', '');
        return $this->attributes['amount'] = encrypt($amount);
    }
    public function setTransactionDateAttribute($transactionDate)
    {
         $oDateHelper = new DateHelper;
         $functionRs = $oDateHelper->changeDateForCountry(session('countryId'),'Mutador');
         $newDate    = $oDateHelper->$functionRs($transactionDate);

        $this->attributes['transactionDate'] = $newDate;
    }
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    public function getAll()
    {
        return $this->orderBy('transactionDate', 'ASC')->get();
    }
  //----------------------------------------------------------------------
       public function getAllByInvoice($invoiceId,$countryId,$companyId)
    { 
        //OJO DEBE LLEVARSE POR SIGNOS 
     $result = Transaction::select()
        ->join('transaction_type', 'transaction_type.transactionTypeId', '=', 'transaction.transactionTypeId')
        ->where('transaction_type.transactionTypeCode', 'INCOME_INVOICE')
        ->where('transaction.countryId', $countryId) 
        ->where('transaction.companyId',$companyId)
        ->where('transaction.invoiceId',$invoiceId)
        ->orderBy('transaction.transactionId', 'ASC')
        ->get();

        return $result;
    }
     public function getAllWithSaleNotesByInvoice($invoiceId,$countryId,$companyId)
    { 


       $notes = SaleNote::select('salId as id','dateNote as transactionDate','netTotal as amount','noteType as reason')
           ->where('invoiceId',$invoiceId);


      $transactions = Transaction::select('transactionId as id','transactionDate','amount','reason')
        ->join('transaction_type', 'transaction_type.transactionTypeId', '=', 'transaction.transactionTypeId')
        ->where('transaction_type.transactionTypeCode', 'INCOME_INVOICE')
        ->where('transaction.countryId', $countryId) 
        ->where('transaction.companyId',$companyId)
        ->where('transaction.invoiceId',$invoiceId)
         ->union($notes)
         ->orderBy('transactionDate', 'ASC')
         ->get();

        return $transactions;
    }
    //------------------------------------
    public function getAllForSign($transactionSign,$countryId,$companyId)
    {
// ->with('invoiceDetails','note','scope','projectDescription')
        $result = $this->with('invoice','paymentMethod','account','user','invoice.contract')
                      ->where('sign', $transactionSign)
                      ->where('countryId', $countryId)
                      ->where('companyId', $companyId) 
            ->orderBy('transactionDate', 'DESC')
            ->get();

        return $result;
    }

    //------------------------------------------
    public function getAllForTwoDate($date1, $date2,$countryId,$companyId)
    {
        $result = $this->where("transactionDate", ">=", $date1)
            ->where("transactionDate", "<=", $date2)
            ->where('countryId', $countryId)
             ->where('companyId', $companyId) 
            ->orderBy('transactionId', 'ASC')
            ->get();

        return $result;
    }
    //------------------------------------------
    public function getAllForTwoDateAndSign($date1, $date2, $sign,$countryId,$companyId)
    {
        $result = $this->where("transactionDate", ">=", $date1)
            ->where("transactionDate", "<=", $date2)
            ->where("sign", "=", $sign)
            ->where('countryId', $countryId)
            ->where('companyId', $companyId) 
            ->orderBy('transactionId', 'ASC')
            ->get();

        return $result;
    }
    //------------------------------------------
    public function findById($id,$countryId,$companyId)
    {
        return $this->where('transactionId', '=', $id)
                      ->where('countryId', $countryId)
                      ->where('companyId', $companyId) 
                      ->get();
    }

    //------------------------------------------
    public function insertT($countryId,$companyId, $transactionTypeId,$description, $payMethodId, $payMethodDetails, $reason, $transactionDate, $amount, $sign,$cashboxId = '' , $accountId = '' ,$invoiceId,$userId,$file = '')
    {

        $error = null;

        DB::beginTransaction();
        try {
            //INSERTA UNA NUEVA TRANSACTION
            $transaction                    = new Transaction;
            $transaction->countryId         = $countryId;
            $transaction->companyId          = $companyId;
            $transaction->transactionTypeId = $transactionTypeId;
            $transaction->description       = $description;
            $transaction->payMethodId      = $payMethodId;
            $transaction->payMethodDetails = $payMethodDetails;
            $transaction->reason            = $reason;
            $transaction->transactionDate   = $transactionDate;
            $transaction->amount            = $amount;
            $transaction->sign              = $sign;
            $transaction->cashboxId         = $cashboxId;
            $transaction->accountId            = $accountId;
            $transaction->invoiceId         = $invoiceId;
            $transaction->userId            = $userId;
            $transaction->save();
            
            //SI ES UNA TRANSACCION DE EGRESO DEBO AGREGAR EL docId he insertarlo.

            //AGREGAR DOCUMENTO SI ES DE EGRESO
            if($sign == '-'){
            $oDocument = new Document;
              $rs2 = $oDocument->insertF($file,'transaction',$transaction->transactionId,'transactionsexpenses');
            }
            
            //REALIZA ACTUALIZACION EN BANCO
            // $oBank = new Bank;
            // $oBank->updateBalanceForBank($sign, $bankId, $month, $amount);
            
            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
          return $rs  = ['alert' => 'success', 'msj' => 'Transaccion Exitosa','transactionId'=>$transaction->transactionId];
        } else {
            return $rs = ['alert' => 'error', 'msj' => $error];
        }

    }
    //------------------------------------------
    public function deleteT($id)
    {      
        $error = null;
        DB::beginTransaction();
        try {
            //FALTA QUE CUANDO ELIMINE LA TRANSACION DESCUENTE O SUME DE BANK 
              $transaction   = Transaction::find($id);

            if($transaction->sign == '-') {
                $oDocument = new Document;
                $rs2 = $oDocument->deleteF($transaction->document->docUrl,$transaction->document->docId);
              }
                //  $oBank = new Bank;
                //  $oBank->updateBalanceForBank($transaction->sign, $transaction->bankId, $month, $transaction->$amount);

                $transaction->delete();

            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return $result = ['alert' => 'info', 'msj' => 'Transaccion Eliminada'];
        } else {
            return $result = ['alert' => 'error', 'msj' => $error];
        }
    }
    //-----------------------------------------

}
