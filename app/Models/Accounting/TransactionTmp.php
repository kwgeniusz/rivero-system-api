<?php

namespace App\Models\Accounting;

use Auth;
use DB;
use App\Models\Accounting\GeneralLedger;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionTmp extends Model
{
   //traits
      use SoftDeletes;
      
    public $timestamps = false;

    protected $table      = 'acc_transaction_tmp';
    protected $primaryKey = 'transactionId';

    // protected $fillable = ['transactionId' ,'countryId' ,'companyId','transactionNumber','generalLedgerId','transactionDate' ,'transactionDescription' ,'debit' ,'credit' ,	'balanceUpdated' ,	'userId' ,	'deleted_at']; 	
  
    // protected $dates = ['deleted_at'];


//--------------------------------------------------------------------
    /** RELATIONS **/
//--------------------------------------------------------------------
    public function generalLedger()
    {
        return $this->hasOne(GeneralLedger::class, 'generalLedgerId', 'generalLedgerId');
    }
    // public function accountClassification()
    // {
    //     return $this->hasOne('App\AccountClassification', 'accountClassificationCode', 'accountClassificationCode');
    // }
    // public function daughterAccount()
    // {
    //     return $this->hasMany('App\GeneralLedger', 'parentAccountId', 'generalLedgerId');
    // }
    // public function allDaughterAccount()
    // {
    //     return $this->daughterAccount()->with('allDaughterAccount');
    // } 
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
        return $this->where('transactionId', '=', $id)
                    ->where('companyId','=', $companyId)
                    ->get();
    }

    public function getAllByCompany($companyId) 
    {  
         return $this->with('generalLedger')
                     ->where('companyId', '=', $companyId)
                     ->orderBy('transactionId', 'ASC')
                     ->get(); 
     }      

    //  public function getAllByBalanceUpdated($companyId,$status) 
    //  {  
    //       return $this->with('generalLedger')
    //                   ->where('companyId', '=', $companyId)
    //                   ->where('balanceUpdated', '=', $status)
    //                   ->orderBy('transactionId', 'ASC')
    //                   ->get(); 
    //   }
    public function insertT($countryId, $companyId, $data)
    {
          $error = null;
    
     DB::beginTransaction();
      try {

        if($data['debit'] == ''){$data['debit'] = 0;}
        if($data['credit'] == ''){$data['credit'] = 0;}

        $transaction                          = new Transaction;
        $transaction->countryId               = $countryId;
        $transaction->companyId               = $companyId;
        $transaction->transactionNumber       = $data['transactionNumber'];
        $transaction->generalLedgerId         = $data['generalLedgerId'];
        $transaction->transactionDate         = $data['transactionDate'];
        $transaction->transactionDescription  = $data['transactionDescription'];
        $transaction->transactionReference    = $data['transactionReference'];
        $transaction->debit                   = $data['debit'];
        $transaction->credit                  = $data['credit'];
        $transaction->userId                  = Auth::user()->userId;
        $transaction->save();
            
            $success = true;
            DB::commit();
        } catch (\Exception $e) {

            $success = false;
            $error   = $e->getMessage();
            DB::rollback();
        }

        if ($success) {
          return $rs  = ['alert' => 'success', 'message' => "Transaccion Creada Exitosamente."];
        } else {
            return $rs = ['alert' => 'error', 'message' => $error];
        }

    }
//------------------------------------------
    public function updateT($companyId,$transactionId ,$data)
    {
          $error = null;

     DB::beginTransaction();
      try {

        $transaction                          = Transaction::find($transactionId);
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
          return $rs  = ['alert' => 'success', 'message' => "Transaccion Modificada"];
        } else {
            return $rs = ['alert' => 'error', 'message' => $error];
        }
    }
//------------------------------------------
    public function deleteT($companyId,$transactionId)
    {
        try {
          $this->where('companyId', '=', $companyId)
               ->where('transactionId', '=', $transactionId)
               ->delete();
               
            $success = true;
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
        }

        if ($success) {
            return $rs = ['alert' => 'info', 'message' => 'Transaccion Eliminada'];
        } else {
            return $rs = ['alert' => 'error', 'message' => $error];
        }
    }
//------------------------------------------
    // public function setBalanceUpdated($transactionId,$status)
    // {
    //     $error = null;

    //     DB::beginTransaction();
    //      try {
    //        $transaction                          = Transaction::find($transactionId);
    //        $transaction->balanceUpdated          = $status;
    //        $transaction->save();

    //            $success = true;
    //            DB::commit();
    //        }catch(\Exception $e) {
    //            $success = false;
    //            $error   = $e->getMessage();
    //            DB::rollback();
    //        }

    //        if ($success) {
    //          return $rs  = ['alert' => 'success', 'message' => "Transaccion Actualizada"];
    //        } else {
    //            return $rs = ['alert' => 'error', 'message' => $error];
    //        }
    // }
//------------------------------------------
//    public function updateBalance() {
    
//     DB::beginTransaction();
//     try {
//       // Actualizar transacciones contables
//       // 1. Leer las transacciones que no han sido actualizadas
//           $companyId        = session('companyId');
//           $statusUpdated    = 1; //actualizados
//           $statusNotUpdated = 0; //No actualizados

//       $rs =  $this->getAllByBalanceUpdated($companyId,$statusNotUpdated);
//     // dd($rs);
//      foreach ($rs as $item) {
//           $transactionId            = $item->transactionId;
//           $companyId                = $item->companyId;
//           $countryId                = $item->countryId;
//           $generalLedgerId          = $item->generalLedgerId;
//           $debit                    = $item->debit;
//           $credit                   = $item->credit;
//           $transactionDate          = $item->transactionDate;
          
//         //   $year  = getYear($transactionDate);
//         //   $month = getMonth($transactionDate);
//           $year = 2021;
//           $month = 1;
           
//         // Ejecutar funcion de actualizacion en el libro mayor - general_ledger
//         $oGeneralLedger = new GeneralLedger;
//         $rs = $oGeneralLedger->cascadeBalanceUpdate($countryId,$companyId,$generalLedgerId,$debit,$credit,$year,$month);
//         // dd($rs);
//         // Marcar como "actualizado" el registro de trasacciones contable (MODELO) (SET balanceUpdated = 1)
//          $rs = $this->setBalanceUpdated($transactionId,$statusUpdated);  
//         //  dd($rs);
//        }//foreach end

//           $success = true;
//           DB::commit();
//       } catch (\Exception $e) {
//           $error   = $e->getMessage();
//           $success = false;
//           DB::rollback();
//       }
  
//       if ($success) {
//         return $result = ['alert-type' => 'success', 'message' => 'Operacion Realizada'];
//      }else {
//         return $result = ['alert-type' => 'error', 'message' => $error];
//      }

//   } 


}//end of the class