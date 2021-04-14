<?php

namespace App;

use DB;
use Carbon\Carbon;
use App\Helpers\DateHelper;
use App\TransactionType;
use App\SaleNote;
use App\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{

     //traits
     use SoftDeletes;

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

    protected $appends = ['transactionDate','status'];
    
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
    //  public function invoice()
    // {
    //     return $this->belongsTo('App\Invoice', 'invoiceId', 'invoiceId');
    // }
    public function transactionable()
    {
        return $this->morphTo();
    }
    public function payable()
    {
        return  $this->belongsToMany('App\Payable', 'transaction_payable','transactionId', 'payableId')
        ->with('subcontInvDetail.invoice.contract')
        ->withPivot('amountPaid', 'reason');
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
    public function getTransactionDateAttribute()
    {
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['transactionDate'], 'UTC');
        $date->tz = session('companyTimeZone');   // ... set to the current users timezone
        return $date->format('Y-m-d H:i:s');
    }
    public function getStatusAttribute()
    {
         if($this->document) {
            return 'PROCESADA';
         }else{
             return 'PENDIENTE';
         }

    } 
    // ------------MUTADORES-----------------//
    public function setAmountAttribute($amount)
    {
         $amount = number_format((float)$amount, 2, '.', '');
        return $this->attributes['amount'] = encrypt($amount);
    }
    public function setTransactionDateAttribute($transactionDate)
    {
        $date = Carbon::createFromFormat('Y-m-d', $transactionDate, session('companyTimeZone'));
        $date->setTimezone('UTC');
        $this->attributes['transactionDate'] = $date;
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
        ->where('transaction.transactionable_type','App\Invoice')
        ->where('transaction.transactionable_id',$invoiceId)
         ->union($notes)
         ->orderBy('transactionDate', 'ASC')
         ->get();

        return $transactions;
    }
    //------------------------------------
    public function getAllForSign($transactionSign,$countryId,$companyId)
    {

        $result = $this->with('payable','paymentMethod','transactionType','account.bank','transactionable','document','user')
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
        return $this->with('document','account')
                      ->where('transactionId', '=', $id)
                      ->where('countryId', $countryId)
                      ->where('companyId', $companyId) 
                      ->get();
    }

    public function insertT($countryId,$companyId,$transactionTypeId,$description,$payMethodId,$payMethodDetails,$reason,$transactionDate,$amount,$sign,$cashboxId = '',$accountId = '',$model = '', $userId,$file = '')
    {
        $error = null; 
        DB::beginTransaction();
        try {
        

            //INSERTA UNA NUEVA TRANSACTION
            $transaction                          = new Transaction;
            $transaction->countryId               = $countryId;
            $transaction->companyId               = $companyId;
            $transaction->transactionTypeId       = $transactionTypeId;
            $transaction->description             = $description;
            $transaction->payMethodId             = $payMethodId;
            $transaction->payMethodDetails        = $payMethodDetails;
            $transaction->reason                  = $reason;
            $transaction->transactionDate         = $transactionDate;
            $transaction->amount                  = $amount;
            $transaction->sign                    = $sign;
            $transaction->cashboxId               = $cashboxId;
            $transaction->accountId               = $accountId;
            if($model != ''){
             $transaction->transactionable_id      = $model->getKey();
             $transaction->transactionable_type    = get_class($model);
            }
            $transaction->userId                   = $userId;
            $transaction->save();
            
            //SI ES UNA TRANSACCION DE EGRESO DEBO AGREGAR EL docId he insertarlo.
            //AGREGAR DOCUMENTO SI ES DE EGRESO
         if($file != null){ 
            $oDocument = new Document;
            $rs2 = $oDocument->insertF($file,'transaction',$transaction->transactionId,'expense');
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
          return $rs  = ['alert' => 'success', 'message' => 'Transaccion Exitosa','transactionId'=>$transaction->transactionId];
        } else {
            return $rs = ['alert' => 'error', 'message' => $error];
        }

    }
 //------------------------------------------
  public function updateT($transactionId,$data)
 {
        $error = null;
      
        DB::beginTransaction();
        try {

            //INSERTA UNA NUEVA TRANSACTION
            $transaction                          = Transaction::find($transactionId);
            $transaction->transactionTypeId       = $data['transactionTypeId'];
            $transaction->description             = $data['description'];
            $transaction->payMethodId             = $data['payMethodId'];
            $transaction->payMethodDetails        = $data['payMethodDetails'];
            $transaction->reason                  = $data['reason'];
            $transaction->transactionDate         = $data['transactionDate'];
            $transaction->amount                  = $data['amount'];
            $transaction->cashboxId               = $data['cashboxId'];
            $transaction->accountId               = $data['accountId'];
            $transaction->save();
            
            // $photo = $request->file('photo');
            // $new = rand() . '_' . $bank->getClientOriginalName();
            // $new = preg_replace("/[^a-zA-Z0-9.]/", "", $new);
            // $photo->move(public_path('images'), $new);
            // $validate['photo'] = $new;
 //   $currentFile = $user->photo

// if($request->photo != $currentPhoto){
//  $name = nombre del nuevo documento
 
// \Image::make($request->photo)->save(public_path('img/profile/').$name);
// $request->merge(['photo' => $name]);
// }

// if(file_exists()){
//  @unlink($userPhoto);
// }

            //SI ES UNA TRANSACCION DE EGRESO DEBO AGREGAR EL docId he insertarlo.
            //AGREGAR DOCUMENTO SI ES DE EGRESO
        //   if($sign == '-' && $model == '') {
        //     $oDocument = new Document;
        //     $rs2 = $oDocument->insertF($file,'transaction',$transaction->transactionId,'expense');
        //   }
   
            
            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();

            $success = false;
            DB::rollback();
        }

        if ($success) {
          return $rs  = ['alert' => 'success', 'message' => 'Transaccion Modificada Exitorisamente','transactionId'=>$transaction->transactionId];
        } else {
            return $rs = ['alert' => 'error', 'message' => $error];
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
               
            if($transaction->document != null) {
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
            return $result = ['alert' => 'info', 'message' => 'Transaccion Eliminada'];
        } else {
            return $result = ['alert' => 'error', 'message' => $error];
        }
    }
    //-----------------------------------------

}
