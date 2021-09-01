<?php

namespace App\Models\Accounting;

use Auth;
use DB;
use App\Models\Accounting\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionHeader extends Model
{
   //traits
      use SoftDeletes;
      
    public $timestamps = false;

    protected $table      = 'acc_transaction_header';
    protected $primaryKey = 'headerId';

    protected $fillable = ['headerId' ,'entryNumber' ,'entryDate' ,'entryDescription' ,'totalDebit' ,'totalCredit' ,'validation' ,'entryUpdated']; 
    //protected $dates = ['deleted_at'];


//--------------------------------------------------------------------
    /** RELATIONS **/
//--------------------------------------------------------------------
    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'transactionId', 'transactionId');
    }
//--------------------------------------------------------------------
     /** ACCESORES **/
//--------------------------------------------------------------------
//    public function getTransactionDateAttribute($transactionDate)
//    {
//         $oDateHelper = new DateHelper;
//         $functionRs = $oDateHelper->changeDateForCountry(session('countryId'),'Accesor');
//         $newDate    = $oDateHelper->$functionRs($transactionDate);
//        return $newDate;
//    }
 //--------------------------------------------------------------------
     /** MUTADORES **/
//--------------------------------------------------------------------
//    public function setClientNameAttribute($clientName)
//    {
//     $clientName = strtolower($clientName);
//     $clientName = ucwords($clientName);

//      return $this->attributes['clientName'] = ucwords($clientName);
//    }
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    public function findById($id,$companyId)
    {
        return $this->where('headerId', '=', $id)
                    ->where('companyId','=', $companyId)
                    ->get();
    }

    public function getAllByCompany($companyId) 
    {  
         return $this->where('companyId', '=', $companyId)
                     ->orderBy('headerId', 'ASC')
                     ->get(); 
     }      
    public function insertHeaderWithTransactions($countryId, $companyId, $data)
    {
          $error = null;
    
     DB::beginTransaction();
      try {
    
        $header                           = new TransactionHeader;
        $header->countryId                = $countryId;
        $header->companyId                = $companyId;
        $header->entryNumber              = 0;
        $header->entryDate                = $data[0]['date'];
        $header->entryDescription         = $data[0]['description'];
        $header->totalDebit               = 0;
        $header->totalCredit              = 0;
        $header->validation               = 0;
        $header->entryUpdated             = 0;
        $header->save();

        foreach ($data[1] as $key => $transactionData) {
            $transaction                           = new Transaction;
            $transaction->countryId                = $countryId;
            $transaction->companyId                = $companyId;
            $transaction->headerId                 = $header->headerId;
            $transaction->generalLedgerId          = $transactionData['generalLedgerId'];
            $transaction->transactionDate          = $data[0]['date'];
            $transaction->transactionDescription   = $transactionData['description'];
            $transaction->transactionReference     = $transactionData['reference'];
             if($transactionData['type'] == 'debit'){ 
              $transaction->debit                    = $transactionData['amount'];
              $transaction->credit                   = 0;
             }else{
              $transaction->debit                    = 0;
              $transaction->credit                   = $transactionData['amount']; 
             }
             $transaction->balanceUpdated           = 0;
             $transaction->userId                   = 0;
             $transaction->save();
        }
            
            $success = true;
            DB::commit();
        } catch (\Exception $e) {

            $success = false;
            $error   = $e->getMessage();
            DB::rollback();
        }

        if ($success) {
          return $rs  = ['alert' => 'success', 'message' => "Encabezado Y Renglones creados Exitosamente."];
        } else {
            return $rs = ['alert' => 'error', 'message' => $error];
        }

    }
//------------------------------------------
    public function updateT($companyId,$headerId ,$data)
    {
          $error = null;

     DB::beginTransaction();
      try {

        $transaction                          = Transaction::find($headerId);
        $transaction->transactionNumber       = $data['transactionNumber'];
        $transaction->generalLedgerId           = $data['generalLedgerId'];
        $transaction->transactionDate         = $data['transactionDate'];
        $transaction->transactionDescription  = $data['transactionDescription'];
        $transaction->transactionReference  = $data['transactionReference'];
        $transaction->debit                 = $data['debit'];
        $transaction->credit               = $data['credit'];
        $transaction->save();
        
            $success = true;
            DB::commit();
        } catch (\Exception $e) {

            $success = false;
            $error   = $e->getMessage();
            DB::rollback();
        }

        if ($success) {
          return $rs  = ['alert' => 'success', 'message' => "Encabezado Modificada"];
        } else {
            return $rs = ['alert' => 'error', 'message' => $error];
        }
    }
//------------------------------------------
    public function deleteT($companyId,$headerId)
    {
        try {
          $this->where('companyId', '=', $companyId)
               ->where('headerId', '=', $headerId)
               ->delete();
               
            $success = true;
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
        }

        if ($success) {
            return $rs = ['alert' => 'info', 'message' => 'Encabezado Eliminado'];
        } else {
            return $rs = ['alert' => 'error', 'message' => $error];
        }
    }
//------------------------------------------

}//end of the class