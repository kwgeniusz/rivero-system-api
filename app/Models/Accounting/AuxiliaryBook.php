<?php

namespace App\Models\Accounting;

use Auth;
use DB;
use App\Models\Accounting\GeneralLedgerBalance;
use App\CompanyConfiguration;
use App\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuxiliaryBook extends Model
{
   //traits
      use SoftDeletes;
      
    public $timestamps = false;

    protected $table      = 'acc_auxiliary';
    protected $primaryKey = 'auxiliaryId';

    protected $fillable = ['auxiliaryId','transactionId','generalLedgerId','date','debit','credit','conversionRate','debitSecond','creditSecond','entityName','entityId','deleted_at'];
    // protected $dates = ['deleted_at'];

//--------------------------------------------------------------------
    /** RELATIONS **/
//--------------------------------------------------------------------
    public function transaction()
    {
        return $this->belongsToMany('App\Models\Accounting\Transaction', 'acc_transaction_auxiliary', 'auxiliaryId', 'transactionId');
    }
    public function generalLedger()
    {
        return $this->hasOne('App\Models\Accounting\GeneralLedger', 'generalLedgerId', 'generalLedgerId');
    }
    public function entity()
    {
        return $this->hasOne('App\Models\Entity', 'entityId', 'entityId');
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
    /** Query Scope  */
//--------------------------------------------------------------------
    // nombre codigo direccion
    // public function scopeFilter($query, $filteredOut)
    // {
    //     if ($filteredOut) {
    //         return $query->where('clientCode', 'LIKE', "%$filteredOut%")
    //                      ->orWhere('clientName', 'LIKE', "%$filteredOut%")
    //                      ->orWhere('businessPhone', 'LIKE', "%$filteredOut%")
    //                      ->orWhere('mainEmail', 'LIKE', "%$filteredOut%")
    //                      ->orWhereHas('company', function ($query) use ($filteredOut) {
    //                           return $query->where('companyName', 'LIKE', "%$filteredOut%");
    //                       });
    //     }
    // }
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    public function findById($id)
    {
        return $this->where('auxiliaryId', '=', $id)
                    ->get();
    }

    public function getAllByAccountAndCompany($companyId, $generalLedgerId) 
    {  
         return $this->with('generalLedger', 'entity')
                     ->where('companyId', '=', $companyId)
                     ->where('generalLedgerId', '=', $generalLedgerId)
                     ->orderBy('auxiliaryId', 'ASC')
                     ->get(); 
     }      
     public function getAllByType($companyId,$accountTypeCode) 
     {  
          return $this->with('accountType','accountClassification')
                      ->where('companyId', '=', $companyId)
                      ->where('accountTypeCode', '=', $accountTypeCode)
                      ->orderBy('accountCode', 'ASC')
                      ->get(); 
      }      
     public function getAllWithBalanceByYear($companyId,$year) 
      {  
           return $this->join('acc_general_ledger_balance','acc_general_ledger.generalLedgerId','=','acc_general_ledger_balance.generalLedgerId')
                       ->where('companyId', '=', $companyId)
                       ->where('year',      '=', $year)
                       ->orderBy('accountCode', 'ASC')
                       ->get(); 
       }    

    public function insertA($countryId, $companyId, $data)
    {
          $error = null;
    
     DB::beginTransaction();
      try {

        $auxiliary                          = new AuxiliaryBook;
        $auxiliary->countryId               = $countryId;
        $auxiliary->companyId               = $companyId;
        $auxiliary->transactionId           = $data['transactionId'];
        $auxiliary->generalLedgerId         = $data['generalLedgerId'];
        $auxiliary->date                    = $data['transactionDate'];
        $auxiliary->debit                   = $data['debit'];
        $auxiliary->credit                  = $data['credit'];
        $auxiliary->conversionRate          = $data['conversionRate'];
        $auxiliary->debitSecond             = $data['debitSec'];
        $auxiliary->creditSecond            = $data['creditSec'];
        $auxiliary->entityName              = $data['entityName'];
        $auxiliary->entityId                = $data['entityId'];
        $auxiliary->save();
            
            $success = true;
            DB::commit();
        } catch (\Exception $e) {

            $success = false;
            $error   = $e->getMessage();
            DB::rollback();
        }

        if ($success) {
          return $rs  = ['alert' => 'success', 'message' => "Registro en Libro Auxiliar Creado."];
        } else {
            return $rs = ['alert' => 'error', 'message' => $error];
        }

    }
//------------------------------------------
    public function updateG($companyId,$generalLedgerId ,$data)
    {
          $error = null;

     DB::beginTransaction();
      try {

        $generalLedger                          = GeneralLedger::find($generalLedgerId);
        $generalLedger->accountCode                 = $data['accountCode'];
        $generalLedger->accountName                 = $data['accountName'];
        $generalLedger->leftMargin                  = $data['leftMargin'];
        $generalLedger->parentAccountId           = $data['parentAccountId'];
        $generalLedger->accountClassificationCode   = $data['accountClassificationCode'];
        $generalLedger->accountTypeCode             = $data['accountTypeCode'];
        $generalLedger->save();
        
            $success = true;
            DB::commit();
        } catch (\Exception $e) {

            $success = false;
            $error   = $e->getMessage();
            DB::rollback();
        }

        if ($success) {
          return $rs  = ['alert' => 'success', 'message' => "Cuenta Modificada"];
        } else {
            return $rs = ['alert' => 'error', 'message' => $error];
        }
    }
//------------------------------------------
 public function updateAmounts($generalLedgerId,$debit,$credit,$debitSec,$creditSec)
{
      $error = null;

 DB::beginTransaction();
  try {

         $this->where('generalLedger', $generalLedgerId)
              ->update([
                  'debit'     => $debit,
                  'credit'    => $credit,
                  'debitSec'  => $debitSec,
                  'creditSec' => $creditSec,
              ]); 

        $success = true;
        DB::commit();
    } catch (\Exception $e) {

        $success = false;
        $error   = $e->getMessage();
        DB::rollback();
    }

    if ($success) {
      return $rs  = ['alert' => 'success', 'message' => "Saldos de la cuenta modificados"];
    } else {
        return $rs = ['alert' => 'error', 'message' => $error];
    }
}
//------------------------------------------
    public function deleteG($companyId,$generalLedgerId)
    {
        try {
          $this->where('companyId', '=', $companyId)
               ->where('generalLedgerId', '=', $generalLedgerId)
               ->delete();
               
            $success = true;
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
        }

        if ($success) {
            return $rs = ['alert' => 'info', 'message' => 'Cuenta Eliminada'];
        } else {
            return $rs = ['alert' => 'error', 'message' => $error];
        }
    }
//------------------------------------------
function cascadeBalanceUpdate($countryId,$companyId,$generalLedgerId,$debit,$credit,$debitSec,$creditSec,$year,$month)
{
    DB::beginTransaction();
    try {    
    // obtener $accountCode
    $accountCode = '';
    $query  = $this->find($generalLedgerId);
     //   $query =  "SELECT * FROM acc_general_ledger WHERE generalLedgerId = $generalLedgerId";

      $accountCode = $query->accountCode;
      if ($query->parentAccountId == 0) { //HAY CAMBIAR ESTA LINEA POR parentAccountId == 0 (porque no tiene padre)
         $parentAccountId = 0;
      } else {
         $parentAccountId = $query->parentAccountId;
      }
  // actualizar saldo en cascada
  $loop = 1;
  // inicio del loop
  while($loop == 1) {
     // actualizar el saldo de cuenta con $generalLedgerId libro diario
     $oGeneralLedger = new GeneralLedger;
     $rs = $oGeneralLedger->updateBalance($generalLedgerId,$debit,$credit,$debitSec,$creditSec);
     // actualizar el saldo de cuenta con $generalLedgerId en GeneralLedger Balance libro mayors
     $oGeneralLedgerBalance = new GeneralLedgerBalance;
     $rs = $oGeneralLedgerBalance->updateBalance($generalLedgerId,$year,$month,$debit,$credit,$debitSec,$creditSec);

      // siguiente nivel arriba
      $generalLedgerId = 0;

      $query =  $this->where('countryId','=',$countryId)
                     ->where('companyId','=',$companyId)
                     ->where('generalLedgerId','=',$parentAccountId) //  generalLedgerId = parentAccountId  
                     ->get();
                  
      foreach($query as $rs){
          $generalLedgerId    = $rs->generalLedgerId;
          $accountCode        = $rs->accountCode;
          if ($rs->parentAccountId == 0) { //parentAccountId
             $parentAccountId = 0;          // parentAccountId = 0
          } else {
             $parentAccountId  = $rs->parentAccountId;   // parentAccountId = $rs-> parentAccountId
          }
      }

      // condicion de salida del ciclo while
      if ($generalLedgerId == 0 ) {
         $loop = 0;
      }

    }//end of the loop
            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return $rs = ['alert' => 'info', 'message' => 'Actualizacion en cascada Exitosa'];
        } else {
            return $rs = ['alert' => 'error', 'message' => $error];
        }
  }//end of the function

// =========================================================================
  function updateBalance($generalLedgerId,$debit,$credit,$debitSec,$creditSec)
{
  // obtener $saldos actuales
    DB::beginTransaction();
    try {   
        $query = $this->where('generalLedgerId', '=', $generalLedgerId)->get();

  //Actualizar saldos en tabl acc_general_ledger_balance
  foreach($query as $rs){
        $rs->debit    = $rs->debit + $debit;
        $rs->credit   = $rs->credit + $credit;
        $rs->debitSec  = $rs->debitSec + $debitSec;
        $rs->creditSec = $rs->creditSec + $creditSec;
        $rs->save();
  }
         $success = true;
         DB::commit();
    } catch (\Exception $e) {
        $error   = $e->getMessage();
        $success = false;
        DB::rollback();
    }

    if ($success) {
      return $result = ['alert-type' => 'success', 'message' => 'Balance de la cuenta actualizado.'];
    } else {
      return $result = ['alert-type' => 'error', 'message' => $error];
    }
 }//end function
//------------------------------------------
}//end of the class
