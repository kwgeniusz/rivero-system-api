<?php

namespace App\Models\Accounting;

use Auth;
use DB;
use App\Models\Accounting\AuxiliaryBook;
use App\Models\Accounting\GeneralLedger;
use App\Models\Accounting\Transaction;
use App\CompanyConfiguration;
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
        return $this->hasMany(Transaction::class, 'headerId', 'headerId')->with('generalLedger')->orderBy('transactionId','ASC');
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
        return $this->with('transaction.generalLedger')
                    ->where('headerId', '=', $id)
                    ->where('companyId','=', $companyId)
                    ->get();
    }
    
    public function getAllByYear($year)
    {
       return $this->with('transaction.generalLedger')
                   ->where('companyId', '=', session('companyId'))
                   ->whereYear('entryDate', $year)
                   ->orderBy('entryDate', 'ASC')
                   ->get();
     } 
    public function getAllByCompany($companyId) 
    {  
         return $this->where('companyId', '=', $companyId)
                     ->orderBy('headerId', 'ASC')
                     ->get(); 
     }      

    public function getAllByEntryUpdated($companyId,$status) 
     {  
          return $this->with('transaction')
                      ->where('companyId', '=', $companyId)
                      ->where('entryUpdated', '=', $status)
                      ->orderBy('headerId', 'ASC')
                      ->get(); 
      } 
    public function insertHeaderWithTransactions($countryId, $companyId, $data)
    {
          $error = null;
    
     DB::beginTransaction();
      try {
    
        $oConfiguration = new CompanyConfiguration();
                       $oConfiguration->increaseEntryNumber($countryId, $companyId);
        $entryNumber = $oConfiguration->retrieveEntryNumber($countryId, $companyId);
 
        $header                   = new TransactionHeader;
        $header->countryId        = $countryId;
        $header->companyId        = $companyId;
        $header->entryNumber      = $entryNumber;
        $header->entryDate        = $data[0]['date'];
        $header->entryDescription = $data[0]['description'];
        $header->validation       = 0;
        $header->entryUpdated     = 0;
        $header->source           = 'ACCOUNTING';
        $header->totalDebit       = 0;
        $header->totalCredit      = 0;
        $header->totalDebitSec    = 0;
        $header->totalCreditSec   = 0;
        $header->conversionRate   = $data[0]['conversionRate'];
        $header->userId           = Auth::user()->userId;
        $header->save();
        
        // inicializando variables acumuladoras de saldo
        $acumDebit = 0; $acumCredit = 0; $acumDebitSec  = 0; $acumCreditSec = 0;

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
              $transaction->debitSec                 = $transactionData['amount'] * $header->conversionRate;

              $acumDebit    += $transaction->debit;
              $acumDebitSec += $transaction->debitSec;
             }else{
              $transaction->credit                   = $transactionData['amount']; 
              $transaction->creditSec                = $transactionData['amount'] * $header->conversionRate; 

              $acumCredit    += $transaction->credit;
              $acumCreditSec += $transaction->creditSec;
             }

             $transaction->save();
        }
            $header->totalDebit     = $acumDebit;
            $header->totalCredit    = $acumCredit;
            $header->totalDebitSec  = $acumDebitSec;
            $header->totalCreditSec = $acumCreditSec;

            $header->save();

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
     public function updateHeaderWithTransactions($countryId, $companyId, $data)
   {
        $error = null;

      DB::beginTransaction();
      try {

        
    $header                   = TransactionHeader::find();
    $header->countryId        = $countryId;
    $header->companyId        = $companyId;
    $header->entryNumber      = $entryNumber;
    $header->entryDate        = $data[0]['date'];
    $header->entryDescription = $data[0]['description'];
    $header->validation       = 0;
    $header->entryUpdated     = 0;
    $header->source           = 'ACCOUNTING';
    $header->totalDebit       = 0;
    $header->totalCredit      = 0;
    $header->totalDebitSec    = 0;
    $header->totalCreditSec   = 0;
    $header->conversionRate   = $data[0]['conversionRate'];
    $header->userId           = Auth::user()->userId;
    $header->save();
    
    // inicializando variables acumuladoras de saldo
    $acumDebit = 0; $acumCredit = 0; $acumDebitSec  = 0; $acumCreditSec = 0;

    foreach ($data[1] as $key => $transactionData) {
        $transaction                           = Transaction::find();
        $transaction->countryId                = $countryId;
        $transaction->companyId                = $companyId;
        $transaction->headerId                 = $header->headerId;
        $transaction->generalLedgerId          = $transactionData['generalLedgerId'];
        $transaction->transactionDate          = $data[0]['date'];
        $transaction->transactionDescription   = $transactionData['description'];
        $transaction->transactionReference     = $transactionData['reference'];
         if($transactionData['type'] == 'debit'){ 
          $transaction->debit                    = $transactionData['amount'];
          $transaction->debitSec                 = $transactionData['amount'] * $header->conversionRate;

          $acumDebit    += $transaction->debit;
          $acumDebitSec += $transaction->debitSec;
         }else{
          $transaction->credit                   = $transactionData['amount']; 
          $transaction->creditSec                = $transactionData['amount'] * $header->conversionRate; 

          $acumCredit    += $transaction->credit;
          $acumCreditSec += $transaction->creditSec;
         }

         $transaction->save();
    }
        $header->totalDebit     = $acumDebit;
        $header->totalCredit    = $acumCredit;
        $header->totalDebitSec  = $acumDebitSec;
        $header->totalCreditSec = $acumCreditSec;

        $header->save();

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
  public function updateBalance() {
    
    DB::beginTransaction();
    try {
      // Actualizar transacciones contables
       // 1. Leer las transacciones que no han sido actualizadas
          $companyId        = session('companyId');
          $statusUpdated    = 1; //actualizados
          $statusNotUpdated = 0; //No actualizados

       //Instancia de Libro Auxiliar
         $oAuxiliary  = new AuxiliaryBook;

      $headers =  $this->getAllByEntryUpdated($companyId,$statusNotUpdated);
   
     foreach ($headers as $header) {

        $header  = TransactionHeader::find($header->headerId);
        
        $entryDate = $header->entryDate;
        $year  = substr($entryDate,0,4);
        $month = substr($entryDate,5,2);
         
        foreach ($header->transaction as $transaction) {
          $transactionId            = $transaction->transactionId;
          $companyId                = $transaction->companyId;
          $countryId                = $transaction->countryId;
          $generalLedgerId          = $transaction->generalLedgerId;
          $debit                    = $transaction->debit;
          $credit                   = $transaction->credit;
          $transaction->convertionRate = $header->convertionRate;
          $debitSec                 = $transaction->debitSec;
          $creditSec                = $transaction->creditSec;

        //   AQUI ES CREAR EL REGISTRO EN TABLA ACC_AUXILIARY
           //DEBO VALIDAR SI EL campo EntityName no esta vacio en esta tabla acc_auxiliary
            if($transaction->entityName != ''){
                //insertar registro auxiliar
                $rs = $oAuxiliary->insertA($countryId, $companyId, $transaction);
                if($rs['alert'] == 'error'){ 
                    throw new \Exception($rs['message']);
                 }
                 
            }

           
        // Ejecutar funcion de actualizacion en el libro mayor - general_ledger
        $oGeneralLedger = new GeneralLedger;
        $rs = $oGeneralLedger->cascadeBalanceUpdate($countryId,$companyId,$generalLedgerId,$debit,$credit,$debitSec,$creditSec,$year,$month);
        // Marcar como "actualizado" el registro de trasacciones contable (MODELO) (SET balanceUpdated = 1)
        //  $rs = $this->setBalanceUpdated($transactionId,$statusUpdated);  

     }//end first foreach

        //se ha actualizado el encabezado de las transacciones
         $header->entryUpdated       = 1;
         $header->save();
    }//end second foreach

          $success = true;
          DB::commit();
      } catch (\Exception $e) {
          $error   = $e->getMessage();
          $success = false;
          DB::rollback();
      }
  
      if ($success) {
        return $result = ['alert-type' => 'success', 'message' => 'Operacion Realizada'];
     }else {
        return $result = ['alert-type' => 'error', 'message' => $error];
     }

  } //end of function updateBalance
// ------------------------------------------------------------------------------
  public function updateValidation($headerId,$validationValue)
  {
        $error = null;

   DB::beginTransaction();
    try {

      $transaction                          = TransactionHeader::find($headerId);
      $transaction->validation              = $validationValue;
      $transaction->save();
      
          $success = true;
          DB::commit();
      } catch (\Exception $e) {

          $success = false;
          $error   = $e->getMessage();
          DB::rollback();
      }

      if ($success) {
        return $rs  = ['alert-type' => 'success', 'message' => "Encabezado Validado Exitosamente"];
      } else {
          return $rs = ['alert-type' => 'error', 'message' => $error];
      }
  }




}//end of the class